<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ChatModel;
use App\Models\UserModel;
use App\Models\TempatKulinerModel;

class ChatController extends BaseController
{
    protected $chatModel;
    protected $userModel;

    public function __construct()
    {
        $this->chatModel = new ChatModel();
        $this->userModel = new UserModel();
    }

    public function index($penerimaId = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userId = session()->get('user_id');
        
        // Ambil list orang yang pernah chat dengan kita
        $db = \Config\Database::connect();
        $builder = $db->table('chats');
        $builder->select('users.id, users.username, users.role, MAX(chats.created_at) as last_chat');
        $builder->join('users', 'users.id = chats.penerima_id OR users.id = chats.pengirim_id');
        $builder->groupStart()
                ->where('chats.pengirim_id', $userId)
                ->orWhere('chats.penerima_id', $userId)
                ->groupEnd();
        $builder->where('users.id !=', $userId);
        $builder->groupBy('users.id, users.username, users.role');
        $builder->orderBy('last_chat', 'DESC');
        $chatPartners = $builder->get()->getResultArray();

        // Jika ada penerima spesifik
        $messages = [];
        $activePartner = null;
        if ($penerimaId) {
            $activePartner = $this->userModel->find($penerimaId);
            $messages = $this->chatModel->where("(pengirim_id = $userId AND penerima_id = $penerimaId) OR (pengirim_id = $penerimaId AND penerima_id = $userId)")
                                        ->orderBy('created_at', 'ASC')
                                        ->findAll();
                                        
            // Mark as read
            $this->chatModel->where('pengirim_id', $penerimaId)
                            ->where('penerima_id', $userId)
                            ->set(['is_read' => 1])
                            ->update();
        }

        $data = [
            'title' => 'Chat Interaktif',
            'chatPartners' => $chatPartners,
            'messages' => $messages,
            'activePartner' => $activePartner,
            'userId' => $userId
        ];

        return view('kontributor/v_chat', $data);
    }

    public function send()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $penerimaId = $this->request->getPost('penerima_id');
        $pesan = $this->request->getPost('pesan');
        $tempatId = $this->request->getPost('tempat_id') ?: null;

        if ($pesan) {
            $this->chatModel->insert([
                'pengirim_id' => session()->get('user_id'),
                'penerima_id' => $penerimaId,
                'tempat_id'   => $tempatId,
                'pesan'       => $pesan,
                'created_at'  => date('Y-m-d H:i:s')
            ]);
        }

        return redirect()->to('/chat/' . $penerimaId);
    }
}
