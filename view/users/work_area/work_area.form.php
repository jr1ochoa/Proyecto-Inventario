<?php
    include("../../config/net.php");

    $action = "add";

    if(isset($_REQUEST['iu'])){
        $iu = $_REQUEST['iu'];   
        $action = "update";

        $query = "SELECT * FROM workarea WHERE id = $iu";
        $update = $net_rrhh->prepare($query);
        $update->execute();
        $dataU = $update->fetch();
    }

?> 

<form action="process/" method="post" id="formArea">
    <?php
        if(!isset($_REQUEST['iu'])){
            echo '<h2 class="text-uppercase fw-bolder">Agregar Área</h2>';
        }else{
            echo '<h2 class="text-uppercase fw-bolder">Actualizar Área</h2>';
        }
    ?>
    
    <input type="hidden" class="form-control" name="process" value="Area">
    <input type="hidden" class="form-control" name="action" value="<?= $action; ?>" />
    <input type="hidden" name="iu" value="<?= $iu; ?>" />

    <div class="mb-3">
        <label for="recipient-name" class="col-form-label">Área:</label>
        <input type="text" class="form-control" name="area" value="<?=$dataU[1]; ?>">
    </div>

    <div class="mb-3">
        <label for="recipient-name" class="col-form-label">Tag:</label>
        <input type="text" class="form-control" name="tag" value="<?= $dataU[2]; ?>">
    </div>
    
</form>