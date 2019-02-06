<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Barang_model extends MY_Model
{
    public $table = 'barang';
    public $primary_key = 'id';
    public $column_order = array(null, 'id','kode','nama','keterangan','batas_stok','satuan',null);
    public $column_search = array('id','kode','nama','keterangan','batas_stok','satuan');
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

    public function combo_jenis_barang($and_or, $order_by, $page_num, $per_page, $q_word,$search_field)
    {
        $data = array();

        $offset   = ($page_num - 1) * $per_page;

        if(!empty($q_word[0])){
            $this->db->like('jenis_barang',$q_word[0],'both');
            $this->db->or_like('keterangan',$q_word[0],'both');
        }

        $this->db->order_by('jenis_barang', 'ASC');
        $query = $this->db->get('jenis_barang', $per_page, $offset);
        if(!empty($q_word[0])){ $totaly2 = $query->num_rows();}else{ $totaly2 = $this->db->count_all('jenis_barang'); }

        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $data[] = array(
                    'id' => $atributy->id,
                    'jenis_barang' => $atributy->jenis_barang,
                    'keterangan' => $atributy->keterangan
                );
            }

        }

        return array('cnt_whole'=>$totaly2,'result' => $data);

    }


    function get_barang()
    {
        //echo $jenis;
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

    public function total_limit_perbarang($kode){
        $total_masuk = array();
        $this->db->select("
            batas_stok
        ");
        $this->db->where("kode",$kode);
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $batas_stok = $atributy->batas_stok ;
                
            }

        }
        return $batas_stok;

    }

    public function get_barang_by_kode($kode){
        $total_masuk = array();
        $this->db->select("
            kode
        ");
        $this->db->where("kode",$kode);
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $kode = $atributy->kode ;
                
            }

        }
        return $kode;

    }

}