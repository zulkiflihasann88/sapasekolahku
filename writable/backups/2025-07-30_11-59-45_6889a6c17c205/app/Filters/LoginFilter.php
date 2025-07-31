<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class LoginFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Cek apakah session user ada
        if (!session('id_user')) {
            // Log the attempt for debugging
            log_message('info', 'Unauthorized access attempt to: ' . $request->getUri()->getPath() . ' from IP: ' . $request->getIPAddress());

            // Jika request AJAX atau JSON, kembalikan response 403 JSON
            if (
                $request->hasHeader('X-Requested-With') && $request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest' ||
                strpos($request->getHeaderLine('Accept'), 'application/json') !== false ||
                strpos($request->getHeaderLine('Content-Type'), 'application/json') !== false
            ) {
                return service('response')
                    ->setStatusCode(403)
                    ->setJSON([
                        'status' => false,
                        'message' => 'Session expired. Please login again.',
                        'redirect' => site_url('login')
                    ]);
            }

            // Untuk request biasa, redirect ke login dengan pesan flash
            session()->setFlashdata('error', 'Silakan login terlebih dahulu untuk mengakses halaman tersebut.');
            return redirect()->to(site_url('login'));
        }

        // Update last activity if session exists
        session()->set('lastActivity', time());

        // Optional: Cek timeout session (30 menit)
        $lastActivity = session('lastActivity');
        if ($lastActivity && (time() - $lastActivity > 1800)) { // 30 menit = 1800 detik
            session()->destroy();
            session()->setFlashdata('error', 'Session telah berakhir. Silakan login kembali.');
            return redirect()->to(site_url('login'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
