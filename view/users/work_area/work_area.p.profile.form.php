<?php
include("../../config/net.php");
$type = $_REQUEST['type'];

if($type == 'boss'){
?>

<h2 class="text-uppercase fw-bolder">Asignar Jefe del Cargo</h2>

<div class="mb-3">
    <label for="recipient-name" class="col-form-label">Buscar por cargo:</label>
    <input id="txtBusqueda" type="text" class="form-control" name="position" value="<?= $dataU[1]; ?>">
</div>

<div id="salida"></div>


<script>
    $(document).ready(function() {
        $("#txtBusqueda").keyup(function() {
            var parametros = "txtBusqueda=" + $(this).val() + "&idPosition=" + <?= $_REQUEST['idp']?>;
            $.ajax({
                data: parametros,
                url: '../view/work_area/work_area.position.search.php',
                type: 'POST',
                beforeSend: function() {},
                success: function(response) {
                    $("#salida").html(response);
                },
                error: function() {
                    alert("error jquery")
                }
            });
        })
    })
</script>

<?php } else{ ?>

<h2 class="text-uppercase fw-bolder">Asignar Empleado del Cargo</h2>

<form action="process/" method="post" id="formArea">
    
    <input type="hidden" class="form-control" name="process" value="Area">
    <input type="hidden" class="form-control" name="action" value="Asing Employee" />
    <input type="hidden" class="form-control" name="idposition" value="<?= $_REQUEST['idp']?>" />

    <div class="mb-4">
        <label for="cboEmployee" class="form-label">Empleado:</label>
        <select id="cboEmployee" name="idemployee" class="js-example-basic-single" style="width: 100%;">
            <?php
                $query = "SELECT e.id, CONCAT(e.name1, ' ', e.name2, ' ', e.name3, ' ', e.lastname1, ' ', e.lastname2) as 'Nombre' FROM `employee` as e;";
                $user = $net_rrhh->prepare($query);  
                $user->execute();
            
                while($data = $user->fetch())
                {         
                    $selected = ($employeeValue == $data[0]) ? 'selected' : "";
                    echo "<option value='$data[0]' $selected>".utf8_encode($data[1])."</option>";
                }
                /*
                $query = "SELECT * FROM workarea where visible = 1";
                
                $workarea = $net_rrhh->prepare($query);  
                $workarea->execute();

                while($data = $workarea->fetch())
                {
                    if($data[0] == $areaP)
                        echo "<option value='$data[0]' selected='selected'>".utf8_encode($data[1])."</option>";
                    else
                        echo "<option value='$data[0]'>".utf8_encode($data[1])."</option>";
                }*/
            ?>
        </select>
    </div>
   <!--
    <div class="mb-4">
        <label for="cboEmployee" class="form-label">Empleado:</label>
        <select id="cboEmployee" class="js-example-basic-single" name="idemployee" style="width: 100%">
            <option value="<?=$employeeValue?>"><?=utf8_encode($employeeP)?></option>
        </select>
    </div>

    
    <div class="mb-3">
        <label for="recipient-name" class="col-form-label">Empleado:</label>

        <select class="form-select" name="idemployee">
        <?php
            $query = "SELECT * FROM employee ORDER BY name1 ASC, name2 ASC, name3 ASC, lastname1 ASC, lastname2 ASC";
            $employeeList = $net_rrhh->prepare($query);
            $employeeList->execute();
            if ($employeeList->rowCount() > 0) 
            {
                while($data = $employeeList->fetch())
                {   
                    echo "<option value='$data[0]'> $data[1] $data[2] $data[3] $data[4] $data[5]</option>";
                }
            }else{
                echo "<option value='No hay respuesta'></option>";
            }
        ?>
        </select> 
    </div>
        -->

    <div class="mb-3">
        <label for="recipient-name" class="col-form-label">Contrato:</label>
        <select class="form-select" name="contrat" id="contrato">
            <?php
            $options = array("Planilla", "Proyecto");
            foreach ($options as $option) {
                echo "<option value='$option'>$option</option>";
            }
            ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="recipient-name" class="col-form-label">Financiamiento:</label>
        <input type="text" class="form-control" name="financing">
    </div>

    <div class="mb-3">
        <label for="recipient-name" class="col-form-label">Salario:</label>
        <input type="number" class="form-control" name="salary">
    </div>

    <div class="mb-3">
        <label for="recipient-name" class="col-form-label">Fecha de Inicio:</label>
        <input type="date" class="form-control" name="startdate">
    </div>

    <div class="mb-3" id="dFin" style="display: none;">
        <label for="recipient-name" class="col-form-label">Fecha de Finalización:</label>
        <input type="date" class="form-control" name="enddate">
    </div>
    
    
</form>
<script>
    var select = document.getElementById('contrato');
    select.addEventListener('change',
    function(){
        var selectedOption = this.options[select.selectedIndex];
        if(selectedOption.value == "Proyecto"){
            document.getElementById('dFin').style.display = "block";
        }else{
            document.getElementById('dFin').style.display = "none";
        }
    });   
    function loadEmployees(area) {
        document.getElementById('cboEmployee').options.length = 0;
        $.get("view/inventory/employee.list.php", { area: area },
            function (resultado) {
                if (resultado == false) {
                    alert("Error");
                }
                else {
                    $('#cboEmployee').append(resultado);
                }
            }
        );
    }
</script>

<?php } ?>
<script>
    $('#cboEmployee').select2({
        dropdownParent: $('#FormModal')
    });
</script>