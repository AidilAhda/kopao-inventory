<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanTambahKategori extends CI_Controller
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

    public function index()
    {
        $data['title'] = 'Kategori';
        $data['user'] = $this->User->cek($this->session->userdata('username'));
        $this->form_validation->set_rules('nama_kategori', 'Nama kategori', 'required');
        if ($this->form_validation->run() == false) {
            $this->template->load('admin/HalamanDashboard', 'admin/kategori/HalamanTambahKategori', $data);
        } else {
            $input = $this->input->post(null, true);
            $data = [
                'nama_kategori' => $input['nama_kategori'],
            ];
            $query =  $this->kategori->simpanData($data);
            if ($query) {
                $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Tambah kategori<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanKategori');
            } else {
                $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal Tambah kategori<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanTambahKategori');
            }
        }
    }
}
