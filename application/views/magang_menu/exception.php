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
                                    <h3 class="mb-0 text-white">Exception Menu</h3>
                                </div>
                                <div class="col text-right">
                                    <h6 id="jarak_display" class="text-white"></h6>
                                </div>
                            </div>
                        </div>
                        <!-- Card body -->
                        <div class="card-body">
                            <form action="<?php echo base_url('index.php');?>/magang/exception_absen" method="post">
                                <label for="">Choose Date <span class="text-danger"> * </span></label>
                                <input type="date" class="form-control" name="tanggal">

                                <label for="" class="mt-3">Status <span class="text-danger"> * </span></label>
                                <select class="form-control" name="type">
                                    <option value="IZIN">Izin</option>
                                    <option value="SAKIT">Sakit</option>
                                    <option value="LAINYA">Lainya</option>
                                </select>

                                <label for="" class="mt-3">Remark <span class="text-danger"> * </span></label>
                                <input type="text" class="form-control" name="remark">

                                <button class="btn btn-primary btn-block mt-3" type="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>