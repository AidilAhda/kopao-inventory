<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanUbahKategoriController extends CI_Controller
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
    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $data['title'] = "Kategori";
        $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
        $data['kategori'] = $this->kategori->muatKategori($id);
        $this->template->load('admin/HalamanDashboard', 'admin/kategori/HalamanUbahKategori', $data);
    }
    public function updateKategori($getId)
    {
        is_logged_in();
        isAdmin();
        $id = encode_php_tags($getId);
        $this->form_validation->set_rules('nama_kategori', 'Nama kategori', 'required|trim', array(
            'required' => 'Nama Kategori tidak boleh kosong'
        ));
        if ($this->form_validation->run() == false) {
            $data['title'] = "Kategori";
            $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
            $data['kategori'] = $this->kategori->muatKategori($id);
            $this->template->load('admin/HalamanDashboard', 'admin/kategori/HalamanUbahKategori', $data);
        } else {
            $input = $this->input->post(null, true);
            $data = [
                'nama_kategori' => $input['nama_kategori']
            ];
            $query = $this->kategori->updateKategori($id, $data);
            if ($query) {
                $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Ubah kategori<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('halamankategori');
            } else {
                $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal Ubah kategori<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");

                redirect('HalamanUbahKategoriController/edit');
            }
        }
    }
}
