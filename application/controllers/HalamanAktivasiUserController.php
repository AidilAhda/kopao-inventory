<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanAktivasiUserController extends CI_Controller
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
    public function aktifkanUser($getId)
    {
        is_logged_in();
        isAdmin();
        $id = encode_php_tags($getId);
        $status = $this->User->muatUser($id)['is_active'];
        $toggle = $status ? 0 : 1; //Jika user aktif maka nonaktifkan, begitu pula sebaliknya
        $query = $this->User->aktivasiUser('user', 'id_user', $id, ['is_active' => $toggle]);
        if ($query) {
            if ($toggle == 1) {
                $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>User Berhasil diaktifkan<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
            } else {
                $this->session->set_flashdata('pesan', "<div class='alert alert-success' role='alert'>User Berhasil dinonaktifkan<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
            }
        }
        redirect('HalamanPengelolaanUser');
    }
}
