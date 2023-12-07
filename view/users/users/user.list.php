    <?php

        $query = "SELECT u.id, u.username, u.type, 
                         CONCAT(name1, ' ', name2, ' ', name3, ' ', lastname1, ' ', lastname2), u.enabled as Nombre
                         FROM users as u 
                  LEFT JOIN employee as e on u.id = e.id ";
        
        $user = $net_rrhh->prepare($query);  
        $user->execute();
        
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
                <th>Usuario</th>
                <th>Tipo de Usuario</th>
                <th>Empleado</th>
                <th>Estado</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php

            while($data = $user->fetch())
            {         
                $color = ($data[4] == 0) ? "red" : "#01ff15";
                
                echo utf8_encode("<tr>
                        <td>$data[0]</td>
                        <td>$data[1]</td>
                        <td>$data[2]</td>
                        <td>$data[3]</td>   
                        <td><i class='fas fa-user' style='color: $color;'></i></td>
                        <td>
                            <a data-bs-toggle='modal' data-bs-target='#FormModal' onclick='edit($data[0])'>
                            <i class='fas fa-edit'></i>
                            </a>
                        </td>
                        <td>
                            <a data-bs-toggle='modal' data-bs-target='#FormModal' onclick='pass($data[0])'>
                                <i class='fa fa-key'></i>
                            </a>
                        </td>
                        <td><a data-bs-toggle='modal' data-bs-target='#FormModal' onclick='enable($data[0], $data[4])'>
                                <i class='fas fa-user-times'></i></a>
                            </td>
                        </tr>");
            }

            ?>
        </tbody>
    </table>

<script>
    $(document).ready(function(){
        $('#UserTable').DataTable( {
            "order": [[ 0, "asc" ]], 
            "language": { "url": "https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json" }
        });
    });
</script>