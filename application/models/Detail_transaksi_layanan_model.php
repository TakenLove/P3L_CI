<?php

class Detail_transaksi_layanan_model extends CI_Model{

    //untuk tampil semua data
    public function getLog($id_detail_layanan = null){
        if($id_detail_layanan === null){
            return $this->db->get('detail_transaksi_layanan')->result_array();
        } else{
            return $this->db->get_where('detail_transaksi_layanan', ['id_detail_layanan' => $id_detail_layanan]) ->result_array();
        }
        
    }

    //tidak menampilkan yang ter soft delete   
    public function getDetail_transaksi_layanan($id_detail_layanan = null){
        if($id_detail_layanan === null){
            return $this->db->query("SELECT dl.id_detail_layanan, tl.id_transaksi_layanan, l.nama as layanan, dl.sub_harga, dl.jumlah, u.ukuran, j.jenis, u.harga as hargaU, j.harga as hargaJ, l.harga as hargaL
            from detail_transaksi_layanan dl JOIN layanan l ON (dl.id_layanan = l.id_layanan) JOIN transaksi_layanan tl ON (dl.id_transaksi_layanan = tl.id_transaksi_layanan) JOIN ukuran_hewan u ON (dl.id_ukuran = u.id_ukuran) JOIN jenis_hewan j ON (dl.id_jenis = j.id_jenis)")->result_array();
        } else{
            return $this->db->get_where('detail_transaksi_layanan', ['id_detail_layanan' => $id_detail_layanan]) ->result_array();
        }
        
    }

    public function deleteDetail_transaksi_layanan($data,$id_detail_layanan){
        $this->db->update('detail_transaksi_layanan' , $data , ['id_detail_layanan' => $id_detail_layanan]);
        return $this->db->affected_rows();
    }

    public function hardDelete($id_detail_layanan){
        $this->db->delete('detail_transaksi_layanan' , ['id_detail_layanan' => $id_detail_layanan]);
        return $this->db->affected_rows();
    }

    public function createDetail_transaksi_layanan($data){
        $this->db->insert('detail_transaksi_layanan', $data);
        return $this->db->affected_rows();
    }

    public function updateDetail_transaksi_layanan($data,$id_detail_layanan){
        $this->db->update('detail_transaksi_layanan' , $data , ['id_detail_layanan' => $id_detail_layanan]);
        return $this->db->affected_rows();
    }
}