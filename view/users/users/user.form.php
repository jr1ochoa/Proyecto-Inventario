<?php
    include("../../config/net.php");

    if(isset($_SESSION['iu']) && $_SESSION['type'] == "Administrador") 
    { 

    $action = "add";
    $title = "Agregar Usuario";

    if(isset($_REQUEST['iu']))
    {
        $iu = $_REQUEST['iu'];   
        $action = "update";
        $title = "Actualizar Usuario";

        $query = "SELECT * FROM users WHERE id = $iu";
        $update = $net_rrhh->prepare($query);
        $update->execute();
        $dataU = $update->fetch();

        $hide = "<input type='hidden' name='iu' value='$iu' />";
    }

?>

<form action="process/" method="post" id="form">

    <b><?=$title?></b>    
    <input type="hidden" class="form-control" name="process" value="Users">
    <input type="hidden" class="form-control" name="action" value="<?= $action; ?>" />
    <?=$hide?>

    <div class="mb-3">
        <label for="recipient-name" class="col-form-label">Usuario:</label>
        <input type="text" class="form-control" name="username" value="<?=$dataU[1]; ?>">
    </div>

    <div class="mb-3">
        <label for="recipient-name" class="col-form-label">Tipo de Usuario:</label>
        <select class="form-select" name="type">
            <?php 
            foreach(array("Administrador", "Gestor", "RRHH", "Bodega") as $type)
            {
                $selected = ($type == $dataU[2]) ? 'selected="selected"' : '';
                echo "<option value='$type' $selected>$type</option>";
            }
            ?>
        </select>
    </div>
    <?php
        if(!isset($_REQUEST['iu'])){
            echo '<div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Contraseña:</label>
                    <input type="password" class="form-control" name="pass">
                </div>';
        }
    ?>

    <div class="mb-3">
        <label for="recipient-name" class="col-form-label">Lugar:</label>
        <select class="form-select" name="location">
            <?php 
            foreach(array("Soyapango", "Santa Ana", "San Miguel", "Multigimnasio", "Otro") as $type)
            {
                $selected = ($type == $dataU[4]) ? 'selected="selected"' : '';
                echo "<option value='$type' $selected>$type</option>";
            }
            ?>
        </select>    
    </div>
    
</form>

<?php    
    }
?>