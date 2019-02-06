<html>
<head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">

    <title>Cetak Raw</title>
</head>

<!-- Required scripts -->
<script type="text/javascript" src="<?php echo site_url('assets/qtray/js/dependencies/rsvp-3.1.0.min.js');?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/qtray/js/dependencies/sha-256.min.js');?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/qtray/js/qz-tray.js');?>"></script>

<!-- Page styling -->
<script type="text/javascript" src="<?php echo site_url('assets/qtray/js/additional/jquery-1.11.3.min.js');?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/qtray/js/additional/bootstrap.min.js');?>"></script>
<link rel="stylesheet" href="<?php echo site_url('assets/qtray/css/font-awesome.min.css');?>" />
<link rel="stylesheet" href="<?php echo site_url('assets/qtray/css/bootstrap.min.css');?>" />
<link rel="stylesheet" href="<?php echo site_url('assets/qtray/css/style.css');?>" />


<body id="qz-page" role="document" onload="setPrinter('Epson LX-310');">

<div id="qz-alert" style="position: fixed; width: 60%; margin: 0 4% 0 36%; z-index: 900;"></div>
<div id="qz-pin" style="position: fixed; width: 30%; margin: 0 66% 0 4%; z-index: 900;"></div>

<div class="container" role="main">

    <div class="row">
        <h1 id="title" class="page-header"></h1>
    </div>

    <div class="row spread">
        <div class="col-md-4">
            <div id="qz-connection" class="panel panel-default">
                <div class="panel-heading">
                    <button class="close tip" data-toggle="tooltip" title="Launch QZ" id="launch" href="#" onclick="launchQZ();" style="display: none;">
                        <i class="fa fa-external-link"></i>
                    </button>
                    <h3 class="panel-title">
                        Connection: <span id="qz-status" class="text-muted" style="font-weight: bold;">Unknown</span>
                    </h3>
                </div>

                <div class="panel-body">
                    <div class="btn-toolbar">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-success" onclick="startConnection();">Connect</button>
                            <button type="button" class="btn btn-warning" onclick="endConnection();">Disconnect</button>
                        </div>
                        <button type="button" class="btn btn-info" onclick="listNetworkInfo();">List Network Info</button>
                    </div>
                </div>
            </div>

            <hr />

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Printer</h3>
                </div>

                <div class="panel-body">
                    <div class="form-group">
                        <label>Current printer:</label>
                        <div id="configPrinter">NONE</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <ul class="nav nav-tabs" role="tablist">
                <li id="rawTab" role="presentation" class="active"><a href="#rawContent" role="tab" data-toggle="tab">Preview Cetakan </a></li>
            </ul>
        </div>

        <div class="tab-content">
            <div id="rawContent" class="tab-pane active col-md-8">
                 <div class="row">
                    <div class="col-md-12">
                        <span style="float: right;">
                            Set Printer :
                            <a href="javascript:setPrinter('Epson LX-310');">Epson</a>
                        </span>
                    </div>
                </div>
                <div class="row">&nbsp;</div>
                <div class="row">&nbsp;</div>
                <div class="row" align="center">
                    <div class="col-md-12">
                            <table border="1" class="table">
                                <tr>
                                    <td>No</td>
                                    <td>Nama Brg</td>
                                    <td>Kode Brg</td>
                                    <td>Qty</td>
                                    <td>Satuan</td>
                                    <td>Total</td>
                                </tr>
                                <?php

                               // print_r($datanya);
                                $urut = 1;
                                foreach ($datanya as $hasil) {
                                    // print_r($hasil);
                                    //echo $hasil['kode_barang'];

                                ?>
                                <tr>
                                    <td><?php echo $urut;?></td>
                                    <td><?php echo $hasil['nama_barang'];?></td>
                                    <td><?php echo $hasil['kode_barang'];?></td>
                                    <td><?php echo $hasil['qty'];?></td>
                                    <td><?php echo $hasil['harga'];?></td>
                                    <td><?php echo $hasil['qty'] * $hasil['harga'];?></td>

                                </tr>
                               <?php
                                $urut++;
                                }

                                ?>
                            </table>
                    </div>
                </div>

                <div class="row" align="center">
                    <div class="col-md-12">
                        <p></p>
                        <p></p>
                        <button type="button" class="btn btn-success" onclick="printESCPOS();">Cetak</button>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="modal fade" id="askFileModal" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="askFile">File:</label>
                        <input type="text" id="askFile" class="form-control" value="C:\tmp\example-file.txt" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="setPrintFile();">Set</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="askHostModal" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="askHost">Host:</label>
                        <input type="text" id="askHost" class="form-control" value="192.168.1.254" />
                    </div>
                    <div class="form-group">
                        <label for="askPort">Port:</label>
                        <input type="text" id="askPort" class="form-control" value="9100" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="setPrintHost();">Set</button>
                </div>
            </div>
        </div>
    </div>

</div>
</body>


<script>
    /// Authentication setup ///
    qz.security.setCertificatePromise(function(resolve, reject) {
        //Preferred method - from server
//        $.ajax({ url: "assets/signing/digital-certificate.txt", cache: false, dataType: "text" }).then(resolve, reject);

        //Alternate method 1 - anonymous
//        resolve();

        //Alternate method 2 - direct
        resolve("-----BEGIN CERTIFICATE-----\n" +
                "MIIFAzCCAuugAwIBAgICEAIwDQYJKoZIhvcNAQEFBQAwgZgxCzAJBgNVBAYTAlVT\n" +
                "MQswCQYDVQQIDAJOWTEbMBkGA1UECgwSUVogSW5kdXN0cmllcywgTExDMRswGQYD\n" +
                "VQQLDBJRWiBJbmR1c3RyaWVzLCBMTEMxGTAXBgNVBAMMEHF6aW5kdXN0cmllcy5j\n" +
                "b20xJzAlBgkqhkiG9w0BCQEWGHN1cHBvcnRAcXppbmR1c3RyaWVzLmNvbTAeFw0x\n" +
                "NTAzMTkwMjM4NDVaFw0yNTAzMTkwMjM4NDVaMHMxCzAJBgNVBAYTAkFBMRMwEQYD\n" +
                "VQQIDApTb21lIFN0YXRlMQ0wCwYDVQQKDAREZW1vMQ0wCwYDVQQLDAREZW1vMRIw\n" +
                "EAYDVQQDDAlsb2NhbGhvc3QxHTAbBgkqhkiG9w0BCQEWDnJvb3RAbG9jYWxob3N0\n" +
                "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAtFzbBDRTDHHmlSVQLqjY\n" +
                "aoGax7ql3XgRGdhZlNEJPZDs5482ty34J4sI2ZK2yC8YkZ/x+WCSveUgDQIVJ8oK\n" +
                "D4jtAPxqHnfSr9RAbvB1GQoiYLxhfxEp/+zfB9dBKDTRZR2nJm/mMsavY2DnSzLp\n" +
                "t7PJOjt3BdtISRtGMRsWmRHRfy882msBxsYug22odnT1OdaJQ54bWJT5iJnceBV2\n" +
                "1oOqWSg5hU1MupZRxxHbzI61EpTLlxXJQ7YNSwwiDzjaxGrufxc4eZnzGQ1A8h1u\n" +
                "jTaG84S1MWvG7BfcPLW+sya+PkrQWMOCIgXrQnAsUgqQrgxQ8Ocq3G4X9UvBy5VR\n" +
                "CwIDAQABo3sweTAJBgNVHRMEAjAAMCwGCWCGSAGG+EIBDQQfFh1PcGVuU1NMIEdl\n" +
                "bmVyYXRlZCBDZXJ0aWZpY2F0ZTAdBgNVHQ4EFgQUpG420UhvfwAFMr+8vf3pJunQ\n" +
                "gH4wHwYDVR0jBBgwFoAUkKZQt4TUuepf8gWEE3hF6Kl1VFwwDQYJKoZIhvcNAQEF\n" +
                "BQADggIBAFXr6G1g7yYVHg6uGfh1nK2jhpKBAOA+OtZQLNHYlBgoAuRRNWdE9/v4\n" +
                "J/3Jeid2DAyihm2j92qsQJXkyxBgdTLG+ncILlRElXvG7IrOh3tq/TttdzLcMjaR\n" +
                "8w/AkVDLNL0z35shNXih2F9JlbNRGqbVhC7qZl+V1BITfx6mGc4ayke7C9Hm57X0\n" +
                "ak/NerAC/QXNs/bF17b+zsUt2ja5NVS8dDSC4JAkM1dD64Y26leYbPybB+FgOxFu\n" +
                "wou9gFxzwbdGLCGboi0lNLjEysHJBi90KjPUETbzMmoilHNJXw7egIo8yS5eq8RH\n" +
                "i2lS0GsQjYFMvplNVMATDXUPm9MKpCbZ7IlJ5eekhWqvErddcHbzCuUBkDZ7wX/j\n" +
                "unk/3DyXdTsSGuZk3/fLEsc4/YTujpAjVXiA1LCooQJ7SmNOpUa66TPz9O7Ufkng\n" +
                "+CoTSACmnlHdP7U9WLr5TYnmL9eoHwtb0hwENe1oFC5zClJoSX/7DRexSJfB7YBf\n" +
                "vn6JA2xy4C6PqximyCPisErNp85GUcZfo33Np1aywFv9H+a83rSUcV6kpE/jAZio\n" +
                "5qLpgIOisArj1HTM6goDWzKhLiR/AeG3IJvgbpr9Gr7uZmfFyQzUjvkJ9cybZRd+\n" +
                "G8azmpBBotmKsbtbAU/I/LVk8saeXznshOVVpDRYtVnjZeAneso7\n" +
                "-----END CERTIFICATE-----\n" +
                "--START INTERMEDIATE CERT--\n" +
                "-----BEGIN CERTIFICATE-----\n" +
                "MIIFEjCCA/qgAwIBAgICEAAwDQYJKoZIhvcNAQELBQAwgawxCzAJBgNVBAYTAlVT\n" +
                "MQswCQYDVQQIDAJOWTESMBAGA1UEBwwJQ2FuYXN0b3RhMRswGQYDVQQKDBJRWiBJ\n" +
                "bmR1c3RyaWVzLCBMTEMxGzAZBgNVBAsMElFaIEluZHVzdHJpZXMsIExMQzEZMBcG\n" +
                "A1UEAwwQcXppbmR1c3RyaWVzLmNvbTEnMCUGCSqGSIb3DQEJARYYc3VwcG9ydEBx\n" +
                "emluZHVzdHJpZXMuY29tMB4XDTE1MDMwMjAwNTAxOFoXDTM1MDMwMjAwNTAxOFow\n" +
                "gZgxCzAJBgNVBAYTAlVTMQswCQYDVQQIDAJOWTEbMBkGA1UECgwSUVogSW5kdXN0\n" +
                "cmllcywgTExDMRswGQYDVQQLDBJRWiBJbmR1c3RyaWVzLCBMTEMxGTAXBgNVBAMM\n" +
                "EHF6aW5kdXN0cmllcy5jb20xJzAlBgkqhkiG9w0BCQEWGHN1cHBvcnRAcXppbmR1\n" +
                "c3RyaWVzLmNvbTCCAiIwDQYJKoZIhvcNAQEBBQADggIPADCCAgoCggIBANTDgNLU\n" +
                "iohl/rQoZ2bTMHVEk1mA020LYhgfWjO0+GsLlbg5SvWVFWkv4ZgffuVRXLHrwz1H\n" +
                "YpMyo+Zh8ksJF9ssJWCwQGO5ciM6dmoryyB0VZHGY1blewdMuxieXP7Kr6XD3GRM\n" +
                "GAhEwTxjUzI3ksuRunX4IcnRXKYkg5pjs4nLEhXtIZWDLiXPUsyUAEq1U1qdL1AH\n" +
                "EtdK/L3zLATnhPB6ZiM+HzNG4aAPynSA38fpeeZ4R0tINMpFThwNgGUsxYKsP9kh\n" +
                "0gxGl8YHL6ZzC7BC8FXIB/0Wteng0+XLAVto56Pyxt7BdxtNVuVNNXgkCi9tMqVX\n" +
                "xOk3oIvODDt0UoQUZ/umUuoMuOLekYUpZVk4utCqXXlB4mVfS5/zWB6nVxFX8Io1\n" +
                "9FOiDLTwZVtBmzmeikzb6o1QLp9F2TAvlf8+DIGDOo0DpPQUtOUyLPCh5hBaDGFE\n" +
                "ZhE56qPCBiQIc4T2klWX/80C5NZnd/tJNxjyUyk7bjdDzhzT10CGRAsqxAnsjvMD\n" +
                "2KcMf3oXN4PNgyfpbfq2ipxJ1u777Gpbzyf0xoKwH9FYigmqfRH2N2pEdiYawKrX\n" +
                "6pyXzGM4cvQ5X1Yxf2x/+xdTLdVaLnZgwrdqwFYmDejGAldXlYDl3jbBHVM1v+uY\n" +
                "5ItGTjk+3vLrxmvGy5XFVG+8fF/xaVfo5TW5AgMBAAGjUDBOMB0GA1UdDgQWBBSQ\n" +
                "plC3hNS56l/yBYQTeEXoqXVUXDAfBgNVHSMEGDAWgBQDRcZNwPqOqQvagw9BpW0S\n" +
                "BkOpXjAMBgNVHRMEBTADAQH/MA0GCSqGSIb3DQEBCwUAA4IBAQAJIO8SiNr9jpLQ\n" +
                "eUsFUmbueoxyI5L+P5eV92ceVOJ2tAlBA13vzF1NWlpSlrMmQcVUE/K4D01qtr0k\n" +
                "gDs6LUHvj2XXLpyEogitbBgipkQpwCTJVfC9bWYBwEotC7Y8mVjjEV7uXAT71GKT\n" +
                "x8XlB9maf+BTZGgyoulA5pTYJ++7s/xX9gzSWCa+eXGcjguBtYYXaAjjAqFGRAvu\n" +
                "pz1yrDWcA6H94HeErJKUXBakS0Jm/V33JDuVXY+aZ8EQi2kV82aZbNdXll/R6iGw\n" +
                "2ur4rDErnHsiphBgZB71C5FD4cdfSONTsYxmPmyUb5T+KLUouxZ9B0Wh28ucc1Lp\n" +
                "rbO7BnjW\n" +
                "-----END CERTIFICATE-----\n");
    });

    qz.security.setSignaturePromise(function(toSign) {
        return function(resolve, reject) {
            //Preferred method - from server
//            $.ajax("/secure/url/for/sign-message?request=" + toSign).then(resolve, reject);

            //Alternate method - unsigned
            resolve();
        };
    });


    /// Connection ///
    function launchQZ() {
        if (!qz.websocket.isActive()) {
            window.location.assign("qz:launch");
            //Retry 5 times, pausing 1 second between each attempt
            startConnection({ retries: 5, delay: 1 });
        }
    }

    function startConnection(config) {
        if (!qz.websocket.isActive()) {
            updateState('Waiting', 'default');

            qz.websocket.connect(config).then(function() {
                updateState('Active', 'success');
                findVersion();
            }).catch(handleConnectionError);
        } else {
            displayMessage('An active connection with QZ already exists.', 'alert-warning');
        }
    }

    function endConnection() {
        if (qz.websocket.isActive()) {
            qz.websocket.disconnect().then(function() {
                updateState('Inactive', 'default');
            }).catch(handleConnectionError);
        } else {
            displayMessage('No active connection with QZ exists.', 'alert-warning');
        }
    }

    function listNetworkInfo() {
        qz.websocket.getNetworkInfo().then(function(data) {
            if (data.macAddress == null) { data.macAddress = 'UNKNOWN'; }
            if (data.ipAddress == null) { data.ipAddress = "UNKNOWN"; }

            var macFormatted = '';
            for(var i = 0; i < data.macAddress.length; i++) {
                macFormatted += data.macAddress[i];
                if (i % 2 == 1 && i < data.macAddress.length - 1) {
                    macFormatted += ":";
                }
            }

            displayMessage("<strong>IP:</strong> " + data.ipAddress + "<br/><strong>Physical Address:</strong> " + macFormatted);
        }).catch(displayError);
    }


    /// Detection ///
    function findPrinter(query, set) {
        $("#printerSearch").val(query);
        qz.printers.find(query).then(function(data) {
            displayMessage("<strong>Found:</strong> " + data);
            if (set) { setPrinter(data); }
        }).catch(displayError);
    }

    function findDefaultPrinter(set) {
        qz.printers.getDefault().then(function(data) {
            displayMessage("<strong>Found:</strong> " + data);
            if (set) { setPrinter(data); }
        }).catch(displayError);
    }

    function findPrinters() {
        qz.printers.find().then(function(data) {
            var list = '';
            for(var i = 0; i < data.length; i++) {
                list += "&nbsp; " + data[i] + "<br/>";
            }

            displayMessage("<strong>Available printers:</strong><br/>" + list);
        }).catch(displayError);
    }




    function  printESCPOS() {
        var config = getUpdatedConfig();

        var printData = [
            { type: 'raw', data: '\n', options: { language: 'ESCPOS', dotDensity: 'double',  } , },
            '\x1B' + '\x40',   
            '\x1B' + '\x45' + '\x0D',
            
            /*
            { type: 'raw', data: '                  INVOICE                      \n' },
            { type: 'raw', data: 'CV. Abyan Jaya                          Number    :  <?php echo $so->kode_so ?>    \n' },
            { type: 'raw', data: 'Jl. Balongsari Tama Blok A/3            Tanggal   :  <?php echo $so->tanggal ?>      \n' },
            { type: 'raw', data: 'Balongsari - Tandes, Surabaya           TOP       : \n' },
            { type: 'raw', data: 'Phone : (031) 561-3507                  Sales     : \n' },
            { type: 'raw', data: 'WA :0822-3204-7857 \n' },
            { type: 'raw', data: ' ====================================================================== \n' },
            { type: 'raw', data: ' | No | Kode Barang |  Nama Barang  | Jumlah | Harga | Diskon | Total | \n' },
            { type: 'raw', data: ' ====================================================================== \n' },
            */
             '                               INVOICE                      \n',
             'CV. Abyan Jaya                          Number    :  <?php echo $so->kode_so ?>    \n' ,
             'Jl. Balongsari Tama Blok A/3            Tanggal   :  <?php echo $so->tanggal ?>      \n' ,
             'Balongsari - Tandes, Surabaya           TOP       : \n' ,
             'Phone : (031) 561-3507                  Sales     : <?php echo $pegawai->nama_pegawai ?>\n' ,
             'WA :0822-3204-7857                      Customer  :  <?php echo $so->nama_customer ?>\n' ,
             '                                        Po        :  \n',
             ' ============================================================================= \n' ,
             ' | No | Kode  |    Nama Barang      | QTY |   Harga  | Diskon |     Total    | \n' ,
             ' ============================================================================= \n' ,
            
              <?php 
              $q=1;
              $total_harga = 0;
              $diskonx = 0;
              foreach ($datanya as $hasilx) {
                    $total_harga = $total_harga + ($hasilx['qty'] * $hasilx['harga']);
                    
                    $kode_barang = $hasilx['kode_barang'];
                    $panjang_kode_barang = str_repeat(" ", (6-strlen($kode_barang)));
                    $nama_barang = $hasilx['nama_barang'];
                    $panjang_nama_barang = str_repeat(" ", (20-strlen($nama_barang)));
                    $qty = $hasilx['qty'];
                    $panjang_qty = str_repeat(" ", (4-strlen($qty)));
                    $harga = number_format((($hasilx['harga'])?$hasilx['harga']:'0'),0,",",".");
                    $panjang_harga = str_repeat(" ", (9-strlen($harga)));
                    $diskon = $diskonx;
                    $panjang_diskon = str_repeat(" ", (7-strlen($diskon)));
                    $sub_total = number_format((($hasilx['qty'] * $hasilx['harga'])?$hasilx['qty'] * $hasilx['harga']:'0'),0,",",".");
                    $panjang_sub_total = str_repeat(" ", (11-strlen($sub_total)));
                ?>

           { type: 'raw', data:  ' |<?php echo      $q.'   | '.$kode_barang.$panjang_kode_barang.'| '.$nama_barang.$panjang_nama_barang.'| '.$qty.$panjang_qty.'| '.$harga.$panjang_harga.'| '.$diskon.$panjang_diskon.'| '.$sub_total.$panjang_sub_total.'|'            ?> \n' },

           
              <?php
              $q++;
              }

              $total_hargax = number_format((($total_harga)?$total_harga:'0'),0,",",".");

              ?>
            { type: 'raw', data: ' ============================================================================= \n' },          

            { type: 'raw', data: ' |                    Total                                 |  <?php echo $total_hargax ?>     | \n' },

            { type: 'raw', data: ' ============================================================================= \n' },
            

             { type: 'raw', data: ' Transfer Via :  \n' },
             { type: 'raw', data: ' BCA                 Penerima            Pengirim              Hormat Kami \n' },
             { type: 'raw', data: ' A/C 790-0954-004 \n' },
             { type: 'raw', data: ' A/N Zuhair Bobsaid  \n' },
             { type: 'raw', data: '\n' },
             { type: 'raw', data: '---------------------------------------------------------------------------  \n' },
             { type: 'raw', data: ' | Nb: Barang yang dibeli tidak dapat dikembalikan, kecuali ada perjanjian | \n' },
             { type: 'raw', data: ' ---------------------------------------------------------------------------\n' },
        ];

        qz.print(config, printData).catch(displayError);
    }




    /// Resets ///
    function resetRawOptions() {
        $("#rawPerSpool").val(1);
        $("#rawEncoding").val(null);
        $("#rawEndOfDoc").val(null);
        $("#rawAltPrinting").prop('checked', false);
        $("#rawCopies").val(1);
    }

    function resetPixelOptions() {
        $("#pxlColorType").val("color");
        $("#pxlCopies").val(1);
        $("#pxlDensity").val('');
        $("#pxlDuplex").prop('checked', false);
        $("#pxlInterpolation").val("");
        $("#pxlJobName").val("");
        $("#pxlLegacy").prop('checked', false);
        $("#pxlOrientation").val("");
        $("#pxlPaperThickness").val(null);
        $("#pxlPrinterTray").val(null);
        $("#pxlRasterize").prop('checked', true);
        $("#pxlRotation").val(0);
        $("#pxlScale").prop('checked', true);
        $("#pxlUnitsIN").prop('checked', true);

        $("#pxlMargins").val(0).css('display', '');
        $("#pxlMarginsTop").val(0);
        $("#pxlMarginsRight").val(0);
        $("#pxlMarginsBottom").val(0);
        $("#pxlMarginsLeft").val(0);
        $("#pxlMarginsActive").prop('checked', false);
        $("#pxlMarginsGroup").css('display', 'none');

        $("#pxlSizeWidth").val('');
        $("#pxlSizeHeight").val('');
        $("#pxlSizeActive").prop('checked', false);
        $("#pxlSizeGroup").css('display', 'none');
    }

    function checkSizeActive() {
        if ($("#pxlSizeActive").prop('checked')) {
            $("#pxlSizeGroup").css('display', '');
        } else {
            $("#pxlSizeGroup").css('display', 'none');
        }
    }

    function checkMarginsActive() {
        if ($("#pxlMarginsActive").prop('checked')) {
            $("#pxlMarginsGroup").css('display', '');
            $("#pxlMargins").css('display', 'none');
        } else {
            $("#pxlMarginsGroup").css('display', 'none');
            $("#pxlMargins").css('display', '');
        }
    }

    function resetSerialOptions() {
        $("#serialPort").val('');
        $("#serialCmd").val('');
        $("#serialStart").val("0x0002"); //String.fromCharCode(2)
        $("#serialEnd").val("0x000D"); //String.fromCharCode(13)

        $("#serialBaud").val(9600);
        $("#serialData").val(8);
        $("#serialStop").val(1);
        $("#serialParity").val('NONE');
        $("#serialFlow").val('NONE');

        // M/T PS60 - 9600, 7, 1, EVEN, NONE
    }

    function resetUsbOptions() {
        $("#usbVendor").val('');
        $("#usbProduct").val('');

        $("#usbInterface").val('');
        $("#usbEndpoint").val('');
        $("#usbData").val('');
        $("#usbResponse").val(8);
        $("#usbStream").val(100);

        // M/T PS60 - V:0x0EB8 P:0xF000, I:0x0 E:0x81
        // Dymo S100 - V:0x0922 P:0x8009, I:0x0 E:0x82
    }

    function resetHidOptions() {
        $("#hidVendor").val('');
        $("#hidProduct").val('');
        $("#hidUsagePage").val('');
        $("#hidSerial").val('');

        $("#hidInterface").val('');
        $("#hidEndpoint").val('');
        $("#hidData").val('');
        $("#hidReport").val('');
        $("#hidResponse").val(8);
        $("#hidStream").val(100);
    }


    /// Page load ///
    $(document).ready(function() {
        window.readingWeight = false;
        resetRawOptions();
        startConnection();

        $("#printerSearch").on('keyup', function(e) {
            if (e.which === 13 || e.keyCode === 13) {
                findPrinter($('#printerSearch').val(), true);
                return false;
            }
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            if (window.readingWeight) {
                $("#usbWeightRadio").click();
                $("#hidWeightRadio").click();
            } else {
                $("#usbRawRadio").click();
                $("#hidRawRadio").click();
            }
        });

        $("#usbRawRadio").click(function() { window.readingWeight = false; });
        $("#usbWeightRadio").click(function() { window.readingWeight = true; });
        $("#hidRawRadio").click(function() { window.readingWeight = false; });
        $("#hidWeightRadio").click(function() { window.readingWeight = true; });

        $("[data-toggle='tooltip']").tooltip();
    });

    qz.websocket.setClosedCallbacks(function(evt) {
        updateState('Inactive', 'default');
        console.log(evt);

        if (evt.reason) {
            displayMessage("<strong>Connection closed:</strong> " + evt.reason, 'alert-warning');
        }
    });

    qz.websocket.setErrorCallbacks(handleConnectionError);

    qz.serial.setSerialCallbacks(function(streamEvent) {
        if (streamEvent.type !== 'ERROR') {
            console.log('Serial', streamEvent.portName, 'received output', streamEvent.output);
            displayMessage("Received output from serial port [" + streamEvent.portName + "]: <em>" + streamEvent.output + "</em>");
        } else {
            console.log(streamEvent.exception);
            displayMessage("Received an error from serial port [" + streamEvent.portName + "]: <em>" + streamEvent.exception + "</em>", 'alert-error');

        }
    });

    qz.usb.setUsbCallbacks(function(streamEvent) {
        var vendor = streamEvent.vendorId;
        var product = streamEvent.productId;

        if (vendor.substring(0, 2) !== '0x') { vendor = '0x' + vendor; }
        if (product.substring(0, 2) !== '0x') { product = '0x' + product; }
        var $pin = $('#' + vendor + product);

        if (streamEvent.type !== 'ERROR') {
            if (window.readingWeight) {
                $pin.html("<strong>Weight:</strong> " + readScaleData(streamEvent.output));
            } else {
                $pin.html("<strong>Raw data:</strong> " + streamEvent.output);
            }
        } else {
            console.log(streamEvent.exception);
            $pin.html("<strong>Error:</strong> " + streamEvent.exception);
        }
    });

    qz.hid.setHidCallbacks(function(streamEvent) {
        var vendor = streamEvent.vendorId;
        var product = streamEvent.productId;

        if (vendor.substring(0, 2) !== '0x') { vendor = '0x' + vendor; }
        if (product.substring(0, 2) !== '0x') { product = '0x' + product; }
        var $pin = $('#' + vendor + product);

        if (streamEvent.type === 'RECEIVE') {
            if (window.readingWeight) {
                var weight = readScaleData(streamEvent.output);
                if (weight) {
                    $pin.html("<strong>Weight:</strong> " + weight);
                }
            } else {
                $pin.html("<strong>Raw data:</strong> " + streamEvent.output);
            }
        } else if (streamEvent.type === 'ACTION') {
            displayMessage("<strong>Device status changed:</strong> " + "[v:" + vendor + " p:" + product + "] - " + streamEvent.actionType);
        } else { //ERROR type
            console.log(streamEvent.exception);
            $pin.html("<strong>Error:</strong> " + streamEvent.exception);
        }
    });

    var qzVersion = 0;
    function findVersion() {
        qz.api.getVersion().then(function(data) {
            $("#qz-version").html(data);
            qzVersion = data;
        }).catch(displayError);
    }

    $("#askFileModal").on("shown.bs.modal", function() {
        $("#askFile").focus().select();
    });
    $("#askHostModal").on("shown.bs.modal", function() {
        $("#askHost").focus().select();
    });


    /// Helpers ///
    function handleConnectionError(err) {
        updateState('Error', 'danger');

        if (err.target !== undefined) {
            if (err.target.readyState >= 2) { //if CLOSING or CLOSED
                displayError("Connection to QZ Tray was closed");
            } else {
                displayError("A connection error occurred, check log for details");
                console.error(err);
            }
        } else {
            displayError(err);
        }
    }

    function displayError(err) {
        console.error(err);
        displayMessage(err, 'alert-danger');
    }

    function displayMessage(msg, css) {
        if (css === undefined) { css = 'alert-info'; }

        var timeout = setTimeout(function() { $('#' + timeout).alert('close'); }, 5000);

        var alert = $("<div/>").addClass('alert alert-dismissible fade in ' + css)
                .css('max-height', '20em').css('overflow', 'auto')
                .attr('id', timeout).attr('role', 'alert');
        alert.html("<button type='button' class='close' data-dismiss='alert'>&times;</button>" + msg);

        $("#qz-alert").append(alert);
    }
    function updateState(text, css) {
        $("#qz-status").html(text);
        $("#qz-connection").removeClass().addClass('panel panel-' + css);

        if (text === "Inactive" || text === "Error") {
            $("#launch").show();
        } else {
            $("#launch").hide();
        }
    }

    /** Attempts to parse scale reading from USB raw output */
    function readScaleData(data) {
        // Filter erroneous data
        if (data.length < 4 || data.slice(2, 8).join('') == "000000000000") {
            return null;
        }

        // Get status
        var status = parseInt(data[1], 16);
        switch(status) {
            case 1: // fault
            case 5: // underweight
            case 6: // overweight
            case 7: // calibrate
            case 8: // re-zero
                status = 'Error';
                break;
            case 3: // busy
                status = 'Busy';
                break;
            case 2: // stable at zero
            case 4: // stable non-zero
            default:
                status = 'Stable';
        }

        // Get precision
        var precision = parseInt(data[3], 16);
        precision = precision ^ -256; //unsigned to signed

        // xor on 0 causes issues
        if (precision == -256) { precision = 0; }

        // Get units
        var units = parseInt(data[2], 16);
        switch(units) {
            case 2:
                units = 'g';
                break;
            case 3:
                units = 'kg';
                break;
            case 11:
                units = 'oz';
                break;
            case 12:
            default:
                units = 'lbs';
        }

        // Get weight
        data.splice(0, 4);
        data.reverse();
        var weight = parseInt(data.join(''), 16);

        weight *= Math.pow(10, precision);
        weight = weight.toFixed(Math.abs(precision));

        return weight + units + ' - ' + status;
    }


    /// QZ Config ///
    var cfg = null;
    function getUpdatedConfig() {
        if (cfg == null) {
            cfg = qz.configs.create(null);
        }

        updateConfig();
        return cfg
    }

    function updateConfig() {
        var pxlSize = null;
        if ($("#pxlSizeActive").prop('checked')) {
            pxlSize = {
                width: $("#pxlSizeWidth").val(),
                height: $("#pxlSizeHeight").val()
            };
        }

        var pxlMargins = $("#pxlMargins").val();
        if ($("#pxlMarginsActive").prop('checked')) {
            pxlMargins = {
                top: $("#pxlMarginsTop").val(),
                right: $("#pxlMarginsRight").val(),
                bottom: $("#pxlMarginsBottom").val(),
                left: $("#pxlMarginsLeft").val()
            };
        }

        var copies = 1;
        var jobName = null;
        if ($("#rawTab").hasClass("active")) {
            copies = $("#rawCopies").val();
            jobName = $("#rawJobName").val();
        } else {
            copies = $("#pxlCopies").val();
            jobName = $("#pxlJobName").val();
        }

        cfg.reconfigure({
                            altPrinting: $("#rawAltPrinting").prop('checked'),
                            encoding: $("#rawEncoding").val(),
                            endOfDoc: $("#rawEndOfDoc").val(),
                            perSpool: $("#rawPerSpool").val(),

                            colorType: $("#pxlColorType").val(),
                            copies: copies,
                            density: $("#pxlDensity").val(),
                            duplex: $("#pxlDuplex").prop('checked'),
                            interpolation: $("#pxlInterpolation").val(),
                            jobName: jobName,
                            legacy: $("#pxlLegacy").prop('checked'),
                            margins: pxlMargins,
                            orientation: $("#pxlOrientation").val(),
                            paperThickness: $("#pxlPaperThickness").val(),
                            printerTray: $("#pxlPrinterTray").val(),
                            rasterize: $("#pxlRasterize").prop('checked'),
                            rotation: $("#pxlRotation").val(),
                            scaleContent: $("#pxlScale").prop('checked'),
                            size: pxlSize,
                            units: $("input[name='pxlUnits']:checked").val()
                        });
    }

    function setPrintFile() {
        setPrinter({ file: $("#askFile").val() });
        $("#askFileModal").modal('hide');
    }

    function setPrintHost() {
        setPrinter({ host: $("#askHost").val(), port: $("#askPort").val() });
        $("#askHostModal").modal('hide');
    }

    function setPrinter(printer) {
        var cf = getUpdatedConfig();
        cf.setPrinter(printer);

        if (printer && typeof printer === 'object' && printer.name === undefined) {
            var shown;
            if (printer.file !== undefined) {
                shown = "<em>FILE:</em> " + printer.file;
            }
            if (printer.host !== undefined) {
                shown = "<em>HOST:</em> " + printer.host + ":" + printer.port;
            }

            $("#configPrinter").html(shown);
        } else {
            if (printer && printer.name !== undefined) {
                printer = printer.name;
            }

            if (printer === undefined) {
                printer = 'NONE';
            }
            $("#configPrinter").html(printer);
        }
    }
</script>

</html>
