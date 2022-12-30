<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanEntriUserController extends CI_Controller
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

    public function index()
    {
        $data['title'] = 'Kelola User';
        $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
        $this->template->load('admin/HalamanDashboard', 'admin/kelolaakun/HalamanEntriUser', $data);
    }
    public function simpanUser()
    {
        is_logged_in();
        isAdmin();
        //jika gagal
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[user.username]', array(
            'required' => 'Username tidak boleh kosong',
            'is_unique' => 'Username Sudah ada terdaftar',
        ));
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]', array(
            'required' => 'Pasword tidak boleh kosong',
            'min_length' => 'Minimal 3 huruf'
        ));
        $this->form_validation->set_rules('nama', 'Name', 'trim|required', array(
            'required' => 'Nama tidak boleh kosong',

        ));
        $this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required|trim', array(
            'required' => 'No Telepon tidak boleh kosong',

        ));
        if ($this->form_validation->run() == false) {

            $data['title'] = 'Tambah User';
            $data['user'] = $this->User->cek($this->session->userdata('username'), $this->session->userdata('password'));
            $this->template->load('admin/HalamanDashboard', 'admin/kelolaakun/HalamanEntriUser', $data);
        } else {
            $input = $this->input->post(null, true);
            $data = [
                'nama' => strtoupper($input['nama']),
                'username' => $input['username'],
                'no_telp' => $input['no_telp'],
                'role_id' => 2,
                'password' => password_hash($input['password'], PASSWORD_DEFAULT),
                'created_at' => time(),
                'is_active' => 0
            ];
            $query =  $this->User->simpanUser($data);
            if ($query) {
                $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Berhasil Tambah User<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanPengelolaanAkun');
            } else {
                $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Gagal Tambah User<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanEntriUserController');
            }
        }
    }
}
