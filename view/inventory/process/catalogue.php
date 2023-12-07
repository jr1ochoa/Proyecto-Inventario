<!-- PROCESOS DEL CATÀLOGO -->
<?php
//Agregar un registro al catálogo
if($action == "Add Catalogue" )
{ 
    $query = "INSERT INTO catalogue VALUES(NULL, :n1, :n2)";
    
    $insert = $net_rrhh->prepare($query);
    $insert->bindParam(":n1", $_POST['type']);
    $insert->bindParam(":n2", $_POST['value']);
    $insert->execute();

    //showerrors($insert);

    echo "¡Elemento agregado correctamente!";

//Eliminar registro del catálogo
}elseif($action == "Delete Catalogue" ){

    $query = "DELETE FROM catalogue WHERE id = :id";
    
    $delete = $net_rrhh->prepare($query);
    $delete->bindParam(":id", $_POST['id']);
    $delete->execute();

    foreach($delete->errorInfo() as $error)
        $msg .= "$error";

    echo "¡Elemento eliminado correctamente!";
}

?>