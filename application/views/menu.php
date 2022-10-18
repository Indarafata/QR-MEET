<?php

$menus = get_menu();
// echo json_encode($menus);die();
?>

<div class="collapse navbar-collapse" id="sidenav-collapse-main">
  <!-- Nav items -->
  <ul class="navbar-nav">
  <?php
  $i =1;
    foreach ($menus as $m => $value) {
        if (isset($value['CHILDS'])) { 
    ?>
            <li class="nav-item">
            <a class="nav-link" href="#navbar-examples<?= $i?>" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                <i class="ni ni-ungroup text-orange"></i>
                <span class="nav-link-text"><?= $value['MENU'] ?></span>
            </a>
            <div class="collapse" id="navbar-examples<?= $i?>">
                <ul class="nav nav-sm flex-column">
                <?php foreach ($value['CHILDS'] as $c => $child){?>
                    <li class="nav-item"><a href="<?= site_url($child['URL']) ?>" class="nav-link"><span><?= $child['MENU'] ?></span></a></li>
                <?php } ?>
                </ul>
            </div>
            </li>
        <?php
        $i++;
            }
        }
    ?>
  </ul>
</div>



