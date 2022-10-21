<div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Meeting</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="table-responsive py-4">
              <table class="table table-sm table-flush" id="datatable-buttons" style="width: 100% !important;">
                <thead class="thead-light">
                  <tr>
                    <th>No</th>
                    <th>TANGGAL</th>
                    <th>CHECKIN</th>
                    <th>CHECKOUT</th>
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
        refreshDatatable();
    });

    

    function refreshDatatable() {
        $('#datatable-buttons').DataTable({
           "filter": true,
            "destroy": true,
            "ordering": true,
            "processing": true, 
            "serverSide": true, 
            "searching": true, 
            "responsive":true,
            "autoWidth": false,
            "orderCellsTop": true,
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": site_url+"/magang/datatable_log_absensi_arr_menu",
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