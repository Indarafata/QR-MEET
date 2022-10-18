    <!-- Main content -->
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Form Edit Meeting</h6>
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
                            <form action="<?php echo base_url('index.php');?>/meeting_menu/update" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="form-control-label" for="exampleFormControlInput1">Meeting Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control"  placeholder="Nama Meeting" name="meeting_name" id="meeting_name" required>
                                    <input type="hidden" class="form-control"  placeholder="Nama Meeting" name="id_meeting" id="id_meeting" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="exampleFormControlInput1">Meeting Location <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Lokasi Meeting" name="meeting_location" id="meeting_location" required>
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
                                    <label class="form-control-label" for="event">File URL</label>
                                        <div class="dropzone dropzone-multiple" data-toggle="dropzone" data-dropzone-multiple data-dropzone-url="http://">
                                            <div class="fallback">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="customFileUploadMultiple" name="userfile" required>
                                                    <label class="custom-file-label" for="customFileUploadMultiple">Choose file</label>
                                                </div>
                                            </div>
                                            <ul class="dz-preview dz-preview-multiple list-group list-group-lg list-group-flush">
                                                <li class="list-group-item px-0">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                            <div class="avatar">
                                                                <img class="avatar-img rounded"  data-dz-thumbnail>
                                                            </div>
                                                        </div>
                                                        <div class="col ml--3">
                                                            <h4 class="mb-1" data-dz-name>...</h4>
                                                            <p class="small text-muted mb-0" data-dz-size>...</p>
                                                        </div>
                                                        <div class="col-auto">
                                                            <div class="dropdown">
                                                                <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fe fe-more-vertical"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a href="#" class="dropdown-item" data-dz-remove>
                                                                        Remove
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
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
        
        $url = window.location.href
        $split =$url.split("/");
        for(var i = 0 ; i < $split.length ; i++){
            $url = ($split[i])
        }

        $(document).ready(function(){
            tampil_departement(); 
            tampil_event();      
            tampil_detail_meeting($url);
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
                function tampil_detail_meeting($id){
                    $.ajax({
                        type  : 'GET',
                        url   : '<?php echo base_url('index.php/')?>meeting_menu/meeting_detail/'+$id,
                        async : false,
                        dataType : 'json',
                        success : function(data){
                            event_date = new Date(data.EVENT_DATE)
                            let getFullDate_event_date = event_date.getFullYear()+'-'+("0" + (event_date.getMonth() + 1)).slice(-2)+'-'+("0" + event_date.getDate()).slice(-2)+'T'+("0" + event_date.getHours()).slice(-2)+':'+("0" + event_date.getMinutes()).slice(-2);

                            start_date = new Date(data.START_DATE)
                            let getFullDate_start_date = start_date.getFullYear()+'-'+("0" + (start_date.getMonth() + 1)).slice(-2)+'-'+("0" + start_date.getDate()).slice(-2)+'T'+("0" + start_date.getHours()).slice(-2)+':'+("0" + start_date.getMinutes()).slice(-2);

                            end_date = new Date(data.END_DATE)
                            let getFullDate_end_date = end_date.getFullYear()+'-'+("0" + (end_date.getMonth() + 1)).slice(-2)+'-'+("0" + end_date.getDate()).slice(-2)+'T'+("0" + end_date.getHours()).slice(-2)+':'+("0" + end_date.getMinutes()).slice(-2);

                            $("#id_meeting").val(data.ID_MEETING);
                            $("#meeting_name").val(data.EVENT);
                            $("#meeting_location").val(data.LOCATION);
                            $("#departement").val(data.ID_DEPT);
                            $("#event").val(data.ID_EVENT);
                            $("#event_date").val(getFullDate_event_date);
                            $("#start_date").val(getFullDate_start_date);
                            $("#end_date").val(getFullDate_end_date);

                        }
                    });
                }
      </script>