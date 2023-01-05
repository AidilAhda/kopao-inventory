<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanHapusBarangController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user', 'User');
        $this->load->model('Kategori', 'kategori');
        $this->load->model('Barang', 'barang');

        //cek apakah belum login tapi sudah masuk melalui url
        is_logged_in();

        // cek siapa yang login dan ingin masuk ke page admin
        isAdmin();
    }
    public function hapusBarang($getId)
    {
        is_logged_in();
        isAdmin();
        $id = encode_php_tags($getId);
<<<<<<< HEAD:application/controllers/HalamanUbahBarang.php
        $data['title'] = "Data Barang";
        $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
        $data['kategori'] = $this->kategori->muatSemuaKategori();
        $data['barang'] = $this->barang->muatBarang($id);
        $this->template->load('admin/HalamanDashboard', 'admin/databarang/HalamanUbahBarang', $data);
=======
        if ($this->barang->hapusBarang($id)) {
            $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Hapus Barang<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
        }
        redirect('HalamanBarang');
>>>>>>> 85e7fa68a09a3c009ea8099441f9e0c6649fdb6b:application/controllers/HalamanHapusBarangController.php
    }
}
