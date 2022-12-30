<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanUbahuserController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user', 'User');

        //cek apakah belum login tapi sudah masuk melalui url
        is_logged_in();

        // cek siapa yang login dan ingin masuk ke page admin
        isAdmin();
    }

    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $data['title'] = "Kelola User";
        $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
        $data['akun'] = $this->User->muatUser($id);
        $this->template->load('admin/HalamanDashboard', 'admin/kelolaakun/HalamanUbahUser', $data);
    }
    public function updateUser($getId)
    {
        is_logged_in();
        isAdmin();
        $id = encode_php_tags($getId);
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[user.username]', array(
            'required' => 'Username tidak boleh kosong',
            'is_unique' => 'Username Sudah ada terdaftar',
        ));

        $this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required|trim', array(
            'required' => 'No Telepon tidak boleh kosong',

        ));
        if ($this->form_validation->run() == false) {

            $data['title'] = "Kelola User";
            $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
            $data['akun'] = $this->User->muatUser($id);
            $this->template->load('admin/HalamanDashboard', 'admin/kelolaakun/HalamanUbahUser', $data);
        } else {
            $input = $this->input->post(null, true);
            $data = [
                'username' => $input['username'],

                'no_telp' => $input['no_telp']
            ];
            $query = $this->User->updateUser($id, $data);
            if ($query) {
                $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Ubah User<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanPengelolaanAkun');
            } else {
                $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal Ubah Cabang<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");

                redirect('HalamanUbahuserController/edit');
            }
        }
    }
}
