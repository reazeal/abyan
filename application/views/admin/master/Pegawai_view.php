
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Data Pegawai</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <p>
                                
                                <button class="btn btn-success" onclick="add_pegawai()"><i class="glyphicon glyphicon-plus"></i> Tambah Pegawai</button>
                                <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
                            </p>


                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>id</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
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
                "url": "<?php echo site_url('admin/master/pegawai/get_data_all');?>",
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

    function add_pegawai()
    {
        save_method = 'add';
        $('#form_pegawai')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Pegawai'); // Set Title to Bootstrap modal title
    }

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
<div class="modal fade" id="modal_form" role="dialog" style="overflow-y: auto !important;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Tambah Pegawai</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_pegawai" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Kode Pegawai <span class="required">*</span></label>
                            <div class="col-md-9">
                                <input name="kode_pegawai" placeholder="Kode Pegawai">
                                <span class="help-block"></span>
                            </div>
                        </div>                        
                    </div>

                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Pegawai <span class="required">*</span></label>
                            <div class="col-md-9">
                                <input name="nama_pegawai" placeholder="Nama Pegawai">
                                <span class="help-block"></span>
                            </div>
                        </div>                        
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="simpan_pegawai()" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal Terima -->


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

    function simpan_pegawai()
    {

        var url;

        url = "<?php echo site_url('admin/master/pegawai/add')?>";

        seen = [];



        if(!$("#form_pegawai").validationEngine('validate')){
            return false;
        }


        $('#btnSave').text('menyimpan...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable

        // ajax adding data to database
        $.ajax({
            url : url,
            type: "POST",
            data: $('#form_pegawai').serialize() ,
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

