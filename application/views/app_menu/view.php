<div class="header bg-primary pb-6">
    <div class="container-fluid">
    <div class="header-body">
        <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
            <h6 class="h2 text-white d-inline-block mb-0">Master Menu</h6>
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
        <div class="col">
            <div class="card">
                <?= $this->session->flashdata('notif'); ?>
                <div class="table-responsive py-4">
                    <table class="table table-flush" id="datatable-basic">
                        <thead class="thead-light">
                        <!-- <a href="<?=site_url('App_Menu/create')?>" class="btn btn-success">Tambahkan</a> -->

                            <th width="20">No</th>
                            <th>Parent</th>
                            <th width="120">Menu</th>
                            <th>URL</th>
                            <th>Seq</th>
                            <th>Status</th>
                            <th width="140">Aksi</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    var table;
    var site_url = '<?=site_url()?>';

    $(document).ready(function(){
        var columnFilter = [1,2, 3];

        $('#datatable-basic thead tr').clone(true).appendTo('#datatable-basic thead');
        $('#datatable-basic thead tr:eq(1) th').each(function(i) {
            var isFilterable = false;
            jQuery.each(columnFilter, function(j, val) {
                if (i == val) {
                    isFilterable = true;
                    return false;
                }
            });

            if (isFilterable) {
                var title = $(this).text();
                $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');

                $('input', this).on('keyup change', function() {
                    if (table.column(i).search() !== this.value) {
                        table
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            } else {
                $(this).text("");
            }
        });

        refreshDatatable();        
    });

    

    function refreshDatatable() {
        table = $('#datatable-basic').DataTable({
           "filter": true,
            "destroy": true,
            "ordering": true,
            "processing": true, 
            "serverSide": true, 
            "searching": true, 
            "responsive":true,
            "orderCellsTop": true,
            "fixedHeader": true,
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": site_url+"/App_Menu/datatable_app_menu",
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

    // $(document).ready(function() {
    //     refreshDatatable();
    // });

    // var site_url = '<?=site_url()?>';
    

    // function refreshDatatable() {
    //     $('#datatable-basic_app_menu').DataTable({
    //        "filter": true,
    //         "destroy": true,
    //         "ordering": true,
    //         "processing": true, 
    //         "serverSide": true, 
    //         "searching": true, 
    //         "responsive":true,
    //         "order": [], //Initial no order.

    //         // Load data for the table's content from an Ajax source
    //         "ajax": {
    //             "url": site_url+"App_Menu/datadatatable-basic",
    //             "type": "POST"
    //         },

    //         //Set column definition initialisation properties.
    //         "columnDefs": [
    //             {
    //                 "targets": [0], //first column / numbering column
    //                 "orderable": false, //set not orderable
    //             },
    //         ],

    //     });

    // }


</script>