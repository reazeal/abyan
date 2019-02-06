
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Data Piutang</h2>
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
                                    <th>Kode Piutang</th>
                                    <th>Kode Referensi</th>
                                    
                                    <th>Nama Relasi</th>
                                    
                                    <th>Tanggal JT</th>
                                    <th>Nominal</th>
                                    <th>Bayar</th>
                                    <th>Sisa</th>
                                    <th>Status</th>
                                    <th>Kode Relasi</th>
                                    <th>Jenis</th>
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
                "url": "<?php echo site_url('admin/transaksi/piutang/get_data_all');?>",
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

    function bayar_piutang(id)
    {
        save_method = 'update';
        $('#form_bayar')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('admin/transaksi/piutang/get/')?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="id"]').val(data[0]['id']);
                $('[name="kode_piutang"]').val(data[0]['kode_piutang']);
                $('[name="nomor_referensi"]').val(data[0]['nomor_referensi']);
                $('[name="kode_relasi"]').val(data[0]['kode_relasi']);
                $('[name="nama_relasi"]').val(data[0]['nama_relasi']);
                $('[name="jenis"]').val(data[0]['jenis']);
                $('[name="nominal"]').val(data[0]['nominal']);
                $('[name="kode_bantu"]').val(data[0]['kode_bantu']);
                
                $('#modal_form_bayar').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Bayar Piutang'); // Set title to Bootstrap modal title

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
                            <label class="control-label col-md-3">Kode Piutang <span class="required">*</span></label>
                            <div class="col-md-9">
                                <input name="kode_piutang" class="form-control" placeholder="Kode Piutang" readonly="true">
                                <span class="help-block"></span>
                            </div>
                        </div>                        
                    </div>

                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Nomor Referensi <span class="required">*</span></label>
                            <div class="col-md-9">
                                <input name="nomor_referensi" class="form-control" placeholder="Nomor" readonly="true">
                                <span class="help-block"></span>
                            </div>
                        </div>                        
                    </div>

                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Kode Bantu <span class="required">*</span></label>
                            <div class="col-md-9">
                                <input name="kode_bantu" class="form-control" placeholder="Kode Bantu" readonly="true">
                                <span class="help-block"></span>
                            </div>
                        </div>                        
                    </div>

                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Relasi <span class="required">*</span></label>
                            <div class="col-md-9">
                                <input name="nama_relasi" class="form-control" placeholder="Nama Relasi" readonly="true">
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


                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Keterangan <span class="required">*</span></label>
                            <div class="col-md-9">
                                <input name="keterangan" class="validate[required,custom[number]] form-control" placeholder="Keterangan">
                                <span class="help-block"></span>
                            </div>
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


<div class="modal fade" id="modal_piutang" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3>Form Detail piutang</h3>
            </div>
            <div class="panel-body">
                <table id="datatable-piutang" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
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

    function simpan_bayar()
    {

        var url;

        url = "<?php echo site_url('admin/transaksi/pembayaran_piutang/add')?>";

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