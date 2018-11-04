
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
                                    <th>Kode Relasi</th>
                                    <th>Nama Relasi</th>
                                    <th>Jenis</th>
                                    <th>Tanggal JT</th>
                                    <th>Nominal</th>
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

    


</script>

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
</script>