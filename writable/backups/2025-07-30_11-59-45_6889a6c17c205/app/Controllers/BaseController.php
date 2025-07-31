<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = ['custom'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    protected $session;
    protected $db;
    protected $viewTahunAjaran; // Tahun ajaran yang sedang dilihat

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();

        // Cek tahun ajaran yang sedang dilihat
        $this->checkViewingTahunAjaran();
    }
    /**
     * Cek tahun ajaran yang sedang dilihat
     */
    protected function checkViewingTahunAjaran()
    {
        // Tahun ajaran yang sedang dilihat dari session
        $id_tahun_ajaran_view = session()->get('id_tahun_ajaran_view');

        if ($id_tahun_ajaran_view) {
            // Jika ada di session, ambil dari database
            $this->viewTahunAjaran = $this->db->table('db_tahunajaran')
                ->where('id_tahun_ajaran', $id_tahun_ajaran_view)
                ->get()->getRow();

            // Jika tidak ditemukan di database, reset session
            if (!$this->viewTahunAjaran) {
                session()->remove('id_tahun_ajaran_view');
            }
        }

        // Jika tidak ada di session atau tidak valid, gunakan tahun ajaran aktif
        if (!$id_tahun_ajaran_view || !$this->viewTahunAjaran) {
            $this->viewTahunAjaran = $this->db->table('db_tahunajaran')
                ->where('status', 'Aktif')
                ->orderBy('tahun', 'DESC')
                ->get()->getRow();

            // Pastikan viewTahunAjaran tidak null dan memiliki properti id_tahun_ajaran
            if ($this->viewTahunAjaran && !isset($this->viewTahunAjaran->id_tahun_ajaran)) {
                log_message('error', 'Tahun ajaran aktif tidak memiliki id_tahun_ajaran');
                // Coba menggunakan properti id jika ada
                if (isset($this->viewTahunAjaran->id)) {
                    $this->viewTahunAjaran->id_tahun_ajaran = $this->viewTahunAjaran->id;
                }
            }
        }
    }
}
