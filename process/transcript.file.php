<?php

if($action == "Add File")
{
    $tamano = $_FILES["file"]['size'];
    $tipo = $_FILES["file"]['type'];
    $archivo = $_FILES["file"]['name'];
    $prefijo = substr(md5(uniqid(rand())),0,4);               

    if ($archivo != "") 
    {
        if($tipo == "image/jpeg" || $tipo == "image/png" || $tipo == "image/gif")
        {
            $namefile = $prefijo."_".$archivo;
            $destino =  $_SERVER['DOCUMENT_ROOT']."/process/documents/$namefile";
            if (copy($_FILES['file']['tmp_name'], $destino)) 
            {            
                $query = "INSERT INTO employee_files 
                        VALUES(NULL, :n1, :n2, :n3, :n4, :n5)";

                $Insert = $net_rrhh->prepare($query);
                $Insert->bindParam(':n1', $_SESSION['iu']);
                $Insert->bindParam(':n2', $_POST['filename']);  
                $Insert->bindParam(':n3', $namefile);  
                $Insert->bindParam(':n4', $_POST['type']);  
                $Insert->bindParam(':n5', $_POST['ide']);  
                $Insert->execute();
                            
                //Guardar Registro de Actualización
                $query = "DELETE FROM employee_updates WHERE part = 'Files' AND idemployee = ".$_SESSION['iu'];
                $Delete = $net_rrhh->prepare($query);
                $Delete->execute();

                $query = "INSERT INTO employee_updates VALUES(NUll, :n1, 'Files', CURRENT_TIMESTAMP)";
                $Insert = $net_rrhh->prepare($query);
                $Insert->bindParam(':n1', $_SESSION['iu']);
                $Insert->execute();              

                $return = ($_POST['type'] == "Education") ? "education" : "documents";

                redirection("../?view=transcript&part=$return&n=8");
            } 
            else             
                $status = "Error al subir el archivo 1";  
        }                                          
    } 
    else         
        $status = "Error al subir archivo 2";
}
else if ($action == "Delete File")
{
    $query = "DELETE FROM employee_files 
              WHERE id = :n1 AND type = :n2 AND idemployee = :n3 ";
    $delete = $net_rrhh->prepare($query);
    $delete->bindParam(':n1', $_POST['idf']);
    $delete->bindParam(':n2', $_POST['type']);
    $delete->bindParam(':n3', $_SESSION['iu']);
    $delete->execute();

    //Guardar Registro de Actualización
    $query = "DELETE FROM employee_updates WHERE part = 'Files' AND idemployee = ".$_SESSION['iu'];
    $Delete = $net_rrhh->prepare($query);
    $Delete->execute();

    $query = "INSERT INTO employee_updates VALUES(NUll, :n1, 'Files', CURRENT_TIMESTAMP)";
    $Insert = $net_rrhh->prepare($query);
    $Insert->bindParam(':n1', $_SESSION['iu']);
    $Insert->execute();  

    $return = ($_POST['type'] == "Education") ? "education" : "documents";
    redirection("../?view=transcript&part=$return&n=9");
}
else if($action == "Change Picture")
{
    ini_set('upload_max_filesize', '10M');
    ini_set('post_max_size', '10M');

    $tamano = $_FILES["NewPicture"]['size'];
    $tipo = $_FILES["NewPicture"]['type'];
    $archivo = $_FILES["NewPicture"]['name'];
    $prefijo = substr(md5(uniqid(rand())),0,4);               

    if ($archivo != "") 
    {
        $namefile = $prefijo."_".$archivo;
        $destino =  $_SERVER['DOCUMENT_ROOT']."/process/pictures/$namefile";
        if (copy($_FILES['NewPicture']['tmp_name'], $destino)) 
        {   
            $query = "DELETE FROM employee_picture
                      WHERE idemployee = " . $_POST['iu'];
            $delete =  $net_rrhh->prepare($query);
            $delete->execute();

            $query = "INSERT INTO employee_picture 
                      VALUES(NULL, :n1, :n2)";

            $Insert = $net_rrhh->prepare($query);
            $Insert->bindParam(':n1', $_POST['iu']);
            $Insert->bindParam(':n2', $namefile);  
            $Insert->execute();
                        
            /*Guardar Registro de Actualización
            $query = "DELETE FROM employee_updates WHERE part = 'Picture' AND idemployee = ".$_POST['iu'];
            $Delete = $net_rrhh->prepare($query);
            $Delete->execute();

            $query = "INSERT INTO employee_updates VALUES(NUll, :n1, 'Picture', CURRENT_TIMESTAMP)";
            $Insert = $net_rrhh->prepare($query);
            $Insert->bindParam(':n1', $_POST['iu']);
            $Insert->execute();     */         

            redirection("../?view=profile&iu=".$_POST['iu']);
        } 
        else{
            if($_SESSION['type'] == "Administrador"){
                $error = array();
                $error = error_get_last();

                foreach($error as $details)
                    $msg .= "$details -";
                
                echo "Error al subir el archivo: $msg";
            }else{
                echo "<script>alert('¡Tamaño de imagen muy grande! La imagen no debe exeder los 8MB')</script>";
            }
        }                                               
    } 
    else         
        echo "Error al subir archivo 2";
}


?>