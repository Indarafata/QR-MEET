  <!-- Main content -->
  <div class="main-content" id="panel">
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Form Tambah User</h6>
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
                                    <h3 class="mb-0">Buat User Baru</h3>
                                </div>
                                <!-- Card body -->
                                    <div class="card-body">
                                        <form action="<?= site_url('user_menu/insert')?>" method="post">
                                            <div class="form-group">
                                                <label class="form-control-label" for="exampleFormControlInput1">Nama <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control"  placeholder="Nama" name="nama">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label" for="departement">ID Departemen <span class="text-danger">*</span></label>
                                                    <select class="form-control" data-toggle="select" name="id_dept" id="departement" required>
                                                        
                                                    </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label" for="exampleFormControlInput1">No Telepon <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Nomor Telepon" name="telepon">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label" for="exampleFormControlInput1">Email <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control" placeholder="E-mail" name="email">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label" for="exampleFormControlInput1">Nama PT <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Nama PT" name="company">
                                            </div>
                                           
                                            <button type="submit" class="btn btn-success btn-block">Simpan User</button>
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
