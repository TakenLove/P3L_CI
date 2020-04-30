<?php

class Transaksi_layanan_model extends CI_Model{

    //untuk tampil semua data
    public function getLog($id = null){
        if($id === null){
            return $this->db->get('transaksi_layanan')->result_array();
        } else{
            return $this->db->get_where('transaksi_layanan', ['id_uid_transaksi_layanankuran' => $id]) ->result_array();
        }
        
    }

    //tidak menampilkan yang ter soft delete 
    public function getTransaksi_layanan($id_transaksi_layanan = null){
        if($id_transaksi_layanan === null){
            return $this->db->query("SELECT tl.id_transaksi_layanan, tl.id_hewan, tl.total_harga, tl.status_layanan, tl.diskon, tl.sub_total, tl.id_member, tl.created_at, tl.delete_at, tl.id_pegawai_cs, tl.aktor, m.nama as member, p.nama as aktors, h.nama as hewan
            from transaksi_layanan tl JOIN pegawai p ON (tl.aktor = p.id_pegawai) JOIN member m ON (tl.id_member = m.id_member) JOIN data_hewan h ON (tl.id_hewan = h.id_hewan) where tl.delete_at IS NULL AND tl.id_pegawai_cs = '0'")->result_array(); 
        } else{
            return $this->db->get_where('transaksi_layanan', ['id_transaksi_layanan' => $id_transaksi_layanan]) ->result_array();
        }
    }

    public function deleteTransaksiLayanan($data,$id_transaksi_layanan){
        $this->db->update('transaksi_layanan' , $data , ['id_transaksi_layanan' => $id_transaksi_layanan]);
        return $this->db->affected_rows();
    }

    public function hardDelete($id_transaksi_layanan){
        $this->db->delete('transaksi_layanan' , ['id_transaksi_layanan' => $id_transaksi_layanan]);
        return $this->db->affected_rows();
    }

    public function createTransaksi_layanan($data){
        $this->db->insert('transaksi_layanan', $data);
        return $this->db->affected_rows();
    }

    public function updateTransaksi_layanan($data,$id_transaksi_layanan){
        $this->db->update('transaksi_layanan' , $data , ['id_transaksi_layanan' => $id_transaksi_layanan]);
        return $this->db->affected_rows();
    }
}