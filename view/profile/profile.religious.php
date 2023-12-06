<!-- FORMULARIO DEL PERFIL RELIGIOSO -->

<?php include("../../config/net.php"); //Conexión a BDD

//Validación de la acción
if (isset($_REQUEST['ir'])) {
    $ir = $_REQUEST['ir'];
    $action = "Add Religious";
    $query = "Select * from employee_religious where id_employee = " . $ir;
    $religious = $net_rrhh->prepare($query);
    $religious->execute();
    $dataR = $religious->fetch();
?>
    <?php
        //Encabezado según la acción
        if ($ir != 0){
            echo '<h2 class="text-uppercase fw-bolder">Actualizar Información Religiosa</h2>';
        }else{
            echo '<h2 class="text-uppercase fw-bolder">Agregar Información Religiosa</h2>';
        }
    ?>
    
    <!-- Formulario -->
    <form action="process/" method="post" id="formProfile"> 

        <input type="hidden" class="form-control" name="process" value="Profile" />
        <input type="hidden" class="form-control" name="action" value="Add Religious" />
        <input type="hidden" name="ir" value="<?= $dataR[0]; ?>" />
        <input type="hidden" name="iu" value="<?= $_SESSION['iu']; ?>" />

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Religión:</label>
            <select class="form-select" name="data1" id="religion">
                <?php
                $options = array("Cristiano Católico", "Cristiano Evangelico", "Otro");
                foreach ($options as $option) {
                    $selected = ($option == $dataR[1]) ? "selected='true'" : "";
                    echo "<option value='$option' $selected>$option</option>";
                }
                ?>
            </select>
        </div>

        <div id="despl">
            <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Si perteneces a una congregación escribe su nombre:</label>
                <input type="text" class="form-control" name="data2" value="<?= $dataR[2]; ?>">
            </div>

            <div class="mb-3">
                <label for="recipient-name" class="col-form-label">¿Donde está ubicada?:</label>
                <input type="text" class="form-control" name="data3" value="<?= $dataR[3]; ?>">
            </div>

            <div class="mb-3">
                <hr/>
                Sacramentos realizados
            </div>


            <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Bautismo:</label>
                <input type="text" class="form-control" name="data4" value="<?= $dataR[4];?>">
            </div>

            <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Confesión:</label>
                <input type="text" class="form-control" name="data5" value="<?= $dataR[5]; ?>">
            </div>

            <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Primera Comunión:</label>
                <input type="text" class="form-control" name="data6" value="<?= $dataR[6]; ?>">
            </div>

            <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Confirma:</label>
                <input type="text" class="form-control" name="data7" value="<?= $dataR[7]; ?>">
            </div>

            <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Matrimónio:</label>
                <input type="text" class="form-control" name="data8" value="<?= $dataR[8]; ?>">
            </div>

            <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Unción de enfermos:</label>
                <input type="text" class="form-control" name="data9" value="<?= $dataR[9]; ?>">
            </div>

            <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Ordenación Sacerdotal:</label>
                <input type="text" class="form-control" name="data10" value="<?= $dataR[10]; ?>">
            </div>
        </div>   

    </form>
<?php
}
?>
<script>
    //Mostrar campos según la religión
    var select = document.getElementById('religion');
    select.addEventListener('change',
    function(){
        var selectedOption = this.options[select.selectedIndex];
        if(selectedOption.value == "Cristiano Católico"){
            document.getElementById('despl').style.display = "block";
        }else{
            document.getElementById('despl').style.display = "none";
        }
        console.log(selectedOption.value + ': ' + selectedOption.text);
    });
</script>