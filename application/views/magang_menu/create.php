<style>
    #notify {
        animation: hideAnimation 0s ease-in 5s;
        animation-fill-mode: forwards;
    }

    @keyframes hideAnimation {
    to {
        visibility: hidden;
        width: 0;
        height: 0;
    }
    }
</style>
    <!-- Main content -->
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Absensi Magang</h6>
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
                        <div id="notif"></div>
                        <!-- Card header -->
                        <div class="card-header bg-gradient-success" id="jarak">
                            <div class="row">
                                <div class="col text-left">
                                    <h3 class="mb-0 text-white">Detail Absensi</h3>
                                </div>
                                <div class="col text-right">
                                    <h6 id="jarak_display" class="text-white"></h6>
                                </div>
                            </div>
                        </div>
                        <!-- Card body -->
                        <div class="card-body">
                            <h6>Note : <br>
                            <ul>
                                <li><i id="info_jarak"></i></li>
                                <li><i>Refresh Halaman Sebelum Melakukan Absensi !</i></li>
                            </ul>
                        </h6>
                            <!-- <form action="<?php echo base_url('index.php');?>/magang/absen" method="post" enctype="multipart/form-data"> -->
                                <hr>
                                <h2 class="text-center" id="jam_kerja"></h2>
                                <br>
                                <h3 class="text-center" >Status Absen Anda: </h3>
                                <div class="row">
                                    <div class="col">
                                        <div class="card bg-gradient-danger" id="absen_pagi">
                                            <div class="card-body text-center">
                                                <h2 class="card-title text-white">DATANG</h2>
                                                <h2 class="card-title text-white" id="jam_absen_datang">
                                                </h2>
                                                <blockquote class="blockquote text-white mb-0"><p id="absen1">Anda Sudah Melakukan Absen Kedatangan !</p></blockquote>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card bg-gradient-danger" id="absen_sore" >
                                            <div class="card-body text-center">
                                                <h2 class="card-title text-white">PULANG</h2>
                                                <h2 class="card-title text-white" id="jam_absen_pulang">
                                                </h2>
                                                <blockquote class="blockquote text-white mb-0"><p id="absen2">Anda Belum Melakukan Absen Pulang !</p></blockquote>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="txt_jarak" id="txt_jarak">
                                <input type="hidden" name="txt_lat" id="txt_lat">
                                <input type="hidden" name="txt_long" id="txt_long">

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card-wrapper">
                    <div class="card">
                        <button class="btn btn-primary btn-block" onclick="absen();">Absensi Sekarang</button>
                    </div>
                </div>
            </div>
            <!-- </form> -->

        </div>
    </div>


      <script type="text/javascript">
        let today = new Date();

        var x = document.getElementById("jarak");
        var waktu = document.getElementById("waktu");

        $(document).ready(function(){
            showData();
            getLocation(); 
            showTime();
        });

        function absen(){
            var formData = {
                'txt_jarak' : $('#txt_jarak').val(),
                'txt_lat' : $('#txt_lat').val(),
                'txt_long' : $('#txt_long').val(),
            }
            $.ajax({
                url: '<?php echo base_url('index.php/')?>magang/absen',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(data) {
                    data.status = data.status != 'success' ? 'danger' : 'success';
                    document.getElementById("notif").innerHTML = '<div data-notify="container" id="notify" class="alert alert-dismissible alert-'+data.status+' alert-notify animated fadeInDown" '+
                                                                        'role="alert" data-notify-position="top-center" '+
                                                                        'style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">'+
                                                                        '<span class="alert-icon ni ni-bell-55" data-notify="icon"></span> '+
                                                                        '<div class="alert-text" <="" div=""> '+
                                                                            '<span class="alert-title" data-notify="title">'+ 
                                                                                'Notifikasi</span> <span data-notify="message">'+
                                                                                ''+data.msg+''+
                                                                            '</span>'+
                                                                        '</div>'+
                                                                    '</div>';

                    showData();
                    showTime();

                },
                error: function(result){
                    console.log(result);
                    alert('Something went wrong');
                }
            });
        }
       

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPositionAndTime);
            }else {
                jarak = "Geolocation is not supported by this browser.";
                document.getElementById("jarak_display").innerHTML = jarak;
                document.getElementById('jarak').classList.remove('bg-gradient-success');
                document.getElementById('jarak').classList.add('bg-gradient-danger');
            }
        }

        function showData(){
                try{
                    $.ajax({
                    type  : 'GET',
                    url   : '<?php echo base_url('index.php/')?>magang/get_current_absen',
                    async : false,
                    dataType : 'json',
                    success : function(data){
                            if(data != null){
                            checkinDate = new Date(data.CHECKIN_DATE);
                            checkinTime =("0" + checkinDate.getHours()).slice(-2) +":"+ ("0" + checkinDate.getMinutes()).slice(-2);

                            checkoutDate = new Date(data.CHECKOUT_DATE);
                            checkoutTime =("0" + checkoutDate.getHours()).slice(-2) +":"+ ("0" + checkoutDate.getMinutes()).slice(-2);

                                if(data.CHECKIN_DATE != null && data.STATUS_ARR != null && data.STATUS_ARR == 'O'){
                                    document.getElementById("absen1").innerHTML = "STATUS : <b>ONTIME</b> ";
                                    document.getElementById('absen_pagi').classList.remove('bg-gradient-danger');
                                    document.getElementById('absen_pagi').classList.remove('bg-gradient-warning');
                                    document.getElementById('absen_pagi').classList.add('bg-gradient-success');
                                }else if(data.CHECKIN_DATE != null && data.STATUS_ARR != null && data.STATUS_ARR == 'E'){
                                    document.getElementById("absen1").innerHTML = "STATUS : <b>EARLY</b> ";
                                    document.getElementById('absen_pagi').classList.remove('bg-gradient-danger');
                                    document.getElementById('absen_pagi').classList.remove('bg-gradient-warning');
                                    document.getElementById('absen_pagi').classList.add('bg-gradient-success');
                                }else if(data.CHECKIN_DATE != null && data.STATUS_ARR == 'L'){
                                    document.getElementById("absen1").innerHTML = "STATUS : <b>LATE</b> ";
                                    document.getElementById('absen_pagi').classList.remove('bg-gradient-danger');
                                    document.getElementById('absen_pagi').classList.remove('bg-gradient-success');
                                    document.getElementById('absen_pagi').classList.add('bg-gradient-warning');
                                }else{
                                    document.getElementById("absen1").innerHTML = "STATUS : <b>BELUM ABSEN</b> ";
                                    document.getElementById('absen_pagi').classList.add('bg-gradient-danger');
                                    document.getElementById('absen_pagi').classList.remove('bg-gradient-success');
                                    document.getElementById('absen_pagi').classList.remove('bg-gradient-warning');
                                }
                                if(data.STATUS_END == 'O'){
                                    document.getElementById("absen2").innerHTML = "STATUS : <b>ONTIME</b> ";
                                    document.getElementById('absen_sore').classList.remove('bg-gradient-danger');
                                    document.getElementById('absen_sore').classList.add('bg-gradient-success');
                                }else if(data.STATUS_END == 'E'){
                                    document.getElementById("absen2").innerHTML = "STATUS : <b>EARLY</b> ";
                                    document.getElementById('absen_sore').classList.remove('bg-gradient-danger');
                                    document.getElementById('absen_sore').classList.add('bg-gradient-success');
                                }else{
                                    document.getElementById("absen2").innerHTML = "STATUS : <b>BELUM ABSEN</b> ";
                                    document.getElementById('absen_sore').classList.add('bg-gradient-danger');
                                    document.getElementById('absen_sore').classList.remove('bg-gradient-success');
                                }
                            }else{
                                document.getElementById("absen1").innerHTML = "STATUS : <b>BELUM ABSEN</b> ";
                                document.getElementById("absen2").innerHTML = "STATUS : <b>BELUM ABSEN</b> ";
                                document.getElementById('absen_pagi').classList.add('bg-gradient-danger');
                                document.getElementById('absen_pagi').classList.remove('bg-gradient-success');
                                document.getElementById('absen_sore').classList.add('bg-gradient-danger');
                                document.getElementById('absen_sore').classList.remove('bg-gradient-success');
                            }
                        }
                    });
                }catch(err){
                        document.getElementById("absen1").innerHTML = "STATUS : <b>BELUM ABSEN</b> ";
                        document.getElementById("absen2").innerHTML = "STATUS : <b>BELUM ABSEN</b> ";
                        document.getElementById('absen_pagi').classList.add('bg-gradient-danger');
                        document.getElementById('absen_pagi').classList.remove('bg-gradient-success');
                        document.getElementById('absen_sore').classList.add('bg-gradient-danger');
                        document.getElementById('absen_sore').classList.remove('bg-gradient-success');
                }
            }
        
            function showTime(){
                $.ajax({
                    type  : 'GET',
                    url   : '<?php echo base_url('index.php/')?>magang/get_abs_time',
                    async : false,
                    dataType : 'json',
                    success : function(data){
                        time_point_arr = new Date(data.TIME_ARR);
                        time_point_end = new Date(data.TIME_END);

                        document.getElementById("jam_kerja").innerHTML = "Jam Kerja ("+("0" + time_point_arr.getHours()).slice(-2) +":"+ ("0" + time_point_arr.getMinutes()).slice(-2)+" - " +("0" + time_point_end.getHours()).slice(-2) +":"+ ("0" + time_point_end.getMinutes()).slice(-2)+")";
                    }
                });

                $.ajax({
                    type  : 'GET',
                    url   : '<?php echo base_url('index.php/')?>magang/get_current_absen',
                    async : false,
                    dataType : 'json',
                    success : function(data){
                        if(data.CHECKIN_DATE != null){
                            time_absen_arr = new Date(data.CHECKIN_DATE);
                            document.getElementById("jam_absen_datang").innerHTML = ("0" + time_absen_arr.getHours()).slice(-2) +":"+ ("0" + time_absen_arr.getMinutes()).slice(-2);
                        }else{
                            document.getElementById("jam_absen_datang").innerHTML = ".. : ..";
                        }

                        if(data.CHECKOUT_DATE != null){
                            time_absen_end = new Date(data.CHECKOUT_DATE);
                            document.getElementById("jam_absen_pulang").innerHTML = ("0" + time_absen_end.getHours()).slice(-2) +":"+ ("0" + time_absen_end.getMinutes()).slice(-2);
                        }else{
                            document.getElementById("jam_absen_pulang").innerHTML = ".. : ..";
                        }

                    }
                });
            }


        function showPositionAndTime(position) {

            $.ajax({
                    type  : 'GET',
                    url   : '<?php echo base_url('index.php/')?>magang/get_abs_area',
                    async : false,
                    dataType : 'json',
                    success : function(data){
                        var jarak_x = 0;
                        var i = 0;
                        var abs_jarak = 0;

                        for (let index = 0; index < data.length; index++) {
                            // Fungsi Jarak
                            lat1 = position.coords.latitude;
                            lon1 = position.coords.longitude;
                            
                            lat2 = data[index].LAT;
                            lon2 = data[index].LON;

                            var R = 6371; // km (change this constant to get miles)
                            var dLat = (lat2-lat1) * Math.PI / 180;
                            var dLon = (lon2-lon1) * Math.PI / 180;
                            var a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.cos(lat1 * Math.PI / 180 ) * Math.cos(lat2 * Math.PI / 180 ) * Math.sin(dLon/2) * Math.sin(dLon/2);
                            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
                            var d = R * c;

                            // console.log(data[index].AREA_NAME+" : "+d);
                            if(index == 0){
                                jarak_x = d;
                                i = 0;
                            }else if(d < jarak_x){
                                i = index;
                                area = data[index].AREA_NAME;
                                jarak_x = d;   
                            }
                                // getKm = Math.round(d);
                                // getM = Math.round(d*1000);
                        }

                        $.ajax({
                            type  : 'GET',
                            url   : '<?php echo base_url('index.php/')?>magang/get_abs_jarak',
                            async : false,
                            dataType : 'json',
                            success : function(data){
                                abs_jarak = data.PARAM1;
                                document.getElementById('info_jarak').innerHTML = "Jarak Anda Harus < "+abs_jarak +" km Dari Checkpoint Absensi Yang Terdaftar"; 
                            }
                        });

                        document.getElementById('txt_jarak').value = jarak_x; 
                        document.getElementById('txt_lat').value = lat1; 
                        document.getElementById('txt_long').value = lon2; 

                        if(jarak_x < abs_jarak){
                            
                            document.getElementById("jarak_display").innerHTML = "Bisa Absen , Anda Masuk Sekitaran "+data[i].AREA_NAME;
                            document.getElementById('jarak').classList.add('bg-gradient-success');
                            document.getElementById('jarak').classList.remove('bg-gradient-danger');
                        }else{
                            document.getElementById("jarak_display").innerHTML = "Tidak Bisa Absen , Jarak Anda "+Math.round(jarak_x*1000)+" m dari "+data[i].AREA_NAME+ " (Checkpoint Terdekat)";
                            document.getElementById('jarak').classList.add('bg-gradient-danger');
                            document.getElementById('jarak').classList.remove('bg-gradient-success');      
                        }
                    }
                });
            }
      </script>