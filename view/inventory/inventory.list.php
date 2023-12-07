<!-- LISTADO DE ACTIVOS -->
<?php include("../../config/net.php"); //Conexión con la BDD ?>

<!-- Imprimir listado de activos -->
<table id="tableInventory" class="table table-hover mb-5">
    <thead>
        <tr>
            <th class="border"></th>
            <th class="border border-dark" colspan="3">Datos de Asignación</th>
            <th class="border border-dark" colspan="8">Datos del Activo</th>
            <th class="border"></th>
        </tr>
        <tr>
            <th>#</th>
            <th>Empleado</th>
            <th>Área</th>
            <?php if($_REQUEST['loan'] != "All"){ ?>
                <th>Fecha de Asignación</th>
            <?php }else{ ?>
                <th>Retornado</th>
            <?php } ?>
            <th>Tipo</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Activo Fijo</th>
            <th>MAC</th>
            <th>Serial</th>
            <th>Licencia</th>
            <th>Estado de Activo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>

    <?php 
    $ia = '';
    $dateR = '';
    $stateE = '';

    //Cargar listado de activos
    $query = "SELECT ia.id, ct.value as 'Tipo', cb.value as 'Marca',  ia.model, ia.fixedasset, ia.mac, ia.serial, cs.value, ia.license as 'Estado'
            FROM `inventory_active` as ia 
            INNER JOIN catalogue as ct ON ia.type = ct.id AND ct.type = 'Tipo'
            INNER JOIN catalogue as cb ON ia.brand = cb.id AND cb.type = 'Marca'
            INNER JOIN catalogue as cs ON ia.status = cs.id AND cs.type = 'Estado'";
    $Inventory = $net_rrhh->prepare($query); 
    $Inventory->execute();  

    //Validar existencias
    if($Inventory->rowCount() > 0)
    {
        //Imprimir resultados
        $i = 0;
        while($data = $Inventory->fetch())
        {
            $i++;
            echo "<tr>
                    <td>$i</td>";

            //Cargar última asignación al activo
            $query = "SELECT * FROM `inventory_assignation` WHERE active = $data[0] ORDER BY id DESC LIMIT 1";              
            $lastA = $net_rrhh->prepare($query);
            $lastA->execute();

            //Verificación de existencia
            if($lastA->rowCount() > 0){

                $dataL = $lastA->fetch();

                //Cargar Empleado (Si existe)
                if($dataL[1] != ""){
                    $query = "SELECT * FROM `employee` WHERE id = $dataL[1]";              
                    $employee = $net_rrhh->prepare($query);
                    $employee->execute();
                    $dataE = $employee->fetch();
                    echo utf8_encode("<td>$dataE[1] $dataE[2] $dataE[4] $dataE[5]</td>");
                }else{
                    echo "<td class='text-danger'>(Sin Asignación a Empleado)</td>";
                }

                //Cargar Área (Si existe)
                if($dataL[2] != ""){
                    $query = "SELECT * FROM `workarea` WHERE id = $dataL[2]";              
                    $area = $net_rrhh->prepare($query);
                    $area->execute();
                    $dataA = $area->fetch();
                    echo "<td>$dataA[1]</td>";
                }else{
                    echo "<td class='text-danger'>(Sin Asignación a Área)</td>";
                }

                //Mostrar fecha de asignación o retorno según filtro
                if($_REQUEST['loan'] != "All"){
                    echo "<td>$dataL[3]</td>";
                }else{
                    echo $disp = ($dataL[4] == "") ? "<td class='text-success'>En uso</td>" : "<td class='text-danger'>$dataL[4]</td>";
                }

                $ia = $dataL[0];
                $dateR = $dataL[4];
                $stateE = $dataL[1];

            }else{
                echo "<td class='text-center border border-danger' colspan='3'>(Sin Asignación)</td>
                        <td style='display: none;'></td>
                        <td style='display: none;'></td>";
            }

            echo "<td>$data[1]</td>
                <td>$data[2]</td>
                <td>$data[3]</td>
                <td>$data[4]</td>
                <td>$data[5]</td>
                <td>$data[6]</td>
                <td>$data[8]</td>
                <td>$data[7]</td>
                <td>
                        <div class='dropdown'>
                            <a class='btn btn-primary btn-sm dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                Acciones
                            </a>
                            <ul class='dropdown-menu'>
                                <li>
                                    <a class='dropdown-item text-success' href='#' data-bs-toggle='modal' data-bs-target='#modal' onclick='loadAssignation($data[0])'>
                                        <i class='bi bi-clipboard-fill'></i> Asignaciones
                                    </a>
                                </li>
                                <li>
                                    <a class='dropdown-item text-secondary' href='#' data-bs-toggle='modal' data-bs-target='#modal' onclick='loadMaintenance($data[0])'>
                                        <i class='bi bi-gear-fill'></i> Mantenimientos
                                    </a>
                                </li>
                                <li>
                                    <a class='dropdown-item text-primary' href='#' data-bs-toggle='modal' data-bs-target='#modal' onclick='active(\"update\", $data[0])'>
                                        <i class='bi bi-pencil-square'></i> Editar
                                    </a>
                                </li>
                                <li>
                                    <a class='dropdown-item text-danger' href='#' data-bs-toggle='modal' data-bs-target='#modal' onclick='active(\"delete\", $data[0])'>
                                        <i class='bi bi-trash3-fill'></i> Eliminar
                                    </a>
                                </li>
                                <li>
                                    <a class='dropdown-item text-secondary' href='#' data-bs-toggle='modal' data-bs-target='#modal' onclick='loadExtra($data[0])'>
                                        <i class='bi bi-list'></i> Complementos
                                    </a>
                                </li>";
                                if($stateE != '' && $dateR == ""){
                                    echo "<li>
                                            <a class='dropdown-item text-secondary' href='#' data-bs-toggle='modal' data-bs-target='#modal' onclick='loadDocuments($ia)'>
                                                <i class='bi bi-file-earmark-fill'></i> Documentos
                                            </a>
                                        </li>";
                                }
                    echo    "</ul>
                        </div>
                    </td>
                </tr>";
        }
    }else{
        echo "<tr>
                <td colspan='10' class='text-center'>
                    No hay registros guardados
                </td>
                <td style='display: none;'></td>
                <td style='display: none;'></td>
                <td style='display: none;'></td>
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

<script>
    //Cargar DataTable
     $('#tableInventory').DataTable();
</script>