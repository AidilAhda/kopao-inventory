<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanUbahKategori extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user', 'User');
        $this->load->model('Kategori', 'kategori');
    }
    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $this->form_validation->set_rules('nama_kategori', 'Nama kategori', 'required|trim');
        if ($this->form_validation->run() == false) {
            $data['title'] = "Kategori";
            $data['user'] = $this->User->cek($this->session->userdata('username'));
            $data['kategori'] = $this->kategori->getData('kategori', ['id_kategori' => $id]);
            $this->template->load('admin/HalamanDashboard', 'admin/kategori/HalamanUbahKategori', $data);
        } else {
            $this->updateData($getId);
        }
    }
    public function updateData($getId)
    {
        $id = encode_php_tags($getId);
        $this->form_validation->set_rules('nama_kategori', 'kategori', 'required|trim');
        if ($this->form_validation->run() == false) {
            $data['title'] = "Kategori";
            $data['user'] = $this->User->cek($this->session->userdata('username'));
            $data['kategori'] = $this->kategori->getData('kategori', ['id_kategori' => $id]);
            $this->template->load('admin/HalamanDashboard', 'admin/kategori/HalamanUbahKategori', $data);
        }
        $input = $this->input->post(null, true);
        $data = [
            'nama_kategori' => $input['nama_kategori']
        ];
        $query = $this->kategori->updateData('kategori', 'id_kategori', $id, $data);
        if ($query) {
            $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Ubah kategori<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
            redirect('halamankategori');
        } else {
            $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal Ubah kategori<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");

            redirect('HalamanUbahKategori/edit');
        }
    }
}
