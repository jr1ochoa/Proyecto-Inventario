<?php

if($action == "AddCatalogue" )
{ 
    $query = "INSERT INTO inventory_category
              VALUES(NULL, :n1, CURRENT_TIMESTAMP)";
    
    $insert = $net_rrhh->prepare($query);
    $insert->bindParam(":n1", $_POST['category']);
    $insert->execute();

    //showerrors($insert);

    echo "<script>alert('Categoría agregada correctamente')</script>";
}

?>