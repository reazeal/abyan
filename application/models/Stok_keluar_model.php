<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Stok_keluar_model extends MY_Model
{
    public $table = 'stok_keluar';
    public $primary_key = 'id';
    public $column_order = array(null, 'id','barang_keluar_id','no_bukti_keluar','barang_id','nama_barang','no_bukti_stok','qty_order','qty_stok',null);
    public $column_search = array('no_bukti_keluar','barang_id','nama_barang','no_bukti_stok','qty_order','qty_stok');
    public $order = array('id' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
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

   


    function get_all_barangx($jenis)
    {

         $data = array();
         $this->db->select("
            barang.id as barang_id,
        kode,
        barang.nama,
        barang.keterangan,
        batas_stok,
        sum(qty) as qty,
        status_stok,
        satuan
        ");
        $this->db->join('stok_fisik','barang.id = stok_fisik.barang_id','left');
        if($jenis != 'ALL'){
            $this->db->where('status_stok',$jenis);
        }
        $this->db->group_by('barang.id');

        $query = $this->db->get('barang');
        foreach($query->result() as $row){
            $data[] = array(
                'kode' => $row->kode,
                'nama' => $row->nama,
                'satuan' => $row->satuan,
                'qty' => $row->qty,
            );
        }
        //print_r($data);
        return $data;
    }

}