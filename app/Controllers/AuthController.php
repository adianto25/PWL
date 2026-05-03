<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
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
            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');

            $dataUser = $this->userModel->where('username', $username)->first();

            if ($dataUser) {
                if (md5($password) == $dataUser['password']) {
                    session()->set([
                        'user_id'    => $dataUser['id'],
                        'username'   => $dataUser['username'],
                        'role'       => $dataUser['role'],
                        'isLoggedIn' => TRUE
                    ]);

                    if ($dataUser['role'] == 'admin') {
                        return redirect()->to(base_url('/admin'));
                    } else {
                        return redirect()->to(base_url('/'));
                    }
                } else {
                    session()->setFlashdata('failed', 'Password Salah');
                    return redirect()->back();
                }
            } else {
                session()->setFlashdata('failed', 'Username Tidak Ditemukan');
                return redirect()->back();
            }
        } else {
            return view('v_login');
        }
    }

    public function register()
    {
        if ($this->request->getPost()) {
            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');
            $confirm_password = $this->request->getVar('confirm_password');

            if ($password != $confirm_password) {
                session()->setFlashdata('failed', 'Password tidak cocok!');
                return redirect()->back();
            }

            // Check if username exists
            if ($this->userModel->where('username', $username)->first()) {
                session()->setFlashdata('failed', 'Username sudah digunakan!');
                return redirect()->back();
            }

            $this->userModel->save([
                'username' => $username,
                'password' => md5($password),
                'role'     => 'kontributor',
                'created_at' => date('Y-m-d H:i:s')
            ]);

            session()->setFlashdata('success', 'Registrasi berhasil, silakan login.');
            return redirect()->to(base_url('/login'));
        } else {
            return view('v_register');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }
}
