
<?php
if (isset($custom_file_header) || !empty($custom_file_header)) {
    foreach ($custom_file_header as $file_header) {
        $this->load->view($file_header['view'], @$file_header['data'], TRUE);
    }
}
?>

<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0"><?= $list_header ?></h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <?php foreach ($buttons as $key_button => $value_button) : ?>
              <button onclick="<?= $value_button['onclick'] ?>" class="btn btn-<?= $value_button['type'] ?> btn-sm">
                  <span>
                      <i class="<?= $value_button['icon'] ?>"></i>
                      <span>
                          <?= $value_button['label'] ?>
                      </span>
                  </span>
              </button>
          <?php endforeach; ?>
          <?php if (count($filter) > 0) { ?>
              <button id="filter" onclick=(filter()) class="btn btn-secondary btn-sm" data-toggle="modal">
                  <span>
                      <i class="ni ni-settings"></i>
                      <span>
                          Filter
                      </span>
                  </span>
              </button>
          <?php } ?>
          <?php if ($add) : ?>
              <button id="add" onclick=(add()) class="btn btn-success btn-sm" data-toggle="modal">
                  <span>
                      <i class="ni ni-fat-add"></i>
                      <span>
                          Add
                      </span>
                  </span>
              </button>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Page content -->
<div class="container-fluid mt--6" id="list">
  <?= $this->session->flashdata('notif'); ?>
  <!-- Table -->
  <div class="row">
    <div class="col">
      <div class="card">
        <div class="table-responsive py-4">
          <table class="table table-sm table-flush" id="table-list" style="width: 100% !important;">
            <thead class="thead-light">
              <tr>
                  <th width="40px">NO</th>
                  <th width="80px">ACTION</th>
                  <?php foreach ($col as $c) {
                      echo "<th>".$c['label']."</th>";
                  } ?>
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

<?php
if (isset($custom_file_footer) || !empty($custom_file_footer)) {
    foreach ($custom_file_footer as $file_footer) {
        $this->load->view($file_footer['view'], @$file_footer['data'], TRUE);
    }
}
?>

<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="titleForm" id="titleForm">Add</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form id="input_form">
        <div class="modal-body">
          <?php foreach ($forms as $form) {
              switch ($form['type']) {
                  case 'select':
                      if (isset($form['dataTable'])) {
                          $data_table = explode(';', $form['dataTable']);
                          $data_table[0] = explode('.', $data_table[0]);
                          $pk = $data_table[0][1];
                          $distinct = isset($form['distinct']) ? $form['distinct'] : false;
                          $distinct = $distinct ? 'DISTINCT' : '';
                          $field = $data_table[1];
                          $value = isset($form['value']) ? $form['value'] : '';
                          $tipe = isset($form['tipe']) ? $form['tipe'] : 1;
                          $jwhere = isset($form['where']) ? " where $form[where]" : '';
                          $order_by = isset($form['order_by']) ? $form['order_by'] : "$field ASC";
                          $query = "SELECT $distinct $pk" . ($field != $pk ? ", $field " : ' ') . "FROM " . $data_table[0][0] . $jwhere . " ORDER BY $order_by";
                          $attr = array_search('true', $form);
                          echo selectan_db($form['label'], $form['name'], $query, $pk, $field, $value, $tipe, $attr ? $attr : '');
                      } else {
                          echo selectan($form['label'], $form['name'], $form['customOption'], isset($form['value']) ? $form['value'] : NULL, isset($form['tipe']) ? $form['tipe'] : '', isset($form['attr']) ? $form['attr'] : '');
                      }
                      break;
                  case 'date':
                      $attr = array_search('true', $form);
                      echo indate($form['label'], $form['name'], (isset($form['value']) ? $value : NULL), $attr);
                      break;
                  case 'time':
                      echo input_time($form['label'], $form['name'], (@$form['value'] ?: NULL), (@$form['required'] ?: false));
                      break;
                  case 'formButton':
                      echo formButton($form);
                      break;
                  default:
                      if (isset($form['required']) && $form['required']) {
                          $hasil = 1;
                      } else if (isset($form['disabled']) && $form['disabled']) {
                          $hasil = 2;
                      } else if (isset($form['readOnly']) && $form['readOnly']) {
                          $hasil = 3;
                      } else if (isset($form['date']) && $form['date']) {
                          $hasil = 4;
                      } else if (isset($form['twoDecimal']) && $form['twoDecimal']) {
                          $hasil = 5;
                      } else {
                          $hasil = '';
                      }
                      if (isset($form['strToUpper']) and $form['strToUpper'] == true) {
                          $attr = "onkeyup='myUpper()'";
                      } else {
                          $attr = '';
                      }
                        
                      echo inputan($form['label'], $form['type'], $form['name'], isset($form['value']) ? $form['value'] : '', $hasil, $attr);
                      break;
              }
          } ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php if (count($filter) > 0) { ?>
  <div class="modal fade" id="filter_modal" tabindex="-1" role="dialog" aria-labelledby="filter_modal" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="titleForm" id="titleForm">Filter</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form id="input_form">
          <div class="modal-body">
            <?php
            foreach ($filter as $f) {
                $tb    = '';
                $query = '';
                $pk    = '';
                $field = '';
                $value = '';
                if ($f['type'] == 'select') {
                    if (isset($f['dataTable'])) {
                        $data_table = explode(';', $f['dataTable']);
                        $data_table[0] = explode('.', $data_table[0]);
                        $tb = $data_table[0][0] . '.';
                        $pk = $data_table[0][1];
                        $distinct = isset($f['distinct']) ? $f['distinct'] : false;
                        $distinct = $distinct ? 'DISTINCT' : '';
                        $field = $data_table[1];
                        $value = isset($f['value']) ? $f['value'] : '';
                        $jwhere = isset($f['where']) ? " where $f[where]" : '';
                        $query = "SELECT $distinct $pk" . ($field != $pk ? ", $field " : ' ') . "FROM " . $data_table[0][0] . $jwhere . " ORDER BY $field ASC";
                        
                        echo filter_form($f['label'], $f['name'], $f['equal'], $f['type'], $tb, $query, $pk, $field, $value);
                    } else {
                        $value = isset($f['value']) ? $f['value'] : '';
                        echo filter_form($f['label'], $f['name'], $f['equal'], $f['type'], $tb, '', $pk, $field, $value, $f['customOption']);
                    }
                }
            }
            ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary" onclick="filterData()">Filter</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php } ?>

<style>
    input.salah, .select2-selection.salah {
        border: 1px solid red !important;
    }
</style>l

<?= $this->load->view('master/script', NULL, TRUE) ?>
<?php
if (isset($custom_file_js) || !empty($custom_file_js)) {
    foreach ($custom_file_js as $js) {
        $this->load->view($js, NULL, TRUE);
    }
}
?>

<script>
    <?= $custom_script ?>
</script>