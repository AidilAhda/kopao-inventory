<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanDashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user', 'User');
    }
    public function admin()
    {

        $data['title'] = "Dashboard";
        $data['user'] = $this->User->muatSemuaUser($this->session->userdata('username'));
        $this->load->view('templates/header', $data);
        $this->load->view('admin/HalamanDashboard', $data);
        $this->load->view('templates/footer');
    }

    public function cabang()
    {
        $data['title'] = "Dashboard";
        $data['user'] = $this->User->muatSemuaUser($this->session->userdata('username'));
        $this->load->view('templates/header', $data);
        $this->load->view('cabang/HalamanDashboard', $data);
        $this->load->view('templates/footer');
    }
    public function owner()
    {
        $data['title'] = "Dashboard";
        $data['user'] = $this->User->muatSemuaUser($this->session->userdata('username'));
        $this->load->view('templates/header', $data);
        $this->load->view('owner/HalamanDashboard', $data);
        $this->load->view('templates/footer');
    }
}
