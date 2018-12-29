
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Data Pengiriman SO</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <p>
                                <!-- 
                                <button class="btn btn-success" onclick="add_barang()"><i class="glyphicon glyphicon-plus"></i> Tambah piutang Barang</button> -->
                                <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
                            </p>


                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>id</th>
                                    <th>Tanggal</th>
                                    <th>Kode Pengiriman</th>
                                    <th>Kode SO</th>
                                    <th>Kode Kurir</th>
                                    <th>Nama Kurir</th>
                                    <th>Qty</th>
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
                "url": "<?php echo site_url('admin/transaksi/pengiriman_so/get_data_all');?>",
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
                },
                {
                    "targets": [5],
                    "visible": false
                }
            ]
        });

        table_detailpiutang = $('#datatable-detailpiutang').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": false, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            responsive: true,
            columns: [
                { title: "Id" },
                { title: "No. Bukti" },
                { title: "Nama Barang" },
                { title: "Nama Gudang" },
                { title: "Expired" },
                { title: "Qty" }
                
            ],
            "columnDefs": [
                {
                    "targets": [ 0 ], //last column
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

    function kirim_so(id)
    {

        //$('#modal_detail_so').modal('hide');

        save_method = 'update';
        $('#form_kirim')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('admin/transaksi/sales_order/edit/')?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="id_so"]').val(data[0]['id_so']);                
                $('[name="id"]').val(data[0]['id']);
                $('[name="kode_so"]').val(data[0]['kode_so']);
                $('[name="kode_barang"]').val(data[0]['kode_barang']);
                $('[name="nama_barang"]').val(data[0]['nama_barang']);
                $('[name="harga"]').val(data[0]['harga']);
                $('[name="qty_order"]').val(data[0]['qty']);
                
                $('[name="id_detail_barang_masuk"]').val(data[0]['id_detail_barang_masuk']);
                $('#modal_form_kirim').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Kirim Sales Order'); // Set title to Bootstrap modal title

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
    
    function return_so(id)
    {
        save_method = 'update';
        $('#form_return')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('admin/transaksi/sales_order/edit/')?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="id_so"]').val(data[0]['id_so']);                
                $('[name="id"]').val(data[0]['id']);
                $('[name="kode_so"]').val(data[0]['kode_so']);
                $('[name="kode_barang"]').val(data[0]['kode_barang']);
                $('[name="nama_barang"]').val(data[0]['nama_barang']);
                $('[name="harga"]').val(data[0]['harga']);
                $('[name="qty_order"]').val(data[0]['qty']);
                $('[name="harga"]').val(data[0]['harga']);
                $('[name="harga_beli"]').val(data[0]['harga_beli']);
                $('[name="bottom_supplier"]').val(data[0]['bottom_supplier']);
                $('[name="bottom_retail"]').val(data[0]['bottom_retail']);
                $('[name="id_detail_barang_masuk"]').val(data[0]['id_detail_barang_masuk']);
                //$('#modal_form_kirim').modal('show'); // show bootstrap modal when complete loaded
                $('#modal_form_return').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Return Sales Order'); // Set title to Bootstrap modal title

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

    function detail_piutang($barang)
    {
        
        table_detailpiutang.clear().draw();

        $.ajax({
            url : "<?php echo site_url('admin/transaksi/piutang/piutang')?>/"+ $barang,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                //alert(data[0]['detailpiutang'].length);
                for(var i = 0; i < data[0]['detailpiutang'].length; i++) {
                    var obj = data[0]['detailpiutang'][i];
                    table_detailpiutang.row.add([obj.no_bukti, obj.nama_barang, obj.nama_gudang, obj.expired, obj.qty, obj.action]).draw();
                }

                $('#modal_detail_piutang').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('piutang Barang'); // Set title to Bootstrap modal title

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });

        $('#modal_detail_piutang').modal('show'); // show bootstrap modal
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

    
    function bayar_hutang(id)
    {
        alert(id);
        save_method = 'update';
        $('#form_bayar')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('admin/transaksi/hutang/get/')?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="id"]').val(data[0]['id']);
                $('[name="kode_hutang"]').val(data[0]['kode_hutang']);
                $('[name="nomor_referensi"]').val(data[0]['nomor_referensi']);
                $('[name="kode_relasi"]').val(data[0]['kode_relasi']);
                $('[name="nama_relasi"]').val(data[0]['nama_relasi']);
                $('[name="jenis"]').val(data[0]['jenis']);
                $('[name="nominal"]').val(data[0]['nominal']);
                
                
                $('#modal_form_bayar').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Bayar Hutang'); // Set title to Bootstrap modal title

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }


</script>

<!-- Bootstrap modal Terima-->
<div class="modal fade" id="modal_form_bayar" role="dialog" style="overflow-y: auto !important;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Pembayaran Hutang</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_bayar" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    <input type="hidden" value="" name="kode_relasi"/>
                    
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Kode Hutang <span class="required">*</span></label>
                            <div class="col-md-9">
                                <input name="kode_hutang" placeholder="Kode Hutang" readonly="true">
                                <span class="help-block"></span>
                            </div>
                        </div>                        
                    </div>

                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Nomor Referensi <span class="required">*</span></label>
                            <div class="col-md-9">
                                <input name="nomor_referensi" placeholder="Nama Supplier" readonly="true">
                                <span class="help-block"></span>
                            </div>
                        </div>                        
                    </div>

                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Relasi <span class="required">*</span></label>
                            <div class="col-md-9">
                                <input name="nama_relasi" placeholder="Nama Relasi" readonly="true">
                                <span class="help-block"></span>
                            </div>
                        </div>                        
                    </div>


                    <div class="form-group">
                         <label class="control-label col-md-3">Nominal<span class="required">*</span></label>
                        <div class="col-md-6">
                            <input name="nominal" placeholder="Nominal" class="validate[required,custom[number]] form-control" type="text" required="required" readonly="true">
                        <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Tanggal Bayar <span class="required">*</span></label>
                        <div class="col-md-9">
                            <input placeholder="dd-mm-yyyy" name="tanggal" class="validate[required] form-control datepicker" type="text" required="required">
                            <span class="help-block"></span>
                        </div>
                    </div>



                    <div class="form-group">
                        <label class="control-label col-md-3">Nominal Bayar<span class="required">*</span></label>
                        <div class="col-md-6">
                            <input name="nominal_bayar" placeholder="Nominal Bayar" class="validate[required,custom[number]] form-control" type="text" required="required">
                            <span class="help-block"></span>
                            </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="simpan_bayar()" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal Terima -->
<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form_kirim" role="dialog" style="overflow-y: auto !important;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Barang Masuk</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_kirim" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    <input type="hidden" value="" name="id_so"/>
                    <input type="hidden" value="" name="kode_barang"/>
                    <input type="hidden" value="" name="harga"/>
                    <input type="hidden" value="" name="id_detail_barang_masuk"/>

                    <div class="form-group">
                        <label class="control-label col-md-3">Tanggal Kirim<span class="required">*</span></label>
                        <div class="col-md-9">
                            <input placeholder="dd-mm-yyyy" name="tanggal" class="validate[required] form-control datepicker" type="text" required="required">
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">No. So <span class="required">*</span></label>
                            <div class="col-md-9">
                                <input name="kode_so" placeholder="Nomor So" class="validate[required,minSize[6]] form-control" type="text" required="required" data-validate-length-range="6" data-validate-words="2" readonly="true">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Barang <span class="required">*</span></label>
                            <div class="col-md-9">
                                <input name="nama_barang" placeholder="Nama Barang" class="validate[required,minSize[6]] form-control" type="text" required="required" data-validate-length-range="6" data-validate-words="2" readonly="true">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">QTY Order<span class="required">*</span></label>
                            <div class="col-md-6">
                                <input name="qty_order" placeholder="Qty order" class="validate[required,custom[number]] form-control" type="text" readonly="true">
                            <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                        <label class="control-label col-md-3">QTY Kirim<span class="required">*</span></label>
                        <div class="col-md-6">
                            <input name="qty_kirim" placeholder="Qty Kirim" class="validate[required,custom[number]] form-control" type="text" required="required">
                            <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                        <label class="control-label col-md-3">Biaya Kardus<span class="required">*</span></label>
                        <div class="col-md-6">
                            <input name="biaya_kardus" placeholder="Biaya Kardus" class="validate[required,custom[number]] form-control" type="text" required="required">
                            <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                        <label class="control-label col-md-3">Kurir<span class="required">*</span></label>
                        <div class="col-md-6">
                            <select id="nama_pegawai" name="nama_pegawai" data-live-search="true"  class="selectpicker validate[required] form-control" required="required">
                                <option value="">--Pilih Kurir--</option>
                                <?php
                                foreach ($pilihan_pegawai as $row3):
                                    ?>
                                    <option value="<?php echo $row3->kode_pegawai."-".$row3->nama_pegawai; ?>"><?php echo $row3->kode_pegawai."-".$row3->nama_pegawai; ?></option>
                                    <?php

                                endforeach;
                                ?>
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="simpan_kirim()" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form_return" role="dialog" style="overflow-y: auto !important;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Retun SO</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_return" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    <input type="hidden" value="" name="id_so"/>
                    <input type="hidden" value="" name="kode_barang"/>
                    <input type="hidden" value="" name="harga_beli"/>
                    <input type="hidden" value="" name="id_detail_barang_masuk"/>

                    <div class="form-group">
                        <label class="control-label col-md-3">Tanggal Return<span class="required">*</span></label>
                        <div class="col-md-9">
                            <input placeholder="dd-mm-yyyy" name="tanggal" class="validate[required] form-control datepicker" type="text" required="required">
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">No. So <span class="required">*</span></label>
                            <div class="col-md-9">
                                <input name="kode_so" placeholder="Nomor So" class="validate[required,minSize[6]] form-control" type="text" required="required" data-validate-length-range="6" data-validate-words="2" readonly="true">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Barang <span class="required">*</span></label>
                            <div class="col-md-9">
                                <input name="nama_barang" placeholder="Nama Barang" class="validate[required,minSize[6]] form-control" type="text" required="required" data-validate-length-range="6" data-validate-words="2" readonly="true">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">QTY Order<span class="required">*</span></label>
                            <div class="col-md-6">
                                <input name="qty_order" placeholder="Qty order" class="validate[required,custom[number]] form-control" type="text" readonly="true">
                            <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                        <label class="control-label col-md-3">QTY Return<span class="required">*</span></label>
                        <div class="col-md-6">
                            <input name="qty_return" placeholder="Qty Return" class="validate[required,custom[number]] form-control" type="text" required="required">
                            <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                        <label class="control-label col-md-3">Harga<span class="required">*</span></label>
                        <div class="col-md-6">
                            <input name="harga" placeholder="Harga" class="validate[required,custom[number]] form-control" type="text" required="required">
                            <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                        <label class="control-label col-md-3">Bottom Retail<span class="required">*</span></label>
                        <div class="col-md-6">
                            <input name="bottom_retail" placeholder="Bottom Retail" class="validate[required,custom[number]] form-control" type="text" required="required" readonly="true">
                            <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                        <label class="control-label col-md-3">Bottom Supplier<span class="required">*</span></label>
                        <div class="col-md-6">
                            <input name="bottom_supplier" placeholder="Bottom Supplier" class="validate[required,custom[number]] form-control" type="text" required="required" readonly="true">
                            <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Alasan Return <span class="required">*</span></label>
                            <div class="col-md-9">
                                <input name="alasan_return" placeholder="Alasan Return" class="validate[required,minSize[6]] form-control" type="text" required="required" data-validate-length-range="6" data-validate-words="2" >
                                <span class="help-block"></span>
                            </div>
                        </div>

                       
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="simpan_return()" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
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

    function simpan_kirim()
    {

        var url;

        url = "<?php echo site_url('admin/transaksi/pengiriman_so/add/true')?>";

        seen = [];

        var id_so = $('#form_kirim').find('input[name="id_so"]').val();

        if(!$("#form_kirim").validationEngine('validate')){
            return false;
        }


        $('#btnSave').text('menyimpan...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable

        // ajax adding data to database
        $.ajax({
            url : url,
            type: "POST",
            data: $('#form_kirim').serialize(),
            dataType: "JSON",
            success: function(data)
            {

                if(data.status) //if success close modal and reload ajax table
                {
                    if(save_method === 'add') {
                        $('#modal_form_kirim').modal('hide');
                    }else{
                        $('#modal_form_kirim').modal('hide');
                    }
                    reload_table();
                }

                $('#btnSave').text('simpan'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable

                detail_so(id_so);

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
                $('#btnSave').text('simpan'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable

            }
        });
    }


    function simpan_return()
    {

        var url;

        url = "<?php echo site_url('admin/transaksi/return_masuk/add')?>";

        seen = [];

        var id_so = $('#form_kirim').find('input[name="id_so"]').val();

        if(!$("#form_return").validationEngine('validate')){
            return false;
        }


        $('#btnSave').text('menyimpan...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable

        // ajax adding data to database
        $.ajax({
            url : url,
            type: "POST",
            data: $('#form_return').serialize(),
            dataType: "JSON",
            success: function(data)
            {

                if(data.status) //if success close modal and reload ajax table
                {
                    if(save_method === 'add') {
                        $('#modal_form_return').modal('hide');
                    }else{
                        $('#modal_form_return').modal('hide');
                    }
                    reload_table();
                }

                $('#btnSave').text('simpan'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable

                detail_so(id_so);

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
                $('#btnSave').text('simpan'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable

            }
        });
    }


    function simpan_bayar()
    {

        var url;

        url = "<?php echo site_url('admin/transaksi/pembayaran_hutang/add')?>";

        seen = [];



        if(!$("#form_bayar").validationEngine('validate')){
            return false;
        }


        $('#btnSave').text('menyimpan...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable

        // ajax adding data to database
        $.ajax({
            url : url,
            type: "POST",
            data: $('#form_bayar').serialize() ,
            dataType: "JSON",
            success: function(data)
            {

                if(data.status) //if success close modal and reload ajax table
                {
                    if(save_method === 'add') {
                        $('#modal_form_bayar').modal('hide');
                    }else{
                        $('#modal_form_bayar').modal('hide');
                    }
                    reload_table();
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



</script>

