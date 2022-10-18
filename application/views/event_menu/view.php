    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Event</h6>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <a href="<?= site_url();?>/event_menu/create_page" class="btn btn-sm btn-success">Tambahkan Event</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <!-- Table -->
      <?php
          $in = $this->session->flashdata('in');
          if($in==1)
          {
      ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <span class="alert-icon"><i class="ni ni-like-2"></i></span>
          <span class="alert-text"><strong>Berhasil!</strong> Event Baru Telah Ditambahkan!</span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php }else if($in==2){ ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <span class="alert-icon"><i class="ni ni-like-2"></i></span>
          <span class="alert-text"><strong>Berhasil!</strong> Event Telah Di Update!</span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <?php } ?>
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="table-responsive py-4">
              <table class="table table-flush" id="datatable-basic" style="width: 100% !important;">
                <thead class="thead-light">
                  <tr>
                    <th>No</th>
                    <th>ID Event</th>
                    <th>Nama Event</th>
                    <th>Created By</th>
                    <th>Created Date</th>
                    <th>Updated Date</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
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


    $(document).ready(function() {
        var columnFilter = [1,2,3,4,5];

        $('#datatable-basic thead tr').clone(true).appendTo( '#datatable-basic thead' );
        $('#datatable-basic thead tr:eq(1) th').each( function (i) {
            var isFilterable = false;
            jQuery.each(columnFilter, function(j, val) {
                if(i == val) {
                    isFilterable = true;
                    return false;
                }
            });

            if(isFilterable) {
                var title = $(this).text();
                $(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" />' );
        
                $( 'input', this ).on( 'keyup change', function () {
                    if ( $('#datatable-basic').DataTable().column(i).search() !== this.value ) {
                      $('#datatable-basic').DataTable()
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                } );
            } else {
                $(this).text("");
            }
        } );
        refreshDatatable();
    });

    

    function refreshDatatable() {
        $('#datatable-basic').DataTable({
           "filter": true,
            "destroy": true,
            "ordering": true,
            "processing": true, 
            "serverSide": true, 
            "searching": true, 
            "responsive":true,
            "order": [], //Initial no order.
            "autoWidth": false,
            "orderCellsTop": true,

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": site_url+"/event_menu/datatable_event_menu",
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