<div class="header bg-primary pb-6">
    <div class="container-fluid">
    <div class="header-body">
        <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
            <h6 class="h2 text-white d-inline-block mb-0">Master Roles</h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
            <a href="<?=site_url('App_Menu/create')?>" class="btn btn-sm btn-success">Tambahkan Baru</a>
        </div>
        </div>
    </div>
    </div>
</div>
<div class="container-fluid mt--6">
    <!-- Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-rep-plugin">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="table_app_roles">
                                <thead>
                                    <th width="40">No</th>
                                    <th width="70">Kode SITTL</th>
                                    <th>Role</th>
                                    <th>Aplikasi</th>
                                    <th width="120">Aksi</th>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->  
</div>

<script type="text/javascript">
    $(document).ready(function() {
        refreshDatatable();
    });

    var site_url = '<?=site_url()?>';
    

    function refreshDatatable() {
        $('#table_app_roles').DataTable({
           "filter": true,
            "destroy": true,
            "ordering": true,
            "processing": true, 
            "serverSide": true, 
            "searching": true, 
            "responsive":true,
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": site_url+"/App_Roles/datatable_app_roles",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [0], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ],
            "language": {
              "paginate": {
                "previous": "<i class='fas fa-angle-left'>",
                "next": "<i class='fas fa-angle-right'>"
              }
            }

        });

    }


</script>