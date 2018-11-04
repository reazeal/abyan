<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $page_title;?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo site_url('assets/bootstrap/css/bootstrap.min.css');?>" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo site_url('assets/css/AdminLTE.min.css');?>" />
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo site_url('assets/css/skins/_all-skins.min.css');?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo site_url('assets/plugins/iCheck/flat/blue.css');?>">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo site_url('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css');?>">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo site_url('assets/plugins/datepicker/datepicker3.css');?>">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo site_url('assets/plugins/daterangepicker/daterangepicker.css');?>">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo site_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css');?>">
  <link rel="stylesheet" href="<?php echo site_url('assets/plugins/bootstrap/css/bootstrap.css');?>" />
  <link rel="stylesheet" href="<?php echo site_url('assets/plugins/bootstrap-table/src/bootstrap-table.css');?>">
  <link rel="stylesheet" href="<?php echo site_url('assets/plugins/bootstrap-table/bootstrap-editable.css');?>">
  <link rel="stylesheet" href="<?php echo site_url('assets/plugins/dataTables/dataTables.bootstrap.css');?>">
  <link rel="stylesheet" href="<?php echo site_url('assets/css/main.css');?> "  />
  <link rel="stylesheet" href="<?php echo site_url('assets/css/theme.css');?> " />
  <link rel="stylesheet" href="<?php echo site_url('assets/css/jquery.ajax-combobox.css');?> " />
  <link rel="stylesheet" href="<?php echo site_url('assets/plugins/validationengine/css/validationEngine.jquery.css');?> " />
  <link rel="stylesheet" href="<?php echo site_url('assets/plugins/Font-Awesome/css/font-awesome.css');?> " />
  <link rel="stylesheet" href="<?php echo site_url('assets/css/jquery-ui.css');?>"  />
  <link rel="stylesheet" href="<?php echo site_url('assets/plugins/uniform/themes/default/css/uniform.default.css');?>" />
  <link rel="stylesheet" href="<?php echo site_url('assets/plugins/inputlimiter/jquery.inputlimiter.1.0.css');?>" />
  <link rel="stylesheet" href="<?php echo site_url('assets/plugins/chosen/chosen.min.css');?>" />
  <link rel="stylesheet" href="<?php echo site_url('assets/plugins/tagsinput/jquery.tagsinput.css');?>" />
  <link rel="stylesheet" href="<?php echo site_url('assets/plugins/daterangepicker/daterangepicker-bs3.css');?>" />
  <link rel="stylesheet" href="<?php echo site_url('assets/plugins/datepicker/css/datepicker.css');?>" />
  <link rel="stylesheet" href="<?php echo site_url('assets/plugins/timepicker/css/bootstrap-timepicker.min.css');?>" />
  <link rel="stylesheet" href="<?php echo site_url('assets/plugins/switch/static/stylesheets/bootstrap-switch.css');?>" />
  <link rel="stylesheet" href="<?php echo site_url('assets/css/uploadfile.css');?>" />
  <link rel="stylesheet" href="<?php echo site_url('assets/css/blue.css');?>" />
  <link rel="stylesheet" href="<?php echo site_url('assets/css/bootstrap-select-min.css');?>" />
  <link rel="stylesheet" href="<?php echo site_url('assets/plugins/timeline/timeline.css');?>" />
  <link rel="stylesheet" href="<?php echo site_url('assets/css/jquery.printarea.css');?>" />
  <link rel="stylesheet" href="<?php echo site_url('assets/plugins/datetimepicker/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css');?>" />

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- <script src="<?php echo site_url('assets/plugins/jQuery/jquery-2.2.3.min.js');?>"></script> -->
  <script src="<?php echo site_url('assets/Lama/plugins/jquery-2.0.3.min.js');?>"></script>
  <!-- <script src="<?php echo site_url('assets/js/jquery-ui.min.js');?>"></script> -->
  <script src="<?php echo site_url('assets/Lama/js/jquery-ui.min.js');?>"></script>
  <script src="<?php echo site_url('assets/plugins/modernizr-2.6.2-respond-1.1.0.min.js');?>"></script>
  <script src="<?php echo site_url('assets/plugins/validationengine/js/jquery.validationEngine.js');?>"></script>
  <script src="<?php echo site_url('assets/plugins/validationengine/js/languages/jquery.validationEngine-en.js');?>"></script>
  <script src="<?php echo site_url('assets/plugins/jquery-validation-1.11.1/dist/jquery.validate.min.js');?>"></script>
  <script src="<?php echo site_url('assets/plugins/uniform/jquery.uniform.min.js');?>"></script>
  <script src="<?php echo site_url('assets/plugins/inputlimiter/jquery.inputlimiter.1.3.1.min.js');?>"></script>
  <script src="<?php echo site_url('assets/plugins/chosen/chosen.jquery.min.js');?>"></script>
  <script src="<?php echo site_url('assets/plugins/validVal/js/jquery.validVal.min.js');?>"></script>
  <script src="<?php echo site_url('assets/plugins/datepicker/js/bootstrap-datepicker.js');?>"></script>
  <script src="<?php echo site_url('assets/plugins/timepicker/js/bootstrap-timepicker.min.js');?>"></script>
  <script src="<?php echo site_url('assets/plugins/switch/static/js/bootstrap-switch.min.js');?>"></script>
  <script src="<?php echo site_url('assets/plugins/autosize/jquery.autosize.min.js');?>"></script>
  <script src="<?php echo site_url('assets/plugins/tagsinput/jquery.tagsinput.min.js');?>"></script>
  <script src="<?php echo site_url('assets/js/formsInit.js');?>"></script>
  <script src="<?php echo site_url('assets/js/jquery.uploadfile.min.js');?>"></script>
  <script src="<?php echo site_url('assets/js/jquery.form.js');?>"></script>
  <script src="<?php echo site_url('assets/plugins/jquery.dualListbox-1.3/jquery.dualListBox-1.3.min.js');?>"></script>
  <script src="<?php echo site_url('assets/plugins/jasny/js/bootstrap-inputmask.js');?>"></script>
  <script src="<?php echo site_url('assets/js/bootstrap-select.min.js');?>"></script>
  <script src="<?php echo site_url('assets/js/tooltip.js');?>"></script>
  <script src="<?php echo site_url('assets/js/popover.js');?>"></script>
  <script src="<?php echo site_url('assets/plugins/bootstrap-table/src/bootstrap-table.js');?>"></script>
  <script src="<?php echo site_url('assets/plugins/bootstrap-table/bootstrap-editable.js');?>"></script>
  <script src="<?php echo site_url('assets/plugins/bootstrap-table/src/extensions/editable/bootstrap-table-editable.js');?>"></script>
  <script src="<?php echo site_url('assets/js/jquery.printarea.js');?>"></script>
  <script src="<?php echo site_url('assets/js/eModal.min.js');?>"></script>
  <script src="<?php echo site_url('assets/js/credit.js');?>"></script>
  <script src="<?php echo site_url('assets/js/icheck.min.js');?>"></script>
  <script src="<?php echo site_url('assets/js/jquery.ajax-combobox.js');?>"></script>
  <script src="<?php echo site_url('assets/js/jquery.simple-scroll-follow.min.js');?>"></script>
  <script src="<?php echo site_url('assets/plugins/datetimepicker/moment/min/moment-with-locales.min.js');?>"></script>
  <script src="<?php echo site_url('assets/plugins/datetimepicker/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js');?>"></script>


  <!-- jQuery 2.2.3 -->
  <!-- <script src="<?php echo site_url('assets/plugins/jQuery/jquery-2.2.3.min.js');?>"></script> -->
  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo site_url('assets/bootstrap/js/bootstrap.min.js');?>"></script>
  <!-- Sparkline -->
  <script src="<?php echo site_url('assets/plugins/sparkline/jquery.sparkline.min.js');?>"></script>
  <!-- jvectormap -->
  <script src="<?php echo site_url('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js');?>"></script>
  <script src="<?php echo site_url('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js');?>"></script>
  <!-- jQuery Knob Chart -->
  <script src="<?php echo site_url('assets/plugins/knob/jquery.knob.js');?>"></script>
  <!-- daterangepicker -->
  <script src="<?php echo site_url('assets/js/moment.min.js');?>"></script>
  <script src="<?php echo site_url('assets/plugins/daterangepicker/daterangepicker.js');?>"></script>
  <!-- datepicker -->
  <script src="<?php echo site_url('assets/plugins/datepicker/bootstrap-datepicker.js');?>"></script>
  <!-- Bootstrap WYSIHTML5 -->
  <script src="<?php echo site_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js');?>"></script>
  <!-- Slimscroll -->
  <script src="<?php echo site_url('assets/plugins/slimScroll/jquery.slimscroll.min.js');?>"></script>
  <!-- FastClick -->
  <script src="<?php echo site_url('assets/plugins/fastclick/fastclick.js');?>"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo site_url('assets/js/app.min.js');?>"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?php echo site_url('assets/js/demo.js');?>"></script>

  <script type="application/javascript">
    var COPYRIGHT           = '<?php echo $this->config->item("copyright"); ?>';
    var WEB_TITLE           = '<?php echo $this->config->item("site_title"); ?>';
    var CREDIT              = '<?php echo $this->config->item("credit"); ?>';
  </script>

</head>
<body class="hold-transition login-page skin-blue sidebar-mini">
<?php
if($this->ion_auth->logged_in()) {
?>
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin</b>SIMPRA</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- <img src="assets/img/user2-160x160.jpg" class="user-image" alt="User Image"> -->
              <span class="hidden-xs">Administrator</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <!-- <img src="assets/img/user2-160x160.jpg" class="img-circle" alt="User Image"> -->

                <p>
                  Administrator - Web Developer
                  <small>Dibangun sejak Agustus 2016</small>
                </p>
              </li>

              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo site_url('admin/user/profile');?>" class="btn btn-default btn-flat">Profile</a>
                </div>
				<div class="pull-center">
                  <a href="<?php echo site_url('admin/groups');?>" class="btn btn-default btn-flat">Groups</a>
				  <a href="<?php echo site_url('admin/users');?>" class="btn btn-default btn-flat">Users</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo site_url('admin/user/logout');?>" class="btn btn-danger btn-flat">LogOut</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> 
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <!-- <img src="assets/img/user2-160x160.jpg" class="img-circle" alt="User Image"> -->
        </div>
      </div>

      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li class="<?php echo (($menu_data['dashboard']=='true')? 'active':'') ?> treeview">
          <a href="<?php echo site_url('admin/');?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
        <li class="<?php echo (($menu_data['Barang']=='true')? 'active':'') ?> treeview">
          <a href="#">
            <i class="fa fa-gears"></i> <span>Master</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
			<li class="" id="menuPengumuman"><a href="<?php echo site_url('admin/pengumuman');?>"><i class="fa fa-circle-o "></i> Pengumuman</a> </li>
            <li class="" id="menuTahunAjaran"><a href="<?php echo site_url('admin/tahun_ajaran');?>"><i class="fa fa-circle-o "></i> Tahun Ajaran</a> </li>
            <li class="" id="menuDosen"><a href="<?php echo site_url('admin/dosen');?>"><i class="fa fa-circle-o"></i> Dosen </a> </li>
            <li class="" id="menuMahasiswa"><a href="<?php echo site_url('admin/mahasiswa');?>"><i class="fa fa-circle-o"></i> Mahasiswa </a> </li>
            <li class="" id="menuMataKuliah"><a href="<?php echo site_url('admin/mata_kuliah');?>"><i class="fa fa-circle-o "></i> Mata Kuliah</a> </li>
            <li class="" id="menuRuangPraktikum"><a href="<?php echo site_url('admin/ruang_praktikum');?>"><i class="fa fa-circle-o "></i> Ruang Praktikum</a> </li>
            <li class="" id="menuTawarPraktikum"><a href="<?php echo site_url('admin/tawar_praktikum');?>"><i class="fa fa-circle-o "></i> Tawar Praktikum</a> </li>
            <li class="" id="menuKelompokPraktikum"><a href="<?php echo site_url('admin/kelompok_praktikum');?>"><i class="fa fa-circle-o "></i> Kelompok Praktikum</a> </li>
            <li class="" id="menuJadwalPraktikum"><a href="<?php echo site_url('admin/jadwal_praktikum');?>"><i class="fa fa-circle-o "></i> Jadwal Praktikum</a> </li>
            <li class="" id="menuAsistenPraktikum"><a href="<?php echo site_url('admin/asisten_praktikum');?>"><i class="fa fa-circle-o "></i> Dosen/Asisten Praktikum</a> </li>
            <!-- <li class="" id="menuMahasiswaMagang"><a href="<?php echo site_url('admin/mahasiswa_magang');?>"><i class="fa fa-circle-o "></i> Mahasiswa Magang</a> </li> -->
         </ul>
        </li>
        <li class="<?php echo (($menu_data['transaksi']=='true')? 'active':'') ?> treeview">
          <a href="#">
            <i class="fa fa-tasks"></i>
            <span>Transaksi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="" id="menuDaftarPraktikum"><a href="<?php echo site_url('admin/daftar_praktikum');?>"><i class="fa fa-circle-o "></i> Pendaftar Praktikum</a> </li>
            <li class="" id="menuAbsensiOnline"><a href="<?php echo site_url('admin/absensi_online');?>"><i class="fa fa-circle-o "></i> Absensi Online</a> </li>
            <li class="" id="menuNilaiPraktikum"><a href="<?php echo site_url('admin/nilai_praktikum');?>"><i class="fa fa-circle-o "></i> Nilai Praktikum</a> </li>
          </ul>
        </li>

		 <li class="<?php echo (($menu_data['cetakan']=='true')? 'active':'') ?> treeview">
          <a href="#">
            <i class="fa fa-print"></i>
            <span>Cetakan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="" id="menuCetakanAbsensiOnline"><a href="<?php echo site_url('admin/cetakan/absensi_online');?>"><i class="fa fa-circle-o "></i> Absensi Online</a> </li>
            <li class="" id="menuCetakanAbsensi"><a href="<?php echo site_url('admin/cetakan/absensi');?>"><i class="fa fa-circle-o "></i> Absensi Manual</a> </li>
            <li class="" id="menuCetakanDaftarMhs"><a href="<?php echo site_url('admin/cetakan/pendaftar_praktikum');?>"><i class="fa fa-circle-o "></i> Pendaftar Praktikum</a> </li>
            <!-- <li class="" id="menuCetakanSertifikat"><a href="<?php echo site_url('admin/cetakan/sertifikat_praktikum');?>"><i class="fa fa-circle-o "></i> Sertifikat Praktikum</a> </li> -->
          </ul>
        </li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

      <?php
      echo $this->postal->get();
      ?>

  <!-- /.content-wrapper -->

  <?php
  }
  ?>
