<div class="header bg-primary pb-6">
    <div class="container-fluid">
    <div class="header-body">
        <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
            <h6 class="h2 text-white d-inline-block mb-0">Configurasi Menu</h6>
        </div>
        </div>
    </div>
    </div>
</div>
<div class="container-fluid mt--6">
<div class="row">
    <?=$this->session->flashdata('notif');?>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-rep-plugin">
                    <div class="row">
                        <div class="col-md-12">
                            <?php foreach ($data as $key => $val): ?>
                                
                            <form class="form-horizontal" action="<?=site_url('App_Roles/update/'.$id)?>" method="post">
                                <?php foreach ($data as $key => $val): ?>

                                <div class="form-group">
                                    <label class="control-label col-md-2">Kode Roles SITTL</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" placeholder="Masukkan Kode Role SITTL" name="sittl_role_id" required="" value="<?=$val['SITTL_ROLE_ID']?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Nama Roles</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" placeholder="Masukkan Nama Roles" name="nama" required="" value="<?=$val['NAMA']?>"/>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-md-2">Aplikasi</label>
                                    <div class="col-md-9">
                                        <select class="form-control" name="id_aplikasi">
                                            <?php foreach ($application as $key => $val2): ?>
                                                <option value="<?=$val2['CODE']?>" <?=($val['ID_APLIKASI']==$val2['CODE'] ? 'SELECTED':'')?>>
                                                    <?=$val2['NAME']?> (<?=$val2['CODE']?>)
                                                </option>
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
                                <?php endforeach ?>

                            </form>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row --> 
</div>

            
            
        

<script type="text/javascript">
    $(document).ready(function() {
        // refreshDatatable();
    });

</script>