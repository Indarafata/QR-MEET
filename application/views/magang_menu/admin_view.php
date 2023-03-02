<div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">List Absensi</h6>
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
                    <th>NAMA</th>
                    <th>AKSI</th>
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

<div class="modal fade" id="list_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">DETAIL ABSEN : <span class="text-primary" id="user"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card">
          <div class="table-responsive py-4">
            <table class="table table-sm table-flush" id="datatable-basic" style="width: 100% !important;">
              <thead class="thead-light">
                <tr>
                  <th>No</th>
                  <th>TANGGAL</th>
                  <th>CHECKIN</th>
                  <th>CHECKOUT</th>
                  <th>TYPE & REMARK</th>
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
</div>
    <script type="text/javascript">
    
    var table;
    var site_url = '<?=site_url()?>';

    function listDetail(val){
        $('#list_detail').modal('show');
        refreshDatatable1(val);
        $.ajax({
            url: site_url+"/magang_admin/get_user/"+val,
            type: "get",
            dataType: "json",
            success: function (response) {
              $('#user').html(response.USERNAME);
            }
        });
    }

    $(document).ready(function() {
        var columnFilter = [1];

      $('#datatable-buttons thead tr').clone(true).appendTo( '#datatable-buttons thead' );
      $('#datatable-buttons thead tr:eq(1) th').each( function (i) {
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
                  if ( $('#datatable-buttons').DataTable().column(i).search() !== this.value ) {
                  $('#datatable-buttons').DataTable()
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
        $('#datatable-buttons').DataTable({
           "filter": true,
            "destroy": true,
            "processing": true, 
            "serverSide": true, 
            "searching": true, 
            "responsive":true,
            "autoWidth": false,
            // "orderCellsTop": true,
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": site_url+"/magang_admin/datatable_log_absensi_all_menu",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [0], //first column / numbering column
                    "orderable": false, //set not orderable
                },
                {
                    "targets": [1], //first column / numbering column
                    "orderable": false, //set not orderable
                },
                {
                    "targets": [2], //first column / numbering column
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

    function refreshDatatable1(val) {
        $('#datatable-basic').DataTable({
            "destroy": true,
            "processing": true, 
            "serverSide": true, 
            "responsive":true,
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": site_url+"/magang_admin/datatable_log_absensi_arr_menu/"+val,
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [0], //first column / numbering column
                    "orderable": false, //set not orderable
                },
                {
                    "targets": [1], //first column / numbering column
                    "orderable": false, //set not orderable
                },
                {
                    "targets": [2], //first column / numbering column
                    "orderable": false, //set not orderable
                },
                {
                    "targets": [3], //first column / numbering column
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