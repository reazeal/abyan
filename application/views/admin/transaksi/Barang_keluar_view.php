
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Data Barang Keluar</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <p>
                                <button class="btn btn-success" onclick="add_barang()"><i class="glyphicon glyphicon-plus"></i> Tambah Barang</button>
                                <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
                            </p>


                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>`
                                <tr>
                                    <th>No</th>
                                    <th>Id</th>
                                    <th>Tanggal</th>
                                    <th>Kode Keluar</th>
                                    <th>Nomor Referensi</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
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
                "url": "<?php echo site_url('admin/transaksi/barang_keluar/get_data_all');?>",
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

        table_detail = $('#datatable-detail').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": false, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            responsive: true,
            columns: [
                { title: "Id" },
                { title: "Nama Barang" },
                { title: "Qty" },
                { title: "Action" , width:'25'}
            ],
            "columnDefs": [
                {
                    "targets": [ -1 ], //last column
                    "orderable": false
                },{
                    "targets": [0],
                    "visible": false
                }
            ]
        });

        table_stok = $('#datatable-stok').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": false, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            responsive: true,
            columns: [
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

        table_detailbarang = $('#datatable-detailbarang').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": false, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            responsive: true,
            columns: [
                { title: "Nama Barang" },
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
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        table_detail.clear().draw();

        $('select[name=barang_id]').val();
        $('.selectpicker').selectpicker('refresh');

        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Barang'); // Set Title to Bootstrap modal title
    }

    function get_nobukti()
    {
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('admin/transaksi/barang_keluar/get_nobukti/')?>",
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

    function add_Detailbarang()
    {
        $.ajax({
            url : "<?php echo site_url('admin/transaksi/barang_keluar/session_barang')?>/?barang_id="+0,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                //console.log(data[0].web_situs);
                //$('[name="domain"]').val("@"+data[0].web_situs);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });

        save_method_detail = 'add';
        $('#formDetail')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        $('select[name=nama_barang]').val();
        $('.selectpicker').selectpicker('refresh');

        $('#modal_formDetail').modal('show'); // show bootstrap modal
    }

    function cek_stok()
    {
        
        table_stok.clear().draw();

        $.ajax({
            url : "<?php echo site_url('admin/transaksi/barang_keluar/stok')?>/",
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                

                

                for(var i = 0; i < data[0]['detailStok'].length; i++) {
                    var obj = data[0]['detailStok'][i];
                    table_stok.row.add([obj.nama_barang, obj.nama_gudang, obj.expired, obj.qty]).draw();
                }

                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Stok Barang'); // Set title to Bootstrap modal title

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });

        $('#modal_stok').modal('show'); // show bootstrap modal
    }


    function detail_barang_keluar($id)
    {
        
        table_detailbarang.clear().draw();

        $.ajax({
            url : "<?php echo site_url('admin/transaksi/barang_keluar/get_detail')?>/"+ $id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                //alert(data[0]['detailStok'].length);
                for(var i = 0; i < data[0]['detailBarang'].length; i++) {
                    var obj = data[0]['detailBarang'][i];
                    table_detailbarang.row.add([obj.nama_barang, obj.qty]).draw();
                }

                $('#modal_detail_barang').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Detail Barang Masuk'); // Set title to Bootstrap modal title

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });

        $('#modal_detail_barang').modal('show'); // show bootstrap modal
    }

    function edit_barang(id)
    {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //table_detail.clear().draw();

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('admin/transaksi/barang_keluar/edit/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="id"]').val(data[0]['id']);
                $('[name="keterangan"]').val(data[0]['keterangan']);
                $('[name="no_bukti"]').val(data[0]['no_bukti']);
                $('[name="tanggal"]').val(data[0]['tanggal']);
                $('[name="ongkir"]').val(data[0]['ongkir']);
                $('[name="no_resi"]').val(data[0]['no_resi']);
               
                /*
                for(var i = 0; i < data[0]['detailBarangKeluar'].length; i++) {
                    var obj = data[0]['detailBarangKeluar'][i];
                    table_detail.row.add([obj.id, obj.nama_barang, obj.qty, obj.action]).draw();
                }
                */

                $('#modal_form_edit').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Ubah Barang'); // Set title to Bootstrap modal title

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

    function cekData() {
        var data = table_detail .rows().data();
    }

    function reload_table()
    {
        table.ajax.reload(null,false); //reload datatable ajax
    }

    function reload_Detailtable()
    {
        table_detail.ajax.reload(null,false); //reload datatable ajax
    }

    function save()
    {

        var url;

        if(save_method === 'add') {
            url = "<?php echo site_url('admin/transaksi/barang_keluar/add')?>";
        } else {
            url = "<?php echo site_url('admin/transaksi/barang_keluar/update')?>";
        }

        seen = [];

        json = JSON.stringify(table_detail .rows().data(), function(key, val) {
            if (typeof val === "object") {
                if (seen.indexOf(val) >= 0)
                    return
                    seen.push(val)
            }
            return val
        });


        if(!$("#form").validationEngine('validate')){
            return false;
        }

        if(!$("#formDetail").validationEngine('validate')){
            return false;
        }

        $('#btnSave').text('menyimpan...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable

        // ajax adding data to database
       $.ajax({
            url : url,
            type: "POST",
            data: $('#form').serialize() + "&dataDetail=" + json,
            dataType: "JSON",
            success: function(data)
            {

                if(data.status) //if success close modal and reload ajax table
                {
                    $('#modal_form').modal('hide');
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

    function update()
    {

        var url;

        if(save_method === 'add') {
            url = "<?php echo site_url('admin/transaksi/barang_keluar/add')?>";
        } else {
            url = "<?php echo site_url('admin/transaksi/barang_keluar/update')?>";
        }

        seen = [];

        json = JSON.stringify(table_detail .rows().data(), function(key, val) {
            if (typeof val === "object") {
                if (seen.indexOf(val) >= 0)
                    return
                    seen.push(val)
            }
            return val
        });


        if(!$("#form_edit").validationEngine('validate')){
            return false;
        }

        if(!$("#formDetail").validationEngine('validate')){
            return false;
        }

        $('#btnSave').text('menyimpan...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable

        // ajax adding data to database
       $.ajax({
            url : url,
            type: "POST",
            data: $('#form_edit').serialize() + "&dataDetail=" + json,
            dataType: "JSON",
            success: function(data)
            {

                if(data.status) //if success close modal and reload ajax table
                {
                    $('#modal_form_edit').modal('hide');
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

    function saveDetail()
    {


        if(!$("#formDetail").validationEngine('validate')){
            return false;
        }

        $('#btnSaveDetail').text('menyimpan...'); //change button text
        $('#btnSaveDetail').attr('disabled',true); //set button disable

        var url;

        if(save_method_detail === 'add') {


            var dd =  $('#formDetail').serialize();
            var barang_id =   $('#modal_formDetail').find('[name="nama_barang"]').val();
            var nama_barang =    $("#nama_barang :selected").text();
            var qty =   $('#modal_formDetail').find('[name="qty"]').val();
            var aksi = "<a class='btn btn-sm btn-danger hapus-detail' href='javascript:void(0)' title='Hapus' onclick='hapus_dataDetail()'><i class='glyphicon glyphicon-trash'></i> Delete</a>";

            //alert(barang_id);
            
            $.ajax({
                url : "<?php echo site_url('admin/transaksi/barang_keluar/cek_stok')?>/"+barang_id+"/"+qty, 
                type: "POST",
                dataType: "JSON",
                success: function(data)
                {   
                    
                    if(data.status){ //if success close modal and reload ajax table
                        //$('#modal_form').modal('hide');
                        //reload_table();

                        iterasi++;
                        table_detail.row.add([barang_id,nama_barang, qty, aksi]).draw();

                        $('#modal_formDetail').modal('hide');
                        

                    } else {
                        alert(data.info);
                    }

                    //if success reload ajax table
                   // $('#modal_form').modal('hide');
                   // reload_table();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error deleting data');
                }
            });
            

           // iterasi++;
            //table_detail.row.add([barang_id,nama_barang, qty, aksi]).draw();

            
            $('#btnSaveDetail').text('simpan'); //change button text
            $('#btnSaveDetail').attr('disabled',false); //set button enable

        } else {

        }
    }

    function hapus_dataDetail() {
        /*
        $('#datatable-detail').on( 'click', 'tbody tr', function () {
            table_detail.row( this ).remove().draw();
        } );
        */

        $('#datatable-detail').on( 'click', '.hapus-detail', function () {
            if(confirm('Anda yakin mau menghapus data ini ?')){
                
                table_detail.row('.selected').remove().draw( false ); // visually delete row
                
                table_detail.row( $(this).parents('tr')).remove().draw();

                //table_detail.row( this ).remove().draw();

            }
        } );
    

    }


    function delete_barang(id)
    {
        if(confirm('Anda yakin mau menghapus data ini ?'))
        {
            // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('admin/transaksi/barang_keluar/delete')?>/"+id,
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
</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog" style="overflow-y: auto !important;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Barang Keluar</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    <input type="hidden" value="" name="nama_barang"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Tgl. Barang Keluar<span class="required">*</span></label>
                            <div class="col-md-9">
                                <input placeholder="dd-mm-yyyy" name="tanggal" class="validate[required] form-control datepicker" type="text" required="required">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        
                        <div class="form-group">
                            <label class="control-label col-md-3">No. Referensi <span class="required">*</span></label>
                            <div class="col-md-6">
                                <input name="nomor_referensi" placeholder="No. Referensi" class="validate[required] form-control" type="text" required="required" data-validate-length-range="6" data-validate-words="2">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Jenis Trans <span class="required">*</span></label>
                            <div class="col-md-9">
                                <select name="jenis_trans" class="validate[required] form-control" required="required">
                                    <option value="">--Pilih Trans--</option>
                                    <option value="PEMBELIAN">Penjualan</option>
                                    <option value="RETURN">Return</option>                                    
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3">Keterangan <span class="required">*</span></label>
                            <div class="col-md-9">
                                <input name="keterangan" placeholder="Keterangan" class="form-control" type="text" required="required">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>

                <p>
                    <a href="javascript:void(0)" class="btn btn-success" onclick="add_Detailbarang();"><i class="glyphicon glyphicon-plus"></i> Tambah Detail Barang</a>
                </p>

                <table id="datatable-detail" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nama Barang</th>
                        <th>Qty</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>

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

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form_edit" role="dialog" style="overflow-y: auto !important;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Barang Keluar</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_edit" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    <input type="hidden" value="" name="nama_barang"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Tgl. Barang Keluar<span class="required">*</span></label>
                            <div class="col-md-9">
                                <input placeholder="dd-mm-yyyy" name="tanggal" class="validate[required] form-control datepicker" type="text" required="required">
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
                            <label class="control-label col-md-3">No. Resi <span class="required"></span></label>
                            <div class="col-md-6">
                                <input name="no_resi" placeholder="No. Resi" class="validate[required] form-control" type="text"  data-validate-length-range="6" data-validate-words="2">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Ongkir<span class="required"></span></label>
                            <div class="col-md-6">
                                <input name="ongkir" placeholder="Ongkir" class="validate[required,custom[number]] form-control" type="text" >
                                <span class="help-block"></span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-md-3">Keterangan <span class="required">*</span></label>
                            <div class="col-md-9">
                                <input name="keterangan" placeholder="Keterangan" class="form-control" type="text" required="required">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="update()" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->


<!-- Bootstrap modal -->

<div class="modal fade" id="modal_formDetail" role="dialog">
    <div class="modal-dialog modal-lg">
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
                        <label class="col-sm-3 control-label">Barang</label>

                        <div class="col-sm-9">
                          
                          <div class="input-group">
                            <select id="nama_barang" name="nama_barang" data-live-search="true"  class="selectpicker validate[required] form-control" required="required">
                                    <option value="">--Pilih Barang--</option>
                                    <?php
                                    foreach ($pilihan_barang as $row3):
                                        ?>
                                        <option value="<?php echo $row3->kode; ?>"><?php echo $row3->nama." (".($row3->satuan)." )"; ?></option>
                                        <?php

                                    endforeach;
                                    ?>
                                </select>                           
                          </div>
                        </div>
                      </div>
                      <div class="divider-dashed"></div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Qty<span class="required">*</span></label>
                            <div class="col-md-6">
                                <input name="qty" placeholder="Qty" class="validate[required,custom[number]] form-control" type="text" required="required">
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

<div class="modal fade" id="modal_detail_barang" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3>Form Detail Barang</h3>
            </div>
            <div class="panel-body">
                <table id="datatable-detailbarang" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Qty</th>
                            
                        </tr>
                        </thead>
                    </table>
            </div>
            
        </div>
    </div>
</div>

<!-- End Bootstrap modal -->

<script>
    $(function() {

        $('#barang_id').on('change', function(){
            //var selected = $(this).find("option:selected").val();
            $('[name="nama_barang"]').val($("#barang_id :selected").text());
        });
    });

    $(function() {


        $('#nama_barang').on('change', function(){
            var selected = $(this).find("option:selected").val();
//            alert(selected);

            $.ajax({
                url : "<?php echo site_url('admin/transaksi/barang_keluar/session_barang')?>/?barang_id="+selected,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    //console.log(data[0].web_situs);
                    //$('[name="domain"]').val("@"+data[0].web_situs);
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error deleting data');
                }
            });


        });

       

    });

</script>