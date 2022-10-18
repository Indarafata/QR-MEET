<div class="row">
    <?=$this->session->flashdata('notif');?>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-5">
                    <div class="col">
                        <h4 class="mt-0 header-title">MASTER ROLES</h4>
                    </div>
                </div>
                <div class="table-rep-plugin">
                <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal" action="<?=site_url('App_Menu/update/'.$id)?>" method="post" onsubmit="return validateForm();" enctype="multipart/form-data">
                                        <?php foreach ($data as $key => $val2): ?>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Parent Menu</label>
                                                    <div class="col-md-9">
                                                        <select class="form-control" name="parent_id">
                                                            <option value=""> -- Tidak Punya Parent -- </option>
                                                            <?php foreach ($parent as $key => $val): ?>
                                                                <option value="<?=$val['ID']?>" <?=($val2['PARENT_ID']==$val['ID'] ? 'selected':'')?>>
                                                                    <?=$val['MENU']?> (<?=$val['NAMA_APLIKASI']?>)
                                                                </option>
                                                            <?php endforeach ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Nama Menu</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="Masukkan Nama Menu" name="menu" required="" value="<?=$val2['MENU']?>" />
                                                    </div>
                                                </div>                                               
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">URL</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="Masukkan URL" name="url" required="" value="<?=$val2['URL']?>"/>
                                                    </div>
                                                </div>  
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Form Name</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="Masukkan Form Name" name="form_name" required="" value="<?=$val2['FORM_NAME']?>"/>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Nomor Urut</label>
                                                    <div class="col-md-9">
                                                        <input type="number" class="form-control" placeholder="Masukkan Nomor Urut" name="no_seq" required="" min="0" value="<?=$val2['NO_SEQ']?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">                                               
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Versi</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="Masukkan Versi" name="versi" required="" value="<?=$val2['VERSI']?>"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Aplikasi</label>
                                                    <div class="col-md-9">
                                                        <select class="form-control" name="id_aplikasi" required="">
                                                            <?php foreach ($application as $key => $val): ?>
                                                                <option value="<?=$val['CODE']?>" <?=($val2['ID_APLIKASI']==$val['CODE'] ? 'selected':'')?>>
                                                                    <?=$val['NAME']?>
                                                                </option>
                                                            <?php endforeach ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                <hr>
                                <div class="row">
                                    <div class="col-md-offset-2 col-md-9">
                                        <input type="submit" name="submit" class="js-waves-off btn btn-success col-md-3" value="Simpan">
                                        <a href="<?= site_url('App_Menu') ?>" class="btn btn-danger col-md-3">Batal</a>
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