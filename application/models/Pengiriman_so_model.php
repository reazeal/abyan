<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pengiriman_so_model extends MY_Model
{
    public $table = 'pengiriman_so';
    public $primary_key = 'id';
    public $column_order = array(null, 'id','kode_pengiriman', 'kode_so','kode_kurir','nama_kurir','qty','tanggal',null);
    public $column_search = array('kode_pengiriman', 'kode_so','kode_kurir','nama_kurir','qty','tanggal');
    public $order = array('tanggal' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        //$this->db->group_by('kode');
        $this->db->order_by('pengiriman_so.tanggal','desc');
        $this->db->from('pengiriman_so');
        $this->db->join('detail_so','detail_so.kode_so = pengiriman_so.kode_so','left');
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

        /*
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
        */
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
        //$this->db->update($this->table,array("upload_rate"=>0,"download_rate"=>0));
    }

    public function delete_by_id($id)
    {
        $this->db->where($this->primary_key, $id);
        $this->db->delete($this->table);
    }

    public function update_by_kode($kode, $data)
    {
        $this->db->where('kode',$kode);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
        //$this->db->update($this->table,array("upload_rate"=>0,"download_rate"=>0));
    }


    public function total_pengiriman_so_perbulan_tahun($bulan,$tahun){
        $total_pengiriman = array();
        $filter = "$bulan"."/".$tahun;
        $this->db->select("
            ifnull(max(abs(substring_index(kode_pengiriman, '/', 1))),0) as total_pengiriman
        ");
        $this->db->where(" kode_pengiriman like '%$filter' ");
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $total_pengiriman = $atributy->total_pengiriman ;
                
            }

        }
        return $total_pengiriman;

    }

    public function total_qty_pengiriman_so_perbulan_tahun_barang($bulan,$tahun,$barang){
        $total_pengiriman = array();
        $filter = $bulan."/".$tahun;
        $this->db->select("
            sum(qty) as total_pengiriman
        ");
        $this->db->where(" kode_pengiriman like '%$filter' ");
        $this->db->where("kode_barang",$barang);
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $total_pengiriman = $atributy->total_pengiriman ;
                
            }

        }
        return $total_pengiriman;

    }

    public function get_total_kirim_by_so($noSo)
    {
        $this->db->select('sum(qty) as total');
        $this->db->from($this->table);

        $this->db->where('kode_so',$noSo);
        $query = $this->db->get();

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $total_kirim = $atributy->total ;
                
            }

        }
        return $total_kirim;
    }

}