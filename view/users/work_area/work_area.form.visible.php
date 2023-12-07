<?php
    include("../../config/net.php");
    

    if(isset($_REQUEST['iu'])){
        $iu = $_REQUEST['iu'];
        $visible = $_REQUEST['visible'];

        if($visible == 0){
            $action = "visibleArea";
        }else{
            $action = "invisibleArea";
        }

        $query = "SELECT * FROM workarea WHERE id = $iu";
        $enable = $net_rrhh->prepare($query);
        $enable->execute();
        $dataE = $enable->fetch();
    }
?>
<form action="process/" method="post" id="formArea">
    <input type="hidden" class="form-control" name="process" value="Area">
    <input type="hidden" class="form-control" name="action" value="<?=$action;?>" />
    <input type="hidden" name="iu" value="<?= $iu ?>" />

    <?php if($visible == 1){ ?>
        <h2 class="text-uppercase fw-bolder">Deshabilitar área</h2>
        <p>¿Está seguro que desea deshabilitar el área <b><?=$dataE[1];?></b>?</p>
    <?php } else { ?>
        <h2 class="text-uppercase fw-bolder">Habilitar área</h2>
        <p>¿Está seguro que desea habilitar el área <b><?=$dataE[1];?></b>?</p>
    <?php } ?>
</form>