<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanLogin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user', 'User');
    }


    public function index()
    {
        $data['title'] = 'Login';
        $this->load->view('templates/auth_header', $data);
        $this->load->view('auth/login');
        $this->load->view('templates/auth_footer');
    }

    public function logout()
    {
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('role_id');
        $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>Telah berhasil log out <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
        redirect('HalamanLogin');
    }
}
