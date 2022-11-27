<?php
defined('BASEPATH') or exit('No direct script access allowed');

class admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user', 'User');
    }
    public function index()
    {

        $data['title'] = "Dashboard";
        $data['user'] = $this->User->muatSemuaUser($this->session->userdata('username'));
        $this->load->view('templates/header', $data);
        $this->load->view('admin/HalamanDashboard', $data);
        $this->load->view('templates/footer');
    }
}
