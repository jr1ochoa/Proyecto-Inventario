<?php 

include("../../config/net.php"); 

$action = $_REQUEST['action'];
if($action == "ActiveEmployeesByarea")
{
    $area = $_REQUEST['area'];
    $query = "SELECT e.id, p.position, e.name1, e.name2, e.name3, e.lastname1, e.lastname2 
    FROM workarea_positions AS p 
    INNER JOIN workarea_positions_assignment AS a ON p.id = a.idposition 
    INNER JOIN employee AS e ON a.idemployee = e.id 
    WHERE p.idarea = $area  AND enddate = '0000-00-00' 
    GROUP BY e.id 
    ORDER BY e.name1 ASC, e.name2 ASC ";

    $positionArea = $net_rrhh->prepare($query);  
    $positionArea->execute();    
    
    while($data = $positionArea->fetch())
    {
        echo utf8_encode("<option value='$data[0]'>$data[2] $data[3] $data[4] $data[5] $data[6] - $data[1]</option>");
    }
}

?>