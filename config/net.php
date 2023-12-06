<?php 

session_start();
date_default_timezone_set('Etc/GMT+6');
$root = $_SERVER['DOCUMENT_ROOT']."/";

try
{
    $net_rrhh = new PDO('mysql:host=localhost;dbname=catedra_database', 'root', '');   
    function redirection($Redirecion)
    {    
        echo"<script language='javascript'>window.location='$Redirecion'</script>";
    }
}
catch (PDOException $e)
{
    echo $e;
}

function registerLog($con, $module, $process, $action, $comment)
{
    $query = "Insert into log values(null, :n1, :n2, :n3, :n4, :n5, CURRENT_TIMESTAMP);";
    $Log = $con->prepare($query);
    $Log->bindParam(':n1', $module);
    $Log->bindParam(':n2', $process);
    $Log->bindParam(':n3', $action);
    $Log->bindParam(':n4', $comment);
    $Log->bindParam(':n5', $_SESSION['iu']);
    $Log->execute();
}

error_reporting(0);


?>