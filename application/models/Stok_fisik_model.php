<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Stok_fisik_model extends MY_Model
{
    public $table = 'stok_fisik';
    public $primary_key = 'id';
    public $column_order = array(null, 'id','tanggal','no_bukti','qty','nama_barang','keterangan','no_rak','gudang_id','nama_gudang','nomor_invoice','expired',null);
    public $column_search = array('nomor_invoice','tanggal','no_bukti','qty','nama_barang','stok_fisik.keterangan','no_rak','gudang_id','nama_gudang','expired');
    public $order = array('expired' => 'asc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        $this->db->select("
        stok_fisik.id,
        stok_fisik.barang_id,
        stok_fisik.gudang_id,
        stok_fisik.tanggal,
        stok_fisik.no_bukti,
        stok_fisik.qty,
        stok_fisik.nama_barang,
        stok_fisik.nama_gudang,
        stok_fisik.expired,
        stok_fisik.keterangan,
        stok_fisik.nomor_invoice
        ");
        $this->db->join('barang','barang.id=stok_fisik.barang_id');
        $this->db->where('qty != ',0);
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

    public function get_nobukti()
    {
        $no_urut = 0;
        $no_bukti = "";

        $tgl_cek_bukti = date('Y')."-".date('m')."-01";
        $nomor=date('m')."/".date('Y');

        $this->db->select('
             MAX(LEFT(no_bukti, 3)) AS urut 
        ');
        $this->db->from($this->table);
        $this->db->where('tanggal >= ',$tgl_cek_bukti);
        $this->db->like('no_bukti', $nomor, 'before');
        $query = $this->db->get();
        $totaly2 = $query->num_rows();

        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy):
                $no_urut = $atributy->urut+1;
                $no_bukti=substr("000",0,3-strlen($no_urut)).$no_urut."/STK/".date('m')."/".date('Y');
             endforeach;

            return $no_bukti;

        }else{
            $no_urut = 1;
            $no_bukti=substr("000",0,3-strlen($no_urut)).$no_urut."/STK/".date('m')."/".date('Y');
            return $no_bukti;
        }

    }

    public function getStokByBarang(){
        $data = array();

        $barang = $this->session->userdata("barang_id");

        $this->db->select("
        stok_fisik.nama_barang,
        stok_fisik.nama_gudang,
        stok_fisik.qty,
        stok_fisik.no_bukti,
        stok_fisik.expired
        ");
        $this->db->where('barang_id',$barang);
        $this->db->where('qty != ','0');
        $this->db->order_by('expired','ASC');
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $data[] = array(
                    'nama_barang' => $atributy->nama_barang,
                    'nama_gudang' => $atributy->nama_gudang,
                    'qty' => $atributy->qty,
                    'expired' => $atributy->expired,
                    'no_bukti' => $atributy->no_bukti
                );
            }

        }
        return $data;

    }

    public function getMinStokBarang($barang_id){
        $data = array();


        $this->db->select(" min(expired) as expired, qty, id, no_bukti
        ");
        $this->db->where('barang_id',$barang_id);
        $this->db->where('qty != ','0');
        $this->db->limit(1);
        $this->db->group_by('barang_id,id');
        $this->db->order_by('expired','ASC');
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $data = array(
                    'qty' => $atributy->qty,
                    'expired' => $atributy->expired,
                    'id' => $atributy->id,
                    'no_bukti' => $atributy->no_bukti
                );
            }

        }
        return $data;

    }

    public function getMinStokBarangSelain($barang_id, $id){
        $data = array();


        $this->db->select(" min(expired) as expired, qty, id, no_bukti
        ");
        $this->db->where('barang_id',$barang_id);
        $this->db->where('qty != ','0');
        $this->db->where('id != ',$id);
        $this->db->limit(1);
        $this->db->group_by('barang_id,id');
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $data = array(
                    'qty' => $atributy->qty,
                    'expired' => $atributy->expired,
                    'id' => $atributy->id,
                    'no_bukti' => $atributy->no_bukti
                );
            }

        }
        return $data;

    }

    public function getJumlahStokBarang($id){
        $data = array();

        $this->db->select("
        sum(qty) as jumlah from stok_fisik where barang_id = $id
        ");
        $query = $this->db->get();

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $data = $atributy->jumlah;
               // $data = 0;
                
            }

        }
        return $data;

    }

    public function getStokByBarangId($barang){
        $data = array();

        $this->db->select("
        id, 
        no_bukti,
        barang_id, 
        gudang_id, 
        nama_barang, 
        nama_gudang, 
        qty,
        expired,
        keterangan 
        ");

        $this->db->where('barang_id',$barang);
        //$this->db->where('gudang_id',$gudang);
        $this->db->order_by('expired','asc');
        $query = $this->db->get($this->table);

        //$query = $this->db->get();

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $data[] = array(
                    'id' => $atributy->id,
                    'barang_id' => $atributy->barang_id,
                    'gudang_id' => $atributy->gudang_id,
                    'no_bukti' => $atributy->no_bukti,
                    'nama_gudang' => $atributy->nama_gudang,
                    'nama_barang' => $atributy->nama_barang,
                    'qty' => $atributy->qty,
                    'expired' => $atributy->expired,
                    'keterangan' => $atributy->keterangan
                    
                );
                
            }

        }
        return $data;

    }


    public function getStokExpired(){
        $data = array();

        $query = $this->db->query("
            select * from stok_fisik  where expired < DATE_ADD(now(), INTERVAL 8 month) and qty != 0  order by expired asc          
        ");

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $data[] = array(
                    'nama_barang' => $atributy->nama_barang,
                    'nama_gudang' => $atributy->nama_gudang,
                    'qty' => $atributy->qty,
                    'expired' => $this->tanggal($atributy->expired)
                    
                );
                
            }

        }
        return $data;

    }

}