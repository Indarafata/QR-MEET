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
                        <!-- Card header -->
                        <div class="card-header">
                            <h3 class="mb-0">Detail Absensi</h3>
                        </div>
                        <!-- Card body -->
                        <div class="card-body">
                            <h6>Note : <br>
                            <ul>
                                <li><i>Pastikan <b>Waktu</b> dan <b
                                >Lokasi</b> Berwarna Hijau Untuk Melakukan Absensi Agar Tidak Terlambat ! <span class="text-danger">*</span></i></li>
                                <li><i>Refresh Halaman Sebelum Melakukan Absensi ! <span class="text-danger">*</span></i></li>
                            </ul>
                            <ul>
                                <li>Waktu Absen Pagi Jam 06.00 - 08.00</li>
                                <li>Waktu Absen Sore Jam 17.00 - 23.00</li>
                                <li>Lokasi Absen < 2,5 KM dari Kantor Terminal Teluk Lamong</li>
                            </ul>
                        </h6>
                            <form action="<?php echo base_url('index.php');?>/magang/absen" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="txt_jarak" id="txt_jarak">
                                <input type="hidden" name="txt_lat" id="txt_lat">
                                <input type="hidden" name="txt_long" id="txt_long">

                                <div class="card bg-gradient-success" id="waktu_display">
                                    <div class="card-body">
                                        <h2 class="card-title text-white">
                                            Waktu :
                                        </h2>
                                        <blockquote class="blockquote text-white mb-0"><p id="waktu"></p></blockquote>
                                    </div>
                                </div>

                               <div class="card bg-gradient-success" id="j1">
                                    <div class="card-body">
                                        <h2 class="card-title text-white">
                                            Lokasi :
                                        </h2>
                                        <blockquote class="blockquote text-white mb-0"><p id="jarak"></p></blockquote>
                                    </div>
                                </div>
                                
                                <div class="card bg-gradient-danger" id="j2">
                                    <div class="card-body">
                                        <h2 class="card-title text-white">
                                            Lokasi :
                                        </h2>
                                        <blockquote class="blockquote text-white mb-0"><p id="jarak2"></p></blockquote>
                                    </div>
                                </div>
                                <hr>
                                <h4>Status Absen : </h4>
                                    <div class="row text-center">
                                        <div class="col">
                                            <span>Absen Pagi</span>
                                        </div>
                                        <div class="col">
                                            <span>Absen Sore</span>
                                        </div>
                                    </div>
                                    <div class="row text-center">
                                        <div class="col">
                                            <span class="btn btn-danger">Belum Absen</span>
                                        </div>
                                        <div class="col">
                                            <span class="btn btn-danger">Belum Absen</span>
                                        </div>
                                    </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card-wrapper">
                    <div class="card">
                        <button class="btn btn-default btn-block" type="submit">Absensi Sekarang</button>
                    </div>
                </div>
            </div>
            </form>

        </div>
    </div>


      <script type="text/javascript">
        let today = new Date();

        var j1 = document.getElementById("j1");
        var j2 = document.getElementById("j2");

        var x = document.getElementById("jarak");
        var y = document.getElementById("jarak2");

        var w1 = document.getElementById("w1");
        var w2 = document.getElementById("w2");
        var w3 = document.getElementById("w3");


        var waktu = document.getElementById("waktu");
        var waktu2 = document.getElementById("waktu2");
        var waktu3 = document.getElementById("waktu3");


        $(document).ready(function(){
            getLocation();
        });

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPositionAndTime);
            } else {
                e.innerHTML = "Geolocation is not supported by this browser.";
            }
        }

        function showPositionAndTime(position) {


                jamMasuk1 = 0;
                jamMasuk2 = 7;

                jamPulang1 = 17;
                jamPulang2 = 23;

                // Fungsi Jarak
                lat1 = position.coords.latitude;
                lon1 = position.coords.longitude;
                
                lat2 = -7.204690;
                lon2 = 112.669110;

                var R = 6371; // km (change this constant to get miles)
                var dLat = (lat2-lat1) * Math.PI / 180;
                var dLon = (lon2-lon1) * Math.PI / 180;
                var a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.cos(lat1 * Math.PI / 180 ) * Math.cos(lat2 * Math.PI / 180 ) * Math.sin(dLon/2) * Math.sin(dLon/2);
                var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
                var d = R * c;

                // getKm = Math.round(d);
                // getM = Math.round(d*1000);

                document.getElementById("txt_jarak").value = d;
                document.getElementById("txt_lat").value = lat1;
                document.getElementById("txt_long").value = lon1;


                if(d < 2.5){
                    jarak = "Anda Sudah Masuk Area Terminal Teluk Lamong (Masuk Jangkauan Absensi)";
                    x.innerHTML = jarak;

                    j1.style.display = "block";
                    j2.style.display = "none";
                }else{
                    jarak = "Anda Belum Masuk Area Terminal Teluk Lamong (Belum Masuk Jangkauan Absensi) , Jarak Anda Sekarang ( "+Math.round(d)+" KM ) Dari TTL";
                    y.innerHTML = jarak;

                    j2.style.display = "block";
                    j1.style.display = "none";
                }
                

                // Fungsi Waktu
                if(today.getHours() >= jamMasuk1 && today.getHours() <= jamMasuk2 && today.getMinutes() >= 0 && today.getMinutes() <= 59){
                    waktu.innerHTML = "Masuk Waktu Absensi Pagi Jam "+jamMasuk1+".00 - "+jamMasuk2+".00";
                    document.getElementById("waktu_display").classList.add('bg-gradient-success');
                    document.getElementById("waktu_display").classList.remove('bg-gradient-danger');
                    document.getElementById("waktu_display").classList.remove('bg-gradient-warning');

                }else if(today.getHours() >= jamPulang1 && today.getHours() <= jamPulang2 && today.getMinutes() >= 0 && today.getMinutes() <= 59){
                    waktu.innerHTML = "Waktunya Masuk Absensi Sore Jam "+jamPulang1+".00 - "+jamPulang2+".00";
                    document.getElementById("waktu_display").classList.add('bg-gradient-success');
                    document.getElementById("waktu_display").classList.remove('bg-gradient-danger');
                    document.getElementById("waktu_display").classList.remove('bg-gradient-warning');

                }else if(today.getHours() >= jamMasuk2 && today.getHours() <= jamPulang1 && today.getMinutes() >= 0 && today.getMinutes() <= 59){
                    waktu.innerHTML = "Waktunya Jam Masuk , Jam "+(jamMasuk2+1)+".00 - "+jamPulang1+".00 . Silahkan Lakukan Absen Jika Belum Absen";
                    document.getElementById("waktu_display").classList.remove('bg-gradient-success');
                    document.getElementById("waktu_display").classList.remove('bg-gradient-danger');
                    document.getElementById("waktu_display").classList.add('bg-gradient-warning');

                }else{
                    waktu2.innerHTML = "Tidak Masuk Waktu Absen , Silahkan Absen Sesuai Waktu Yang Berlaku";
                    document.getElementById("waktu_display").classList.remove('bg-gradient-success');
                    document.getElementById("waktu_display").classList.add('bg-gradient-danger');
                    document.getElementById("waktu_display").classList.remove('bg-gradient-warning');
                }
                

                
            }
      </script>