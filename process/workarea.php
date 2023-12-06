<?php
if($action == "add"){
    
    $query = "Insert into workarea values(null, :n1, :n2, 1)";
    $insert = $net_rrhh->prepare($query);
    $insert->bindParam(':n1', htmlspecialchars($_POST['area']));
    $insert->bindParam(':n2', htmlspecialchars($_POST['tag']));
    $insert->execute();

    registerLog($net_rrhh, "Work Area", "Work Area", "Add Work Area", "Agregar Área");
    redirection("../?view=area");

}else if($action == "update"){
    $Query = "update workarea set area=:n1, tag=:n2 where id=:n3 ";
            
    $updateArea = $net_rrhh->prepare($Query);
    $updateArea->bindParam(':n1', htmlspecialchars($_POST['area']));
    $updateArea->bindParam(':n2', htmlspecialchars($_POST['tag']));
    $updateArea->bindParam(':n3', $_POST['iu']);        
    $updateArea->execute();

    registerLog($net_rrhh, "Work Area", "Work Area", "Update Work Area", "Actualizar Área");
    redirection("../?view=area");

}else if($action == "visibleArea"){

    $query = "Update workarea set visible = 1 where id = :n1";
    $disableArea = $net_rrhh->prepare($query);      
    $disableArea->bindParam(":n1", $_POST['iu']);       
    $disableArea->execute();

    registerLog($net_rrhh, "Work Area", "Work Area", "Disable Work Area", "Deshabilitar Área");
    redirection("../?view=area");

}else if($action == "invisibleArea"){
    $query = "Update workarea set visible = 0 where id = :n1";
    $disableArea = $net_rrhh->prepare($query);      
    $disableArea->bindParam(":n1", $_POST['iu']);       
    $disableArea->execute();

    registerLog($net_rrhh, "Work Area", "Work Area", "Enable Work Area", "Habilitar Área");
    redirection("../?view=area");

}else if($action == "addPosition"){
    
    $query = "Insert into workarea_positions values(null, :n1, :n2, :n3)";
    $insertPosition = $net_rrhh->prepare($query);
    $insertPosition->bindParam(':n1', htmlspecialchars($_POST['position']));
    $insertPosition->bindParam(':n2', htmlspecialchars($_POST['details']));
    $insertPosition->bindParam(':n3', $_POST['idarea']);
    $insertPosition->execute();

    registerLog($net_rrhh, "Work Area", "Positions", "Add Position", "Agregar Cargo");
    redirection("../?view=area&pst=".$_POST['idarea']);

}else if($action == "updatePosition"){
    $Query = "update workarea_positions set position=:n1, details=:n2 where id=:n3 ";
            
    $updatePosition = $net_rrhh->prepare($Query);
    $updatePosition->bindParam(':n1', htmlspecialchars($_POST['position']));
    $updatePosition->bindParam(':n2', htmlspecialchars($_POST['details']));
    $updatePosition->bindParam(':n3', $_POST['iu']);        
    $updatePosition->execute(); 

    foreach ($updatePosition->errorInfo() as $error)
                echo "<br/>$error ";

    registerLog($net_rrhh, "Work Area", "Positions", "Update Position", "Actualizar Cargo");
    redirection("../?view=area&pst=".$_POST['idarea']);

}elseif($action == "changeArea"){
    $Query = "update workarea_positions set idarea=:n1 where id=:n2 ";
            
    $updatePosition = $net_rrhh->prepare($Query);
    $updatePosition->bindParam(':n1', htmlspecialchars($_POST['idarea']));
    $updatePosition->bindParam(':n2', $_POST['iu']);        
    $updatePosition->execute();


    registerLog($net_rrhh, "Work Area", "Positions", "Change Area", "Cambio de Area");
    redirection("../?view=area&pst=".$_POST['idarea']);

}else if($action == "Asing Employee"){

    if(!isset($_POST['enddate'])){
        $enddate = '0000-00-00';
    }elseif($_POST['enddate'] == ''){
        $enddate = '0000-00-00';
    }else{
        $enddate = $_POST['enddate'];
    }
    
    $query = "Insert into workarea_positions_assignment values(null, :n1, :n2, :n3, :n4, :n5, :n6, :n7)";
    $asingPosition = $net_rrhh->prepare($query);
    $asingPosition->bindParam(':n1', htmlspecialchars($_POST['idposition']));
    $asingPosition->bindParam(':n2', htmlspecialchars($_POST['idemployee']));
    $asingPosition->bindParam(':n3', htmlspecialchars($_POST['contrat']));
    $asingPosition->bindParam(':n4', htmlspecialchars($_POST['financing']));
    $asingPosition->bindParam(':n5', htmlspecialchars($_POST['salary']));
    $asingPosition->bindParam(':n6', htmlspecialchars($_POST['startdate']));
    $asingPosition->bindParam(':n7', $enddate);
    $asingPosition->execute();

    registerLog($net_rrhh, "Work Area", "Positions", "Asing Employee", "Asignar Empleado del Cargo");
    redirection("../?view=area&pp=".$_POST['idposition']);

}else if($action == "Asing Boss"){

    $query = "Select * from workarea_hierarchy where idposition=:n1";
    $searchPosition = $net_rrhh->prepare($query);
    $searchPosition->bindParam(':n1', $_POST['idPosition']);
    $searchPosition->execute();
    if ($searchPosition->rowCount() > 0) {
        $query = "update workarea_hierarchy set idboss=:n1 where idposition=:n2";
        $asingPosition = $net_rrhh->prepare($query);
        $asingPosition->bindParam(':n1', htmlspecialchars($_POST['idBoss']));
        $asingPosition->bindParam(':n2', htmlspecialchars($_POST['idPosition']));
        $asingPosition->execute();
    }else{
        $query = "Insert into workarea_hierarchy values(null, :n1, :n2)";
        $asingPosition = $net_rrhh->prepare($query);
        $asingPosition->bindParam(':n1', htmlspecialchars($_POST['idPosition']));
        $asingPosition->bindParam(':n2', htmlspecialchars($_POST['idBoss']));
        $asingPosition->execute();
    }

    //foreach($asingPosition->errorInfo() as $error)
      //  echo "$error <br/>";

    registerLog($net_rrhh, "Work Area", "Positions", "Asing Boss", "Asignar Jefe del Cargo");
    redirection("../?view=area&pp=".$_POST['idPosition']);

}else if($action == "Remove Employee"){

    
    $query = "Update workarea_positions_assignment set enddate = :end where id = :n1 and idposition = :n2";
    $removePosition = $net_rrhh->prepare($query);
    $removePosition->bindParam(':end', htmlspecialchars($_POST['dateend']));
    $removePosition->bindParam(':n1', htmlspecialchars($_POST['id']));
    $removePosition->bindParam(':n2', htmlspecialchars($_POST['idPosition'])); 
    $removePosition->execute();

    registerLog($net_rrhh, "Work Area", "Positions", "Remove Employee", "Remover Empleado del Cargo");
    redirection("../?view=area&pp=".$_POST['idPosition']);

}else if($action == "Remove Boss"){

    $query = "update workarea_hierarchy set idboss=null where idposition=:n1 and id=:n2";
    $removePosition = $net_rrhh->prepare($query);
    $removePosition->bindParam(':n1', htmlspecialchars($_POST['idPosition']));
    $removePosition->bindParam(':n2', htmlspecialchars($_POST['id']));
    $removePosition->execute();

    registerLog($net_rrhh, "Work Area", "Positions", "Remove Boss", "Remover Jefe del Cargo");
    redirection("../?view=area&pp=".$_POST['idPosition']); 

} 

?>