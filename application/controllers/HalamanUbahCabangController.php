<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanUbahCabangController extends CI_Controller
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
    public function edit($getId)
    {

        $id = encode_php_tags($getId);
        $data['title'] = "Data Cabang";
        $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
        $data['cabang'] = $this->cabang->muatCabang($id);
        $this->template->load('admin/HalamanDashboard', 'admin/datacabang/HalamanUbahCabang', $data);
    }
    public function updateCabang($getId)
    {
        is_logged_in();
        isAdmin();
        $id = encode_php_tags($getId);
        $this->form_validation->set_rules('alamat_cabang', 'Alamat Cabang', 'required', array(
            'required' => 'Alamat tidak boleh kosong'
        ));
        if ($this->form_validation->run() == false) {
            $data['title'] = "Data Cabang";
            $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
            $data['cabang'] = $this->cabang->muatCabang($id);
            $this->template->load('admin/HalamanDashboard', 'admin/datacabang/HalamanUbahCabang', $data);
        } else {
            $input = $this->input->post(null, true);
            $data = [
                'alamat_cabang' => $input['alamat_cabang']
            ];
            $query = $this->cabang->updateCabang($id, $data);
            if ($query) {
                $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Ubah Cabang<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanCabang');
            } else {
                $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal Ubah Cabang<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanUbahCabangController/edit');
            }
        }
    }
}
