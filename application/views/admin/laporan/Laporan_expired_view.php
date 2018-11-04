
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>LAPORAN EXPIRED BARANG</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <p>


                               <!-- Bootstrap modal -->
<div  id="modal_form" role="dialog" style="overflow-y: auto !important;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Parameter</h3>
				</div>
				
				<div class="modal-footer">
					<button type="button" id="btnCetak" onclick="cetak()" class="btn btn-primary">Cetak</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<!-- End Bootstrap modal -->


                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /page content -->



<script type="text/javascript">


 $(document).ready(function() {
        //datepicker
        $('.datepicker').datepicker({
            autoclose: true,
            dateFormat: 'dd-mm-yy',
            todayHighlight: true,
            orientation: "top auto",
            todayBtn: true
        });


    });


 function cetak()
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