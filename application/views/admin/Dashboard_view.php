<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="row top_tiles">
            
            <div class="animated flipInY col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="tile-stats">
<!--                    <div class="icon"><i class="fa fa-level-down"></i></div>-->
                    <div class="count"><?php echo "RP. ".number_format($nominal_piutang, 0, ',', '.').",-" ?></div>
                    <h3>Total Piutang</h3>
                    <p>Hingga hari ini</p>
                </div>
            </div>
            <div class="animated flipInY col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="tile-stats">
<!--                    <div class="icon"><i class="fa fa-level-up"></i></div>-->
                    <div class="count"><?php echo number_format($jml_qty, 2, ',', '.') ?></div>
                    <h3>Total Qty Penjualan</h3>
                    <p>Dalam bulan ini</p>
                </div>
            </div>
            <div class="animated flipInY col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="tile-stats">
<!--                    <div class="icon"><i class="fa fa-level-up"></i></div>-->
                    <div class="count"><?php echo "RP. ".number_format($nominal_uang_masuk, 0, ',', '.').",-" ?></div>
                    <h3>Total Uang Masuk</h3>
                    <p>Dalam bulan ini</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-9">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Trend Penjualan Tahun <?= date('Y')?></h2>
                        <!--div class="filter">
                            <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                            </div>
                        </div-->
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="demo-container" >
                                <div class="col-md-4 tile">
                                </div>
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Top Customer <small>per bulan</small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <ul class="list-unstyled top_profiles scroll-view">
                                    <?php foreach($top_customer as $row){?>
                                    <li class="media event">
                                        <a class="pull-left border-aero profile_thumb">
                                            <i class="fa fa-user aero"></i>
                                        </a>
                                        <div class="media-body">
                                            <a class="title" href="#"><?= $row->nama_customer?></a>
                                            <p> <small><?= $row->jumlah?> pembelian</small>
                                            </p>
                                        </div>
                                    </li>
                                    <?php }?>
                                </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
<!-- /page content -->

<script>
var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
        datasets: [{
            label: 'Penjualan',
            data: [
                <?php for($i=1;$i<=12;$i++){
                    if(!empty($a_qty_bulan[$i]))
                        echo $a_qty_bulan[$i].',';
                    else
                        echo '0,';
                }?>
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>