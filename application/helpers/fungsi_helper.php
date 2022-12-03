<?php
//cek apakah belum login tapi sudah masuk melalui url
function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('username')) {
        redirect('HalamanLogin/tampilHalamanLogin');
    }
}
function isAdmin()
{
    $ci = get_instance();
    $role = $ci->session->userdata('role_id');

    if ($role == 2) {
        redirect('HalamanDashboard/cabang');
    }
    if ($role == 3) {
        redirect('HalamanDashboard/owner');
    }
}
