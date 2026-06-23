<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    /**
     
     * @param RequestInterface 
     * @param array|null       
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('/login'))->with('failed', 'Silakan login terlebih dahulu.');
        }
        if (session()->get('role') != 'admin') {
            return redirect()->to(base_url('/'))->with('failed', 'Akses ditolak. Anda bukan admin.');
        }
    }

    /**
     
     * @param RequestInterface  
     * @param ResponseInterface 
     * @param array|null        
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
