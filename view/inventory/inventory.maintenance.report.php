<!-- GENERAR REPORTE DE MANTENIMIENTO -->
<?php include("../../config/net.php"); //Conexión con la BDD

$id = $_REQUEST['id'];

//Cabeceras para generar archivo .xls
header("Content-Type: application/vnd.ms-excel; charset=iso-8859-1");
header("Content-Disposition: attachment; filename=Historial_de_Mantenimientos.xls");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);

?>
<style>
    table, td, th {
        border: 1px solid;
        width: 100%;
    }
</style>
<br>
<h1>HISTORIAL DE MANTENIMIENTOS</h1>
<br>
<?php
    //Cargar Datos del Activo
    $query = "SELECT * FROM inventory_active WHERE id = $id";
    $active = $net_rrhh->prepare($query);
    $active->execute();
    $dataAc = $active->fetch();

    $query = "SELECT * FROM catalogue WHERE id = $dataAc[2] and type LIKE '%Tipo%'";              
    $type = $net_rrhh->prepare($query);
    $type->execute();
    $dataT = $type->fetch();

    $query = "SELECT * FROM catalogue WHERE id = $dataAc[3] and type LIKE '%Marca%'";              
    $brand = $net_rrhh->prepare($query);
    $brand->execute();
    $dataB = $brand->fetch();

    $query = "SELECT * FROM catalogue WHERE id = $dataAc[6] and type LIKE '%Estado%'";              
    $status = $net_rrhh->prepare($query);
    $status->execute();
    $dataS = $status->fetch();
?>

<h3>Datos del Activo</h3>
<table>
    <tr>
        <td><b>Tipo: </b></td>
        <td><?= $dataT[2]; ?></td>
    </tr>
    <tr>
        <td><b>Marca: </b></td>
        <td><?= $dataB[2]; ?></td>
    </tr>
    <tr>
        <td><b>Modelo: </b></td>
        <td><?= $dataAc[4]; ?></td>
    </tr>
    <tr>
        <td><b>Estado: </b></td>
        <td><?= $dataS[2]; ?></td>
    </tr>
</table>

<br/>

<h3>Historial de Mantenimientos</h3>
<table class="table">
    <thead>
        <tr>
            <th><?=utf8_decode("N°")?></th>
            <th>&Uacute;ltimo Mantenimiento</th>
            <th>Comentario</th>
        </tr>
    </thead>
    <tbody>
    <?php
        //Imprimir Mantenimientos del Activo
        $query = "SELECT * FROM inventory_maintenance WHERE active = $id";
        $maintenance = $net_rrhh->prepare($query);
        $maintenance->execute();
        $i=0;
        
        if($maintenance->rowCount() > 0) {

            while($data = $maintenance->fetch()){

                $i++;
                echo "<tr>
                        <td>$i</td> 
                        <td>$data[1]</td>
                        <td>$data[2]</td>
                    </tr>";
            }

        }else{
            echo "<tr>
                    <td class='text-danger text-center' colspan='3'>¡No existen registros para este activo!</td>
                </tr>";
        }
    ?>
    </tbody>
</table>
