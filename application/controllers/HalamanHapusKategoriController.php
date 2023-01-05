<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanHapusKategoriController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user', 'User');
        $this->load->model('Kategori', 'kategori');

        //cek apakah belum login tapi sudah masuk melalui url
        is_logged_in();

        // cek siapa yang login dan ingin masuk ke page admin
        isAdmin();
    }
    public function hapusKategori($getId)
    {
        is_logged_in();
        isAdmin();
        $id = encode_php_tags($getId);
<<<<<<< HEAD:application/controllers/HalamanUbahKategori.php
        $data['title'] = "Kategori";
        $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
        $data['kategori'] = $this->kategori->muatKategori($id);
        $this->template->load('admin/HalamanDashboard', 'admin/kategori/HalamanUbahKategori', $data);
=======
        if ($this->kategori->hapusKategori($id)) {
            $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Hapus kategori<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
        }
        redirect('HalamanKategori');
>>>>>>> 85e7fa68a09a3c009ea8099441f9e0c6649fdb6b:application/controllers/HalamanHapusKategoriController.php
    }
}
