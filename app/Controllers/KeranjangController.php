<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KeranjangModel;
use App\Models\MenuModel;

class KeranjangController extends BaseController
{
    protected $keranjangModel;
    protected $menuModel;

    public function __construct()
    {
        $this->keranjangModel = new KeranjangModel();
        $this->menuModel = new MenuModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userId = session()->get('user_id');
        $data = [
            'title' => 'Keranjang Belanja',
            'keranjang' => $this->keranjangModel->getKeranjangByUser($userId)
        ];

        return view('kontributor/v_keranjang', $data);
    }

    public function add()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $menuId = $this->request->getPost('menu_id');
        $jumlah = $this->request->getPost('jumlah') ?: 1;
        $userId = session()->get('user_id');

        // Check if already in cart
        $existing = $this->keranjangModel->where('user_id', $userId)->where('menu_id', $menuId)->first();

        if ($existing) {
            $this->keranjangModel->update($existing['id'], [
                'jumlah' => $existing['jumlah'] + $jumlah
            ]);
        } else {
            $this->keranjangModel->insert([
                'user_id' => $userId,
                'menu_id' => $menuId,
                'jumlah'  => $jumlah
            ]);
        }

        return redirect()->back()->with('success', 'Berhasil ditambahkan ke keranjang!');
    }

    public function delete($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $this->keranjangModel->delete($id);
        return redirect()->back()->with('success', 'Item dihapus dari keranjang.');
    }
}
