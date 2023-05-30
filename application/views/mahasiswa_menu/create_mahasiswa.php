  <!-- Main content -->
  <div class="main-content" id="panel">
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Form Tambah Mahasiswa</h6>
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
            <span class="alert-text"><strong>Gagal!</strong> Nama User sudah ada, silahkan buat dengan nama user yang berbeda!</span>
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
                                    <h3 class="mb-0">Tambah Mahasiswa Baru</h3>
                                </div>
                                <!-- Card body -->
                                    <div class="card-body">
                                        <form action="<?= site_url('mahasiswa_menu/insert')?>" method="post">
                                            <div class="form-group">
                                                <label class="form-control-label" for="exampleFormControlInput1">Nama <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control"  placeholder="Nama" name="nama">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label" for="exampleFormControlInput1">NIM <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control"  placeholder="NIM" name="nim">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label" for="exampleFormControlInput1">Tanggal Mulai Magang <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" placeholder="Tanggal Mulai Magang" name="start_date">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label" for="exampleFormControlInput1">Tanggal Selesai Magang <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" placeholder="Tanggal Selesai Magang" name="end_date">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label" for="exampleFormControlInput1">Prodi <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Prodi" name="prodi">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label" for="exampleFormControlInput1">Jurusan <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Jurusan" name="jurusan">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label" for="exampleFormControlInput1">Universitas <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Universitas" name="universitas">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label" for="exampleFormControlInput1">Telepon <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Telepon" name="telepon">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label" for="exampleFormControlInput1">Jenis Kelamin <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Jenis Kelamin" name="gender">
                                            </div>
                                            <input type="hidden" class="form-control" name="status" value="aktif">
                                            <button type="submit" class="btn btn-success btn-block">Simpan Mahasiswa</button>
                                        </form>
                                    </div>
                            </div>
                        </div>
                    </div>         
                </div>
        </div>

        <script>
            tampil_departement();
            function tampil_departement(){
                    $.ajax({
                        type  : 'GET',
                        url   : '<?php echo base_url('index.php/')?>user_menu/departement',
                        async : false,
                        dataType : 'json',
                        success : function(data){
                            var html = '';
                            var i;
                            for(i=0; i<data.length; i++){
                                html += '<option value="'+data[i].ID_DEPT+'">'+data[i].DEPT_NAME+'</option>';
                            }
                            $('#departement').html(html);
                        }
                    });
                }
        </script>
