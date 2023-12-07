<?php

$query = "SELECT * FROM workarea where visible = 1";
$workarea = $net_rrhh->prepare($query);  
$workarea->execute();

?>

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
        <th>Área</th>
        <th>Tag</th>
        <th>Visibilidad</th>
        <th>Cargos</th>
        <th></th>
        <th></th>
    </tr>
</thead>
<tbody>
<?php

    while($data = $workarea->fetch())
    {                    
        echo utf8_encode("<tr>
                <td>$data[0]</td>
                <td>".utf8_decode($data[1])."</td>
                <td>".utf8_decode($data[2])."</td> 
                <td>");
                    if ($data[3] == 0){
                        echo "<i class='fas fa-eye' style='color:red;'></i></a>";
                    }else{
                        echo "<i class='fas fa-eye' style='color:#01ff15;'></i></a>";
                    }
        echo utf8_encode("</td>
                <td>
                    <a href='?view=area&pst=$data[0]'>
                        <i class='far fa-list-alt'></i>
                    </a>
                </td>
                <td>
                    <a data-bs-toggle='modal' data-bs-target='#FormModal' onclick='edit($data[0])'>
                        <i class='fas fa-edit'></i>
                    </a>
                </td>
                <td>
                    <a data-bs-toggle='modal' data-bs-target='#FormModal' onclick='enable($data[0], $data[3])'>
                        <i class='fas fa-eye-slash'></i>
                    </a>
                </td>
                </tr>");
    }

    ?>
</tbody>
</table>
