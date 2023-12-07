<!-- Cargar listado de Empleados de manera Asincrona -->

<?php include("../../config/net.php");

    $area = $_REQUEST["area"];
    
    //Cargar Empleados por Área
    if($area != "Otro"){
        $query = "SELECT e.id, CONCAT(e.name1, ' ', e.name2, ' ', e.name3, ' ', e.lastname1, ' ', e.lastname2) as 'Nombre',
        p.position, a.area FROM `workarea_positions_assignment` as w
        INNER JOIN employee as e ON e.id = w.idemployee
        INNER JOIN workarea_positions as p ON p.id = w.idposition
        INNER JOIN workarea as a ON a.id = p.idarea
        WHERE a.id = $area
        GROUP BY e.id";

    //Cargar Empleados de Manera General
    }else{
        $query = 'SELECT id, CONCAT(name1," ",name2," ",name3," ",lastname1," ",lastname2) as "Empleado" FROM `employee`';
    }

    $user = $net_rrhh->prepare($query);  
    $user->execute();

    while($data = $user->fetch())
    {         
        echo "<option value='$data[0]'>".utf8_encode($data[1])."</option>";
    }
?>