<?php

if(isset($_REQUEST["pst"])){
    $position = $_REQUEST["pst"];

    $query = "SELECT p.id, p.position, a.contrat, a.financing, e.name1, e.name2, e.name3, e.lastname1, e.lastname2 
    FROM workarea_positions AS p 
    LEFT JOIN workarea_positions_assignment AS a ON p.id = a.idposition AND a.enddate = '0000-00-00'
    LEFT JOIN employee AS e ON a.idemployee = e.id 
    WHERE p.idarea = $position  ";

    
    $positionArea = $net_rrhh->prepare($query);  
    $positionArea->execute();
?>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>

<style>
a
{
    text-decoration: none;
    cursor: pointer;
}
</style>

<table id="UserTable" class="display" style="width:100%">
<thead>
    <tr>
        <th>Id</th>
        <th>Cargo</th>
        <th>Contrato</th>
        <th>Financiamiento</th>
        <th>Empleado</th>
        <th></th>
    </tr>
</thead>
<tbody>
<?php

    while($data = $positionArea->fetch())
    {                    
        echo "<tr>
                <td>$data[0]</td>
                <td>$data[1]</td>
                <td>$data[2]</td> 
                <td>$data[3]</td>
                <td>". utf8_encode($data[4]." ".$data[5]." ".$data[6]." <br/> ".$data[7]." ".$data[8])."</td>
                <td>
                    <div class='dropdown'>
                        <a class='btn btn-primary dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                            Acciones
                        </a>
                        <ul class='dropdown-menu'>
                            <li><a class='dropdown-item' href='?view=area&pp=$data[0]'>Perfil</a></li>
                            <li><a class='dropdown-item' href='#' data-bs-toggle='modal' data-bs-target='#FormModal' onclick='editPosition($data[0], $position, \"edit\")'>Editar</a></li>
                            <li><a class='dropdown-item' href='#' href='#' data-bs-toggle='modal' data-bs-target='#FormModal' onclick='editPosition($data[0], $position, \"area\")'>Cambiar de &Aacute;rea</a></li>
                        </ul>
                    </div>
                </td>
                </tr>";
    }

    ?>
</tbody>
</table>
<?php
    }else{
        echo '<p>No se han encontrado resultados</p>';
    }
?>
