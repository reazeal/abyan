<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_mutasi_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function get_stok_barang($kode_jenis)
    {
        //echo $jenis;
        $data = array();
         $this->db->select("
            barang.id as barang_id,
        kode,
        barang.nama,
        barang.keterangan,
        batas_stok,
        status_stok,
        satuan
        ");
       // $this->db->join('stok_fisik','barang.id = stok_fisik.barang_id','left');       
        $this->db->group_by('barang.id');
        $this->db->where('substr(kode,-1,1)',$kode_jenis);
        $query = $this->db->get('barang');
        foreach($query->result() as $row){
            $data[] = array(
            	'id_barang' => $row->barang_id,
                'kode' => $row->kode,
                'nama' => $row->nama,
                'satuan' => $row->satuan
            );
        }
        //print_r($data);
        return $data;
    }

    function get_stok_barang_awal($barang_id, $tanggal_awal_stok)
    {
        //echo $jenis;
        $stok_awal = "";
         $this->db->select("
            sum(qty) as stok_awal
        ");
       // $this->db->join('stok_fisik','barang.id = stok_fisik.barang_id','left');       
        $this->db->group_by('barang_id');
        $this->db->where('stok_fisik.tanggal <= ',$tanggal_awal_stok);
        $this->db->where('barang_id',$barang_id);
        $query = $this->db->get('stok_fisik');
        foreach($query->result() as $row){
            $stok_awal = $row->stok_awal;
        }

        return $stok_awal;
    }

    function get_jumlah_barang_masuk($barang_id, $tanggal_awal, $tanggal_akhir)
    {
        //echo $jenis;
        $jumlah_masuk = "";
         $this->db->select("
            sum(qty) as jumlah_masuk
        ");
       // $this->db->join('stok_fisik','barang.id = stok_fisik.barang_id','left');       
        $this->db->group_by('barang_id');
        $this->db->where('tanggal <= ',$tanggal_awal);
        $this->db->where('tanggal >= ',$tanggal_akhir);
        $this->db->where('barang_id',$barang_id);
        $query = $this->db->get('detail_barang_masuk');
        foreach($query->result() as $row){
            $jumlah_masuk = $row->jumlah_masuk;
        }

        return $jumlah_masuk;
    }

    function get_jumlah_barang_keluar($barang_id, $tanggal_awal, $tanggal_akhir)
    {
        //echo $jenis;
        $jumlah_keluar = "";
         $this->db->select("
            sum(qty) as jumlah_keluar
        ");
       // $this->db->join('stok_fisik','barang.id = stok_fisik.barang_id','left');       
        $this->db->group_by('barang_id');
        $this->db->where('tanggal <= ',$tanggal_awal);
        $this->db->where('tanggal >= ',$tanggal_akhir);
        $this->db->where('barang_id',$barang_id);
        $query = $this->db->get('detail_barang_keluar');
        foreach($query->result() as $row){
            $jumlah_keluar = $row->jumlah_keluar;
        }

        return $jumlah_keluar;
    }





}