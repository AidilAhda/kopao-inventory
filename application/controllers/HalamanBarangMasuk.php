<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanBarangMasuk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user', 'User');

        $this->load->model('Kategori', 'kategori');
        $this->load->model('Barang', 'barang');
        $this->load->model('BarangCabang', 'sc');

        //cek apakah belum login tapi sudah masuk melalui url
        is_logged_in();
        isCabang();
    }

    public function index()
    {
        $data['title'] = 'Barang Masuk';
        $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
        $data['kategori'] = $this->kategori->muatSemuaKategori();
        $data['barang'] = $this->barang->muatSemuaBarang();
        $user_db = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
        $data['barangmasuk'] = $this->sc->muatSemuaBarangCabang($user_db['id_user']);

        $this->template->load('cabang/HalamanDashboard', 'cabang/barangmasuk/HalamanBarangMasuk', $data);
    }
}
