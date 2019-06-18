<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Detail_so_model extends MY_Model
{
    public $table = 'detail_so';
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
        $this->db->select('sales_order.id as id_so, detail_so.id as id, sales_order.kode_so as kode_so, detail_so.kode_barang as kode_barang,
            detail_so.nama_barang as nama_barang, detail_so.qty as qty, detail_so.harga as harga, id_detail_barang_masuk, detail_so.harga_beli, bottom_retail, bottom_supplier');
        $this->db->join('sales_order','sales_order.kode_so = detail_so.kode_so');
        $this->db->join('detail_barang_masuk','detail_barang_masuk.id = detail_so.id_detail_barang_masuk');
        $this->db->from($this->table);
        $this->db->where('detail_so.id',$id);
        $query = $this->db->get();

        return $query->row();
    }

    public function get_by_id_pengiriman($id)
    {
        $this->db->select('sales_order.id as id_so, detail_so.id as id, sales_order.kode_so as kode_so, detail_so.kode_barang as kode_barang,
            detail_so.nama_barang as nama_barang, detail_so.qty as qty, detail_so.harga as harga, id_detail_barang_masuk, detail_so.harga_beli, bottom_retail, bottom_supplier, sum(pengiriman_so.qty) as kirim');
        $this->db->join('sales_order','sales_order.kode_so = detail_so.kode_so');
        $this->db->join('detail_barang_masuk','detail_barang_masuk.id = detail_so.id_detail_barang_masuk');
        $this->db->join('pengiriman_so','pengiriman_so.id_detail_so = detail_so.id');
        $this->db->group_by('detail_so.kode_so');
        $this->db->from($this->table);
        //$this->db->where('detail_so.id',$id);
        $this->db->where('pengiriman_so.id',$id);
        $query = $this->db->get();

        return $query->row();
    }


    public function get_by_id_pengirimanx($id)
    {
        $this->db->select('sales_order.id as id_so, detail_so.id as id, sales_order.kode_so as kode_so, detail_so.kode_barang as kode_barang,
            detail_so.nama_barang as nama_barang, detail_so.qty as qty, detail_so.harga as harga, id_detail_barang_masuk, detail_so.harga_beli, bottom_retail, bottom_supplier, sum(pengiriman_so.qty) as kirim');
        $this->db->join('sales_order','sales_order.kode_so = detail_so.kode_so');
        $this->db->join('detail_barang_masuk','detail_barang_masuk.id = detail_so.id_detail_barang_masuk');
        $this->db->join('pengiriman_so','pengiriman_so.id_detail_so = detail_so.id');
        //$this->db->group_by('detail_so.kode_so');
        $this->db->from($this->table);
        //$this->db->where('detail_so.id',$id);
        $this->db->where('pengiriman_so.id',$id);
        $query = $this->db->get();

        return $query->row();
    }

        public function get_by_no_so_barang($no_so, $kode_barang)
    {
        $this->db->from($this->table);
        $this->db->where('kode_so',$no_so);
        $this->db->where('kode_barang',$kode_barang);
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

     public function delete_by_no_so($id)
    {
        $this->db->where('kode_so', $id);
        $this->db->delete($this->table);
    }

    public function delete_by_no_bukti($no_bukti)
    {
        $this->db->where('no_bukti', $no_bukti);
        $this->db->delete($this->table);
    }

    public function update_by_no_so_barang($so, $barang, $data)
    {   

        $this->db->where('kode_so',$so);
        $this->db->where('kode_barang',$barang);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }

    public function update_by_id($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

    public function getDataByNoSO($id){
        $data = array();
        $this->db->select('detail_so.id as id, sales_order.kode_so as kode_so, detail_so.kode_barang as kode_barang,
            detail_so.nama_barang as nama_barang, detail_so.qty as qty, detail_so.harga as harga');
        $this->db->join('sales_order','sales_order.kode_so = detail_so.kode_so');
        
        $this->db->where('sales_order.id',$id);
        $this->db->group_by('detail_so.kode_so');
        $this->db->group_by('detail_so.kode_barang');
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {
                $total = $atributy->harga * $atributy->qty;
                
                $this->db->select('sum(qty) as kirim');
                $this->db->where('kode_so',$atributy->kode_so);
                $this->db->where('kode_barang',$atributy->kode_barang);
                //$this->db->where('id_detail_sox',$atributy->id);
                $query_kirim = $this->db->get('pengiriman_so');                    
                $totaly2x = $query_kirim->num_rows();

                if ($totaly2x > 0) {
                    foreach ($query_kirim->result() as $atributy_kirim) {
                        $jumlah_kirim = $atributy_kirim->kirim;
                    }
                }else{
                    $jumlah_kirim = 0;
                }

                if($atributy->qty > $jumlah_kirim){

                    

                    $data[] = array(
                    'id' => $atributy->id,
                    'kode_so' => $atributy->kode_so,
                    'kode_barang' => $atributy->kode_barang,
                    'nama_barang' => $atributy->nama_barang,
                    'qty' => $atributy->qty,
                    'harga' => number_format((($atributy->harga)?$atributy->harga:'0'),0,",","."),
                    'total' => number_format((($total)?$total:'0'),0,",","."),

                    //'harga' => $atributy->harga,
                    //'total' => ,
                    'kirim' => $jumlah_kirim,                    
                    'action' => '<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Kirim" onclick="kirim_so('."'".$atributy->id."'".')"><i class="glyphicon glyphicon-share"></i> Pengiriman</a>
                        <a class="btn btn-sm btn-success" href="javascript:void(0)" title="Return" onclick="return_so('."'".$atributy->id."'".')"><i class="glyphicon glyphicon-repeat"></i> Return</a>'    
                    
                    );
                }else{
                    $data[] = array(
                    'id' => $atributy->id,
                    'kode_so' => $atributy->kode_so,
                    'kode_barang' => $atributy->kode_barang,
                    'nama_barang' => $atributy->nama_barang,
                    'qty' => $atributy->qty,
//                    'harga' => $atributy->harga,
  //                  'total' => $atributy->harga * $atributy->qty,
                    'harga' => number_format((($atributy->harga)?$atributy->harga:'0'),0,",","."),
                    'total' => number_format((($total)?$total:'0'),0,",","."),
                    'kirim' => $jumlah_kirim,
                    'action' => '<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Return" onclick="return_so('."'".$atributy->id."'".')"><i class="glyphicon glyphicon-repeat"></i>Return</a>'
                     );
                }    
            }

        }
        return $data;

    }

    public function getDataByNoSOx($id){
        $data = array();
        $this->db->select('detail_so.id as id, sales_order.kode_so as kode_so, detail_so.kode_barang as kode_barang,
            detail_so.nama_barang as nama_barang, detail_so.qty as qty, detail_so.harga as harga');
        $this->db->join('sales_order','sales_order.kode_so = detail_so.kode_so');
        
        $this->db->where('sales_order.id',$id);
        //$this->db->group_by('detail_so.kode_so');
        //$this->db->group_by('detail_so.kode_barang');
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {
                $total = $atributy->harga * $atributy->qty;
                
                $this->db->select('ifnull(sum(qty),0) as kirim');
                //$this->db->where('kode_so',$atributy->kode_so);
                //$this->db->where('kode_barang',$atributy->kode_barang);
                $this->db->where('id_detail_so',$atributy->id);
                $query_kirim = $this->db->get('pengiriman_so');                    
                $totaly2x = $query_kirim->num_rows();

                if ($totaly2x > 0) {
                    foreach ($query_kirim->result() as $atributy_kirim) {
                        
                        if($atributy_kirim->kirim == 0){
                            $this->db->select('sum(qty) as kirim');
                            $this->db->where('kode_so',$atributy->kode_so);
                            $this->db->where('kode_barang',$atributy->kode_barang);
                            $this->db->where('id_detail_so',null);
                            $query_kirim2 = $this->db->get('pengiriman_so');                    
                            $totaly2x2 = $query_kirim2->num_rows();

                            if ($totaly2x2 > 0) {
                                foreach ($query_kirim2->result() as $atributy_kirim2) {
                                    $jumlah_kirim = $atributy_kirim2->kirim;
                                }
                            }else{
                                $jumlah_kirim = 0;
                            }
                        }else{
                            
                            $jumlah_kirim = $atributy_kirim->kirim;    
                        }
                        
                    }
                }else{
                    $jumlah_kirim = 0;

                    
                }

                if($atributy->qty > $jumlah_kirim){

                    

                    $data[] = array(
                    'id' => $atributy->id,
                    'kode_so' => $atributy->kode_so,
                    'kode_barang' => $atributy->kode_barang,
                    'nama_barang' => $atributy->nama_barang,
                    'qty' => $atributy->qty,
                    'harga' => number_format((($atributy->harga)?$atributy->harga:'0'),0,",","."),
                    'total' => number_format((($total)?$total:'0'),0,",","."),

                    //'harga' => $atributy->harga,
                    //'total' => ,
                    'kirim' => $jumlah_kirim,                    
                    'action' => '<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Kirim" onclick="kirim_so('."'".$atributy->id."'".')"><i class="glyphicon glyphicon-share"></i> Pengiriman</a>
                        <a class="btn btn-sm btn-success" href="javascript:void(0)" title="Return" onclick="return_so('."'".$atributy->id."'".')"><i class="glyphicon glyphicon-repeat"></i> Return</a>'    
                    
                    );
                }else{
                    $data[] = array(
                    'id' => $atributy->id,
                    'kode_so' => $atributy->kode_so,
                    'kode_barang' => $atributy->kode_barang,
                    'nama_barang' => $atributy->nama_barang,
                    'qty' => $atributy->qty,
//                    'harga' => $atributy->harga,
  //                  'total' => $atributy->harga * $atributy->qty,
                    'harga' => number_format((($atributy->harga)?$atributy->harga:'0'),0,",","."),
                    'total' => number_format((($total)?$total:'0'),0,",","."),
                    'kirim' => $jumlah_kirim,
                    'action' => '<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Return" onclick="return_so('."'".$atributy->id."'".')"><i class="glyphicon glyphicon-repeat"></i>Return</a>'
                     );
                }    
            }

        }
        return $data;

    }

    public function get_total_qty_so($noSo)
    {
        $this->db->select('sum(qty) as total');
        $this->db->from($this->table);

        $this->db->where('kode_so',$noSo);
        $query = $this->db->get();

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $total_order = $atributy->total ;
                
            }

        }
        return $total_order;
    }

    public function get_jumlah_barang_between($awal, $akhir){
        $data = array();
        $this->db->select('detail_so.kode_barang as kode_barang, barang.satuan as satuan,
            detail_so.nama_barang as nama_barang, sum(detail_so.qty) as qty');
        $this->db->join('sales_order','sales_order.kode_so = detail_so.kode_so');
        $this->db->join('barang','barang.kode = detail_so.kode_barang');
        $this->db->where('sales_order.tanggal >= ',$awal);
        $this->db->where('sales_order.tanggal <= ',$akhir);
        $this->db->group_by('detail_so.kode_barang');
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {

                $data[] = array(
                'kode_barang' => $atributy->kode_barang,
                'nama_barang' => $atributy->nama_barang,
                'qty' => $atributy->qty,
                'satuan' => $atributy->satuan,
                    
                );
            }

        }
        return $data;

    }


    public function getDataByNoSoCetak($id){
        $data = array();
        $this->db->select('detail_so.id as id, sales_order.kode_so as kode_so, detail_so.kode_barang as kode_barang,
            detail_so.nama_barang as nama_barang, detail_so.qty as qty, detail_so.harga as harga');
        $this->db->join('sales_order','sales_order.kode_so = detail_so.kode_so');
        $this->db->join('barang','barang.kode = detail_so.kode_barang','left');
        //$this->db->join('pengiriman_so','pengiriman_so.kode_so = detail_so.kode_so','left');
        $this->db->where('sales_order.id',$id);
        $query = $this->db->get($this->table);

        $totaly2 = $query->num_rows();
        if ($totaly2 > 0) {
            foreach ($query->result() as $atributy) {
                    $data[] = array(
                    'id' => $atributy->id,
                    'kode_so' => $atributy->kode_so,
                    'kode_barang' => $atributy->kode_barang,
                    'nama_barang' => $atributy->nama_barang,
                    'qty' => $atributy->qty,
                    'harga' => $atributy->harga,
                    'total' => $atributy->harga * $atributy->qty
          //          'kirim' => $atributy->kirim,
                    );       
            }

        }
        return $data;

    }
}