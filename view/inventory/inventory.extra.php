<!-- INFORMACIÓN EXTRA DEL ACTIVO -->
<?php include("../../config/net.php"); //Conexión con la BDD

    $ida = $_REQUEST['ida'];

    //Cargar información del activo
    $query = "Select * from inventory_active where id = $ida";              
    $active = $net_rrhh->prepare($query);
    $active->execute();   
    $dataA = $active->fetch();
?>

<!-- Pestañas de Navegación -->
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="localization-tab" data-bs-toggle="tab" data-bs-target="#localization-tab-pane" type="button" role="tab" aria-controls="localization-tab-pane" aria-selected="false">Localización en la Red</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="extra-tab" data-bs-toggle="tab" data-bs-target="#extra-tab-pane" type="button" role="tab" aria-controls="extra-tab-pane" aria-selected="false">Extra</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="resource-tab" data-bs-toggle="tab" data-bs-target="#resource-tab-pane" type="button" role="tab" aria-controls="resource-tab-pane" aria-selected="false">Recurso Tecnológico</a>
    </li>
</ul>

<!-- Tablas de Contenido -->
<div class="tab-content" id="myTabContent">

    <!-- Localización de Dispositivo en la Red -->
    <div class="tab-pane fade show active" id="localization-tab-pane" role="tabpanel" aria-labelledby="localization-tab" tabindex="0">
        <h3 class="my-3 text-center text-uppercase"><b>Localización de Dispositivo en la Red</b></h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Dirección IP</th>
                    <th>Dirección MAC</th>
                    <th>Nombre del Equipo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <input type="text" id="ip" class="form-control" value="<?=$dataA[7]?>">
                    </td>
                    <td>
                        <input type="text" id="mac" class="form-control" value="<?=$dataA[8]?>">
                    </td>
                    <td>
                        <input type="text" id="device" class="form-control" value="<?=$dataA[9]?>">
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="text-center">
            <button type="button" id="btnLocalization" class="btn btn-primary">Guardar</button>
        </div>
    </div>

    <!-- Información Extra -->
    <div class="tab-pane fade" id="extra-tab-pane" role="tabpanel" aria-labelledby="extra-tab" tabindex="0">
    <h3 class="my-3 text-center text-uppercase"><b>Extra</b></h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Detalles</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <textarea class="form-control" name='details' id="details" rows="3" maxlength="250"><?=$dataA[10]?></textarea>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="text-center">
            <button type="button" id="btnExtra" class="btn btn-primary">Guardar</button>
        </div>
    </div>

    <!-- Recursos Tecnológicos -->
    <div class="tab-pane fade" id="resource-tab-pane" role="tabpanel" aria-labelledby="resource-tab" tabindex="0">
        <h3 class="my-3 text-center text-uppercase"><b>Recursos Tecnológicos</b></h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Chequeo de Revisión</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <input type="date" id="revision" class="form-control" value="<?=$dataA[11]?>">
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="text-center">
            <button type="button" id="btnResource" class="btn btn-primary">Guardar</button>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

        //Agregar-Actualizar Localización de Red
        $("#btnLocalization").click(function(){
            $.post("view/inventory/process/index.php", 
            {                            
                process: 'inventory',
                action: 'Update Localization',
                ip: $("#ip").val(),
                mac: $("#mac").val(),
                device: $("#device").val(),
                ida: <?=$ida?>    
            },
            function(resultado)
            {
                if(resultado == false){
                    alert("Error");
                }
                else{ 
                    alert(resultado);  
                    $("#LoadForm").load("view/inventory/inventory.extra.php", { ida : <?=$ida?> });
                    $('#inventoryList').load('view/inventory/inventory.list.php',{
                        loan: $('#cboLoan').val()
                    });
                }
            });
        }); 

        //Agregar-Actualizar Información Extra
        $("#btnExtra").click(function(){
            $.post("view/inventory/process/index.php", 
            {                            
                process: 'inventory',
                action: 'Update Extra',
                details: $("#details").val(),
                ida: <?=$ida?>    
            },
            function(resultado)
            {
                if(resultado == false){
                    alert("Error");
                }
                else{ 
                    alert(resultado);  
                    $("#LoadForm").load("view/inventory/inventory.extra.php", { ida : <?=$ida?> });
                }
            });
        }); 

        //Agregar-Actualizar Recursos Tecnológicos
        $("#btnResource").click(function(){
            $.post("view/inventory/process/index.php", 
            {                            
                process: 'inventory',
                action: 'Update Resource',
                revision: $("#revision").val(),
                ida: <?=$ida?>    
            },
            function(resultado)
            {
                if(resultado == false){
                    alert("Error");
                }
                else{ 
                    alert(resultado);  
                    $("#LoadForm").load("view/inventory/inventory.extra.php", { ida : <?=$ida?> });
                }
            });
        });

                                      
    })   
</script>