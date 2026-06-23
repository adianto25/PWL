<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ApiAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $header = $request->getServer('HTTP_AUTHORIZATION');
        $validToken = 'Bearer prajamukti-api-key-2026';

        if (!$header || $header !== $validToken) {
            $response = service('response');
            return $response->setJSON([
                'status' => 401,
                'error' => 'Unauthorized',
                'message' => 'API Key tidak valid atau tidak disertakan. Gunakan format "Authorization: Bearer <API_KEY>"'
            ])->setStatusCode(401);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
