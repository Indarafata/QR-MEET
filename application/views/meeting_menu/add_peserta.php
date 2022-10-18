    <!-- Main content -->
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Form Tambah Peserta Meeting</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-wrapper">
                    <!-- Form controls -->
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header">
                            <h3 class="mb-0">Detail Peserta</h3>
                        </div>
                        <!-- Card body -->
                        <div class="card-body">
                            <form action="<?php echo base_url('index.php');?>/user/save_peserta_man" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input type="hidden" name="txt_id" id="txt_id">
                                    <input type="hidden" name="txt_ket" value="1">
                                    <label class="form-control-label" for="event">List Peserta <span class="text-danger">*</span></label>
                                        <select class="form-control" data-toggle="select" id="peserta" name="txt_user" required>
                                        
                                        </select>
                                </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card-wrapper">
                    <div class="card">
                        <button class="btn btn-success btn-block" type="submit">Tambahkan Peserta</button>
                    </div>
                </div>
            </div>
            </form>

        </div>
    </div>


      <script type="text/javascript">
        $url = window.location.href
        $split =$url.split("/");
        for(var i = 0 ; i < $split.length ; i++){
            $url = ($split[i])
        }

        $(document).ready(function(){
            tampil_peserta(); 
            tampil_detail_meeting($url);
        });

                function tampil_peserta(){
                    $.ajax({
                        type  : 'GET',
                        url   : '<?php echo base_url('index.php/')?>meeting_menu/get_user_list',
                        async : false,
                        dataType : 'json',
                        success : function(data){
                            var html = '';
                            var i;
                            for(i=0; i<data.length; i++){
                                html += '<option value="'+data[i].USER_ID+'">'+data[i].USERNAME+'</option>';
                            }
                            $('#peserta').html(html);
                        }
                    });
                }
                function tampil_detail_meeting($id){
                    $.ajax({
                        type  : 'GET',
                        url   : '<?php echo base_url('index.php/')?>meeting_menu/meeting_detail/'+$id,
                        async : false,
                        dataType : 'json',
                        success : function(data){

                            $("#txt_id").val(data.ID_MEETING);                           

                        }
                    });
                }
      </script>