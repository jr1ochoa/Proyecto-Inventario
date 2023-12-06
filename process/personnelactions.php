<?php
if($action == "Add Action"){

    $tamano = $_FILES["file"]['size'];
    $tipo = $_FILES["file"]['type'];
    $archivo = $_FILES["file"]['name'];
    $prefijo = substr(md5(uniqid(rand())),0,4);               

    if ($archivo != "") {
        
        $namefile = $prefijo."_pa.".$archivo;
        $destino =  $_SERVER['DOCUMENT_ROOT']."/process/documents/$namefile";

        if (copy($_FILES['file']['tmp_name'], $destino)) 
        {            
            $query = "INSERT INTO processarea_staffaction VALUES(NULL, :n1, :n2, current_timestamp())";
            $insertPAction = $net_rrhh->prepare($query);
            $insertPAction->bindParam(':n1', htmlspecialchars($_POST['employee']));
            $insertPAction->bindParam(':n2', htmlspecialchars($namefile));
            $insertPAction->execute();
                        

            registerLog($net_rrhh, "Administrative Processes", "Personnel Actions", "Add Personnel Action", "Agregar Acción de Personal");  
            redirection("../?view=personnelactions");
        } 
        else             
            echo "Error al subir el archivo. ET-01";  
                                               
    } 
    else         
        echo "Error al subir archivo. ET-02";

}elseif ($action == "Update Action") {

    $query = "UPDATE processarea_staffaction SET
                idemployee = :n1
                WHERE id = :id";
    $updatePAction = $net_rrhh->prepare($query);
    $updatePAction->bindParam(':n1', htmlspecialchars($_POST['employee']));
    $updatePAction->bindParam(':id', htmlspecialchars($_POST['id']));
    $updatePAction->execute();

    registerLog($net_rrhh, "Administrative Processes", "Personnel Actions", "Update Personnel Action", "Actualizar Acción de Personal");  
    redirection("../?view=personnelactions");

}elseif ($action == "Update Document") {

    $tamano = $_FILES["file"]['size'];
    $tipo = $_FILES["file"]['type'];
    $archivo = $_FILES["file"]['name'];
    $prefijo = substr(md5(uniqid(rand())),0,4);               

    if ($archivo != "") {
        
        $namefile = $prefijo."_pa.".$archivo;
        $destino =  $_SERVER['DOCUMENT_ROOT']."/process/documents/$namefile";

        if (copy($_FILES['file']['tmp_name'], $destino)) 
        {            
            $query = "UPDATE processarea_staffaction SET
                file = :n1
                WHERE id = :id";

            $updatePAction = $net_rrhh->prepare($query);
            $updatePAction->bindParam(':n1', htmlspecialchars($namefile));
            $updatePAction->bindParam(':id', htmlspecialchars($_POST['id']));
            $updatePAction->execute();

            registerLog($net_rrhh, "Administrative Processes", "Personnel Actions", "Update Personnel Action Doc", "Actualizar Documento Acción de Personal");  
            redirection("../?view=personnelactions");
        } 
        else             
            echo "Error al subir el archivo. ET-01";  
                                               
    } 
    else         
        echo "Error al subir archivo. ET-02";

}elseif ($action == "Delete Action") {

    $Query = "DELETE FROM processarea_staffaction WHERE id = :n1";
        
    $deletePermission = $net_rrhh->prepare($Query);
    $deletePermission->bindParam(':n1', $_POST['id']);        
    $deletePermission->execute();

    registerLog($net_rrhh, "Administrative Processes", "Personnel Actions", "Delete Personnel Action", "Eliminar Acción de Personal");  
    redirection("../?view=personnelactions");
}
?>