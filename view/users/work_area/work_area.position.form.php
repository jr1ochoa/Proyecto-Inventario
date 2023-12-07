<?php
    include("../../config/net.php");

    $action = "addPosition";
    $area = $_REQUEST["area"]; 
    $typeA = $_REQUEST["typeA"]; 

    if(isset($_REQUEST['iu'])){
        $iu = $_REQUEST['iu'];   
        $action = "updatePosition";

        $query = "SELECT * FROM workarea_positions WHERE id = $iu";
        $update = $net_rrhh->prepare($query);
        $update->execute();
        $dataU = $update->fetch();
    }

    if($typeA != "area"){
?>
 
<form action="process/" method="post" id="formArea">
    <?php
        if(!isset($_REQUEST['iu'])){
            echo '<h2 class="text-uppercase fw-bolder">Agregar Cargo</h2>';
        }else{
            echo '<h2 class="text-uppercase fw-bolder">Actualizar Cargo</h2>';
        }
    ?>
    
    <input type="hidden" class="form-control" name="process" value="Area">
    <input type="hidden" class="form-control" name="action" value="<?= $action; ?>" />
    <input type="hidden" name="iu" value="<?= $iu; ?>" />

    <div class="mb-3">
        <label for="recipient-name" class="col-form-label">Cargo:</label>
        <input type="text" class="form-control" name="position" value="<?= utf8_encode($dataU[1]); ?>">
    </div>

    <div class="mb-3">
        <label for="recipient-name" class="col-form-label">Detalles:</label>
        <input type="text" class="form-control" name="details" value="<?= utf8_encode($dataU[2]); ?>">
    </div>
    
    <?php
        echo '<input type="hidden" name="idarea" value='.$area.' />';
    ?>
    
</form>

<?php
    }else{
        $action = "changeArea";
?>

<h2 class="text-uppercase fw-bolder">Cambio de &Aacute;rea</h2>

<form action="process/" method="post" id="formArea">

    <input type="hidden" class="form-control" name="process" value="Area">
    <input type="hidden" class="form-control" name="action" value="<?= $action; ?>" />
    <input type="hidden" name="iu" value="<?= $iu; ?>" />

    <div class="mb-3">
        <label for="recipient-name" class="col-form-label">Área:</label>
        <select class="form-select" name="idarea">
        <?php
            $query = "SELECT * FROM workarea where visible = 1";
            $area = $net_rrhh->prepare($query);  
            $area->execute();
            while($data = $area->fetch()){
                if($dataU[3]==$data[0]){
                    echo "<option value='$data[0]' selected>".utf8_encode($data[1])."</option>";
                }else{
                    echo "<option value='$data[0]'>".utf8_encode($data[1])."</option>";
                }
                
            } 
            
        ?>
        </select>
    </div>
</form>

<?php
    }
?>