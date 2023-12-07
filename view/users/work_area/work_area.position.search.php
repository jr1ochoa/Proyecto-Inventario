<?php 
include("../../config/net.php");

if(isset($_POST['txtBusqueda'])){
    $busqueda = $_POST['txtBusqueda'];
    $idPosition = $_POST['idPosition'];

    $tabla = "<div class='row'>
                <div class='col-3'>
                    <p><strong>Jefe</strong></p>
                </div>
                <div class='col-3'>
                    <p><strong>Área</strong></p>
                </div>
                <div class='col-3'>
                    <p><strong>Cargo</strong></p>
                </div>
                <div class='col-3'>
                    <p><strong>Acciones</strong></p>
                </div>
            </div>
            <hr style='margin-top: 0px; padding-top: 0px;'/>";

    if($busqueda != ""){
        $query = "SELECT wb.area, wpb.position, wpab.idemployee, wpab.stardate, wpab.enddate, e.id, e.name1, e.name2, e.lastname1, e.lastname2,  wpb.id, e.email
        FROM workarea as wb  
        LEFT JOIN workarea_positions as wpb ON wpb.idarea = wb.id
        INNER JOIN workarea_positions_assignment as wpab ON wpb.id = wpab.idposition AND wpab.enddate = '0000-00-00'
        RIGHT JOIN employee as e  ON wpab.idemployee = e.id
        WHERE wpb.position LIKE '%$busqueda%'";

        $Employees = $net_rrhh->prepare($query);
        $Employees->execute();

        if($Employees->rowCount() > 0){
            while($data = $Employees->fetch())        
            {
                $tabla .= "
                <form action='process/' method='post' id='formArea'>
                    <input type='hidden' name='process' value='Area'>
                    <input type='hidden' name='action' value='Asing Boss' />
                    <input type='hidden' name='idPosition' value='$idPosition' />
                    <input type='hidden' name='idBoss' value='$data[10]' />
                    <div class='row'>
                        <div class='col-3'>
                            <p>$data[6] $data[7] $data[8] $data[9]</p>
                        </div>
                        <div class='col-3'>
                            <p>$data[0]</p>
                        </div>
                        <div class='col-3'>
                            <p>$data[1]</p>
                        </div>
                        <div class='col-3'>
                            <p><button type='submit' class='btn btn-success'>Asignar</button></p>
                        </div>
                    </div>
                    <hr style='margin-top: 0px; padding-top: 0px;'/>
                </form>";
            }
        }else{
            $tabla .= "<div class='row'>
                        <div class='col-12'>
                            <p>No hay resultados para su búsqueda</p>
                        </div> 
                    </div>";
        }
        
    }else{
        $tabla .= "<div class='row'>
                <div class='col-12'>
                    <p>No ha ingresado valores en el buscador</p>
                </div> 
            </div>";
    }


    echo $tabla;
}else{
    echo "Error";
}
?>