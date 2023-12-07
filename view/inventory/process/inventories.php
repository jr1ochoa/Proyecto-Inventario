<!-- PROCESOS DEL INVENTARIO -->
<?php

//AGREGAR ACTIVO
if($action == "Add Active" )
{ 
    $query = "INSERT INTO inventory_active
              VALUES(NULL, :n1, :n2, :n3, :n4, :n5, :n6, null, null, null, null,
              null, :n7, CURRENT_TIMESTAMP)";

    $insert = $net_rrhh->prepare($query);
    $insert->bindParam(":n1", $_POST['fixedasset']);
    $insert->bindParam(":n2", $_POST['type']);
    $insert->bindParam(":n3", $_POST['brand']);
    $insert->bindParam(":n4", $_POST['model']); 
    $insert->bindParam(":n5", $_POST['serial']);
    $insert->bindParam(":n6", $_POST['status']);
    $insert->bindParam(":n7", $_POST['license']);
    $insert->execute();

    //Agregar asignación inicial si lo requiere
    if(isset($_POST['assignation'])){
        $active = $net_rrhh->lastInsertId();
        $employee = "";
        $area = "";

        //Solo asignar empleado
        if($_POST['selection'] == 'option1'){
            $employee =  $_POST['employee2'];

        //Solo asignar área
        }elseif($_POST['selection'] == 'option2'){
            $area = $_POST['area'];

        //Asignar ambos
        }else{
            $area = ($_POST['area'] == "Otro") ? NULL : $_POST['area'];
            $employee =  $_POST['employee'];
        }
        

        $query = "INSERT INTO inventory_assignation VALUES (NULL, :n1, :n2, :n3, NULL, 'En Prestamo', :n4)";

        $insert = $net_rrhh->prepare($query);
        $insert->bindParam(":n1", $employee);
        $insert->bindParam(":n2", $area);
        $insert->bindParam(":n3", $_POST['date_assignation']);
        $insert->bindParam(":n4", $active);
        $insert->execute();
    }

    /*foreach($insert->errorInfo() as $error)
        echo "$error <br/>";*/

    echo "<script>alert('Activo agregado correctamente')</script>";

    redirection("../../../?view=inventory"); 

//ACTUALIZAR ACTIVO
}elseif($action == "Update Active" ){ 

    $query = "UPDATE inventory_active as a SET 
                a.fixedasset = :n1,
                a.type = :n2,
                a.brand = :n3,
                a.model = :n4,
                a.serial = :n5,
                a.status = :n6,
                a.license = :n7

            WHERE a.id = :idi";

    $update = $net_rrhh->prepare($query);
    $update->bindParam(":n1", $_POST['fixedasset']);
    $update->bindParam(":n2", $_POST['type']);
    $update->bindParam(":n3", $_POST['brand']);
    $update->bindParam(":n4", $_POST['model']);
    $update->bindParam(":n5", $_POST['serial']);
    $update->bindParam(":n6", $_POST['status']);
    $update->bindParam(":n7", $_POST['license']);
    $update->bindParam(":idi", $_POST['idi']);
    $update->execute();

    echo "<script>alert('Activo actualizado correctamente')</script>";

    redirection("../../../?view=inventory"); 

//ELIMINAR ACTIVO
}elseif($action == "Delete Active" ){ 

    $query = "DELETE FROM inventory_active WHERE id = :idi";

    $delete = $net_rrhh->prepare($query);
    $delete->bindParam(":idi", $_POST['idi']);
    $delete->execute();

    echo "<script>alert('Activo eliminado correctamente')</script>";

    redirection("../../../?view=inventory"); 

//AGREGAR ASIGNACIÓN
}elseif($action == "Add Assignment" ){ 

    $employee = "";
    $area = "";

    //Solo asignar empleado
    if($_POST['selection'] == 'option1'){
        $employee =  $_POST['employee2'];

    //Solo asignar área
    }elseif($_POST['selection'] == 'option2'){
        $area = $_POST['area'];

    //Asignar ambos
    }else{
        $area = ($_POST['area'] == "Otro") ? NULL : $_POST['area'];
        $employee =  $_POST['employee'];
    }

    $query = "INSERT INTO inventory_assignation VALUES (NULL, :n1, :n2, :n3, NULL, 'En Prestamo', :n4)";

    $insert = $net_rrhh->prepare($query);
    $insert->bindParam(":n1", $employee);
    $insert->bindParam(":n2", $area);
    $insert->bindParam(":n3", $_POST['date_assignation']);
    $insert->bindParam(":n4", $_POST['active']);
    $insert->execute();

    foreach($insert->errorInfo() as $error)
        $msg .= "$error <br/>";

    echo "¡Asignación agregada correctamente!";

//ACTUALIZAR ASIGNACIÓN
}elseif($action == "Update Assignment" ){ 

    $query = "UPDATE inventory_assignation as i SET
                i.employee = :n1,
                i.area = :n2,
                i.date_assignation = :n3,
                i.date_return = :n4,
                i.state = :n5
                
                WHERE i.id = :iu";

    $area = ($_POST['area'] == "Otro") ? NULL : $_POST['area'];
    $update = $net_rrhh->prepare($query);
    $update->bindParam(":n1", $_POST['employee']);
    $update->bindParam(":n2", $area);
    $update->bindParam(":n3", $_POST['date_assignation']);
    $update->bindParam(":n4", $_POST['date_return']);
    $update->bindParam(":n5", $_POST['state']);
    $update->bindParam(":iu", $_POST['iu']);
    $update->execute();

    foreach($update->errorInfo() as $error)
        $msg .= "$error <br/>";

    echo "¡Asignación actualizada correctamente!";

//DEVOLVER ASIGNACIÓN
}elseif($action == "return" ){ 

    $query = "UPDATE inventory_assignation as i SET
                i.date_return = DATE(CURRENT_TIMESTAMP()),
                i.state = 'Entregado'
                
                WHERE i.id = :iu";

    $update = $net_rrhh->prepare($query);
    $update->bindParam(":iu", $_POST['ia']);
    $update->execute();

    foreach($update->errorInfo() as $error)
        $msg .= "$error <br/>";

    echo "¡Elemento devuelto correctamente!";

//ELIMINAR ASIGNACIÓN
}elseif($action == "Delete Assignment" ){ 

    $query = "DELETE FROM inventory_assignation WHERE id = :id";

    $delete = $net_rrhh->prepare($query);
    $delete->bindParam(":id", $_POST['id']);
    $delete->execute();

    echo "¡Asignación eliminada correctamente!";

//ACTUALIZAR LOCALIZACIÓN EN RED
}elseif($action == "Update Localization" ){ 

    $query = "UPDATE inventory_active as a SET 
                a.ip = :n1,
                a.mac = :n2,
                a.device = :n3

            WHERE a.id = :ida";

    $update = $net_rrhh->prepare($query);
    $update->bindParam(":n1", $_POST['ip']);
    $update->bindParam(":n2", $_POST['mac']);
    $update->bindParam(":n3", $_POST['device']);
    $update->bindParam(":ida", $_POST['ida']);
    $update->execute();

    echo "Localización en red actualizada correctamente";

//AGREGAR MANTENIMIENTO
}elseif($action == "Add Maintenance" ){ 

    $query = "INSERT INTO inventory_maintenance VALUES (NULL, :n1, :n2, :n3)";

    $insert = $net_rrhh->prepare($query);
    $insert->bindParam(":n1", $_POST['lastmaintenance']);
    $insert->bindParam(":n2", $_POST['commentary']);
    $insert->bindParam(":n3", $_POST['active']);
    $insert->execute();

    foreach($insert->errorInfo() as $error)
        $msg .= "$error <br/>";

    echo "¡Mantenimiento agregado correctamente!";

//ACTUALIZAR MANTENIMIENTO
}elseif($action == "Update Maintenance" ){ 

    $query = "UPDATE inventory_maintenance as m SET
                m.lastmaintenance = :n1, 
                m.commentary = :n2
                
                WHERE m.id = :iu";

    $update = $net_rrhh->prepare($query);
    $update->bindParam(":n1", $_POST['lastmaintenance']);
    $update->bindParam(":n2", $_POST['commentary']);
    $update->bindParam(":iu", $_POST['iu']);
    $update->execute();

    foreach($update->errorInfo() as $error)
        $msg .= "$error <br/>";

    echo "¡Mantenimiento actualizado correctamente!";

//ELIMINAR MANTENIMIENTO
}elseif($action == "Delete Maintenance" ){ 

    $query = "DELETE FROM inventory_maintenance WHERE id = :id";

    $delete = $net_rrhh->prepare($query);
    $delete->bindParam(":id", $_POST['id']);
    $delete->execute();

    echo "¡Mantenimiento eliminado correctamente!";

//ACTUALIZAR INFORMACIÓN EXTRA
}elseif($action == "Update Extra" ){ 

    $query = "UPDATE inventory_active as a SET 
                a.details = :n1

            WHERE a.id = :ida";

    $update = $net_rrhh->prepare($query);
    $update->bindParam(":n1", $_POST['details']);
    $update->bindParam(":ida", $_POST['ida']);
    $update->execute();

    echo "Extra actualizado correctamente";

//ACTUALIZAR RECURSOS TECNOLÓGICOS
}elseif($action == "Update Resource" ){ 

    $query = "UPDATE inventory_active as a SET 
                a.revision = :n1

            WHERE a.id = :ida";

    $update = $net_rrhh->prepare($query);
    $update->bindParam(":n1", $_POST['revision']);
    $update->bindParam(":ida", $_POST['ida']);
    $update->execute();

    echo "Recurso actualizado correctamente";

//AGREGAR ARCHIVOS
}elseif($action == "Add File" ){

    $tamano = $_FILES["file"]['size'];
    $tipo = $_FILES["file"]['type'];
    $archivo = $_FILES["file"]['name'];
    $prefijo = substr(md5(uniqid(rand())),0,4);               

    if ($archivo != "") 
    {
        $namefile = $prefijo."_".$archivo;
        $destino =  $_SERVER['DOCUMENT_ROOT']."/process/documents/$namefile";
        if (copy($_FILES['file']['tmp_name'], $destino)) 
        {            
            $query = "INSERT INTO inventory_files 
                      VALUES(NULL, :n1, :n2, :n3, :n4)";

            $InsertFiles = $net_rrhh->prepare($query);
            $InsertFiles->bindParam(':n1', $_POST['type']);  
            $InsertFiles->bindParam(':n2', $namefile);  
            $InsertFiles->bindParam(':n3', $tipo);  
            $InsertFiles->bindParam(':n4', $_POST['assignation']);  
            $InsertFiles->execute();      

            foreach($InsertFiles->errorInfo() as $error)
            $msg .= "$error -";

            echo "¡Archivo Subido Correctamente!";
        } 
        else{        
            echo "Error al subir el archivo. Vuelva a intentarlo";      
        }                                     
    } 
    else {      
        echo "Error al subir archivo. Ingrese un archivo para guardar";
    }

//ELIMINAR ARCHIVOS
}elseif($action == "Delete File"){

    $query = "DELETE FROM inventory_files WHERE id = :n1";
    $deleteFiles = $net_rrhh->prepare($query);
    $deleteFiles->bindParam(':n1', $_POST['id']);  
    $deleteFiles->execute();

    foreach($deleteFiles->errorInfo() as $error)
            $msg .= "$error -";

    echo "¡Archivo Eliminado Correctamente!";
}

?>