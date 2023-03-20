<script>
    // Network
    function postSave(data) {
        if (data.state == 'add') {
            $.post("<?=current_url()?>/ajaxPostInsert", {...data.form}, function(res) {
                response(res)
            }, 'JSON');
        } else {
            $.post("<?=current_url()?>/ajaxPostEdit", {...{id}, ...data.form}, function(res) {
                response(res)
            }, 'JSON');
        }
    }

    function postDelete(id) {
        $.post('<?=current_url()?>/ajaxPostDelete', {id}, function(res) {
            response(res);
        })
    }

    function getDetail(id) {
        return $.get('<?=current_url()?>/ajaxGetDetail', {id}, function(res) {
            return res;
        }, 'JSON')
    }

    // UI
    var state = 'add';
    var id;
    var id_edit = '<?= $id ?>';
    // var title = $('.m-portlet__head-text').text();
    var title = $('.panel-hdr > h2 span').text();
    title = title.trim();
    title = title.substr(title.split(" ")[0].length).trim();
    var forms = <?=json_encode($forms)?>;
    var col = <?=json_encode($col)?>;

    $(document).ready(function() {
		$('.m-select2').each(function() {
            $(this).select2({dropdownParent: $(this).parents('.modal-content').length > 0 ? $(this).parents('.modal-content').first() : $(this).parent()});
        });

        //datatables
        let buttons = [];

        buttons.push({
            extend: 'pdfHtml5',
            text: '<i class="fal fa-file-pdf"></i>',
            titleAttr: 'Generate PDF',
            className: 'btn-outline-danger btn-sm mr-1'
        });
        buttons.push({
            extend: 'excelHtml5',
            text: '<i class="fal fa-file-excel"></i>',
            titleAttr: 'Generate Excel',
            className: 'btn-outline-success btn-sm mr-1'
        });
        buttons.push({
            extend: 'csvHtml5',
            text: 'CSV',
            text: '<i class="fal fa-file-csv"></i>',
            titleAttr: 'Generate CSV',
            className: 'btn-outline-primary btn-sm mr-1'
        });
        buttons.push({
            extend: 'print',
            text: '<i class="fal fa-print"></i>',
            titleAttr: 'Print Table',
            className: 'btn-outline-primary btn-sm mr-1'
        });

        let col_right = [];
        col.forEach((object, index) => {
            if (object?.type == 'number') {
                col_right.push(index+2);
            }
        });

        table = $('#table-list').DataTable({ 
            "processing": true, 
            "serverSide": true,
            "fixedHeader": false,
            "responsive": false,
            "scrollY": 400,
            "scrollX": true,
            "scrollCollapse": true,
            "buttons": buttons,
            "dom": "<'row mb-3 mr-3'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-4 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'B>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-6 mt-n1'i><'col-sm-12 col-md-6'p>>",
            "order": [],
            "fixedColumns": {
                <?php foreach ($fixed_columns as $key_fixed_column => $value_fixed_column) {
                    echo "$key_fixed_column: $value_fixed_column,";
                } ?>
            },

            "ajax": {
                "url": "<?=current_url()?>/get_data",
                "type": "POST",
                <?php if(count($filter)>0) { 
                    $filtered = [];?>
                    "data": function(data) {
                        data.custom_filter = true;
                        <?php foreach ($filter as $f) {
                            // $filtered[] = "'$f[name] ' + $('#$f[name]_eq').val() + ' ' + $('#$f[name]_fil').val";
                            echo "data.filter_$f[name] = ( $('#$f[name]_fil').val() != '' ) ? $('#$f[name]_tab').val()+'$f[name] '+ $('#$f[name]_eq').val() +' \''+ $('#$f[name]_fil').val()+'\'' : ''; ";
                        } ?>
                        // data.custom_filter = [<?=implode(', ', $filtered)?>]
                    },
                <?php } ?>
            },

            "columnDefs": [
                { 
                    "targets": [ 0, 1 ], 
                    "orderable": false, 
                },
                {
                    "targets": col_right,
                    "className": 'text-right'
                }
            ],
            "language": {
              "paginate": {
                "previous": "<i class='fas fa-angle-left'>",
                "next": "<i class='fas fa-angle-right'>"
              },
              "lengthMenu":     "Show _MENU_",
            }
        });

        if (id_edit) {
            edit(id_edit);
        }
    });

    function swal_popup(text, type) {
        Swal.fire({
            title: type == 1 ? "Success!" : "Failed!",
            text: text,
            type: type == 1 ? "success" : "error",
            allowOutsideClick:false
        });
    }

    function response(res) {
        if (res.status == 0) {
            Swal.fire({
                title: "Failed!",
                text: res.msg,
                type: "error"
            });
            $.each(res.data, function(i, v) {
                $('.error_'+i).text(v);
                $('#'+i).addClass('salah');
                $('#'+i).parent().find('.select2-selection')?.addClass('salah');
            }) 
        } else {
            Swal.fire({
                title: "Success!",
                text: res.msg,
                type: "success"
            });
            $('#formModal').modal('hide');
            $('#table-list').DataTable().ajax.reload();
        }
    }

    function add() {
        cleanInput();
        state = 'add';

        $('.titleForm').text(`ADD ${title}`);
        <?=swal_loader()?>
        swal.close();
        $('#formModal').modal('show');
    }

    $('#input_form').submit(function(e) {
        if ($(this).valid()) {
            e.preventDefault();
                Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Menyimpan Data ini?",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#F22D4E",
                confirmButtonText: "Ya, Simpan!"
            })
            .then((result) => {
                if (result.value) {
                    submitForm($( this ).serializeArray());
                }
            });
        } else {
            return swal_popup('Harap lengkapi data yang ada', 0);
        }
    })

    function submitForm(form) {
        data = {...{form}, ...{state}}

        <?=swal_loader();?>;

        cleanError();

        postSave(data);
    }

    function hapus(id) {
        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Hapus Data ini?",
            type: "warning",
            showCancelButton: !0,
            confirmButtonColor: "#F22D4E",
            confirmButtonText: "Ya, Hapus!"
        })
        .then((result) => {
            if (result.value) {
                <?=swal_loader()?>
                postDelete(id);
            }
        });
    }

    function showQr(qr) {
        Swal.fire({
            title: "QR Code",
            html: '<img src="https://qrmeet.test/index.php/validation/makeQrMonic?QR=' + qr + '" alt="gambar" width="100">',
        });
    }

    function detail(id) {
        <?=swal_loader()?>
        getDetail(id)
        .done(function(res) {
            console.log(res)
        })
    }

    function edit(id) {
        this.id = id;
        this.state = 'edit';
        
        $('.titleForm').text(`EDIT ${title}`);
        <?=swal_loader()?>
        getDetail(id)

        .done(function(res) {
            data = res.data

            if (res.status == 0) {
                return swal_popup(data.msg, data.status);
            }
            cleanError()

            const assign = new Promise( function(resolve, reject) {
                setItem(data);
				$('#formModal .m-select2').each(function() {
                    $(this).select2({dropdownParent: $(this).parents('.modal-content').length > 0 ? $(this).parents('.modal-content').first() : $(this).parent()});
                });
                <?=$edit_after_set?>
                resolve();
            });
            
            assign.then(function() {
                swal.close();
                $('#formModal').modal('show');
            })
        })
    }

    function setItem(data) {
        $.each(data, function(i,v) {
            $('#'+i).val(v);
        })
    }

    function cleanError() {
        $.each(forms, function(i, v) {
            $('#'+v.name).removeClass('salah');
            $('#'+v.name).parent().find('.select2-selection')?.removeClass('salah');
            $('.error_'+v.name).text('');
        })
    }

    function cleanInput() {
        cleanError();
        this.id = undefined;
        $('#PASSWORD').val('');
        $('#PASSWORD_CONFIRMATION').val('');
        $.each(forms, function(i, v) {
            var default_value = $('#'+v.name).data('default-value');
            $('#'+v.name).val(default_value != null ? default_value : '').trigger('change');
        })
    }

    function myUpper() {
        return this.event.target.value = this.event.target.value.toUpperCase()
    }
	
	
    function filter() {
        // cleanFilter();

        $('#filter_modal').modal('show');
    }

    function filterData(){
        $('#table-list').DataTable().ajax.reload()
        $('#filter_modal').modal('hide');
    }

</script>