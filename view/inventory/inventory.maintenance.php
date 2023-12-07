<!-- HISTORIAL DE MANTENIMIENTOS -->
<?php include("../../config/net.php"); //Conexión con la BDD

    $id = $_REQUEST['id'];
    $action = $_REQUEST['action'];

    //Verificar acción del mantenimiento
    $action = ($action == 'add') ? "Add Maintenance" : "Update Maintenance";
    $lastmaintenanceP = "";
    $commentaryP = "";

    if(isset($_REQUEST['iu'])){

        $iu = "iu: ".$_REQUEST['iu'].", ";

        $query = "SELECT * FROM inventory_maintenance WHERE id = ".$_REQUEST['iu'];
        $maintenance = $net_rrhh->prepare($query);
        $maintenance->execute();
        $dataM = $maintenance->fetch();
    }

    if(isset($dataM)){

        $lastmaintenanceP = $dataM[1];
        $commentaryP = $dataM[2];

    }

?>

<!-- Pestañas de Navegación -->
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="maintenance-tab" data-bs-toggle="tab" data-bs-target="#maintenance-tab-pane" type="button" role="tab" aria-controls="maintenance-tab-pane" aria-selected="false">Mantenimiento</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history-tab-pane" type="button" role="tab" aria-controls="history-tab-pane" aria-selected="false">Historial</a>
    </li>
</ul>

<!-- Tablas de Contenido -->
<div class="tab-content" id="myTabContent">

    <!-- Agregar/Actualizar Mantenimiento -->
    <div class="tab-pane fade show active" id="maintenance-tab-pane" role="tabpanel" aria-labelledby="maintenance-tab" tabindex="0">
        <h3 class="my-3 text-center text-uppercase"><b>Mantenimiento</b></h3>

        <div class="mb-3">
            <label for="txtLastMaintenance" class="form-label">Última Fecha de Mantenimiento:</label>
            <input type="date" class="form-control" id="txtLastMaintenance" value="<?=$lastmaintenanceP;?>">
        </div>

        <div class="mb-3">
            <label for="txtCommentary" class="form-label">Comentario:</label>
            <textarea class="form-control" id="txtCommentary" rows="3"><?=$commentaryP;?></textarea>
        </div>
        
        <div class="text-center">
            <button type="button" id="btnMaintenance" class="btn btn-primary">Guardar</button>
        </div>
    </div>

    <!-- Historial de Mantenimiento -->
    <div class="tab-pane fade" id="history-tab-pane" role="tabpanel" aria-labelledby="history-tab" tabindex="0">
        <a href="view/inventory/inventory.maintenance.report.php?id=<?=$id?>" target="_blank" class="btn btn-success float-end">
            <i class="bi bi-file-earmark-spreadsheet"></i>
        </a>
        <h3 class="my-3 text-center text-uppercase"><b>Historial</b></h3>

        <table id="tableMaintenance">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Último Mantenimiento</th>
                    <th>Comentario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    //Imprimir historial de mantenimiento
                    $query = "SELECT * FROM inventory_maintenance WHERE active = $id";
                    $maintenance = $net_rrhh->prepare($query);
                    $maintenance->execute();
                    $i = 0;
                    
                    if($maintenance->rowCount() > 0) {

                        while($data = $maintenance->fetch()){

                            $i++;
                            echo "<tr>
                                    <td>$i</td>
                                    <td>$data[1]</td>
                                    <td>$data[2]</td>
                                    <td>
                                        <a role='button' class='btn btn-primary btn-sm' onclick='updateMaintenance($data[0])'>
                                            <i class='bi bi-pencil-square'></i>
                                        </a> 
                                        <a role='button' class='btn btn-danger btn-sm' onclick='deleteElement($data[0])'>
                                            <i class='bi bi-trash3-fill'></i>
                                        </a>
                                    </td>
                                </tr>";
                        }

                    }else{
                        echo "<tr>
                                <td class='text-danger text-center' colspan='4'>¡No existen registros para este activo!</td>
                                <td style='display: none;'></td>
                                <td style='display: none;'></td>
                                <td style='display: none;'></td>
                            </tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function(){

        //Inicializar DataTable
        $('#tableMaintenance').DataTable();
        
        //Agregar-Actualizar Mantenimiento
        $("#btnMaintenance").click(function(){
            $.post("view/inventory/process/index.php", 
            {                            
                process: 'inventory',
                action: '<?=$action?>',
                <?=$iu?>
                lastmaintenance: $("#txtLastMaintenance").val(),
                commentary: $("#txtCommentary").val(),
                active: <?=$id?>    
            },
            function(resultado)
            {
                if(resultado == false){
                    alert("Error");
                }
                else{ 
                    alert(resultado);  
                    $("#LoadForm").load("view/inventory/inventory.maintenance.php", { id : <?=$id?>, action: "add" });
                }
            });
        }); 

    });

    //Cargar vista para actualizar mantenimiento
    function updateMaintenance(id){
        $("#LoadForm").load("view/inventory/inventory.maintenance.php", { id : <?=$id?>, action : "update", iu: id});
    }

    //Eliminar Mantenimiento
    function deleteElement(id){
        if(confirm('Desea realmente eliminar el registro?'))
        {
            $.post("view/inventory/process/index.php", 
                { 
                    process: 'inventory',
                    action: 'Delete Maintenance',
                    id: id
                },
                function(response){
                    alert(response);  
                    $("#LoadForm").load("view/inventory/inventory.maintenance.php", { id : <?=$id?>, action: "add" });
                }
            );
        }
    };
</script>