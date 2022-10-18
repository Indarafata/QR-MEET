<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-5">
                    <div class="col">
                        <h4 class="mt-0 header-title">CREATE MASTER ROLES</h4>
                    </div>
                </div>
                <div class="table-rep-plugin">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal" action="<?=site_url('App_Roles/create')?>" method="post">
                                
                                <div class="form-group">
                                    <label class="control-label col-md-2">Kode Roles SITTL</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" placeholder="Masukkan Kode Role SITTL" name="sittl_role_id" required=""/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Nama Roles</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" placeholder="Masukkan Nama Roles" name="nama" required=""/>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-md-2">Aplikasi</label>
                                    <div class="col-md-9">
                                        <select class="form-control" name="id_aplikasi">
                                            <?php foreach ($application as $key => $val): ?>
                                                <option value="<?=$val['CODE']?>"><?=$val['NAME']?> (<?=$val['CODE']?>)</option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-2 col-md-9">
                                            <input type="submit" name="submit" class="btn btn-success col-md-3" value="Simpan">
                                            <a href="<?=site_url('App_Roles')?>" class="btn btn-danger col-md-3">Batal</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->


<script type="text/javascript">
    $(document).ready(function() {
        // refreshDatatable();
    });

</script>