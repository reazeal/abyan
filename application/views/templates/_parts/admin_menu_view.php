<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
            <li><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a></li>
            <li><a><i class="fa fa-server"></i> Master <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                 <!--    <li><a href="<?php echo site_url('admin/master/gudang');?>">Gudang</a></li> -->
                    <li><a href="<?php echo site_url('admin/master/barang');?>">Barang</a></li>
                    <li><a href="<?php echo site_url('admin/master/supplier');?>">Supplier</a></li> 
                    <li><a href="<?php echo site_url('admin/master/customers');?>">Customer</a></li> 
                    <li><a href="<?php echo site_url('admin/master/pegawai');?>">Pegawai</a></li> 
                </ul>
            </li>
            <li><a><i class="fa fa-puzzle-piece"></i> Transaksi <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="<?php echo site_url('admin/transaksi/purchase_order');?>">Purchase Order</a></li>
                    <li><a href="<?php echo site_url('admin/transaksi/penerimaan_po');?>">Penerimaan PO</a></li>

                    <li><a href="<?php echo site_url('admin/transaksi/barang_masuk');?>">Barang Masuk</a></li>
                
                    <li><a href="<?php echo site_url('admin/transaksi/barang_keluar');?>">Barang Keluar</a>
                    </li>
                    
                    <li><a href="<?php echo site_url('admin/transaksi/sales_order');?>">Sales Order</a></li>
                    <li><a href="<?php echo site_url('admin/transaksi/pengiriman_so');?>">Pengiriman SO</a></li>
                </ul>
            </li>
            <li><a><i class="fa fa-puzzle-piece"></i> Stok <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="<?php echo site_url('admin/transaksi/stok_opname');?>">Stok Opname</a></li>
                    <li><a href="<?php echo site_url('admin/transaksi/stok');?>">Stok Barang</a></li>
                </ul>
            </li>
            <li><a><i class="fa fa-puzzle-piece"></i> Keuangan <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="<?php echo site_url('admin/transaksi/piutang');?>">Piutang</a></li>
                    <li><a href="<?php echo site_url('admin/transaksi/hutang');?>">Hutang</a></li>
                    <li><a href="<?php echo site_url('admin/transaksi/pembayaran_hutang');?>">Pembayaran Hutang</a></li>
                    <li><a href="<?php echo site_url('admin/transaksi/pembayaran_piutang');?>">Pembayaran Piutang</a></li>
                </ul>
            </li>
            <li><a><i class="fa fa-file"></i> Laporan <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="<?php echo site_url('admin/laporan/stok_barang');?>">Stok Barang</a></li>
                    <li><a href="<?php echo site_url('admin/laporan/mutasi_barang');?>">Mutasi Barang</a></li>
                    <li><a href="<?php echo site_url('admin/laporan/penjualan_barang');?>">Penjualan Barang</a></li>
                </ul>
            </li>
            
        </ul>
    </div>
   
</div>
<!-- /sidebar menu -->

<!-- /menu footer buttons -->
<div class="sidebar-footer hidden-small">
    <a data-toggle="tooltip" data-placement="top" title="Settings">
        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="FullScreen">
        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="Lock">
        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?php echo site_url('auth/logout');?>">
        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
    </a>
</div>
<!-- /menu footer buttons -->
</div>
</div>

<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo site_url('assets/images/img.jpg');?>" alt=""><?php echo $firstname_auth." ".$lastname_auth; ?>
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="<?php echo site_url('admin/user/profile');?>"> Profile</a></li>
                        <li><a href="<?php echo site_url('admin/user/user_group');?>">Users/Group</a></li>
                        <li><a href="<?php echo site_url('auth/logout');?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>
<!-- /top navigation -->