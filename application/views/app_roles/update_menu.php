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
                        <form class="form-horizontal" action="<?=site_url('App_Roles/update_menu/'.$id.'/'.$id_aplikasi)?>" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group last">
                                        <label class="control-label col-md-2">Menu</label>
                                        <div class="col-md-9">
                                            <select class="mb-3 multi-select" style="width: 100%" multiple="multiple" data-placeholder="Choose" id="menus" name="menus[]">
                                                <?php foreach ($menus as $m => $menu): ?>
                                                    <?php if($menu['URL'] == '' || $menu['URL'] == '#') { ?>
                                                        <optgroup label="<?=$menu['MENU']?>">
                                                        <?php foreach ($menu['CHILDS'] as $c => $child): ?>
                                                            <option value="<?=$child['ID']?>" <?=$child['SELECTED']?>>
                                                                <?=$child['MENU']?>
                                                            </option>
                                                        <?php endforeach ?>
                                                        </optgroup>
                                                    <?php } else { ?>
                                                        <option value="<?=$menu['ID']?>" <?=$menu['SELECTED']?>>
                                                            <?=$menu['MENU']?>
                                                        </option>
                                                    <?php } ?>
                                                <?php endforeach ?>                                            
                                            </select>
                                        </div>
                                    </div>
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
    </div> <!-- end col -->
</div> <!-- end row -->  
</div>


<script type="text/javascript">


    $(document).ready(function() {
        // refreshDatatable();
        $('.ms-list').attr("style", "height:500px; width:200px");
    });

    $("#menus").multiSelect({
        selectableOptgroup: !0
    });

    $("#platforms").multiSelect({
        selectableOptgroup: !0
    });

    $('#btn_check').click(function() {
        console.log("init tes", $('#menus').val());
    })
</script>