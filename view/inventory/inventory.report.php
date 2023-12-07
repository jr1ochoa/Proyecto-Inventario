<!-- REPORTE DE ACTIVOS -->
<?php include("../../config/net.php"); //Conexión con la BDD

//Cabeceras para generar archivo .xls
header("Content-Type: application/vnd.ms-excel; charset=iso-8859-1");
header("Content-Disposition: attachment; filename=Reporte_Inventario.xls");
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
<h1>GESTI&Oacute;N DE INVENTARIO</h1>
<br>

<table class="table">
    <thead>
        <tr>
            <th colspan='6'>Informaci&oacute;n del Activo</th>
            <th colspan='3'>Localizaci&oacute;n en Red</th>
            <th>Recurso Tecnol&oacute;gico</th>
            <th>Extra</th>
        </tr>
        <tr>
            <th>Descripci&oacute;n</th>
            <th>Tipo</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Serial</th>
            <th>Estado</th>
            <th>IP</th>
            <th>MAC</th>
            <th>Nombre del Equipo</th>
            <th>&Uacute;ltima Revisi&oacute;n</th>
            <th>Detalles</th>
        </tr>
    </thead>
    <tbody>
        <?php
            //Imprimir listado de activos
            $query = 'SELECT * FROM inventory_active';
            $actives = $net_rrhh->prepare($query);
            $actives->execute();
            while ($dataA = $actives->fetch()) {

                $query = "SELECT * FROM catalogue WHERE id = $dataA[2] and type LIKE '%Tipo%'";              
                $type = $net_rrhh->prepare($query);
                $type->execute();
                $dataT = $type->fetch();

                $query = "SELECT * FROM catalogue WHERE id = $dataA[3] and type LIKE '%Marca%'";              
                $brand = $net_rrhh->prepare($query);
                $brand->execute();
                $dataB = $brand->fetch();

                $query = "SELECT * FROM catalogue WHERE id = $dataA[6] and type LIKE '%Estado%'";              
                $status = $net_rrhh->prepare($query);
                $status->execute();
                $dataS = $status->fetch();

                echo "<tr>
                        <td>$dataA[1]</td>
                        <td>$dataT[2]</td>
                        <td>$dataB[2]</td>
                        <td>$dataA[4]</td>
                        <td>$dataA[5]</td>
                        <td>$dataS[2]</td>
                        <td>$dataA[7]</td>
                        <td>$dataA[8]</td>
                        <td>$dataA[9]</td>
                        <td>$dataA[10]</td>
                        <td>$dataA[11]</td>
                    </tr>";
            }
        ?>
    </tbody>
</table>
