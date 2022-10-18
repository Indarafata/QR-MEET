  <!-- Main content -->
  <div class="main-content" id="panel">
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Form Update Event</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
        <div class="container-fluid mt--6">
        <?php
          $in = $this->session->flashdata('in');
          if($in==1)
          {
        ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span class="alert-icon"><i class="ni ni-fat-remove"></i></span>
            <span class="alert-text"><strong>Gagal!</strong> Id Event sudah ada, silahkan buat id event yang berbeda!</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
        <?php } ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-wrapper">
                            <!-- Form controls -->
                            <div class="card">
                            <!-- Card header -->
                                <div class="card-header">
                                    <h3 class="mb-0">Update Event </h3>
                                </div>
                                <!-- Card body -->
                                    <div class="card-body">
                                        <form action="<?= site_url('event_menu/update')?>" method="post">
                                            <div class="form-group">
                                                <label class="form-control-label" for="exampleFormControlInput1">ID Event <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control"  placeholder="ID Event" name="id_event" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label" for="exampleFormControlInput1">Nama Event <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Nama Event" name="nama_event">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label" for="departement">Status Event <span class="text-danger">*</span></label>
                                                    <select class="form-control" data-toggle="select" name="status" required>
                                                        <option value='1'>Aktif</option>
                                                        <option value='0'>Tidak Aktif</option>
                                                    </select>
                                            </div>
                                            <button type="submit" class="btn btn-success btn-block">Simpan Event</button>
                                        </form>
                                    </div>
                            </div>
                        </div>
                    </div>         
                </div>
        </div>

        <script type="text/javascript">
                $url = window.location.href
                $split =$url.split("/");
                for(var i = 0 ; i < $split.length ; i++){
                    $url = ($split[i])
                }

            // Pemanggilan Fungsi
            showData();

            // funsgi menampilkan data kedalam input html
            function showData(){
                    $.ajax({
                        type  : 'GET',
                        url   : '<?php echo base_url('index.php/')?>event_menu/load_event/'+$url,
                        async : false,
                        dataType : 'json',
                        success : function(data){
                            document.querySelector('input[name="id_event"]').value = data.ID_EVENT;
                            document.querySelector('input[name="nama_event"]').value = data.EVENT_NAME;
                        }
                    });
                }
        </script>

