<!-- PERFIL DE ASIGNACIONES -->

<?php include("../../config/net.php"); //Conexión a la BDD

    $id = $_REQUEST["id"];

    //Asignaciones
    $query = "SELECT a.*, w.area FROM inventory_assignation as a
    INNER JOIN workarea as w ON w.id = a.area
    WHERE a.id = $id";
    $assignations = $net_rrhh->prepare($query);
    $assignations->execute();
    $data = $assignations->fetch();

    //Activo
    $query = "SELECT a.id, ct.value as 'tipo', cb.value as 'marca', a.model, cs.value as 'estado', a.fixedasset FROM inventory_active as a
            INNER JOIN catalogue as ct ON ct.id = a.type
            INNER JOIN catalogue as cb ON cb.id = a.brand
            INNER JOIN catalogue as cs ON cs.id = a.status
            WHERE a.id = " . $data[6];
    $active = $net_rrhh->prepare($query);
    $active->execute();
    $dataA = $active->fetch();

?>

<h2 class="text-center text-uppercase">Detalles</h2>
<hr/>

<p class="fs-5 text-center mb-3"><i class="bi bi-clipboard-check" style="font-size: 1.5rem;"></i> Asignación</p>
<div class="card mb-3">
    <div class="card-body">
        <table>
            <tr>
                <td><b>Área: </b></td>
                <td><?=utf8_encode($data[7])?></td>
            </tr>
            <tr>
                <td><b>Fecha de Asignación: </b></td>
                <td><?=$data[3]?></td>
            </tr>
            <tr>
                <td><b>Fecha de Retorno: </b></td>
                <td><?= $echo = ($data[4] == "") ? "(Sin Retorno)" : $data[4]?></td>
            </tr>
            <tr>
                <td><b>Estado: </b></td>
                <td><?=$data[5]?></td>
            </tr>
        </table>
    </div>
</div>

<p class="fs-5 text-center mb-3"><i class="bi bi-laptop" style="font-size: 1.5rem;"></i> Activo</p>
<div class="card mb-3">
    <div class="card-body">
        <table>
            <tr>
                <td><b>Activo Fijo: </b></td>
                <td><?=utf8_encode($dataA[5])?></td>
            </tr>
            <tr>
                <td><b>Tipo: </b></td>
                <td><?=utf8_encode($dataA[1])?></td>
            </tr>
            <tr>
                <td><b>Marca: </b></td>
                <td><?=utf8_encode($dataA[2])?></td>
            </tr>
            <tr>
                <td><b>Modelo: </b></td>
                <td><?=$dataA[3]?></td>
            </tr>
            <tr>
                <td><b>Estado: </b></td>
                <td><?=$dataA[4]?></td>
            </tr>
        </table>
    </div>
</div>

<p class="fs-5 text-center mb-3">
    <i class="bi bi-file-earmark-text-fill" style="font-size: 1.5rem;"></i> Documentos
</p>
<div class="card">
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tipo de Documento</th>
                    <th>Documento</th>
                    <th>Archivo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    //Asignaciones
                    $query = "SELECT * FROM inventory_files WHERE assignation = $id";
                    $files = $net_rrhh->prepare($query);
                    $files->execute();
                    $i = 0;

                    if ($files->rowCount() > 0) {
                        while($dataF = $files->fetch()) {
                            $i++;
                            echo "<tr>
                                    <td>$i</td>
                                    <td>$dataF[1]</td>
                                    <td>
                                        <a href='process/documents/$dataF[2]' target='_blank' rel='noopener noreferrer'>Descargar</a>
                                    </td>    
                                    <td>$dataF[3]</td>
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
</div>
