<?php

$query = "SELECT * FROM workarea where visible = 0";
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
        <th></th>
    </tr>
</thead>
<tbody>
<?php

    while($data = $workarea->fetch())
    {            
        $color = ($data[3] == 0) ? "red" : "#01ff15";
        echo utf8_encode("<tr>
                <td>$data[0]</td>
                <td>$data[1]</td>
                <td>$data[2]</td> 
                <td><i class='fas fa-eye' style='color: $color;'></i></a></td>
                <td><a data-bs-toggle='modal' data-bs-target='#FormModal' onclick='enable($data[0], $data[3])'>
                    <i class='fas fa-undo'></i></a>
                    </td>
                </tr>");
    }

    ?>
</tbody>
</table>
