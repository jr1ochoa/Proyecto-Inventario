<?php
 
if($action == "LogIn")
{
    $query = "SELECT * FROM users WHERE username = :n1 and password = MD5(:n2) and enabled = 1";
    $login = $net_rrhh->prepare($query);
    $login->bindParam(":n1", $_POST["username"]);
    $login->bindParam(":n2", $_POST["password"]);
    $login->execute();

    if($login->rowCount() > 0)
    {
        $data = $login->fetch();
        $_SESSION['iu'] = $data[0];
        $_SESSION['user'] = $data[1];
        $_SESSION['type'] = $data[2];

        registerLog($net_rrhh, "Login", "Login", "Login", "Inicio de Sesión");
        redirection("../?view=main");
    }
    else
    {
        redirection("../?view=login&n=1");
    }
}


?>