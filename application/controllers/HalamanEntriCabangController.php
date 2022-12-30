<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanEntriCabangController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user', 'User');
        $this->load->model('Cabang', 'cabang');

        //cek apakah belum login tapi sudah masuk melalui url
        is_logged_in();
        // cek siapa yang login dan ingin masuk ke page admin
        isAdmin();
    }

    public function index()
    {
        $data['title'] = 'Data Cabang';
        $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
        $this->template->load('admin/HalamanDashboard', 'admin/datacabang/HalamanEntriCabang', $data);
    }
    public function simpanCabang()
    {
        is_logged_in();
        isAdmin();
        $data['title'] = 'Data Cabang ';
        $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
        $this->form_validation->set_rules('nama_cabang', 'Nama Cabang', 'required', array(
            'required' => 'Nama Cabang tidak boleh kosong'
        ));
        $this->form_validation->set_rules('alamat_cabang', 'Alanat ', 'required', array(
            'required' => 'Alamat tidak boleh kosong'
        ));
        $idTerbesar = $this->cabang->idCabangTerbesar();
        $idTerbesar++;


        if ($this->form_validation->run() == false) {
            $this->template->load('admin/HalamanDashboard', 'admin/datacabang/HalamanEntriCabang', $data);
        } else {
            $input = $this->input->post(null, true);
            $data = [
                'id_cabang' => $idTerbesar,
                'nama_cabang' => strtoupper($input['nama_cabang']),
                'alamat_cabang' => $input['alamat_cabang']
            ];
            $query =  $this->cabang->simpanCabang($data);
            if ($query) {
                $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Tambah Cabang<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanCabang');
            } else {
                $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal Tambah Cabang<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanEntriCabangController');
            }
        }
    }
}
