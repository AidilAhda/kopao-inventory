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
                $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Berhasil Tambah Kategori</div>');
                redirect('HalamanKategori');
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Gagal Tambah Kategori</div>');
                redirect('HalamanTambahKategori');
            }
        }
    }
}
