
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Data Barang Stok Fisik</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <p>
                                <!-- 
                                <button class="btn btn-success" onclick="add_barang()"><i class="glyphicon glyphicon-plus"></i> Tambah Stok Barang</button> -->
                                <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
                                <button class="btn btn-default" onclick="cetak_expired()"><i class="glyphicon glyphicon-signal"></i> Cetak Expired</button>
                            </p>


                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>id</th>
                                    <th>No Bukti</th>
                                    <th>No Invoice</th>
                                    <th>Nama Barang</th>
                                    <th>Nama Gudang</th>
                                    <th>Qty</th>
                                    <th>Expired</th>
                                    <th>Keterangan</th>
                                    <th>Action</th>
                                </tr>
                                </thead>


                            </table>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /page content -->



<script type="text/javascript">

    var save_method; //for save method string
    var save_method_detail; //for save method string
    var table;
    var table_detail;
    var iterasi = 0;

    $(document).ready(function() {
        //datatables
        table = $('#datatable-responsive').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('admin/transaksi/stok_fisik/get_data_all');?>",
                "type": "POST"
            },
            buttons: [
                {
                    extend: "copy",
                    className: "btn-sm"
                },
                {
                    extend: "csv",
                    className: "btn-sm"
                },
                {
                    extend: "excel",
                    className: "btn-sm"
                },
                {
                    extend: "pdfHtml5",
                    className: "btn-sm"
                },
                {
                    extend: "print",
                    className: "btn-sm"
                }
            ],
            responsive: true,

            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [ -1 ], //last column
                    "orderable": false
                },{
                    "targets": [1],
                    "visible": false
                }
            ]
        });

        table_detailstok = $('#datatable-detailstok').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": false, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            responsive: true,
            columns: [
                { title: "No. Bukti" },
                { title: "Nama Barang" },
                { title: "Nama Gudang" },
                { title: "Expired" },
                { title: "Qty" }
                
            ],
            "columnDefs": [
                {
                    "targets": [ -1 ], //last column
                    "orderable": false
                }

            ]
        });

        //datepicker
        $('.datepicker').datepicker({
            autoclose: true,
            dateFormat: 'dd-mm-yy',
            todayHighlight: true,
            orientation: "top auto",
            todayBtn: true
        });


    });



    function add_barang()
    {
        save_method = 'add';

        $('#tanggal').attr('readonly',false);

        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        //table_detail.clear().draw();

        $('select[name=rak_id]').val();
        $('.selectpicker').selectpicker('refresh');

        $('select[name=barang_id]').val();
        $('.selectpicker').selectpicker('refresh');

        $('select[name=gudang_id]').val();
        $('.selectpicker').selectpicker('refresh');


        get_nobukti();
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Stok Barang'); // Set Title to Bootstrap modal title
    }

    function get_nobukti()
    {
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('admin/transaksi/stok_fisik/get_nobukti/')?>",
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="no_bukti"]').val(data);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

    /*function add_Detailbarang()
    {
        save_method_detail = 'add';
        $('#formDetail')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_formDetail').modal('show'); // show bootstrap modal
    }*/


    function detail_stok($barang)
    {
        
        table_detailstok.clear().draw();

        $.ajax({
            url : "<?php echo site_url('admin/transaksi/stok/stok')?>/"+ $barang,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                //alert(data[0]['detailStok'].length);
                for(var i = 0; i < data[0]['detailStok'].length; i++) {
                    var obj = data[0]['detailStok'][i];
                    table_detailstok.row.add([obj.no_bukti, obj.nama_barang, obj.nama_gudang, obj.expired, obj.qty, obj.action]).draw();
                }

                $('#modal_detail_stok').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Stok Barang'); // Set title to Bootstrap modal title

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });

        $('#modal_detail_stok').modal('show'); // show bootstrap modal
    }

    function edit_stok(id)
    {
        
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        $('#tanggal').attr('readonly',true);

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('admin/transaksi/stok_fisik/edit/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="id"]').val(data[0]['id']);
                $('[name="barang_id"]').val(data[0]['barang_id']);
                $('[name="keterangan"]').val(data[0]['keterangan']);
                $('[name="no_bukti"]').val(data[0]['no_bukti']);
                $('[name="nama_barang"]').val(data[0]['nama_barang']);
                $('[name="qty"]').val(data[0]['qty']);
                $('[name="rak_id"]').val(data[0]['rak_id']);
                $('[name="gudang_id"]').val(data[0]['gudang_id']);
                $('[name="no_rak"]').val(data[0]['no_rak']);
                $('[name="tanggal"]').val(data[0]['tanggal']);
                $('[name="expired"]').val(data[0]['expired']);

                $('select[name=rak_id]').val(data[0]['rak_id']);
                $('.selectpicker').selectpicker('refresh');

                $('select[name=barang_id]').val(data[0]['barang_id']);
                $('.selectpicker').selectpicker('refresh');

                $('select[name=gudang_id]').val(data[0]['gudang_id']);
                $('.selectpicker').selectpicker('refresh');

          
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Ubah Stok Barang'); // Set title to Bootstrap modal title

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
        
       // $('#modal_stok').modal('show'); // show bootstrap modal when complete loaded
    }

    function cekData() {
        var data = table_detail .rows().data();
    }

    function reload_table()
    {
        table.ajax.reload(null,false); //reload datatable ajax
    }

    /*function reload_Detailtable()
    {
        table_detail.ajax.reload(null,false); //reload datatable ajax
    }*/

    function save()
    {

        var url;

        if(save_method === 'add') {
            url = "<?php echo site_url('admin/transaksi/stok_fisik/add')?>";
        } else {
            url = "<?php echo site_url('admin/transaksi/stok_fisik/update')?>";
        }

        seen = [];

        /*json = JSON.stringify(table_detail .rows().data(), function(key, val) {
            if (typeof val === "object") {
                if (seen.indexOf(val) >= 0)
                    return
                    seen.push(val)
            }
            return val
        });*/


        if(!$("#form").validationEngine('validate')){
            return false;
        }

        /*if(!$("#formDetail").validationEngine('validate')){
            return false;
        }*/

        $('#btnSave').text('menyimpan...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable

        // ajax adding data to database
        $.ajax({
            url : url,
            type: "POST",
            data: $('#form').serialize(),
            //data: $('#form').serialize() + "&dataDetail=" + json,
            dataType: "JSON",
            success: function(data)
            {

                if(data.status) //if success close modal and reload ajax table
                {
                    if(save_method === 'add') {
                        $('#modal_form').modal('hide');
                        reload_table();
                    }else{
                        $('#modal_form').modal('hide');
                        reload_table();
                    }

                }

                $('#btnSave').text('simpan'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable


            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
                $('#btnSave').text('simpan'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable

            }
        });
    }




    /*function saveDetail()
    {

        var x = document.getElementById("jenis_barang").title;
        if(x==="Attention : Please choose from among the list."){
            $("#jenis_barang").val("");
            return false;
        }

        if(!$("#formDetail").validationEngine('validate')){
            return false;
        }

        $('#btnSaveDetail').text('menyimpan...'); //change button text
        $('#btnSaveDetail').attr('disabled',true); //set button disable

        var url;

        if(save_method_detail === 'add') {

            var dd =  $('#formDetail').serialize();
            var nama_barang =   $('#modal_formDetail').find('[name="nama_barang"]').val();
            var jenis_barang =   $('#modal_formDetail').find('[name="jenis_barang"]').val();
            var aksi = "<a class='btn btn-sm btn-danger' href='javascript:void(0)' title='Hapus' onclick='hapus_dataDetail()'><i class='glyphicon glyphicon-trash'></i> Delete</a>";

            iterasi++;
            table_detail.row.add(['', jenis_barang, nama_barang, aksi]).draw();

            $('#modal_formDetail').modal('hide');
            $('#btnSaveDetail').text('simpan'); //change button text
            $('#btnSaveDetail').attr('disabled',false); //set button enable

        } else {

        }
    }*/

    /*function hapus_dataDetail() {
        $('#datatable-detail').on( 'click', 'tbody tr', function () {
            table_detail.row( this ).remove().draw();
        } );
    }*/

function delete_barang(id)
    {
        if(confirm('Anda yakin mau menghapus data ini ?'))
        {
            // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('admin/transaksi/stok_fisik/delete')?>/"+id,
                type: "POST",
                dataType: "JSON",
                success: function(data)
                {
                    //if success reload ajax table
                    $('#modal_form').modal('hide');
                    reload_table();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error deleting data');
                }
            });

        }
    }

    

    function cetak_expired()
    {

        if(!$("#form").validationEngine('validate')){
            return false;
        }


        $('#btnCetak').text('proses mencetak...'); //change button text
        $('#btnCetak').attr('disabled',true); //set button disable


        var form_dt = $('#form').serialize();

        eModal.iframe('<?php echo  site_url('admin/laporan/expired_barang/cetak');?>', 'Laporan Mutasi Barang');

        $('#btnCetak').text('Cetak'); //change button text
        $('#btnCetak').attr('disabled',false); //set button enable
    }

</script>

<div class="modal fade" id="modal_stok" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3>Form Detail Stok</h3>
            </div>
            <div class="panel-body">
                <table id="datatable-stok" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Nama Gudang</th>
                            <th>Expired</th>
                            <th>Qty</th>
                        </tr>
                        </thead>
                    </table>
            </div>
            
        </div>
    </div>
</div>

<!-- Bootstrap modal -->
<!-- <div class="modal fade" id="modal_form" role="dialog" style="overflow-y: auto !important;"> -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Stok Barang</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    <input type="hidden" value="" name="nama_barang"/>
                    <input type="hidden" value="" name="no_rak"/>
                    <input type="hidden" value="" name="nama_gudang"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Tgl. Stok<span class="required">*</span></label>
                            <div class="col-md-6">
                                <input placeholder="dd-mm-yyyy" id="tanggal" name="tanggal" class="validate[required] form-control datepicker" type="text" required="required">
                                <span class="help-block"></span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-md-3">Barang<span class="required">*</span></label>
                            <div class="col-md-6">
                                <select id="barang_id" name="barang_id" data-live-search="true"  class="selectpicker validate[required] form-control" required="required">
                                    <option value="">--Pilih Barang--</option>
                                    <?php
                                    foreach ($pilihan_barang as $row3):
                                        ?>
                                        <option value="<?php echo $row3->id; ?>"><?php echo $row3->nama." (".($row3->satuan)." )"; ?></option>
                                        <?php

                                    endforeach;
                                    ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Gudang<span class="required">*</span></label>
                            <div class="col-md-6">
                                <select id="gudang_id" name="gudang_id" data-live-search="true"  class="selectpicker validate[required] form-control" required="required">
                                    <option value="">--Pilih Gudang--</option>
                                    <?php
                                    foreach ($pilihan_gudang as $row4):
                                        ?>
                                        <option value="<?php echo $row4->id; ?>"><?php echo $row4->kode."-".$row4->nama; ?></option>
                                        <?php

                                    endforeach;
                                    ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">No. Bukti <span class="required">*</span></label>
                            <div class="col-md-6">
                                <input name="no_bukti" placeholder="No. Bukti" class="validate[required] form-control" type="text" required="required" data-validate-length-range="6" data-validate-words="2" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Qty<span class="required">*</span></label>
                            <div class="col-md-6">
                                <input name="qty" placeholder="Qty" class="validate[required,custom[number]] form-control" type="text" required="required">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Expired<span class="required">*</span></label>
                            <div class="col-md-6">
                                <input placeholder="dd-mm-yyyy" name="expired" class="validate[required] form-control datepicker" type="text" required="required">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Keterangan <span class="required">*</span></label>
                            <div class="col-md-6">
                                <input name="keterangan" placeholder="Keterangan" class="form-control" type="text" required="required">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>

                <!--<p>
                    <a href="javascript:void(0)" class="btn btn-success" onclick="add_Detailbarang();"><i class="glyphicon glyphicon-plus"></i> Tambah Detail Barang</a>
                </p>-->

                <!--<table id="datatable-detail" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Jenis Barang</th>
                        <th>Barang</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>-->

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->




<div class="modal fade" id="modal_detail_stok" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3>Form Detail Stok</h3>
            </div>
            <div class="panel-body">
                <table id="datatable-detailstok" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>No. Bukti</th>
                            <th>Nama Barang</th>
                            <th>Nama Gudang</th>
                            <th>Expired</th>
                            <th>Qty</th>
                            
                        </tr>
                        </thead>
                    </table>
            </div>
            
        </div>
    </div>
</div>

<!-- Bootstrap modal -->
<!--
<div class="modal fade" id="modal_formDetail" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3>Form Detail Barang</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="formDetail" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Jenis Barang <span class="required">*</span></label>
                            <div class="col-md-9">
                                <input name="jenis_barang" id="jenis_barang" placeholder="Jenis Barang" class="validate[required] form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Barang <span class="required">*</span></label>
                            <div class="col-md-9">
                                <input name="nama_barang" placeholder="Nama Barang" class="validate[required,minSize[6]] form-control" type="text" required="required">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSaveDetail" onclick="saveDetail()" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
-->
<!-- End Bootstrap modal -->

<script>
    $(function() {

        $('#barang_id').on('change', function(){
            //var selected = $(this).find("option:selected").val();
            $('[name="nama_barang"]').val($("#barang_id :selected").text());
        });

        $('#rak_id').on('change', function(){
            //var selected = $(this).find("option:selected").val();
            $('[name="no_rak"]').val($("#rak_id :selected").text());
        });

    })
</script>