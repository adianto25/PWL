<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        helper('form');
        $this->userModel = new UserModel();
    }

    public function login()
    {
        if ($this->request->getPost()) {
            // 1. Aturan Validasi (Rules)
            $rules = [
                'username' => 'required|min_length[5]',
                'password' => 'required|min_length[7]',
            ];

            // 2. Jalankan Validasi
            if ($this->validate($rules)) {
                $username = $this->request->getPost('username');
                $password = $this->request->getPost('password');

                $dataUser = $this->userModel->where('username', $username)->first();

                if ($dataUser) {
                    // 3. Cek Password dengan password_verify
                    if (password_verify($password, $dataUser['password'])) {
                        session()->set([
                            'user_id'    => $dataUser['id'],
                            'username'   => $dataUser['username'],
                            'role'       => $dataUser['role'],
                            'isLoggedIn' => TRUE
                        ]);

                        // Redirect berdasarkan role
                        if ($dataUser['role'] == 'admin') {
                            return redirect()->to(base_url('/admin'));
                        } else {
                            return redirect()->to(base_url('/'));
                        }
                    } else {
                        session()->setFlashdata('failed', 'Username atau Password Salah');
                        return redirect()->back();
                    }
                } else {
                    session()->setFlashdata('failed', 'Username Tidak Ditemukan');
                    return redirect()->back();
                }
            } else {
                // Tampilkan error jika input tidak memenuhi rules (kurang karakter)
                session()->setFlashdata('failed', $this->validator->listErrors());
                return redirect()->back();
            }
        } else {
            return view('v_login');
        }
    }

    public function register()
    {
        if ($this->request->getPost()) {
            // Tambahkan rules juga di register agar sinkron
            $rules = [
                'username'         => 'required|min_length[5]|is_unique[users.username]',
                'password'         => 'required|min_length[7]',
                'confirm_password' => 'matches[password]'
            ];

            if ($this->validate($rules)) {
                $username = $this->request->getPost('username');
                $password = $this->request->getPost('password');

                $this->userModel->save([
                    'username'   => $username,
                    'password'   => password_hash($password, PASSWORD_DEFAULT),
                    'role'       => 'user', 
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                session()->setFlashdata('success', 'Registrasi berhasil, silakan login.');
                return redirect()->to(base_url('/login'));
            } else {
                session()->setFlashdata('failed', $this->validator->listErrors());
                return redirect()->back();
            }
        } else {
            return view('v_register');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}