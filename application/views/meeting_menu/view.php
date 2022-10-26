    <style>
    .cpas{
      display:none;
    }
    </style>
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Meeting</h6>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <a href="<?= site_url();?>/meeting_menu/create_page" class="btn btn-sm btn-success">Tambahkan Meeting</a>
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
          if($in == 2)
            {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                echo '<span class="alert-icon"><i class="ni ni-air-baloon"></i></span>';
                echo '<span class="alert-text"><strong>Gagal , User Tersebut Sudah Absen</strong></span>';
                echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                    echo '<span aria-hidden="true">&times;</span>';
                echo '</button>';
            echo '</div>';
            }
          ?>


        <?php
            if($in == 1)
              {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                echo '<span class="alert-icon"><i class="ni ni-like-2"></i></span>';
                echo '<span class="alert-text"><strong>Berhasil ,User Berhasil Dimasukan</strong></span>';
                echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                    echo '<span aria-hidden="true">&times;</span>';
                echo '</button>';
            echo '</div>';
            }
      ?>
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="table-responsive py-4">
              <table class="table table-sm table-flush" id="datatable-buttons" style="width: 100% !important;">
                <thead class="thead-light">
                  <tr>
                    <th>No</th>
                    <th>Aksi</th>
                    <th>ID Meeting</th>
                    <th style="word-wrap: break-word;min-width: 160px;max-width: 160px;">Nama Meeting</th>
                    <th>Created By</th>
                    <th>Event Date</th>
                    <th>Waktu</th>
                    <th>Departement</th>
                    <th>Lokasi</th>
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

    let buttonList = document.querySelectorAll(".button");

    function myFunction(no) {
      // Get the text field
      var copyText = document.getElementById("ct"+no);
      console.log(copyText);
      // Select the text field
      copyText.select();
      copyText.setSelectionRange(0, 99999); // For mobile devices

      // Copy the text inside the text field
      navigator.clipboard.writeText(copyText.value);
      
      // Alert the copied text
      alert("Copied the text: " + copyText.value);
    }


    $(document).ready(function() {
        var columnFilter = [2,3,4,5,6];

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
        // copyToClipboard();
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
                "url": site_url+"/meeting_menu/datatable_meeting_menu",
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