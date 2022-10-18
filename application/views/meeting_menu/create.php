    <!-- Main content -->
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Form Tambah Meeting</h6>
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
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header">
                            <h3 class="mb-0">Detail Meeting</h3>
                        </div>
                        <!-- Card body -->
                        <div class="card-body">
                            <form action="<?php echo base_url('index.php');?>/meeting_menu/insert" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="form-control-label" for="exampleFormControlInput1">Meeting Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control"  placeholder="Nama Meeting" name="meeting_name" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="exampleFormControlInput1">Meeting Location <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Lokasi Meeting" name="meeting_location" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="departement">ID Departement <span class="text-danger">*</span></label>
                                        <select class="form-control" data-toggle="select" name="departement" id="departement" required>
                                        
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="event">ID Event <span class="text-danger">*</span></label>
                                        <select class="form-control" data-toggle="select" id="event" name="event" required>
                                        
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="exampleFormControlInput1">File URL</label>
                                    <input type="file" class="form-control" name="userfile">
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card-wrapper">
                    <!-- Sizes -->
                    <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <h3 class="mb-0">Waktu Meeting</h3>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="example-datetime-local-input" class="col-md-10 col-form-label form-control-label">Event Date <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                            <input class="form-control" name="event_date" type="datetime-local" id="event_date" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-datetime-local-input" class="col-md-10 col-form-label form-control-label">Start Date <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                            <input class="form-control" name="start_date" type="datetime-local" id="start_date">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-datetime-local-input" class="col-md-10 col-form-label form-control-label">End Date <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                            <input class="form-control" name="end_date" type="datetime-local" id="end_date">
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card-wrapper">
                    <div class="card">
                        <button class="btn btn-success btn-block" type="submit">Simpan Meeting</button>
                    </div>
                </div>
            </div>
            </form>

        </div>
    </div>


      <script type="text/javascript">
        let today = new Date();
        let getFullDate = today.getFullYear()+'-'+("0" + (today.getMonth() + 1)).slice(-2)+'-'+("0" + today.getDate()).slice(-2)+'T'+("0" + today.getHours()).slice(-2)+':'+("0" + today.getMinutes()).slice(-2);

        $(document).ready(function(){
            tampil_departement(); 
            tampil_event();      
            $('#event_date').val(getFullDate);
            $('#start_date').val(getFullDate);
            $('#end_date').val(getFullDate); 
        });
            function tampil_departement(){
                    $.ajax({
                        type  : 'GET',
                        url   : '<?php echo base_url('index.php/')?>meeting_menu/departement',
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
                function tampil_event(){
                    $.ajax({
                        type  : 'GET',
                        url   : '<?php echo base_url('index.php/')?>meeting_menu/event',
                        async : false,
                        dataType : 'json',
                        success : function(data){
                            var html = '';
                            var i;
                            for(i=0; i<data.length; i++){
                                html += '<option value="'+data[i].ID_EVENT+'">'+data[i].EVENT_NAME+'</option>';
                            }
                            $('#event').html(html);
                        }
                    });
                }
      </script>