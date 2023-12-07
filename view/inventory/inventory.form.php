<!-- FORMULARIO DE ACTIVOS -->
<?php include("../../config/net.php"); //Conexión con la BDD

//Verificar la acción
if($_REQUEST['action'] == "Add")
{
    $data = array();
    $action = "Add Active";
    $input = "";
}
else{

    //Cargar datos del activo
    $query = "SELECT * FROM inventory_active WHERE id = :n1";
    $Inventory = $net_rrhh->prepare($query);
    $Inventory->bindparam(":n1", $_REQUEST['idi']);
    $Inventory->execute();
    $data = $Inventory->fetch();

    $input = "<input type='hidden' name='idi' value='$data[0]' />";

    if($_REQUEST['action'] == "Update"){
        $action = "Update Active";
    }else{
        $action = "Delete Active";
    }
}
?>

<form action="view/inventory/process/" id="form" method='post'>

    <input type="hidden" name="process" value="inventory">
    <input type="hidden" name="action" value="<?=$action?>" />
    <?=$input?>

    <!-- Vista para agregar o editar activos -->
    <?php if($action != "Delete Active"){ ?>
    
    <div class="mb-3">
        <label for="type" class="form-label">Activo Fijo:</label>
        <input type="text" class="form-control" name='fixedasset' id="fixedasset" required value="<?=$data[1]?>">
    </div>

    <div class="mb-3">
        <label for="type" class="form-label">Tipo:</label>
        <select class="form-select" aria-label="Default select example" id="type" name="type">
            <option value=""></option>
            <?php
                $query = "SELECT * FROM catalogue WHERE type LIKE '%Tipo%'";
                $catalogue = $net_rrhh->prepare($query);
                $catalogue->execute();   

                while ($dataC = $catalogue->fetch()) {
                    $selected = ($dataC[0] == $data[2]) ? "selected" : "";
                    echo "<option value='$dataC[0]' $selected>$dataC[2]</option>";
                }

            ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="brand" class="form-label">Marca:</label>
        <select class="form-select" aria-label="Default select example" id="brand" name="brand">
            <option value=""></option>
            <?php
                $query = "SELECT * FROM catalogue WHERE type LIKE '%Marca%'";
                $catalogue = $net_rrhh->prepare($query);
                $catalogue->execute();   

                while ($dataC = $catalogue->fetch()) {
                    $selected = ($dataC[0] == $data[3]) ? "selected" : "";
                    echo "<option value='$dataC[0]' $selected>$dataC[2]</option>";
                }

            ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="model" class="form-label">Modelo:</label>
        <input type="text" class="form-control" name='model' id="model" required value="<?=$data[4]?>">
    </div>

    <div class="mb-3">
        <label for="serial" class="form-label">Serie:</label>
        <input type="text" class="form-control" name='serial' id="serial" required value="<?=$data[5]?>">
    </div>

    <div class="mb-3">
        <label for="serial" class="form-label">Licencia:</label>
        <input type="text" class="form-control" name='license' id="license" required value="<?=$data[12]?>">
    </div>

    <div class="mb-4">
        <label for="status" class="form-label">Estado:</label>
        <select class="form-select" aria-label="Default select example" id="status" name="status">
            <option value=""></option>
            <?php
                $query = "SELECT * FROM catalogue WHERE type LIKE '%Estado%'";
                $catalogue = $net_rrhh->prepare($query);
                $catalogue->execute();   

                while ($dataC = $catalogue->fetch()) {
                    $selected = ($dataC[0] == $data[6]) ? "selected" : "";
                    echo "<option value='$dataC[0]' $selected>$dataC[2]</option>";
                }
            ?>
        </select>
    </div>

    <!-- Vista para agregar asignación inicial -->
    <?php if($action == 'Add Active') { ?>
    <div class="my-3 card">
        <p class="text-center mt-3 mb-1">Desea agregar una asignación inicial?</p>
        <div class="card-body d-flex justify-content-center">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="asignation" id="rdAsignation1" value="option1">
                <label class="form-check-label" for="rdAsignation1">Si</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="asignation" id="rdAsignation2" value="option2" checked>
                <label class="form-check-label" for="rdAsignation2">No</label>
            </div>
        </div>

        <div id="divAssignation" class="card mx-2 mb-2" style="display: none;">

            <input type="hidden" name="assignation" id="assignation" value="yes">

            <div class="mb-3">
                <p class="text-center mt-3">A quien le desea asignar?</p>
                <div class="d-flex justify-content-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="selection" id="rdType1" value="option1">
                        <label class="form-check-label" for="rdType1">Empleado</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="selection" id="rdType2" value="option2">
                        <label class="form-check-label" for="rdType2">Área</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="selection" id="rdType3" value="option3">
                        <label class="form-check-label" for="rdType3">Ambos</label>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-4" id="divArea" style="display: none;">
                    <label for="cboArea" class="form-label">Área:</label>
                    <select id="cboArea" name="area" class="js-example-basic-single" style="width: 100%;" onchange="loadEmployees(this.value)">
                        <option value=""></option>
                        <option value="Otro">Todos los Empleados</option>
                        <?php
                            $query = "SELECT * FROM workarea where visible = 1";
                            
                            $workarea = $net_rrhh->prepare($query);  
                            $workarea->execute();

                            while($data = $workarea->fetch())
                            {
                                if($data[0] == $areaP)
                                    echo "<option value='$data[0]' selected='selected'>".utf8_encode($data[1])."</option>";
                                else
                                    echo "<option value='$data[0]'>".utf8_encode($data[1])."</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="mb-4" id="divEmployee1" style="display: none;">
                    <label for="cboEmployee" class="form-label">Empleado:</label>
                    <select id="cboEmployee" name="employee" class="js-example-basic-single" style="width: 100%">
                        <option value="">Seleccione un área para cargar listado</option>
                    </select>
                </div>
                <div class="mb-4" id="divEmployee2" style="display: none;">
                    <label for="cboEmployee2" class="form-label">Empleado:</label>
                    <select id="cboEmployee2" name="employee2" class="js-example-basic-single" style="width: 100%">
                        <?php
                            $query = "SELECT id, CONCAT(name1,' ',name2,' ',name3,' ',lastname1,' ',lastname2) as 'Empleado' FROM `employee`";       
                            $employee = $net_rrhh->prepare($query);  
                            $employee->execute();

                            while($data = $employee->fetch())
                            {
                                echo "<option value='$data[0]'>".utf8_encode($data[1])."</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="txtAssignation" class="form-label">Fecha de Asignación:</label>
                    <input type="date" class="form-control" id="txtAssignation" name="date_assignation">
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

    <button type="submit" id="btnForm" class="btn btn-primary d-block mx-auto">Guardar</button>
 
    <script>
        $(document).ready(function(){
            //Mostrar y ocultar campo de nueva asignación
            $("#rdAsignation1").on( 'change', function() {
                if ($(this).is(':checked')) {
                    $("#divAssignation").css("display", "block");
                }
            });
            $("#rdAsignation2").on( 'change', function() {
                if ($(this).is(':checked')) {
                    $("#divAssignation").css("display", "none");
                }
            });

            //Solo asignar empleado
            $("#rdType1").on( 'change', function() {
                if ($(this).is(':checked')) {
                    $("#divArea").css("display", "none");
                    $("#divEmployee1").css("display", "none");
                    $("#divEmployee2").css("display", "block");
                }
            });

            //Solo asignar área
            $("#rdType2").on( 'change', function() {
                if ($(this).is(':checked')) {
                    $("#divArea").css("display", "block");
                    $("#divEmployee1").css("display", "none");
                    $("#divEmployee2").css("display", "none");
                }
            });

            //Asignar Ambos
            $("#rdType3").on( 'change', function() {
                if ($(this).is(':checked')) {
                    $("#divArea").css("display", "block");
                    $("#divEmployee1").css("display", "block");
                    $("#divEmployee2").css("display", "none");
                }
            });

        });

        //Cargar Empleados en Select
        function loadEmployees(area) {
            if ($("#rdType3").is(':checked')) {
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
        }
    </script>

    <!-- Vista para eliminar activos -->
    <?php }else{ ?>

        <div class="mb-3">
            <p class="fs-5">¿Está seguro que desea eliminar el registro?</p>
            <p class="text-muted">Esta a punto de eliminar el registro: <?=$data[1]?> (<?=$data[2]?>)</p>
        </div>

        <button type="submit" id="btnForm" class="btn btn-danger">Eliminar</button>

    <?php } ?> 

</form>

