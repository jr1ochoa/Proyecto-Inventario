<!-- HISTORIAL DE ASIGNACIONES -->
<?php include("../../config/net.php"); //Conexión con la BDD

    $id = $_REQUEST['id'];
    $action = $_REQUEST['action'];
    $idDoc = (isset($_REQUEST['idd'])) ? $_REQUEST['idd'] : "";

    //Verificar la acción
    $action = ($action == 'add') ? "Add Assignment" : "Update Assignment";
    $assetP = "";
    $areaP = "";
    $employeeP = "";
    $employeeValue = "";
    $assignationP = "";
    $returnP = "";
    $stateP = "";

    if(isset($_REQUEST['iu'])){

        $iu = "iu: ".$_REQUEST['iu'].", ";

        $query = "SELECT * FROM inventory_assignation WHERE id = ".$_REQUEST['iu'];
        $history = $net_rrhh->prepare($query);
        $history->execute();
        $dataH = $history->fetch();
    }

    if(isset($dataH)){

        //Cargar datos del empleado
        $query = "SELECT * FROM employee WHERE id = $dataH[1]";
        $employee = $net_rrhh->prepare($query);
        $employee->execute();
        $dataE = $employee->fetch();

        $areaP = $dataH[2];
        $employeeP = $dataE[1]." ".$dataE[2]." ".$dataE[3]." ".$dataE[4]." ".$dataE[5];
        $employeeValue = $dataE[0];
        $assignationP = $dataH[3];
        $returnP = $dataH[4];
        $stateP = $dataH[5];
    }

?>

<style>
    .select2-container--open .select2-dropdown {
        z-index: 1070;
    }
</style>

<div id="tabAd">
    <!-- Pestañas de navegación --> 
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="assignment-tab" data-bs-toggle="tab" data-bs-target="#assignment-tab-pane" type="button" role="tab" aria-controls="assignment-tab-pane" aria-selected="true">Asignación</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history-tab-pane" type="button" role="tab" aria-controls="history-tab-pane" aria-selected="false">Historial</a>
        </li>
    </ul>

    <!-- Tabla de Contenido -->
    <div class="tab-content" id="myTabContent">

        <!-- Historial de Asignaciones -->

        <div class="tab-pane fade" id="history-tab-pane" role="tabpanel" aria-labelledby="history-tab" tabindex="0">
            <a href="view/inventory/inventory.assignation.report.php?id=<?=$id?>" target="_blank" class="btn btn-success float-end">
                <i class="bi bi-file-earmark-spreadsheet"></i>
            </a>
            <h3 class="my-3 text-center text-uppercase"><b>Historial</b></h3>
 
            <table id="tableHistory">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Empleado</th>
                        <th>Área</th>
                        <th>Fecha de Asignación</th>
                        <th>Fecha de Devolución</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        //Imprimir listado de asignaciones
                        $query = "SELECT * FROM inventory_assignation WHERE active = $id";
                        $assignations = $net_rrhh->prepare($query);
                        $assignations->execute();
                        $i = 0;

                        $loan = false;
                        
                        if($assignations->rowCount() > 0) {

                            while($data = $assignations->fetch()){

                                //Cargar datos del empleado
                                $query = "SELECT * FROM employee WHERE id = $data[1]";
                                $employee = $net_rrhh->prepare($query);
                                $employee->execute();
                                $dataE = $employee->fetch();

                                //Cargar datos del área
                                $query = "SELECT * FROM workarea WHERE id = $data[2]";
                                $area = $net_rrhh->prepare($query);
                                $area->execute();
                                $dataA = $area->fetch();

                                $i++;
                                echo "<tr>
                                        <td>$i</td>
                                        <td>".utf8_encode($dataE[1]." ".$dataE[4])."</td>
                                        <td>".utf8_encode($dataA[1])."</td>
                                        <td>$data[3]</td>
                                        <td>";

                                        if($data[4] == ""){
                                            echo "(Sin retornar)";
                                            $loan = true;
                                        }else
                                            echo $data[4];

                                echo "</td>
                                        <td>$data[5]</td>
                                        <td>
                                            <div class='dropdown'>
                                                <a class='btn btn-primary btn-sm dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                                    Acciones
                                                </a>
                                            
                                                <ul class='dropdown-menu'>
                                                    <li>
                                                        <a class='dropdown-item text-primary' href='#' onclick='updateHistory($data[0])'>
                                                            <i class='bi bi-pencil-square'></i> Editar
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class='dropdown-item text-danger' href='#' onclick='deleteElement($data[0])'>
                                                            <i class='bi bi-trash3-fill'></i> Eliminar
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class='dropdown-item text-secondary' href='#' onclick='documents($data[0])'>
                                                            <i class='bi bi-file-earmark-fill'></i> Documentos
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            
                                        </td>
                                    </tr>";
                            }

                        }else{
                            echo "<tr>
                                    <td class='text-danger text-center' colspan='7'>¡No existen registros para este activo!</td>
                                    <td style='display: none;'></td>
                                    <td style='display: none;'></td>
                                    <td style='display: none;'></td>
                                    <td style='display: none;'></td>
                                    <td style='display: none;'></td>
                                    <td style='display: none;'></td>
                                </tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Nueva Asignación -->

        <div class="tab-pane fade show active" id="assignment-tab-pane" role="tabpanel" aria-labelledby="assignment-tab" tabindex="0">
            <h3 class="mb-3 mt-4 text-center text-uppercase"><b>Asignación de Activo</b></h3>
            
            <!-- Si el activo se encuentra libre -->
            <?php if($loan == false || isset($_REQUEST['iu'])){ ?>
            <div class="mx-4">
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
                        <option value="<?=($employeeValue == "") ? "" : $employeeValue?>"><?=($employeeP == "") ? "" : utf8_encode($employeeP)?></option>
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
                                $selected = ($employeeValue == $data[0]) ? "selected" : "";
                                echo "<option value='$data[0]' $selected>".utf8_encode($data[1])."</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="txtAssignation" class="form-label">Fecha de Asignación:</label>
                    <input type="date" class="form-control" id="txtAssignation" value="<?=$assignationP;?>">
                </div>

                <?php if(isset($_REQUEST['iu'])){ ?>
                <div class="mb-4">
                    <label for="txtReturn" class="form-label">Fecha de Devolución:</label>
                    <input type="date" class="form-control" id="txtReturn" value="<?=$returnP;?>">
                </div>

                <div class="mb-4">
                    <label for="cboState" class="form-label">Estado:</label>
                    <select class="form-select" aria-label="Default select example" id="cboState">
                        <?php
                            $array = array("", "En Prestamo", "Entregado");
                            foreach($array as $value){
                                $selected = ($value == $stateP) ? "selected" : "";
                                echo "<option value='$value' $selected>$value</option>";
                            }
                        ?>
                    </select>
                </div>
                <?php } ?>

            </div>
                
            <div class="text-center">
                <button type="button" id="btnAssignment" class="btn btn-primary">Asignar</button>
            </div>

            <!-- Si el activo se encuentra asignado -->
            <?php }else{ 
                
                $query = "SELECT a.id, CONCAT(e.name1, ' ', e.name2, ' ', e.lastname1, ' ', e.lastname2) as 'Empleado' FROM inventory_assignation as a 
                INNER JOIN employee as e ON e.id = a.employee
                WHERE active = $id AND state = 'En Prestamo';";
                $assignation = $net_rrhh->prepare($query);  
                $assignation->execute();

                $dataR = $assignation->fetch();
            ?>
            <input type="hidden" id="idAssignation" name="idAssignation" value="<?=$dataR[0]?>">
            <p class="fs-5 p-4 text-center">
                El equipo actualmente se encuentra asignado a <span class="text-primary"><?=utf8_encode($dataR[1])?></span>, si desea realizar una nueva asignación, haga click acá
            </p>
            <button type="button" id="btnFinish" class="btn btn-danger d-block mx-auto mb-3">Finalizar Préstamo</button>
            <?php } ?>
        </div>

    </div>
</div>

<!-- Documentos de Asignaciones -->

<div id="tabDocs" style="display: none;">
    <a role='button' class='btn btn-secondary btn-sm float-start' id="btnReturn">
        <i class="bi bi-caret-left-fill"></i>
    </a>

    <!-- Formulario para subir archivos -->
    <p class="fs-5 text-center text-uppercase mb-3">Subir Archivos</p>
    <div class="mb-3">
        <label for="cboType" class="form-label">Tipo de Documento:</label>
        <select class="form-select" id="cboType" aria-label="Default select example">
            <option></option>
            <option value="Memorándum de Entrega">Memorándum de Entrega</option>
            <option value="Descargar">Descargar</option>
            <option value="Préstamo">Préstamo</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="txtFile" class="form-label">Seleccione un archivo:</label>
        <input class="form-control" type="file" id="txtFile" accept=".doc,.docx, .pdf">
    </div>
    <button class="btn btn-success mb-5 d-block mx-auto" id="btnFiles">Subir</button>

    <!-- Listado de Documentos -->
    <p class="fs-5 text-center mb-3 text-uppercase">Documentos</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Tipo de Documento</th>
                <th>Documento</th>
                <th>Archivo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $query = "SELECT * FROM inventory_files where assignation = $idDoc";
                $docs = $net_rrhh->prepare($query);
                $docs->execute();
                $cont = 0;

                if ($docs->rowCount() > 0) {
                    while($dataD = $docs->fetch()) {
                        $cont++;
                        echo "<tr>
                                <td>$cont</td>
                                <td>$dataD[1]</td>
                                <td>
                                    <a href='process/documents/$dataD[2]' target='_blank' rel='noopener noreferrer'>Descargar</a>
                                </td>    
                                <td>$dataD[3]</td>
                                <td>
                                    <a role='button' class='btn btn-danger btn-sm' onclick='deleteFile($dataD[0])'>
                                        <i class='bi bi-trash3-fill'></i>
                                    </a>
                                </td>
                            </tr>";
                    }
                }else{
                    echo "<tr>
                            <td class='text-danger text-center' colspan='5'>¡No hay documentos para esta asignación!</td>
                        </tr>";
                }
            ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function(){

        //Habilitar vista de documentos
        <?php if(isset($_REQUEST['idd'])){ ?>
            $("#tabAd").css("display","none");
            $("#tabDocs").css("display","block");
        <?php } ?>

        //Activar pestaña de edición
        <?php if(isset($_REQUEST['iu'])){ ?>
            $("#history-tab-pane").attr("class", "tab-pane fade");
            $("#assignment-tab-pane").attr("class", "tab-pane fade show active");
            $("#history-tab").attr("class", "nav-link");
            $("#assignment-tab").attr("class", "nav-link active");
        <?php } ?>

        //Activar DataTable
        $('#tableHistory').DataTable();

        //Inicializar select2
        $('#cboEmployee').select2({
            dropdownParent: $('#modal .modal-body')
        });

        //Inicializar select2
        $('#cboEmployee2').select2({
            dropdownParent: $('#modal .modal-body')
        });

        //Inicializar select2
        $('#cboArea').select2({
            dropdownParent: $('#modal .modal-body')
        });
        
        //Regresar a la vista de asignaciones
        $("#btnReturn").click(function(){
            $("#tabAd").css("display","block");
            $("#tabDocs").css("display","none");
        });

        //Dar por finalizado la etapa de prestamo de activo
        $("#btnFinish").click(function(){
            $.post("view/inventory/process/index.php", 
            {                            
                process: 'inventory',
                action: 'return',
                ia: $("#idAssignation").val()
            },
            function(resultado)
            {
                if(resultado == false){
                    alert("Error");
                }
                else{ 
                    alert(resultado);  
                    $("#LoadForm").load("view/inventory/inventory.assignation.php", { id : <?=$id?>, action: "add" });
                    $("#btnAssignment").text("Asignar");
                    $('#inventoryList').load('view/inventory/inventory.list.php',{
                        loan: "All"
                    });
                }
            });
        });

        //Agregar-Actualizar Asignación
        $("#btnAssignment").click(function(){ 
            $.post("view/inventory/process/index.php", 
            {                            
                process: 'inventory',
                action: '<?=$action?>',
                <?=$iu?>
                employee: $("#cboEmployee option:selected").val(),
                employee2: $("#cboEmployee2 option:selected").val(),
                selection: $('input[name=selection]:checked').val(),
                area: $("#cboArea option:selected").val(),
                date_assignation: $("#txtAssignation").val(),
                date_return: $("#txtReturn").val(),
                state: $("#cboState").val(),
                active: <?=$id?>
            },
            function(resultado)
            {
                if(resultado == false){
                    alert("Error");
                }
                else{ 
                    alert(resultado);  
                    $("#LoadForm").load("view/inventory/inventory.assignation.php", { id : <?=$id?>, action: "add" });
                    $("#btnAssignment").text("Asignar");
                    $('#inventoryList').load('view/inventory/inventory.list.php',{
                        loan: "All"
                    });
                }
            });

        }); 

        //Agregar Documento
        $("#btnFiles").click(function(){ 

            var form_data = new FormData();
            var file_data = $("#txtFile").prop("files")[0];

            form_data.append("file", file_data);
            form_data.append("process", "inventory");
            form_data.append("action", "Add File");
            form_data.append("type", $("#cboType option:selected").val());
            form_data.append("assignation", "<?=$idDoc?>");

            console.log(form_data);

            $.ajax({
                cache: false,
                contentType: false,
                data: form_data,
                enctype: 'multipart/form-data',
                processData: false,
                method: "POST",
                url: "view/inventory/process/index.php",
                success: function (data) {
                    alert(data);
                    $("#LoadForm").load("view/inventory/inventory.assignation.php", { id : <?=$id?>, action: "add", idd: "<?=$idDoc?>"});
                }
            });
        }); 
    });

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

    //Cargar formulario de actualización
    function updateHistory(id){
        $("#LoadForm").load("view/inventory/inventory.assignation.php", { id : <?=$id?>, action : "update", iu: id});
    }

    //Eliminar asignación
    function deleteElement(id){
        if(confirm('Desea realmente eliminar el registro?'))
        {
            $.post("view/inventory/process/index.php", 
                { 
                    process: 'inventory',
                    action: 'Delete Assignment',
                    id: id
                },
                function(response){
                    alert(response);  
                    $("#LoadForm").load("view/inventory/inventory.assignation.php", { id : <?=$id?>, action: "add" });
                }
            );
        }
    };

    //Eliminar documento
    function deleteFile(id){
        if(confirm('Desea realmente eliminar el archivo?'))
        {
            $.post("view/inventory/process/index.php", 
                { 
                    process: 'inventory',
                    action: 'Delete File',
                    id: id
                },
                function(response){
                    alert(response);  
                    $("#LoadForm").load("view/inventory/inventory.assignation.php", { id : <?=$id?>, action: "add", idd: "<?=$idDoc?>"});
                }
            );
        }
    };

    //Cargar vista de documentos
    function documents(idd){
        $("#LoadForm").load("view/inventory/inventory.assignation.php", { id : <?=$id?>, action: "add", idd: idd });
    }
</script>