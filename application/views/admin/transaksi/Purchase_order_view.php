
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Data Purchase Order</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <p>
                                <button class="btn btn-success" onclick="add_po()"><i class="glyphicon glyphicon-plus"></i> Tambah PO</button>
                                <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
                            </p>


                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Id</th>
                                    <th>Tanggal</th>
                                    <th>No PO</th>
                                    <th>Kode Sup</th>
                                    <th>Nama Sup</th>
                                    <th>TOP</th>
                                    <th>Status</th>
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
                "url": "<?php echo site_url('admin/transaksi/purchase_order/get_data_all');?>",
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
                },
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
                },{
                    "targets": [4],
                    "visible": false
                },{
                    "targets": [6],
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
                { title: "Barang Masuk ID" },
                { title: "Barang ID" },
                { title: "Nama Barang" },
                { title: "Qty" },
                { title: "Harga" },
                { title: "Total" },
                { title: "Supplier" },
                { title: "Customer" },
                { title: "Action" , width:'25'}
            ],
            "columnDefs": [
                {
                    "targets": [ -1 ], //last column
                    "orderable": false
                },{
                    "targets": [0],
                    "visible": false
                },{
                    "targets": [1],
                    "visible": false
                },{
                    "targets": [2],
                    "visible": false
                }
            ]
        });

        table_detailpo = $('#datatable-detailbarang').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": false, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            responsive: true,
            /*
            columns: [
                { title: "Nama Barang" },
                { title: "Expired" },
                { title: "Qty" }
                
            ],
            */
            "columnDefs": [
                {
                    "targets": [ -1 ], //last column
                    "orderable": false
                },{
                    "targets": [0], //last column
                    "visible": false
                },{
                    "targets": [2], //last column
                    "visible": false
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



    function add_po()
    {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        table_detail.clear().draw();
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Purchase Order'); // Set Title to Bootstrap modal title
    }

    function add_Detailbarang()
    {
        save_method_detail = 'add';
        

        $('#formDetail')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        $('select[name=nama_barang]').val();
        $('.selectpicker').selectpicker('refresh');
        
        $('#modal_formDetail').modal('show'); // show bootstrap modal
    }

    function edit_po(id)
    {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('admin/transaksi/purchase_order/edit/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="id"]').val(data[0]['id']);
                $('[name="tanggal"]').val(data[0]['tanggal']);
               $('[name="nama_barang"]').val(data[0]['nama_barang']);
                $('[name="kode_po"]').val(data[0]['kode_po']);
                $('[name="nama_supplier"]').val(data[0]['nama_supplier']);
                $('[name="qty"]').val(data[0]['qty']);

                /*
                table_detail.clear().draw();
                for(var i = 0; i < data[0]['detailBarangMasuk'].length; i++) {
                    var obj = data[0]['detailBarangMasuk'][i];
                    table_detail.row.add([obj.id, obj.purchase_order_id, obj.barang_id,  obj.nama_barang, obj.gudang_id, obj.nama_gudang, obj.qty, obj.expired, obj.action]).draw();
                }
                */

                $('#modal_form_edit').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Ubah PO'); // Set title to Bootstrap modal title

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }


    function terima_po(id)
    {
        $('#modal_detail_po').modal('hide');

        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('admin/transaksi/purchase_order/edit/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="id"]').val(id);
                $('[name="id_po"]').val(data[0]['id_po']);
                $('[name="nama_barang"]').val(data[0]['nama_barang']);
                $('[name="kode_po"]').val(data[0]['kode_po']);
                $('[name="nama_supplier"]').val(data[0]['nama_supplier']);
                $('[name="kode_supplier"]').val(data[0]['kode_supplier']);
                $('[name="kode_barang"]').val(data[0]['kode_barang']);
                $('[name="qty"]').val(data[0]['qty']);
                $('[name="harga"]').val(data[0]['harga']);
                $('[name="top"]').val(data[0]['top']);
                $('[name="buttom_supplier"]').val(data[0]['buttom_supplier']);
                $('[name="buttom_retail"]').val(data[0]['buttom_retail']);
                $('[name="harga_beli"]').val(data[0]['harga_beli']);
                $('[name="qty_terima"]').val("0");

  
                $('#modal_form_terima').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Terima PO'); // Set title to Bootstrap modal title

                //$('#modal_detail_po').modal('show');

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });

    }

    function detail_po($id)
    {
        
        table_detailpo.clear().draw();

        $.ajax({
            url : "<?php echo site_url('admin/transaksi/purchase_order/get_detail')?>/"+ $id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                //alert(data[0]['detailStok'].length);
                for(var i = 0; i < data[0]['detailPo'].length; i++) {
                    var obj = data[0]['detailPo'][i];
                    table_detailpo.row.add([obj.id, obj.kode_po, obj.kode_barang, obj.nama_barang, obj.qty, obj.harga, obj.total, obj.terima,  obj.action]).draw();
                }

                $('#modal_detail_po').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Detail Barang Masuk'); // Set title to Bootstrap modal title

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });

        $('#modal_detail_po').modal('show'); // show bootstrap modal
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
            url = "<?php echo site_url('admin/transaksi/purchase_order/add')?>";
        } else {
            url = "<?php echo site_url('admin/transaksi/purchase_order/update')?>";
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
                    if(save_method === 'add') {
                        $('#modal_form').modal('hide');
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

    function simpan_terima_po()
    {

        var url;

        url = "<?php echo site_url('admin/transaksi/penerimaan_po/add')?>";

        seen = [];

        json = JSON.stringify(table_detail .rows().data(), function(key, val) {
            if (typeof val === "object") {
                if (seen.indexOf(val) >= 0)
                    return
                    seen.push(val)
            }
            return val
        });


        if(!$("#form_terima").validationEngine('validate')){
            return false;
        }

        alert('sini');
        
        var id_po = $('#form_terima').find('input[name="id_po"]').val();
        alert(id_po);        

        $('#btnSave').text('menyimpan...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable

        // ajax adding data to database
        $.ajax({
            url : url,
            type: "POST",
            data: $('#form_terima').serialize() + "&dataDetail=" + json,
            dataType: "JSON",
            success: function(data)
            {

                if(data.status) //if success close modal and reload ajax table
                {
                    if(save_method === 'add') {
                        $('#modal_form').modal('hide');
                    }else{
                        $('#modal_form_terima').modal('hide');
                    }
                    reload_table();
                }

                $('#btnSave').text('simpan'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable

                detail_po(id_po);

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
            url = "<?php echo site_url('admin/transaksi/purchase_order/add')?>";
        } else {
            url = "<?php echo site_url('admin/transaksi/purchase_order/update')?>";
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
                    if(save_method === 'add') {
                        $('#modal_form').modal('hide');
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
            var harga =   $('#modal_formDetail').find('[name="harga"]').val();
            var total =   harga * qty;
            var buttom_supplier =   $('#modal_formDetail').find('[name="buttom_supplier"]').val();
            var buttom_retail =   $('#modal_formDetail').find('[name="buttom_retail"]').val();
            var aksi = "<a class='btn btn-sm btn-danger hapus-detail' href='javascript:void(0)' title='Hapus' onclick='hapus_dataDetail()'><i class='glyphicon glyphicon-trash'></i> Delete</a>";

             iterasi++;
            table_detail.row.add(['','', barang_id,nama_barang, qty, harga, total, buttom_supplier, buttom_retail, aksi]).draw();

            $('#modal_formDetail').modal('hide');
            $('#btnSaveDetail').text('simpan'); //change button text
            $('#btnSaveDetail').attr('disabled',false); //set button enable

        } else {

        }
    }

    function hapus_dataDetail() {
        alert('tes');
        $('#datatable-detail').on( 'click', '.hapus-detail', function () {
            if(confirm('Anda yakin mau menghapus data ini ?')){
                
                table_detail.row('.selected').remove().draw( false ); // visually delete row
                
                table_detail.row( $(this).parents('tr')).remove().draw();

                //table_detail.row( this ).remove().draw();

            }
        } );
    


    }

    function delete_po(id)
    {
        if(confirm('Anda yakin mau menghapus data ini ?'))
        {
            // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('admin/transaksi/purchase_order/delete')?>/"+id,
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

    function cetak_purchase_order(id)
    {


        $('#btnCetak').text('proses mencetak...'); //change button text
        $('#btnCetak').attr('disabled',true); //set button disable


        var form_dt = $('#form').serialize();

        eModal.iframe('<?php echo  site_url('admin/transaksi/purchase_order/cetak');?>?id='+id, 'Laporan Stok Barang');

        $('#btnCetak').text('Cetak'); //change button text
        $('#btnCetak').attr('disabled',false); //set button enable
    }
</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog" style="overflow-y: auto !important;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Purchase Order</h3>
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
                        <label class="control-label col-md-3">Supplier<span class="required">*</span></label>
                        <div class="col-md-6">
                            <select id="nama_suplier" name="nama_supplier" data-live-search="true"  class="selectpicker validate[required] form-control" required="required">
                                <option value="">--Pilih Supplier--</option>
                                <?php
                                foreach ($pilihan_supplier as $row3):
                                    ?>
                                    <option value="<?php echo $row3->kode_supplier; ?>"><?php echo $row3->kode_supplier."-".$row3->nama_supplier; ?></option>
                                    <?php

                                endforeach;
                                ?>
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">TOP (Hari)<span class="required">*</span></label>
                        <div class="col-md-6">
                            <div class="col-md-6">
                                <input name="top" placeholder="TOP" class="validate[required,custom[number]] form-control" type="text" required="required">
                            <span class="help-block"></span>
                            </div>
                        <span class="help-block"></span>
                        </div>
                    </div>

                <p>
                    <a href="javascript:void(0)" class="btn btn-success" onclick="add_Detailbarang();"><i class="glyphicon glyphicon-plus"></i> Tambah Detail Barang</a>
                </p>

                <table id="datatable-detail" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Barang Masuk ID</th>
                        <th>Barang ID</th>
                        <th>Nama Barang</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Total</th>
                        <th>Supplier</th>
                        <th>Customer</th>
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
                <h3 class="modal-title">Form Edit PO</h3>
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

                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">No. PO <span class="required">*</span></label>
                            <div class="col-md-9">
                                <input name="kode_po" placeholder="Kode PO" readonly="true">
                                <span class="help-block"></span>
                            </div>
                        </div>                        
                    </div>

                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Supplier <span class="required">*</span></label>
                            <div class="col-md-9">
                                <input name="nama_supplier" placeholder="Nama Supplier" readonly="true">
                                <span class="help-block"></span>
                            </div>
                        </div>                        
                    </div>

                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Barang <span class="required">*</span></label>
                            <div class="col-md-9">
                                <input name="nama_barang" placeholder="Nama Barang" readonly="true">
                                <span class="help-block"></span>
                            </div>
                        </div>                        
                    </div>

                    <div class="form-group">
                         <label class="control-label col-md-3">QTY<span class="required">*</span></label>
                        <div class="col-md-6">
                            <input name="qty" placeholder="Qty" class="validate[required,custom[number]] form-control" type="text" required="required">
                        <span class="help-block"></span>
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


<!-- Bootstrap modal Terima-->
<div class="modal fade" id="modal_form_terima" role="dialog" style="overflow-y: auto !important;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Penerimaan PO</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_terima" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    <input type="hidden" value="" name="id_po"/>
                    <input type="hidden" value="" name="kode_supplier"/>
                    <input type="hidden" value="" name="kode_barang"/>
                    <input type="hidden" value="" name="harga"/>
                    <input type="hidden" value="" name="buttom_retail"/>
                    <input type="hidden" value="" name="buttom_supplier"/>
                    <input type="hidden" value="" name="top"/>
                    <div class="form-group">
                        <label class="control-label col-md-3">Tanggal Terima <span class="required">*</span></label>
                        <div class="col-md-9">
                            <input placeholder="dd-mm-yyyy" name="tanggal" class="validate[required] form-control datepicker" type="text" required="required">
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">No. PO <span class="required">*</span></label>
                            <div class="col-md-9">
                                <input name="kode_po" placeholder="Kode PO" readonly="true">
                                <span class="help-block"></span>
                            </div>
                        </div>                        
                    </div>

                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Supplier <span class="required">*</span></label>
                            <div class="col-md-9">
                                <input name="nama_supplier" placeholder="Nama Supplier" readonly="true">
                                <span class="help-block"></span>
                            </div>
                        </div>                        
                    </div>

                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Barang <span class="required">*</span></label>
                            <div class="col-md-9">
                                <input name="nama_barang" placeholder="Nama Barang" readonly="true">
                                <span class="help-block"></span>
                            </div>
                        </div>                        
                    </div>

                    <div class="form-group">
                         <label class="control-label col-md-3">QTY<span class="required">*</span></label>
                        <div class="col-md-6">
                            <input name="qty" placeholder="Qty" class="validate[required,custom[number]] form-control" type="text" required="required" readonly="true">
                        <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">QTY Terima<span class="required">*</span></label>
                        <div class="col-md-6">
                            <input name="qty_terima" placeholder="Qty Terima" class="validate[required,custom[number]] form-control" type="text" required="required">
                            <span class="help-block"></span>
                            </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="simpan_terima_po()" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal Terima -->


<div class="modal fade" id="modal_detail_po" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3>Form Detail PO</h3>
            </div>
            <div class="panel-body">
                <table id="datatable-detailbarang" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>id detail</th>
                            <th>Kode PO</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>                            
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Total</th>
                            <th>Terima</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
            </div>
            
        </div>
    </div>
</div>

<!-- Bootstrap modal -->
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

                    <div class="form-group">
                        <label class="control-label col-md-3">Barang<span class="required">*</span></label>
                        <div class="col-md-6">
                            <select id="nama_barang" name="nama_barang" data-live-search="true"  class="selectpicker validate[required] form-control" required="required">
                                <option value="">--Pilih Barang--</option>
                                <?php
                                foreach ($pilihan_barang as $row3):
                                    ?>
                                    <option value="<?php echo $row3->id; ?>"><?php echo $row3->kode."-".$row3->nama; ?></option>
                                    <?php

                                endforeach;
                                ?>
                            </select>
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
                        <label class="control-label col-md-3">Harga Beli<span class="required">*</span></label>
                        <div class="col-md-6">
                            <input name="harga" placeholder="Harga" class="validate[required,custom[number]] form-control" type="text" required="required">
                            <span class="help-block"></span>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="control-label col-md-3">Buttom Supplier<span class="required">*</span></label>
                        <div class="col-md-6">
                            <input name="buttom_supplier" placeholder="Harga Buttom Supplier" class="validate[required,custom[number]] form-control" type="text" required="required">
                            <span class="help-block"></span>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="control-label col-md-3">Buttom Retail<span class="required">*</span></label>
                        <div class="col-md-6">
                            <input name="buttom_retail" placeholder="Harga Buttom Customer" class="validate[required,custom[number]] form-control" type="text" required="required">
                            <span class="help-block"></span>
                        </div>
                    </div>

                    

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSaveDetail" onclick="saveDetail()" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<script>

    $("#nama_barang :selected").text(); // The text content of the selected option
    $("#nama_barang").val(); // The value of the selected option

</script>