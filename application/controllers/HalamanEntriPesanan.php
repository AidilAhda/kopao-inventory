<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanEntriPesanan extends CI_Controller
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
        // cek siapa yang login dan ingin masuk ke page cabang
        isCabang();
    }
    public function index()
    {
        $data['title'] = 'Pesanan';
        $data['user'] = $this->User->cek($this->session->userdata('username'));

        $today = date('ymd');
        $prefix = 'PC' . $today;
        $lastKode = $this->pesanan->idPesananTerbesar();


        //mengambail 4 char dari belakang
        $noUrut = (int) substr($lastKode, -4, 4);
        $noUrut++;
        $newKode = $prefix . sprintf("%04s", $noUrut);


        $data['kategori'] = $this->kategori->muatSemuaKategori();
        $data['barang'] = $this->barang->muatSemuaBarang();
        $data['idPesanan'] = $newKode;
        $this->template->load('cabang/HalamanDashboard', 'cabang/pesanan/HalamanEntriPesanan', $data);
    }
}
