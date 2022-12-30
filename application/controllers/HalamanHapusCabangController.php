<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanHapusCabangController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user', 'User');
        $this->load->model('Cabang', 'cabang');
        $this->load->model('Kategori', 'kategori');

        //cek apakah belum login tapi sudah masuk melalui url
        is_logged_in();

        // cek siapa yang login dan ingin masuk ke page admin
        isAdmin();
    }
    public function hapusCabang($getId)
    {
        is_logged_in();
        isAdmin();
        $id = encode_php_tags($getId);
        if ($this->cabang->hapusCabang($id)) {
            $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Hapus Cabang<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
        }
        redirect('HalamanCabang');
    }
}
