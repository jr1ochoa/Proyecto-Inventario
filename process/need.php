<?php

if($action == 'Antiquity')
{
    $query = "Insert into needs_antiquity values(:n1, :n2, :n3, CURRENT_TIMESTAMP)";
    $insert = $net_rrhh->prepare($query);
    $insert->bindParam(':n1', $_SESSION['iu']);
    $insert->bindParam(':n2', $_POST['year']);
    $insert->bindParam(':n3', $_POST['month']);
    $insert->execute();

    redirection("../?view=needs&n=1");
}

?>