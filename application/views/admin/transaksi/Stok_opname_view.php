
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Data Stok Opname</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <p>
                                
                                <button class="btn btn-success" onclick="add_stop_opname()"><i class="glyphicon glyphicon-plus"></i> Tambah Stok</button> 
                                <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
                            </p>


                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>id</th>
                                    <th>Tanggal</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Tanggal Kedatangan</th>
                                    <th>QTY</th>
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
                "url": "<?php echo site_url('admin/transaksi/stok_opname/get_data_all');?>",
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

    function add_stop_opname()
    {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Barang SO'); // Set Title to Bootstrap modal title
    }

    function edit_stok_opname(id)
    {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('admin/transaksi/stok_opname/get/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="id"]').val(data[0]['id']);
                $('[name="tanggal"]').val(data[0]['tanggal']);
                $('[name="nama_barang"]').val(data[0]['nama_barang']);
                $('[name="tanggal_kedatangan"]').val(data[0]['tanggal_kedatangan']);
                $('[name="qty"]').val(data[0]['qty']);
                
                $('#modal_form_edit').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Ubah Stok Opname'); // Set title to Bootstrap modal title

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

</script>

<!-- Bootstrap modal Terima-->
<div class="modal fade" id="modal_form" role="dialog" style="overflow-y: auto !important;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Stok</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    
                    <div class="form-group">
                        <label class="control-label col-md-3">Tanggal <span class="required">*</span></label>
                        <div class="col-md-9">
                            <input placeholder="dd-mm-yyyy" name="tanggal" class="validate[required] form-control datepicker" type="text" required="required">
                            <span class="help-block"></span>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="control-label col-md-3">Barang<span class="required">*</span></label>
                        <div class="col-md-6">
                            <select id="nama_barang" name="nama_barang" data-live-search="true"  class="selectpicker validate[required] form-control" required="required">
                                <option value="">--Pilih Barang--</option>
                                <?php
                                foreach ($pilihan_barang as $row3):
                                    ?>
                                    <option value="<?php echo $row3->kode.'-'.$row3->nama; ?>"><?php echo $row3->kode."-".$row3->nama."-".$row3->satuan; ?></option>
                                    <?php

                                endforeach;
                                ?>
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Tanggal Kedatangan<span class="required">*</span></label>
                        <div class="col-md-9">
                            <input placeholder="dd-mm-yyyy" name="tanggal_kedatangan" class="validate[required] form-control datepicker" type="text" required="required">
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                         <label class="control-label col-md-3">QTY<span class="required">*</span></label>
                        <div class="col-md-6">
                            <input name="qty" placeholder="QTY" class="validate[required,custom[number]] form-control" type="text" required="required">
                        <span class="help-block"></span>
                        </div>
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="simpan_stok()" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal Terima -->

<div class="modal fade" id="modal_form_edit" role="dialog" style="overflow-y: auto !important;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Stok</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_edit" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    
                    <div class="form-group">
                        <label class="control-label col-md-3">Tanggal <span class="required">*</span></label>
                        <div class="col-md-9">
                            <input placeholder="dd-mm-yyyy" name="tanggal" class="validate[required] form-control datepicker" type="text" required="required">
                            <span class="help-block"></span>
                        </div>
                    </div>


                    <div class="form-group">
                         <label class="control-label col-md-3">Nama Barang<span class="required">*</span></label>
                        <div class="col-md-6">
                            <input name="nama_barang" placeholder="Barang" class="validate[required] form-control" type="text" required="required" disabled="true">
                        <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Tanggal Kedatangan<span class="required">*</span></label>
                        <div class="col-md-9">
                            <input placeholder="dd-mm-yyyy" name="tanggal_kedatangan" class="validate[required] form-control datepicker" type="text" required="required">
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                         <label class="control-label col-md-3">QTY<span class="required">*</span></label>
                        <div class="col-md-6">
                            <input name="qty" placeholder="QTY" class="validate[required,custom[number]] form-control" type="text" required="required">
                        <span class="help-block"></span>
                        </div>
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="update_stok()" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


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

    function simpan_stok()
    {

        var url;

        url = "<?php echo site_url('admin/transaksi/stok_opname/add')?>";

        seen = [];



        if(!$("#form").validationEngine('validate')){
            return false;
        }


        $('#btnSave').text('menyimpan...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable

        // ajax adding data to database
        $.ajax({
            url : url,
            type: "POST",
            data: $('#form').serialize() ,
            dataType: "JSON",
            success: function(data)
            {

                if(data.status) //if success close modal and reload ajax table
                {
                    if(save_method === 'add') {
                        $('#modal_form').modal('hide');
                    }else{
                        $('#modal_form').modal('hide');
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

    function update_stok()
    {

        var url;

        url = "<?php echo site_url('admin/transaksi/stok_opname/update_stok')?>";

        seen = [];



        if(!$("#form_edit").validationEngine('validate')){
            return false;
        }


        $('#btnSave').text('menyimpan...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable

        // ajax adding data to database
        $.ajax({
            url : url,
            type: "POST",
            data: $('#form_edit').serialize() ,
            dataType: "JSON",
            success: function(data)
            {

                if(data.status) //if success close modal and reload ajax table
                {
                    if(save_method === 'add') {
                        $('#modal_form_edit').modal('hide');
                    }else{
                        $('#modal_form_edit').modal('hide');
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

