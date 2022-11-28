<?php
defined('BASEPATH') or exit('No direct script access allowed');

class System extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user', 'User');
    }

    public function tambahUser()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[user.username]|alpha_numeric');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]', [
            'min_length' => 'password terlalu pendek'
        ]);
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required|trim');
        //jika gagal
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Tambah User';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/register');
            $this->load->view('templates/auth_footer');
        } else {
            $input = $this->input->post(null, true);
            $data = [
                'nama' => $input['name'],
                'username' => $input['username'],
                'email' => $input['email'],
                'no_telp' => $input['no_telp'],
                'role_id' => 2,
                'password' => password_hash($input['password'], PASSWORD_DEFAULT),
                'created_at' => time(),
                'is_active' => 1
            ];
            $query =  $this->User->tambahUser($data);
            if ($query) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Berhasil Tambah Akun</div>');
                redirect('HalamanLogin');
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Gagal Tambah Akun</div>');
                redirect('HalamanLogin/tambahUser');
            }
        }
    }
}
