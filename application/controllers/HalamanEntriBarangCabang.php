<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanEntriBarangCabang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user', 'User');
        $this->load->model('Kategori', 'kategori');
        $this->load->model('Barang', 'barang');
        $this->load->model('StokCabang', 'sc');


        //cek apakah belum login tapi sudah masuk melalui url
        is_logged_in();
        // cek siapa yang login dan ingin masuk ke page cabang
        isAdmin();
    }
    public function simpanCabang($getId)
    {
        $id = encode_php_tags($getId);
        $data['title'] = 'Barang Cabang';
        $data['user'] = $this->User->cek($this->session->userdata('username'));

        $data['kategori'] = $this->kategori->muatSemuaKategori();
        $data['barang'] = $this->barang->muatSemuaBarang();
        $data['cabang'] = $this->sc->muatCabang($id);
        $this->template->load('admin/HalamanDashboard', 'admin/barangcabang/HalamanEntriBarangCabang', $data);
    }
}
