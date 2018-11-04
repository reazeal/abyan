<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Barang_masuk_model extends MY_Model
{
    public $table = 'barang_masuk';
    public $primary_key = 'id';
    public $column_order = array(null, 'id','tanggal','nomor_referensi','keterangan','jenis_trans',null);
    public $column_search = array('id','tanggal','nomor_invoice','keterangan','jenis_trans');
    public $order = array('tanggal' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {

            /*
        $this->db->select("
        barang_masuk.id,
        detail_barang_masuk.id as id_detail,
        barang_masuk.tanggal,
        barang_masuk.kode_barang_masuk as kode_barang_masuk,
        barang_masuk.nomor_referensi,        
        barang_masuk.keterangan,
        kode_barang,
        nama_barang,
        jenis_trans,
        qty, keluar
        ");
        $this->db->join('detail_barang_masuk','detail_barang_masuk.id_barang_masuk=barang_masuk.id');
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

         $this->db->select("
        detail_barang_masuk.id,
        barang_masuk.tanggal,
        barang_masuk.kode_barang_masuk as kode_barang_masuk,
        barang_masuk.nomor_referensi,        
        barang_masuk.keterangan,
        kode_barang,
        nama_barang,
        jenis_trans,
        qty
        ");

        $this->db->join('detail_barang_masuk','barang_masuk.id = detail_barang_masuk.id_barang_masuk');
        $this->db->from($this->table);
        $param = "barang_masuk.".$id;
        $this->db->where('barang_masuk.id',$id);
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

    public function total_masuk_perbulan_tahun($bulan,$tahun){
        $total_masuk = array();
        $filter = "$bulan"."/".$tahun;
        $this->db->select("
            max(abs(substring_index(kode_barang_masuk, '/', 1))) as total_masuk
        ");
        $this->db->where(" kode_barang_masuk like '%$filter' ");
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $total_masuk = $atributy->total_masuk ;
                
            }

        }
        return $total_masuk;

    }

    public function get_kode_by_kode_terima($kode_terima){
        $kode_barang_masuk = array();
        $this->db->select("
            kode_barang_masuk
        ");
        $this->db->where("nomor_referensi",$kode_terima);
        //$this->db->where("tanggal",$tanggal);
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $kode_barang_masuk = $atributy->kode_barang_masuk ;
                
            }

        }
        return $kode_barang_masuk;
    }


}