<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Barang_keluar_model extends MY_Model
{
    public $table = 'barang_keluar';
    public $primary_key = 'id';
    public $column_order = array(null, 'id','tanggal','nomor_referensi','kode_barang_keluar','keterangan',null);
    public $column_search = array('id','tanggal','nomor_referensi','keterangan','kode_barang_keluar');
    public $order = array('id' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {   
        /*
        $this->db->select("
        barang_keluar.id,
        barang_keluar.tanggal,
        barang_keluar.kode_barang_keluar as kode_barang_keluar,
        barang_keluar.nomor_referensi,        
        barang_keluar.keterangan,
        detail_barang_keluar.kode_barang,
        detail_barang_keluar.nama_barang,
        qty
        ");
        $this->db->join('detail_barang_keluar','detail_barang_keluar.id_barang_keluar=barang_keluar.id');
        */
        $this->db->from($this->table);
          $i = 0;
        foreach ($this->column_search as $item) // loop column
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                if($i===0) // first loop
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->select($this->primary_key);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function get_by_id($id)
    {
        $this->db->from($this->table);
        $this->db->where($this->primary_key,$id);
        $query = $this->db->get();

        return $query->row();
    }

    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update_by_id($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_id($id)
    {
        $this->db->where($this->primary_key, $id);
        $this->db->delete($this->table);
    }
    
    public function total_keluar_perbulan_tahun($bulan,$tahun){
        $total_keluar = array();
        $filter = "$bulan"."/".$tahun;
        $this->db->select("
            max(abs(substring_index(kode_barang_keluar, '/', 1))) as total_keluar
        ");
        $this->db->where(" kode_barang_keluar like '%$filter' ");
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $total_keluar = $atributy->total_keluar ;
                
            }

        }
        return $total_keluar;

    }

    public function get_kode_by_kode_keluar($kode_keluar, $tanggal){
        $kode_barang_keluar = array();
        $this->db->select("
            kode_barang_keluar
        ");
        $this->db->where("nomor_referensi",$kode_keluar);
        $this->db->where("tanggal",$tanggal);
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $kode_barang_keluar = $atributy->kode_barang_keluar ;
                
            }

        }
        return $kode_barang_keluar;
    }


}