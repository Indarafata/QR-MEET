<div class="header bg-primary">
    <div class="container-fluid">
    <div class="header-body">
        <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
                <h6 class="h2 text-white d-inline-block mb-0">Master Roles</h6>
            </div>
        </div>
    </div>
    </div>
</div>
<div class="row">
    <?=$this->session->flashdata('notif');?>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-rep-plugin">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal" action="<?=site_url('App_Menu/create')?>" method="post">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Parent Menu</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="parent_id">
                                                <option value=""> -- Tidak Punya Parent -- </option>
                                                <?php foreach ($parent as $key => $val): ?>
                                                    <option value="<?=$val['ID']?>">
                                                        <?=$val['MENU']?> (<?=$val['NAMA_APLIKASI']?>)
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Nama Menu</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" placeholder="Masukkan Nama Menu" name="menu" required=""/>
                                        </div>
                                    </div>                                                
                                    <div class="form-group">
                                        <label class="control-label col-md-3">URL</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" placeholder="Masukkan URL" name="url" required=""/>
                                        </div>
                                    </div>                                              
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Form Name</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" placeholder="Masukkan Form Name" name="form_name" required=""/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Nomor Urut</label>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" placeholder="Masukkan Nomor Urut" name="no_seq" required="" min="0" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">                                             
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Versi</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" placeholder="Masukkan Versi" name="versi" required="" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Aplikasi</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="id_aplikasi" required="">
                                                <?php foreach ($application as $key => $val): ?>
                                                    <option value="<?=$val['CODE']?>">
                                                        <?=$val['NAME']?>
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>                                     
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-2 col-md-9">
                                            <input type="submit" name="submit" class="btn btn-success col-md-3" value="Simpan">
                                            <a href="<?=site_url('App_Menu')?>" class="btn btn-danger col-md-3">Batal</a>
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