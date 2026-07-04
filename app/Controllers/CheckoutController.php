<?php

namespace App\Controllers;

use App\Models\KeranjangModel;
use CodeIgniter\Controller;

class CheckoutController extends BaseController
{
    public function process()
    {
        $userId = session()->get('user_id');
        if (!$userId) return redirect()->to('/login');

        $keranjangModel = new KeranjangModel();
        $cartItems = $keranjangModel->getKeranjangByUser($userId);

        if (empty($cartItems)) {
            return redirect()->to('/kontributor/keranjang')->with('failed', 'Keranjang Anda kosong.');
        }

        // Setup Midtrans Configuration
        $midtransConfig = new \Config\Midtrans();
        \Midtrans\Config::$serverKey = $midtransConfig->serverKey;
        \Midtrans\Config::$isProduction = $midtransConfig->isProduction;
        \Midtrans\Config::$isSanitized = $midtransConfig->isSanitized;
        \Midtrans\Config::$is3ds = $midtransConfig->is3ds;

        // Hitung total gross amount
        $grossAmount = 0;
        $itemDetails = [];
        $tempatId = null;

        foreach ($cartItems as $item) {
            $grossAmount += ($item['harga'] * $item['jumlah']);
            // Assume single place order for now, grab the first tempat_id if we joined it.
            // Oh wait, KeranjangModel join tempat_kuliner but we didn't select tempat_id explicitly.
            // Let's get it from menu model later or assuming we add it. 
            // For now let's just mock tempatId = 1 if it's missing, but we'll fetch it properly.
            
            $itemDetails[] = [
                'id'       => $item['menu_id'],
                'price'    => $item['harga'],
                'quantity' => $item['jumlah'],
                'name'     => substr($item['nama_makanan'], 0, 50)
            ];
        }

        $orderId = 'INV-' . date('YmdHis') . '-' . $userId;

        // Save to transaksi table
        $db = \Config\Database::connect();
        
        // Find tempat_id from the first item
        $menuIdFirst = $cartItems[0]['menu_id'];
        $menuBuilder = $db->table('menus')->select('tempat_id')->where('id', $menuIdFirst)->get()->getRow();
        $tempatId = $menuBuilder ? $menuBuilder->tempat_id : 1;

        $db->table('transaksi')->insert([
            'order_id' => $orderId,
            'user_id' => $userId,
            'tempat_id' => $tempatId,
            'gross_amount' => $grossAmount,
            'transaction_status' => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        $transaksiId = $db->insertID();

        // Save to transaksi_detail
        foreach ($cartItems as $item) {
            $db->table('transaksi_detail')->insert([
                'transaksi_id' => $transaksiId,
                'menu_id' => $item['menu_id'],
                'harga' => $item['harga'],
                'jumlah' => $item['jumlah'],
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        // Kosongkan keranjang (asumsikan kita hapus setelah checkout)
        $db->table('keranjang')->where('user_id', $userId)->delete();

        // Siapkan parameter Midtrans Snap
        $customerDetails = [
            'first_name' => session()->get('username'),
            'email'      => 'user@example.com', // Dummy email or get from user table
        ];

        $transactionDetails = [
            'order_id' => $orderId,
            'gross_amount' => $grossAmount,
        ];

        $params = [
            'transaction_details' => $transactionDetails,
            'item_details'        => $itemDetails,
            'customer_details'    => $customerDetails,
        ];

        try {
            // Dapatkan Snap Token dari Midtrans
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            
            // Simpan snap token ke tabel transaksi
            $db->table('transaksi')->where('id', $transaksiId)->update(['snap_token' => $snapToken]);

            // Kirim token ke view untuk memunculkan pop-up
            return view('v_checkout', [
                'snapToken' => $snapToken,
                'orderId' => $orderId,
                'grossAmount' => $grossAmount,
                'clientKey' => $midtransConfig->clientKey
            ]);

        } catch (\Exception $e) {
            return redirect()->to('/kontributor/keranjang')->with('failed', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function notification()
    {
        $midtransConfig = new \Config\Midtrans();
        \Midtrans\Config::$serverKey = $midtransConfig->serverKey;
        \Midtrans\Config::$isProduction = $midtransConfig->isProduction;
        
        $notif = new \Midtrans\Notification();
        
        $transactionStatus = $notif->transaction_status;
        $paymentType = $notif->payment_type;
        $orderId = $notif->order_id;
        $fraudStatus = $notif->fraud_status;

        $db = \Config\Database::connect();
        
        $status = 'pending';

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $status = 'challenge';
            } else if ($fraudStatus == 'accept') {
                $status = 'success';
            }
        } else if ($transactionStatus == 'settlement') {
            $status = 'success';
            
            // EMAIL NOTIFICATION
            // Trigger email notification here
            // Note: Make sure email config is set up in app/Config/Email.php
            $transaksi = $db->table('transaksi')->where('order_id', $orderId)->get()->getRow();
            if ($transaksi && $status == 'success') {
                $email = \Config\Services::email();
                // We use a dummy email address to show the notification process
                $email->setTo('adityaw2525@gmail.com');
                $email->setSubject('Pembayaran Berhasil - ' . $orderId);
                $email->setMessage('Halo, Pembayaran untuk pesanan ' . $orderId . ' sebesar Rp ' . number_format($transaksi->gross_amount, 0, ',', '.') . ' telah berhasil diterima via ' . $paymentType);
                $email->send();
            }

        } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            $status = 'failed';
        } else if ($transactionStatus == 'pending') {
            $status = 'pending';
        }

        $db->table('transaksi')->where('order_id', $orderId)->update([
            'transaction_status' => $status,
            'payment_type' => $paymentType,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return $this->response->setJSON(['status' => 'success']);
    }

    // Fungsi tambahan khusus karena berjalan di Localhost (Webhook dari Midtrans tidak bisa masuk ke localhost)
    public function checkStatus($orderId)
    {
        $midtransConfig = new \Config\Midtrans();
        \Midtrans\Config::$serverKey = $midtransConfig->serverKey;
        \Midtrans\Config::$isProduction = $midtransConfig->isProduction;
        
        try {
            $statusResponse = \Midtrans\Transaction::status($orderId);
            
            $db = \Config\Database::connect();
            $status = 'pending';
            
            if ($statusResponse->transaction_status == 'capture') {
                $status = 'success';
            } else if ($statusResponse->transaction_status == 'settlement') {
                $status = 'success';
            } else if ($statusResponse->transaction_status == 'cancel' || $statusResponse->transaction_status == 'deny' || $statusResponse->transaction_status == 'expire') {
                $status = 'failed';
            }
            
            $db->table('transaksi')->where('order_id', $orderId)->update([
                'transaction_status' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            
            return redirect()->to('/kontributor/dashboard')->with('success', 'Status transaksi ' . $orderId . ' berhasil diupdate menjadi: ' . $status);
        } catch (\Exception $e) {
            return redirect()->back()->with('failed', 'Gagal mengecek status: ' . $e->getMessage());
        }
    }
}
