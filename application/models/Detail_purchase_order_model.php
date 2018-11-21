<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Detail_purchase_order_model extends MY_Model
{
    public $table = 'detail_po';
    public $primary_key = 'id';
    //public $column_order = array(null, 'id','nomor_invoice','nama_barang','qty','',null);
    //public $column_search = array('id','tanggal','nomor_invoice','keterangan');
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


    public function delete_by_id($id)
    {
        $this->db->where($this->primary_key, $id);
        $this->db->delete($this->table);
    }

    public function delete_by_no_bukti($no_bukti)
    {
        $this->db->where('no_bukti', $no_bukti);
        $this->db->delete($this->table);
    }

  

    public function update_by_id($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

   


    public function total_masuk_pertahun(){
        $total_masuk_pertahun = array();
        $tahun = date('Y');
        $this->db->select("
            -- ifnull(round(sum(qty) / 1000,1),0) as total_masuk
            ifnull(sum(qty),0)  as total_masuk
        ");
        $this->db->where("tanggal like '%$tahun%' ");
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $total_masuk_pertahun = $atributy->total_masuk ;
                
            }

        }
        return $total_masuk_pertahun;

    }

    public function getByNoPo($id){
        $data = array();
        
     $this->db->select(" detail_po.id as id,
            purchase_order.kode_po as kode_po,
            detail_po.kode_barang as kode_barang, detail_po.nama_barang as nama_barang, qty, harga, detail_po.id as id, detail_po.status as status, sum(ifnull(detail_penerimaan_po.qty_terima,0)) as terima
        ");
        $this->db->join('purchase_order','purchase_order.kode_po = detail_po.kode_po');
        $this->db->join('penerimaan_po','penerimaan_po.kode_po = purchase_order.kode_po','left');
        $this->db->join('detail_penerimaan_po','detail_penerimaan_po.kode_penerimaan_po = penerimaan_po.kode_penerimaan_po and detail_penerimaan_po.kode_barang = detail_po.kode_barang','left');
        $this->db->group_by('purchase_order.kode_po, detail_po.kode_barang');
        $this->db->where('purchase_order.id',$id);
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                if($atributy->terima >= $atributy->qty ){
                    $data[] = array(
                    'id' => $atributy->id,
                    'kode_po' => $atributy->kode_po,
                    'kode_barang' => $atributy->kode_barang,
                    'nama_barang' => $atributy->nama_barang,
                    'qty' => $atributy->qty,
                    'harga' => $atributy->harga,
                    'total' => $atributy->harga * $atributy->qty,
                    'terima' => $atributy->terima,
                    'action' => ''
                    
                );
                }else{
                    $data[] = array(
                    'id' => $atributy->id,
                    'kode_po' => $atributy->kode_po,
                    'kode_barang' => $atributy->kode_barang,
                    'nama_barang' => $atributy->nama_barang,
                    'qty' => $atributy->qty,
                    'harga' => $atributy->harga,
                    'total' => $atributy->harga * $atributy->qty,
                    'terima' => $atributy->terima,
                    'action' => '<a class="btn btn-sm btn-success terima-detail" href="javascript:void(0)" title="Terima" onclick="terima_po('."'".$atributy->id."'".')"><i class="glyphicon glyphicon-check"></i> Terima</a>'    
                    
                );
                }
                
            }

        }
        return $data;

    }    

}