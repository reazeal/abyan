<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Detail_barang_keluar_model extends MY_Model
{
    public $table = 'detail_barang_keluar';
    public $primary_key = 'id';
    public function __construct()
    {
        parent::__construct();

    }

    public function getDataByTransaksi($id){
        $data = array();

        $this->db->select("
        detail_barang_keluar.id,
        detail_barang_keluar.barang_keluar_id,
        detail_barang_keluar.barang_id,
        detail_barang_kelaur.nama_barang,
        detail_barang_masuk.qty
        ");
        $this->db->join('barang_keluar','barang_keluar.id=detail_barang_keluar.barang_keluar_id');
        $this->db->where('barang_masuk_id',$id);
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $data[] = array(
                    'id' => $atributy->id,
                    'barang_keluar_id' => $atributy->barang_keluar_id,
                    'barang_id' => $atributy->barang_id,
                    'nama_barang' => $atributy->nama_barang,
                    'qty' => $atributy->qty,
                    'action' => "<a class='btn btn-sm btn-danger' href='javascript:void(0)' title='Hapus' onclick='hapus_dataDetail()'><i class='glyphicon glyphicon-trash'></i> Delete</a>"
                );
            }

        }
        return $data;

    }

    public function getDataByTransaksi2($id){
        $data = array();

        $this->db->select("
        detail_barang_keluar.id,
        detail_barang_keluar.nama_barang,
        detail_barang_keluar.qty
        ");
        $this->db->where('barang_keluar_id',$id);
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $data[] = array(
                    'nama_barang' => $atributy->nama_barang,
                    'qty' => $atributy->qty,
                );
            }

        }
        return $data;

    }

    public function getDataByTransaksi3($id){
        $data = array();

        $this->db->select("
        detail_barang_keluar.id,
        detail_barang_keluar.barang_keluar_id,
        detail_barang_keluar.nama_barang,
        detail_barang_keluar.qty
        ");
        $this->db->where('barang_keluar_id',$id);
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $data[] = array(
                    'id' => $atributy->id,
                    'barang_keluar_id' => $atributy->barang_keluar_id,
                    'nama_barang' => $atributy->nama_barang,
                    'qty' => $atributy->qty,
                    'action' => "<a class='btn btn-sm btn-danger hapus-detail' href='javascript:void(0)' title='Hapus' onclick='hapus_dataDetail()'><i class='glyphicon glyphicon-trash'></i> Delete</a>"
                );
            }

        }
        return $data;

    }

    public function update_by_id($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

    public function total_penjualan_pertahun(){
        $total_penjualan_pertahun = array();
        $tahun = date('Y');
        $this->db->select("
            -- ifnull(round(sum(qty) / 1000,1),0) as total_penjualan
                ifnull(sum(qty),0) as total_penjualan
                    ");
        $this->db->where("tanggal like '%$tahun%' ");
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $total_penjualan_pertahun = $atributy->total_penjualan ;
                
            }

        }
        return $total_penjualan_pertahun;

    }

    public function total_penjualan_bulan_kemaren(){
        $total_penjualan_pertahun = array();

        $hari_ini = date('Y-m-d');
        $kemaren = date('Y-m',strtotime('-1 months', strtotime($hari_ini)));
        $this->db->select("
            -- ifnull(round(sum(qty) / 1000,1),0) as total_penjualan
            ifnull(sum(qty),0) as total_penjualan
        ");
        $this->db->where("tanggal like '%$kemaren%' ");
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {
                
                $total_penjualan_pertahun = $atributy->total_penjualan ;
                
            }

        }
        return $total_penjualan_pertahun;

    }


    public function total_penjualan_bulan_ini(){
        $total_penjualan_pertahun = array();
        $tahun = date('Y-m');
        $this->db->select("
            -- ifnull(round(sum(qty) / 1000,1),0) as total_penjualan
            ifnull(sum(qty),0) as total_penjualan
        ");
        $this->db->where("tanggal like '%$tahun%' ");
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {
                
                $total_penjualan_pertahun = $atributy->total_penjualan ;
                
            }

        }
        return $total_penjualan_pertahun;

    }

}