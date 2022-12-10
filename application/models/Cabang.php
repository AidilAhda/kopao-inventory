<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cabang extends CI_Model
{
    public function muatSemuaCabang()
    {
        return $this->db->get('cabang')->result_array();
    }

    public function muatCabang($id)
    {
        if ($id != null) {
            return $this->db->get_where('cabang', ['id_cabang' => $id])->row_array();
        } else {
            return $this->db->get_where('cabang', ['id_cabang' => $id])->result_array();
        }
    }
    public function updateCabang($id, $data)
    {
        $this->db->where('id_cabang', $id);
        return $this->db->update('cabang', $data);
    }
    public function idCabangTerbesar()
    {
        $this->db->select_max('id_cabang');
        return $this->db->get('cabang')->row_array()['id_cabang'];
    }
    public function simpanCabang($data)
    {
        return $this->db->insert('cabang', $data);
    }
    public function hapusCabang($id)
    {
        return $this->db->delete('cabang', ['id_cabang' => $id]);
    }
}
