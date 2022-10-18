    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">List Absen Meeting</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <!-- Table -->
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="text-center">
                <img src="<?= base_url();?>/assets/img/brand/logo.png" alt="" width="300px">
                <div class="row text-center">
                    <div class="col">
                    <h4 id="kode"></h4>
                    <h4 id="nama"></h4>
                    <h4 id="tanggal"></h4>
                    <h4 id="lokasi"></h4>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
              <div class="col text-right">
                <a id="print" class="btn btn-info" style="width: 90%;" target="_blank"><i class="ni ni-single-copy-04"></i> Print List Absen</a>
              </div>
              <div class="col text-left">
                <a id="export" class="btn btn-success" style="width: 90%;" target="_blank"><i class="ni ni-single-copy-04"></i> Export Excel List Absen</a>
              </div>
            </div>
            <div class="table-responsive py-4">
              <table class="table table-flush" id="datatable-basic" >
                <thead class="thead-light">
                  <tr>
                    <th>No</th>
                    <th>ID User</th>
                    <th>ID Meeting</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Id Departemen</th>
                    <th>Company</th>
                    <th>Checkin Date</th>
                    <th>STATUS</th>
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
    $url = window.location.href
    $split =$url.split("/");
    for(var i = 0 ; i < $split.length ; i++){
        $url = ($split[i])
    }

    $(document).ready(function() {
        var columnFilter = [1,2,3,4];

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
        refreshDatatable($url);
        showData($url);
        $('#datatable-basic').css('width','10px');
    });

    // funsgi menampilkan data kedalam input html
    function showData($url){
        $.ajax({
            type  : 'GET',
            url   : '<?php echo base_url('index.php/')?>meeting_menu/meeting_detail/'+$url,
            async : false,
            dataType : 'json',
            success : function(data){
              
                var date =   new Date(data.EVENT_DATE).toLocaleString(undefined, {year: 'numeric', month: '2-digit', day: '2-digit'});
                var endDate =   new Date(data.END_DATE).toLocaleString(undefined, {hour: '2-digit', hour12: false, minute:'2-digit'});
                var startDate =   new Date(data.START_DATE).toLocaleString(undefined, {hour: '2-digit', hour12: false, minute:'2-digit'});


                $("#kode").text('ID MEETING : '+data.ID_MEETING);
                $("#nama").text('NAMA MEETING : '+data.EVENT);
                $("#tanggal").text('TANGGAL MEETING : '+date+' ( '+startDate+' - '+endDate+' )');
                $("#lokasi").text('LOKASI MEETING : '+data.LOCATION);
                var a = document.getElementById('print'); //or grab it by tagname etc
                var b = document.getElementById('export'); //or grab it by tagname etc

                a.href = "<?php echo site_url();?>/meeting_menu/list_print_absen_page/"+data.ID_MEETING;
                b.href = "<?php echo site_url();?>/export_excel/createXLS/"+data.ID_MEETING;
            }
        });
    }


    function refreshDatatable($url) {
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
                "url": site_url+"/meeting_menu/datatable_list_absen/"+$url,
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