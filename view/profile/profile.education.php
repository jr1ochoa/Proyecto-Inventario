<?php include("../../config/net.php"); //Conexión a BDD

    $action = $_REQUEST["action"];

    //Verificación de la acción
    if($action != "add"){
        $ie = $_REQUEST['ie'];

        $query = "SELECT * FROM employee_education WHERE id = " . $ie;
        $infoEdu = $net_rrhh->prepare($query);
        $infoEdu->execute();
        $DataEdu = $infoEdu->fetch();
    }

    if($action == "watch"){
?>

<!-- Vista del registro -->
<style>
a
{
    text-decoration: none;
    cursor: pointer;
}
</style>
<div class="col-12 col-12-xsmall mb-4">
    <h2><?= $DataEdu[2];?></h2>
</div>
<table id="UserTable" class="display" style="width:100%">
    <tr>
        <th>Institución</th>
        <th><?= $DataEdu[2]; ?></th>
    </tr>
    <tr>
        <th>Nivel Educativo</th>
        <th><?= $DataEdu[1];?></th>
    </tr>
    <tr>
        <th>Grado</th>
        <th><?= $DataEdu[3];?></th>
    </tr>
    <tr>
        <th>Dirección</th>
        <th><?= $DataEdu[4];?></th>
    </tr>
    <tr>
        <th>Teléfono</th>
        <th><?= $DataEdu[5];?></th>
    </tr>
    <tr>
        <th>Sitio Web</th>
        <th><?= $DataEdu[6]; ?></th>
    </tr>
    <tr>
        <th>Año de Inicio</th>
        <th><?= $DataEdu[7];?></th>
    </tr>
    <tr>
        <th>Año de Finalización</th>
        <th><?= $DataEdu[8];?></th>
    </tr>
    <tr>
        <th>Estado</th>
        <th><?= $DataEdu[9]; ?></th>
    </tr>
    <tr>
        <th>Porcentaje</th>
        <th><?= $DataEdu[10];?></th>
    </tr>
    <tr>
        <th>Periodo</th>
        <th><?= $DataEdu[11];?></th>
    </tr>
<tbody>

</tbody> 
</table>

<?php }else{ ?>

    <!-- Vista de los formularios -->
    <form action="process/" method="post" id="formProfile">
        <?php
            switch($action){
                case "add":
                    $actionSend = "Add Education";
                    echo '<h2 class="text-uppercase fw-bolder">Agregar Información Educacional</h2>';
                    break;
                case "update":
                    $actionSend = "Update Education";
                    echo '<h2 class="text-uppercase fw-bolder">Actualizar Información Educacional</h2>';
                    break;
                case "delete":
                    $actionSend = "Delete Education";
                    echo '<h2 class="text-uppercase fw-bolder">Eliminar Información Educacional</h2>';
                    break;
            }

        ?>
        
        <input type="hidden" class="form-control" name="process" value="Profile">
        <input type="hidden" class="form-control" name="action" value="<?= $actionSend; ?>" />
        <input type="hidden" name="ie" value="<?= $ie; ?>" />
        <input type="hidden" name="iu" value="<?= $_SESSION['iu']; ?>" />
        
        <!-- Ingresar / Actualizar -->
        <?php
        if($action != "delete"){
        ?>
        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Educación:</label>
            <input type="text" class="form-control" name="data1" value="<?= utf8_encode($DataEdu[1]); ?>">
        </div>

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Institución:</label>
            <input type="text" class="form-control" name="data2" value="<?= utf8_encode($DataEdu[2]); ?>">
        </div>

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Nivel, Título o Diploma obtenido:</label>
            <input type="text" class="form-control" name="data3" value="<?=  utf8_encode($DataEdu[3]); ?>">
        </div>

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Dirección:</label>
            <input type="text" class="form-control" name="data4" value="<?=  utf8_encode($DataEdu[4]); ?>">
        </div>

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Teléfono:</label>
            <input type="text" class="form-control" name="data5" value="<?=  utf8_encode($DataEdu[5]); ?>">
        </div>

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Sitio Web:</label>
            <input type="text" class="form-control" name="data6" value="<?=  utf8_encode($DataEdu[6]); ?>">
        </div>

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Año de Inicio:</label>
            <input type="number" class="form-control" name="data7" value="<?=  utf8_encode($DataEdu[7]); ?>">
        </div>

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Año de Finalización:</label>
            <input type="number" class="form-control" name="data8" value="<?=  utf8_encode($DataEdu[8]); ?>">
        </div>

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Estado:</label>
            <input type="text" class="form-control" name="data9" value="<?=  utf8_encode($DataEdu[9]); ?>">
        </div>
 
        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Porcentaje:</label>
            <input type="text" class="form-control" name="data10" value="<?=  utf8_encode($DataEdu[10]); ?>">
        </div>

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Periodo:</label>
            <input type="text" class="form-control" name="data11" value="<?=  utf8_encode($DataEdu[11]); ?>">
        </div>

        <!-- Eliminar -->
        <?php
            }else{
        ?>
            <p>¿Está seguro que desea eliminar la Información Institucional <b><?= utf8_encode($DataEdu[2]);?> - <?=utf8_encode($DataEdu[1]);?> - <?=utf8_encode($DataEdu[3]);?></b>?</p>
        <?php } ?> 
    </form>
<?php } ?>