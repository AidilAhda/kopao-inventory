<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanBarangCabang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user', 'User');

        $this->load->model('Kategori', 'kategori');
        $this->load->model('Barang', 'barang');
        $this->load->model('BarangCabang', 'stok');

        //cek apakah belum login tapi sudah masuk melalui url
        is_logged_in();
        isAdmin();
    }

    public function barangCabang($id)
    {
        $cabang = encode_php_tags($id);
        $data['title'] = 'Barang Cabang';
        $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
        $data['stok'] = $this->stok->muatStokCabang($cabang);
        $data['cabang'] = $this->User->muatUser($cabang);
        $this->template->load('admin/HalamanDashboard', 'admin/barangcabang/HalamanBarangCabang', $data);
    }
}
