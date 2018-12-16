
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Data Kunjungan Outlet</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <p>
                                
                                <button class="btn btn-success" onclick="add_kunjungan_outlet()"><i class="glyphicon glyphicon-plus"></i> Tambah Transaksi</button>
                                <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
                            </p>


                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>id</th>
                                    <th>Tanggal</th>
                                    <th>Nama outlet</th>
                                    <th>Kode Pegawai</th>
                                    <th>Nama Pegawai</th>
                                    <th>Hasil</th>
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
                "url": "<?php echo site_url('admin/transaksi/kunjungan_outlet/get_data_all');?>",
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

    function add_kunjungan_outlet()
    {
        save_method = 'add';
        $('#form_kunjungan_outlet')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Kunjungan Outlet'); // Set Title to Bootstrap modal title
    }

    function edit_kunjungan_outler(id)
    {
        save_method = 'update';
        $('#form_kunjungan_outlet')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('admin/transaksi/kunjungan_outlet/edit/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="id"]').val(data[0]['id']);
                $('[name="nama_outlet"]').val(data[0]['nama_outlet']);
                $('[name="tanggal"]').val(data[0]['tanggal']);
                $('[name="kode_pegawai"]').val(data[0]['kode_pegawai']);
                $('[name="nama_pegawai"]').val(data[0]['nama_pegawai']);
                $('[name="hasil_kunjungan"]').val(data[0]['hasil_kunjungan']);
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Ubah Kunjungan Outlet'); // Set title to Bootstrap modal title

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

    function delete_kunjungan_outlet(id)
    {
        if(confirm('Anda yakin mau menghapus data inix ?'))
        {
            // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('admin/transaksi/kunjungan_outlet/delete')?>/"+id,
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

<!-- Bootstrap modal Terima-->
<div class="modal fade" id="modal_form" role="dialog" style="overflow-y: auto !important;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Tambah Kunjungan Outlet</h3>
            </div>
            <div class="modal-body form">
                <form Kunjungan Outlet id="form_kunjungan_outlet" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Tanggal <span class="required">*</span></label>
                            <div class="col-md-9">
                                <input placeholder="dd-mm-yyyy" name="tanggal" class="validate[required] form-control datepicker" type="text" required="required">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Outlet <span class="required">*</span></label>
                           <div class="col-md-9">
                                <input name="nama_outlet" placeholder="Nama Outlet" class="validate[required] form-control" type="text" required="required"><span class="help-block"></span>
                            </div>
                        </div>


                    <div class="form-group">
                        <label class="control-label col-md-3">Pegawai<span class="required">*</span></label>
                        <div class="col-md-6">
                            <select id="kode_pegawai" name="kode_pegawai" data-live-search="true"  class="selectpicker validate[required] form-control" required="required">
                                <option value="">--Pilih Pegawai--</option>
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

                        <div class="form-group">
                            <label class="control-label col-md-3">Hasil <span class="required">*</span></label>
                           <div class="col-md-9">
                                <input name="hasil_kunjungan" placeholder="Hasil Kunjungan" class="validate[required] form-control" type="text" required="required"><span class="help-block"></span>
                            </div>
                        </div>

                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="simpan_kunjungan_outlet()" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal Terima -->


<script>
    $(function() {

        $('#nama_biaya').on('change', function(){
            alert('tess');
            //var selected = $(this).find("option:selected").val();
            $('[name="nama_biaya"]').val($("#nama_biaya :selected").text());
        });


    })

    function simpan_kunjungan_outlet()
    {

        var url;
        if(save_method === 'add') {
            url = "<?php echo site_url('admin/transaksi/kunjungan_outlet/add')?>";
        }else{
            url = "<?php echo site_url('admin/transaksi/kunjungan_outlet/update')?>";
        }
        seen = [];



        if(!$("#form_kunjungan_outlet").validationEngine('validate')){
            return false;
        }


        $('#btnSave').text('menyimpan...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable

        // ajax adding data to database
        $.ajax({
            url : url,
            type: "POST",
            data: $('#form_kunjungan_outlet').serialize() ,
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



</script>

