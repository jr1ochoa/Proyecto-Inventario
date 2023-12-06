<!-- FORMULARIO DEL PERFIL FAMILIAR -->

<?php include("../../config/net.php"); //Conexión a BDD

    $action = $_REQUEST["action"];

    //Verificación de la acción
    if($action == "update" or $action == "delete"){
        $ifm = $_REQUEST['ifm'];

        $query = "SELECT * FROM employee_familiar WHERE id = $ifm";
        $update = $net_rrhh->prepare($query);
        $update->execute();
        $dataU = $update->fetch();
    }

   
?>

<form action="process/" method="post" id="formProfile">
    <?php
        //Mostrar encabezado según acción
        switch($action){
            case "add":
                echo '<h2 class="text-uppercase fw-bolder">Agregar Familiar</h2>';
                $actionSend = "Add Relative";
                break;
            case "update":
                echo '<h2 class="text-uppercase fw-bolder">Actualizar Familiar</h2>';
                $actionSend = "Update Relative";
                break;
            case "delete":
                echo '<h2 class="text-uppercase fw-bolder">Eliminar Familiar</h2>';
                $actionSend = "Delete Relative";
                break;
        }

    ?>
    
    <input type="hidden" class="form-control" name="process" value="Profile">
    <input type="hidden" class="form-control" name="action" value="<?= $actionSend; ?>" />
    <input type="hidden" name="ifm" value="<?= $ifm; ?>" />
    <input type="hidden" name="iu" value="<?= $_SESSION['iu']; ?>" />
    
    <!-- Agregar / Actualizar -->
    <?php
     if($action != "delete"){
    ?>
    <div class="mb-3">
        <label for="recipient-name" class="col-form-label">Nombres:</label>
        <input type="text" class="form-control" name="data1" value="<?= $dataU[1]; ?>">
    </div>

    <div class="mb-3">
        <label for="recipient-name" class="col-form-label">Apellidos:</label>
        <input type="text" class="form-control" name="data2" value="<?= $dataU[2]; ?>">
    </div>

    <div class="mb-3">
        <label for="recipient-name" class="col-form-label">Parentesco:</label>
        <input type="text" class="form-control" name="data3" value="<?= $dataU[3]; ?>">
    </div>

    <div class="mb-3">
        <label for="recipient-name" class="col-form-label">Teléfono:</label>
        <input type="text" class="form-control" name="data4" value="<?= $dataU[4]; ?>">
    </div>

    <div class="mb-3">
        <label for="recipient-name" class="col-form-label">Profesión:</label>
        <input type="text" class="form-control" name="data5" value="<?= $dataU[5]; ?>">
    </div>

    <div class="mb-3">
        <label for="recipient-name" class="col-form-label">Lugar de Trabajo:</label>
        <input type="text" class="form-control" name="data6" value="<?= $dataU[6]; ?>">
    </div>

    <div class="mb-3">
        <label for="recipient-name" class="col-form-label">Llamar en Emergencias:</label>
        <select class="form-select" name="data7">
            <?php
                if(isset($dataU[7])){
                    if($dataU[7] == 'Si'){
                        echo '<option value="Si" Selected>Si</option>
                        <option value="No">No</option>';
                    }else{
                        echo '<option value="Si">Si</option>
                            <option value="No" Selected>No</option>';
                    }
                }else{
            ?>
            <option value="Si">Si</option>
            <option value="No">No</option>
            <?php } ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="recipient-name" class="col-form-label">Dependencia:</label>
        <select class="form-select" name="data8">
            <?php
                if(isset($dataU[8])){
                    if($dataU[8] == 'Si'){
                        echo '<option value="Si" Selected>Si</option>
                        <option value="No">No</option>';
                    }else{
                        echo '<option value="Si">Si</option>
                            <option value="No" Selected>No</option>';
                    }
                }else{
            ?>
            <option value="Si">Si</option>
            <option value="No">No</option>
            <?php } ?>
        </select>
    </div>

    <!-- Eliminar -->
    <?php
        }else{
    ?>
    <p>¿Está seguro que desea eliminar el familiar <b><?=$dataU[1];?></b>?</p>
    <?php } ?>
</form>

