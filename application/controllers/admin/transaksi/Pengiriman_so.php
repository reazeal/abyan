<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Pudak Digital
 * Date: 5/31/2017
 * Time: 1:14 PM
 */

/**
 * @property  ion_auth $ion_auth
 * @property  barang_model $barang_model
 * @property  datatables $datatables
 * @property  barang_keluar_model $barang_keluar_model
 * @property  barang_masuk_model $barang_masuk_model
 * @property  rak_model $rak_model
 * @property  stok_fisik_model $stok_fisik_model
 */
class Pengiriman_so extends Admin_Controller {

    function __construct() {
        parent::__construct();
     //   if (!$this->ion_auth->in_group('admin')) {
     //       redirect('auth/session_not_authorized', 'refresh');
     //   }
        $this->load->library('form_validation');
        $this->load->helper('text');
        $this->load->helper('url');
        $this->load->model('barang_model');
        $this->load->model('pengiriman_so_model');
        $this->load->model('sales_order_model');
        $this->load->model('stok_model');
        $this->load->model('penerimaan_po_model');
        $this->load->model('piutang_model');
        $this->load->model('barang_keluar_model');
        $this->load->model('detail_barang_keluar_model');
        $this->load->model('detail_barang_masuk_model');
        $this->load->model('detail_so_model');
        $this->load->model('transaksi_biaya_model');
        $this->load->model('pegawai_model');
        $this->load->model('return_masuk_model');
        $this->load->model('barang_masuk_model');
    }

    public function index() {
        //$this->data['pilihan_barang'] = $this->barang_model->get_all();
        //$this->data['pilihan_rak'] = $this->rak_model->get_all();
        //$this->data['pilihan_gudang'] = $this->gudang_model->get_all();
        $this->data['pilihan_pegawai'] = $this->pegawai_model->get_all();
        $this->render('admin/transaksi/Pengiriman_so_view');
    }

    public function get_nobukti() {

        $no_bukti = $this->stok_fisik_model->get_nobukti();

        echo json_encode($no_bukti);
    }

    public function get_data_all() {

        $list = $this->pengiriman_so_model->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $dt) {
            $status = $this->detail_so_model->get_by_no_so_barang($dt->kode_so,$dt->kode_barang);
            //print_r($status);
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $dt->id;
            $row[] = $this->tanggal($dt->tanggal);
            $row[] = $dt->kode_pengiriman;
            $row[] = $dt->kode_so;
            $row[] = $dt->kode_kurir;
            $row[] = $dt->nama_kurir;
            $row[] = $dt->qty;
            $row[] = $dt->keterangan;
            
            if($status->status == 'Terkirim'){
              $row[] = '';
              /*
                $row[] = ' <a class="btn btn-sm btn-success" href="javascript:void(0)" title="Return" onclick="return_so(' . "'" . $dt->id . "'" . ')"><i class="glyphicon glyphicon-repeat"></i> Return</a>';
                */
            }else{
                /*
                $row[] = '<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Kirim" onclick="terima_barang(' . "'" . $dt->id . "'" . ')"><i class="glyphicon glyphicon-share"></i> Terima</a>'
                    . ' <a class="btn btn-sm btn-success" href="javascript:void(0)" title="Return" onclick="return_so(' . "'" . $dt->id . "'" . ')"><i class="glyphicon glyphicon-repeat"></i> Return</a>';
                    */
                $row[] = '<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Kirim" onclick="terima_barang(' . "'" . $dt->id . "'" . ')"><i class="glyphicon glyphicon-share"></i> Terima</a>';
            }
            
           // $row[] = $status->status;
            /*
            $row[] = '<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Kirim" onclick="terima_barang(' . "'" . $dt->id . "'" . ')"><i class="glyphicon glyphicon-share"></i> Terima</a>';
            */
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->pengiriman_so_model->count_all(),
            "recordsFiltered" => $this->pengiriman_so_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function get($id) {
        // echo $id;
        // die();
        $data = $this->hutang_model->get_by_id($id);
        $data = array(
            'id' => $data->id,
            'kode_hutang' => $data->kode_hutang,
            'nomor_referensi' => $data->nomor_referensi,
            'kode_relasi' => $data->kode_relasi,
            'nama_relasi' => $data->nama_relasi,
            'nominal' => $data->nominal,
                //  'detailBarang'=> (array) $this->detail_barang_model->getDataByTransaksi($id)
        );
        echo json_encode(array($data));
    }

    public function add() {

        $tanggal_asli = explode("-", $this->tanggaldb($this->input->post('tanggal')));
        $jumlah_kirim = $this->pengiriman_so_model->total_pengiriman_so_perbulan_tahun($tanggal_asli[1], $tanggal_asli[0]);
        if ($jumlah_kirim == 0) {
            $jumlah = 1;
            $kode_awal = "001";
        } else {
            $jumlah = $jumlah_kirim + 1;

            if (strlen($jumlah) == 1) {
                $kode_awal = "00" . $jumlah;
            } else if (strlen($jumlah) == 2) {
                $kode_awal = "0" . $jumlah;
            } else {
                $kode_awal = $jumlah;
            }
        }
        $kode_kirim = $kode_awal . "/PN/" . $tanggal_asli[1] . "/" . $tanggal_asli[0];

        //input pengiriman
        $this->_inputpengiriman($kode_kirim, $tanggal_asli, $kode_awal, $this->input->post('id'));

        //update barang keluar
        $this->_barang_keluar($kode_kirim, $tanggal_asli, $this->input->post('qty_kirim'));

        //insert biaya kardus
        $data_biaya_kardus = array(
            'id' => md5(rand(1, 100) . '62cce0f72ae42c43f71f7c2c74ce65ba' . $this->input->post('tanggal') . $this->input->post('kode_so') . date("YmdHis")),
            'kode_referensi' => $this->input->post('kode_so'),
            'tanggal' => $this->tanggaldb($this->input->post('tanggal')),
            'nominal' => $this->input->post('biaya_kardus'),
            'id_jenis_biaya' => '7c413a3bfa29d65702df7c60fb554bf6',
            'status' => 'Pending',
        );
        $this->transaksi_biaya_model->insert($data_biaya_kardus);

        //insert transaksi biaya
        $data_so_bunga = $this->detail_so_model->get_by_no_so_barang($this->input->post('kode_so'), $this->input->post('kode_barang'));
        $data_bunga_bank = array(
            'id' => md5(rand(1, 100) . 'e6026106cfb7f0075ec6063cbd82307c' . $this->input->post('tanggal') . $this->input->post('kode_so') . date("YmdHis")),
            'kode_referensi' => $this->input->post('kode_so'),
            'tanggal' => $this->tanggaldb($this->input->post('tanggal')),
            'nominal' => $data_so_bunga->harga * 2.5 / 100,
            'id_jenis_biaya' => '5e07f1f86d4fc32542a2df57d8339a2d',
            'status' => 'Pending',
        );
        $this->transaksi_biaya_model->insert($data_bunga_bank);

        echo json_encode(array("status" => TRUE));
    }

    public function add_terima() {


//        die();

        $tanggal_asli = explode("-", $this->tanggaldb($this->input->post('tanggal')));
        $jumlah_kirim = $this->pengiriman_so_model->total_pengiriman_so_perbulan_tahun($tanggal_asli[1], $tanggal_asli[0]);
        if ($jumlah_kirim == 0) {
            $jumlah = 1;
            $kode_awal = "001";
        } else {
            $jumlah = $jumlah_kirim + 1;

            if (strlen($jumlah) == 1) {
                $kode_awal = "00" . $jumlah;
            } else if (strlen($jumlah) == 2) {
                $kode_awal = "0" . $jumlah;
            } else {
                $kode_awal = $jumlah;
            }
        }
        $kode_kirim = $kode_awal . "/PN/" . $tanggal_asli[1] . "/" . $tanggal_asli[0];

        //update piutang
        //update 20201009
        // $this->_updatepiutang($kode_kirim, $tanggal_asli);
        // tess
        $this->_updatepiutang($this->input->post('kode_so'), $tanggal_asli);

        //update status SO terkirim
        $data_so = array(
            'status' => 'Terkirim'
        );
        //$this->sales_order_model->update_by_no_so($this->input->post('kode_so'), $data_so);
        $this->detail_so_model->update_by_no_so_barang($this->input->post('kode_so'), $this->input->post('kode_barang'), $data_so);

        // barang keluar
//        $this->_barang_keluar($kode_kirim, $tanggal_asli, $this->input->post('qty_terima'));

        //update retur
        if($this->input->post('qty_return') != 0){
            $this->_retur();
        }
        

        //update biaya lunas
        $this->transaksi_biaya_model->update_by_id(array('kode_referensi' => $this->input->post('kode_so')), array('status' => 'Lunas'));

        echo json_encode(array("status" => TRUE));
    }

    public function _inputpengiriman($kode_kirim, $tanggal_asli, $kode_awal, $id_detail_so) {
        $pegawai = explode("-", $this->input->post('nama_pegawai'));

        $kode_kirim = $kode_awal . "/PN/" . $tanggal_asli[1] . "/" . $tanggal_asli[0];
        $id_rand = rand(1, 100);
        $id = md5($id_rand . $kode_kirim . date("YmdHis"));
        $data = array(
            'id' => $id,
            'id_detail_so' => $id_detail_so,
            'kode_pengiriman' => $kode_kirim,
            'kode_so' => $this->input->post('kode_so'),
            'tanggal' => $this->tanggaldb($this->input->post('tanggal')),
            'qty' => $this->input->post('qty_kirim'),
            'kode_barang' => $this->input->post('kode_barang'),
            'nama_barang' => $this->input->post('nama_barang'),
            'kode_kurir' => $pegawai[0],
            'nama_kurir' => $pegawai[1]
        );
        $insert = $this->pengiriman_so_model->save($data);

        $order = $this->detail_so_model->get_total_qty_so($this->input->post('kode_so'));

        $kirim = $this->pengiriman_so_model->get_total_kirim_by_so($this->input->post('kode_so'));

        // die();
        //echo $order;
        //echo $kirim;
        if ($order > $kirim) {
            $status_order = "Proses";
            //  echo "satu";
        } else {
            $status_order = "Selesai";
            //echo "dua";
        }

        //die();

        $data_so = array(
            'status' => $status_order
        );
        $this->sales_order_model->update_by_no_so($this->input->post('kode_so'), $data_so);
    }

    public function _updatepiutang($kode_kirim, $tanggal_asli) {
        //input/update piutang
        $piutang_so = $this->piutang_model->get_piutang_by_kode_kirim($kode_kirim);

        if ($piutang_so == null) {
            $so = $this->sales_order_model->get_by_noSO($this->input->post('kode_so'));
            $jumlah_piutang = $this->piutang_model->total_piutang_perbulan_tahun($tanggal_asli[1], $tanggal_asli[0]);
            if ($jumlah_piutang == 0) {
                $jumlah_p = 1;
                $kode_awal = "001";
            } else {
                $jumlah_p = $jumlah_piutang + 1;

                if (strlen($jumlah_piutang) == 1) {
                    $kode_awal = "00" . $jumlah_p;
                } else if (strlen($jumlah_piutang) == 2) {
                    $kode_awal = "0" . $jumlah_p;
                } else {
                    $kode_awal = $jumlah_p;
                }
            }
            $kode_piutang = $kode_awal . "/PI/" . $tanggal_asli[1] . "/" . $tanggal_asli[0];
            $rand_piutang = rand(1, 100);
            $id_piutang = md5($kode_piutang . $rand_piutang . date("YmdHis") . $jumlah_piutang);
            $jatuh_tempo = $this->penerimaan_po_model->get_by_jatuh_tempo($this->tanggaldb($this->input->post('tanggal')), $so->top);

            $data_piutang = array(
                'id' => $id_piutang,
                'kode_piutang' => $kode_piutang,
                'kode_referensi' => $so->kode_so,
                'kode_bantu' => $so->kode_so,
                'kode_relasi' => $so->kode_customer,
                'nama_relasi' => $so->nama_customer,
                'jenis' => 'Penjualan',
                'nominal' => $this->input->post('qty_terima') * $this->input->post('harga'),
                'tanggal' => $this->tanggaldb($this->input->post('tanggal')),
                'tanggal_jatuh_tempo' => $jatuh_tempo,
                'status' => 'Belum Lunas',
            );
            $this->piutang_model->save($data_piutang);
        } else {
            $nominal = ( $this->input->post('qty_terima') * $this->input->post('harga') ) + $piutang_so->nominal;
            $data_piutang_baru = array(
                'nominal' => $nominal
            );
            // $this->piutang_model->update_by_kode($data_piutang->kode_piutang, $data_piutang_baru);
            $this->piutang_model->update_by_kode($this->input->post('kode_so'), $data_piutang_baru);
        }
        //end of piutang
    }

    public function _barang_keluar($kode_kirim, $tanggal_asli, $qty_keluar) {
        $kode_keluar = $this->barang_keluar_model->get_kode_by_kode_keluar($kode_kirim, $this->tanggaldb($this->input->post('tanggal')));
        if ($kode_keluar == null) {

            $jumlah_keluar = $this->barang_keluar_model->total_keluar_perbulan_tahun($tanggal_asli[1], $tanggal_asli[0]);

            if ($jumlah_keluar == 0) {
                $jumlah = 1;
                $kode_awal = "001";
            } else {
                $jumlah = $jumlah_keluar + 1;

                if (strlen($jumlah) == 1) {
                    $kode_awal = "00" . $jumlah;
                } else if (strlen($jumlah) == 2) {
                    $kode_awal = "0" . $jumlah;
                } else {
                    $kode_awal = $jumlah;
                }
            }

            $kode_barang_keluar = $kode_awal . "/BK/" . $tanggal_asli[1] . "/" . $tanggal_asli[0];

            $id_barang_keluar = md5(rand(1, 100) . 'barang-keluar' . $this->input->post('kode_so') . $this->input->post('kode_barang') . $this->input->post('qty') . $qty_keluar . date('YmdHis'));

            $data_barang_keluar = array(
                'id' => $id_barang_keluar,
                'kode_barang_keluar' => $kode_barang_keluar,
                'jenis_trans' => 'PENGIRIMAN',
                'nomor_referensi' => $this->input->post('kode_so'),
                'tanggal' => $this->tanggaldb($this->input->post('tanggal'))
            );
            $insert = $this->barang_keluar_model->save($data_barang_keluar);

            $id_detail_keluar = md5($this->input->post('kode_barang') . rand(1, 100) . $id_barang_keluar . $kode_barang_keluar . 'detail_keluar' . date('YmdHis'));

            $data_detail_barang = array(
                'kode_barang_keluar' => $kode_barang_keluar,
                'id' => $id_detail_keluar,
                'nomor_referensi' => $kode_kirim,
                'kode_barang' => $this->input->post('kode_barang'),
                'nama_barang' => $this->input->post('nama_barang'),
                'qty' => $qty_keluar,
                'id_detail_barang_masuk' => $this->input->post('id_detail_barang_masuk'),
            );

            $this->detail_barang_keluar_model->insert($data_detail_barang);
        } else {
            $id_detail_keluar = md5($this->input->post('kode_barang') . rand(1, 100) . $kode_keluar . 'detail_keluar' . date('YmdHis'));

            $data_detail_barang = array(
                'kode_barang_keluar' => $kode_keluar,
                'id' => $id_detail_keluar,
                'nomor_referensi' => $kode_kirim,
                'kode_barang' => $this->input->post('kode_barang'),
                'nama_barang' => $this->input->post('nama_barang'),
                'qty' => $qty_keluar,
                'id_detail_barang_masuk' => $this->input->post('id_detail_barang_masuk'),
            );

            $this->detail_barang_keluar_model->insert($data_detail_barang);
        }
    }

    public function _retur() {

        $tanggal_asli = explode("-", $this->tanggaldb($this->input->post('tanggal')));

        $data_return = $this->return_masuk_model->total_return_perbulan_tahun($tanggal_asli[1], $tanggal_asli[0]);

        if ($data_return == 0) {
            $jumlah = 1;
            $kode_awal = "001";
        } else {
            $jumlah = $data_return + 1;

            if (strlen($jumlah) == 1) {
                $kode_awal = "00" . $jumlah;
            } else if (strlen($jumlah) == 2) {
                $kode_awal = "0" . $jumlah;
            } else {
                $kode_awal = $jumlah;
            }
        }

        $kode = $kode_awal . "/RM/" . $tanggal_asli[1] . "/" . $tanggal_asli[0];

        $no = rand(1, 100);

        $id = md5($kode . $no . 'return-so' . $this->input->post('kode_po') . $this->input->post('kode_barang') . date('YmdHis') . $this->input->post('qty'));



        $data = array(
            'id' => $id,
            'kode_return_masuk' => $kode,
            'tanggal' => $this->tanggaldb($this->input->post('tanggal')),
            'kode_so' => $this->input->post('kode_so'),
            'kode_barang' => $this->input->post('kode_barang'),
            'nama_barang' => $this->input->post('nama_barang'),
            'qty' => $this->input->post('qty_return'),
            'alasan_return' => $this->input->post('alasan_return'),
        );
        $insert = $this->return_masuk_model->save($data);

        $jumlah_masuk = $this->barang_masuk_model->total_masuk_perbulan_tahun($tanggal_asli[1], $tanggal_asli[0]);

        if ($jumlah_masuk == 0) {
            $jumlah = 1;
            $kode_awal = "001";
        } else {
            $jumlah = $jumlah_masuk + 1;

            if (strlen($jumlah_masuk) == 1) {
                $kode_awal = "00" . $jumlah;
            } else if (strlen($jumlah_masuk) == 2) {
                $kode_awal = "0" . $jumlah;
            } else {
                $kode_awal = $jumlah;
            }
        }

        $kode_barang_masuk = $kode_awal . "/BM/" . $tanggal_asli[1] . "/" . $tanggal_asli[0];

        $id_barang_masuk = md5(rand(1, 100) . 'barang-masuk' . $this->input->post('kode_so') . $this->input->post('kode_barang') . $this->input->post('qty') . $this->input->post('qty_terima') . date('YmdHis'));

        $data_barang_masuk = array(
            'id' => $id_barang_masuk,
            'kode_barang_masuk' => $kode_barang_masuk,
            'jenis_trans' => 'RETURN',
            'nomor_referensi' => $kode,
            'tanggal' => $this->tanggaldb($this->input->post('tanggal'))
        );
        $insert = $this->barang_masuk_model->save($data_barang_masuk);

        $id_detail_masuk = md5($this->input->post('kode_barang') . rand(1, 100) . $id_barang_masuk . $kode_barang_masuk . 'detail_po_masuk' . date('YmdHis'));

        $data_detail_barang = array(
            'kode_barang_masuk' => $kode_barang_masuk,
            'id' => $id_detail_masuk,
            'nomor_referensi' => $kode,
            'kode_barang' => $this->input->post('kode_barang'),
            'nama_barang' => $this->input->post('nama_barang'),
            'qty' => $this->input->post('qty_return'),
            'harga_beli' => $this->input->post('harga'),
            'bottom_retail' => $this->input->post('bottom_retail'),
            'bottom_supplier' => $this->input->post('bottom_supplier'),
            'keluar' => 0
        );

        $this->detail_barang_masuk_model->insert($data_detail_barang);
    }

    public function update() {
        $datax = $this->input->post('dataDetail');
        $json = json_decode($datax);

        $gudang = $this->gudang_model->get($this->input->post('gudang_id'));

        $data = array(
            'barang_id' => $this->input->post('barang_id'),
            'keterangan' => $this->input->post('keterangan'),
            'nama_barang' => $this->input->post('nama_barang'),
            'qty' => $this->input->post('qty'),
            'gudang_id' => $this->input->post('gudang_id'),
            'nama_gudang' => $gudang->kode . '-' . $gudang->nama
        );
        $this->stok_model->update_by_id(array('id' => $this->input->post('id')), $data);



        echo json_encode(array("status" => TRUE));
    }

    public function delete($id) {
        /* $datay = $this->detail_barang_model->getDataByTransaksi($id);
          foreach ($datay as $rw) :
          $this->detail_barang_model->delete($rw['id']);
          endforeach; */

        //$this->stok_fisik_model->delete($id);

        $data = $this->stok_fisik_model->get($id);

        print_r($data);
        die();
        $stok_barang = $this->stok_fisik_model->getJumlahStokBarang($data->barang_id);

        $stok_limit = $this->barang_model->get($data->barang_id);
        $jumlah_stok_limit = $stok_limit->batas_stok;

        if ($stok_barang < $jumlah_stok_limit) {
            $status = 'Stok Limit';
        } else {
            $status = 'Stok Baik';
        }

        $data_barang = array(
            'status_stok' => $status
        );

        $this->barang_model->update_by_id(array('id' => $data->barang_id), $data_barang);


        echo json_encode(array("status" => TRUE));
    }

    public function combo_jenis_barang() {
        $and_or = $this->input->get('and_or');
        $order_by = $this->input->get('order_by');
        $page_num = $this->input->get('page_num');
        $per_page = $this->input->get('per_page');
        $q_word = $this->input->get('q_word');
        $search_field = $this->input->get('search_field');

        $datanya = $this->barang_model->combo_jenis_barang($and_or, $order_by, $page_num, $per_page, $q_word, $search_field);
        echo json_encode($datanya);
    }

    public function stok($barang) {
        //$data = $this->barang_masuk_model->get($id);
        $data = array(
            'detailStok' => (array) $this->stok_fisik_model->getStokByBarangId($barang)
        );
        echo json_encode(array($data));
    }

}
