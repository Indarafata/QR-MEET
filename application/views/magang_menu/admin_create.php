    <!-- Main content -->
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Form Atur Magang</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="row">
                <div class="col-lg-6">
                    <div class="card-wrapper">
                        <!-- Form controls -->
                        <form action="<?php echo base_url('index.php');?>/magang_admin/update" method="post" enctype="multipart/form-data">
                        <div class="card">
                            <!-- Card header -->
                            <div class="card-header">
                                <h3 class="mb-0">Detail Waktu</h3>
                            </div>
                            <!-- Card body -->
                            <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-control-label" for="exampleFormControlInput1">Waktu Datang <span class="text-danger">*</span></label>
                                        <input type="time" class="form-control" name="waktu_datang" id="waktu_datang" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label" for="exampleFormControlInput1">Waktu Pulang <span class="text-danger">*</span></label>
                                        <input type="time" class="form-control" name="waktu_pulang" id="waktu_pulang" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label" for="exampleFormControlInput1">Waktu Toleransi ONTIME Dari Waktu Datang (menit) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="interval" id="interval" required>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card-wrapper">
                        <!-- Form controls -->
                        <div class="card">
                        <?= $this->session->flashdata('notif'); ?>
                            <!-- Card header -->
                            <div class="card-header">
                                <h3 class="mb-0">Detail Jarak</h3>
                            </div>
                            <!-- Card body -->
                            <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-control-label" for="exampleFormControlInput1">Toleransi Jarak Absensi (km) <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="jarak" id="jarak" required>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card-wrapper">
                        <div class="card">
                            <button class="btn btn-success btn-block" type="submit">Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <hr><br>
    <div class="container-fluid mt--6 pt-5">
        <div class="row">
                <div class="col-lg-12">
                <form action="<?php echo base_url('index.php');?>/magang_admin/insert_lokasi" method="post" enctype="multipart/form-data">
                    <div class="card-wrapper">
                        <!-- Form controls -->
                        <div class="card">
                            <!-- Card header -->
                            <div class="card-header">
                                <h3 class="mb-0">Tambah Lokasi Absensi</h3>
                            </div>
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-control-label" for="exampleFormControlInput1">Nama Area <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nama" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="exampleFormControlInput1">Latitude <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="lat" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="exampleFormControlInput1">Longitude <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="lon" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card-wrapper">
                        <div class="card">
                            <button class="btn btn-success btn-block" type="submit">Tambah Lokasi</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <hr><br>
    <div class="container-fluid mt--6 pt-5">
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-header">
                <h3 class="mb-0">Lokasi Checkpoint Absensi</h3>
            </div>
            <div class="table-responsive py-4">
              <table class="table table-sm table-flush" id="datatable-buttons" style="width: 100% !important;">
                <thead class="thead-light">
                  <tr>
                    <th>No</th>
                    <th>ID AREA</th>
                    <th>NAMA AREA</th>
                    <th>LATITUDE</th>
                    <th>LONGITUDE</th>
                  </tr>
                </thead>
                <tbody>
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>


    <script type="text/javascript">
        var table;
    var site_url = '<?=site_url()?>';


    $(document).ready(function() {
        refreshDatatable();
        showData();
    });

    function showData(){
        $.ajax({
            type  : 'GET',
            url   : '<?php echo base_url('index.php/')?>magang_admin/get_waktu',
            async : false,
            dataType : 'json',
            success : function(data){
                document.getElementById("waktu_datang").value = data.PARAM1;
                document.getElementById("waktu_pulang").value = data.PARAM2;
            }
        });
        $.ajax({
            type  : 'GET',
            url   : '<?php echo base_url('index.php/')?>magang_admin/get_interval',
            async : false,
            dataType : 'json',
            success : function(data){
                document.getElementById("interval").value = data.PARAM1;
            }
        });
        $.ajax({
            type  : 'GET',
            url   : '<?php echo base_url('index.php/')?>magang_admin/get_jarak',
            async : false,
            dataType : 'json',
            success : function(data){
                document.getElementById("jarak").value = data.PARAM1;
            }
        });
    }

    

    function refreshDatatable() {
        $('#datatable-buttons').DataTable({
           "filter": true,
            "destroy": true,
            "ordering": true,
            "processing": true, 
            "serverSide": true, 
            "searching": true, 
            "responsive":true,
            "autoWidth": false,
            "orderCellsTop": true,
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": site_url+"/magang_admin/datatable_lokasi_menu",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [0], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ],
            "language": {
              "paginate": {
                "previous": "<i class='fas fa-angle-left'>",
                "next": "<i class='fas fa-angle-right'>"
              }
            }

        });

    }

    </script>