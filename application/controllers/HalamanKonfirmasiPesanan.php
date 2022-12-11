<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanKonfirmasiPesanan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user', 'User');

        $this->load->model('Kategori', 'kategori');
        $this->load->model('Barang', 'barang');
        $this->load->model('Pesanan', 'pesanan');

        //cek apakah belum login tapi sudah masuk melalui url
        is_logged_in();
        isAdmin();
    }
    public function index()
    {
        $data['title'] = 'Pesanan';
        $data['user'] = $this->User->cek($this->session->userdata('username'));
        $data['pesanan'] = $this->pesanan->muatSemuaPesanan();

        $this->template->load('admin/HalamanDashboard', 'admin/pesanan/HalamanKonfirmasiPesanan', $data);
    }
}
