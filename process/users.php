<?php
if($action == "add"){
    
    $query = "Insert into users values(null, :n1, :n2, MD5(:n3), :n4, 1)";
    $insert = $net_rrhh->prepare($query);
    $insert->bindParam(':n1', htmlspecialchars($_POST['username']));
    $insert->bindParam(':n2', htmlspecialchars($_POST['type']));
    $insert->bindParam(':n3', htmlspecialchars($_POST['pass']));
    $insert->bindParam(':n4', htmlspecialchars($_POST['location']));
    $insert->execute();

    registerLog($net_rrhh, "Users", "Users", "Add User", "Agregar Usuario");
    redirection("../?view=user");

}else if($action == "update"){
    $Query = "update users set username=:n1, type=:n2, location=:n3 where id=:n4 ";
            
    $updateUser = $net_rrhh->prepare($Query);
    $updateUser->bindParam(':n1', htmlspecialchars($_POST['username']));
    $updateUser->bindParam(':n2', htmlspecialchars($_POST['type']));
    $updateUser->bindParam(':n3', htmlspecialchars($_POST['location']));
    $updateUser->bindParam(':n4', $_POST['iu']);        
    $updateUser->execute();

    registerLog($net_rrhh, "Users", "Users", "Update User", "Actualizar Usuario");
    redirection("../?view=user");

}else if($action == "updatePassword"){

    $query = "Update users set password = MD5(:n1) where id = :n2";
    $updatePassword = $net_rrhh->prepare($query);
    $updatePassword->bindParam(":n1", htmlspecialchars($_POST['pass']));       
    $updatePassword->bindParam(":n2", $_POST['iu']);       
    $updatePassword->execute();

    registerLog($net_rrhh, "Users", "Users", "Update Password", "Actualizar Contraseña");
    redirection("../?view=user");

}else if($action == "disableUsers"){

    $query = "Update users set enabled = 0 where id = :n1";
    $disableUser = $net_rrhh->prepare($query);      
    $disableUser->bindParam(":n1", $_POST['iu']);       
    $disableUser->execute();

    registerLog($net_rrhh, "Users", "Users", "Disable User", "Deshabilitar Usuario");
    redirection("../?view=user");

}else if($action == "enableUsers"){
    $query = "Update users set enabled = 1 where id = :n1";
    $disableUser = $net_rrhh->prepare($query);      
    $disableUser->bindParam(":n1", $_POST['iu']);       
    $disableUser->execute();

    registerLog($net_rrhh, "Users", "Users", "Enable User", "Habilitar Usuario");
    redirection("../?view=user");
}

?>