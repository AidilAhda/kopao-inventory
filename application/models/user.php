<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Model
{
    public function cek($username, $pw)
    {
        $this->db->where('username', $username);
        $user_db = $this->db->get('user')->row_array();
        $return = null;
        //jika usernya ada
        if ($user_db) {
            // jika usernya aktif
            if ($user_db['is_active'] == 1) {
                //cek password
                if (password_verify($pw, $user_db['password'])) {
                    $data = [
                        'id_user' => $user_db['id_user'],
                        'username' => $user_db['username'],
                        'role_id' => $user_db['role_id'],
                        'password' => $pw,
                        'nama' => $user_db['nama']
                    ];

                    $return = $data;
                } else {
                    $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Password Anda Salah<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                    redirect('HalamanLogin');
                }
            } else {
                //jika tidak aktif
                $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>Akun anda belum aktif. Silahkan hubungi admin untuk mengaktifkan akun<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('HalamanLogin');
            }
        } else {
            //jika tidak ada
            $this->session->set_flashdata('pesan', "<div class='alert alert-danger' role='alert'>username belum terdaftar <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
            redirect('HalamanLogin');
        }

        return $return;
    }

    public function muatSemuaUser()
    {
        return $this->db->get_where('user', ['role_id' => 2])->result_array();
    }

    public function simpanUser($data)
    {
        return $this->db->insert('user', $data);
    }

    public function muatUser($id)
    {
        return $this->db->get_where('user', ['id_user' => $id])->row_array();
    }

    public function hapusUser($id)
    {
        return $this->db->delete('user', ['id_user' => $id]);
    }
    public function updateUser($id, $data)
    {
        $this->db->where('id_user', $id);
        return $this->db->update('user', $data);
    }
    public function aktivasiUser($table, $pk, $id, $data)
    {
        $this->db->where($pk, $id);
        return $this->db->update($table, $data);
    }
}
