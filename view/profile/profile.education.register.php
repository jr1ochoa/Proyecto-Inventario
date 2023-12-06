<!-- FORMULARIO DEL ESTUDIOS ACTUALES -->

<?php include("../../config/net.php"); //Conexión a BDD

    $iu = $_REQUEST["iu"];

    //Cargar datos de estudios actuales
    $query = "SELECT * FROM employee_education_register 
    WHERE idemployee = " . $iu;
    $infoEdu = $net_rrhh->prepare($query);
    $infoEdu->execute();
    $DataEdu = $infoEdu->fetch();

?>

<!-- Formulario -->
<form id="formProfile" method="post" action="process/">
    <input type="hidden" name="process" value="Profile">
    <input type="hidden" name="action" value="Update Education Register">
    <input type="hidden" name="ier" value="<?=$iu;?>">
    <div class="row gtr-uniform">


        <div class="col-12 col-12-xsmall">
            <h2>Información Educativa</h2>
        </div>

        <div class="col-12 col-12-xsmall">
            ¿Estudia actualmente?
            <select id="study" name="data1">
                <?php
                $options = array("No", "Si");
                foreach ($options as $option) {
                    $selected = ($option == $DataEdu[1]) ? "selected='true'" : "";
                    echo "<option value='$option' $selected>$option</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-12 col-12-xsmall study" style='display: <?= $displayInfo ?>'>
            Institución
            <input type="text" name="data2" value="<?= $DataEdu[2] ?>">
        </div>

        <div class="col-12 col-12-xsmall study" style='display: <?= $displayInfo ?>'>
            ¿Qué estudia?
            <input type="text" name="data3" value="<?= $DataEdu[3] ?>">
        </div>

        <div class="col-12 col-12-xsmall study" style='display: <?= $displayInfo ?>'>
            ¿Qué Nivel?
            <input type="text" name="data4" value="<?= $DataEdu[4] ?>">
        </div>

    </div>
</form>