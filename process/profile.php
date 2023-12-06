<?php
// INFORMACIÓN PERSONAL 
// ----------------------------------------------------------------
if($action == "Add Personal")
{
    $query = "Delete from employee where id = :n1"; 
    $delete = $net_rrhh->prepare($query);
    $delete->bindParam(':n1', $_POST['ip']);
    $delete->execute();

    $query = "Insert into employee values(:id, ";
    for ($i = 1; $i <= 23; $i++) {
        if($i == 23)
            $query .= ":n".$i.")";
        else
            $query .= ":n".$i.", ";
    }

    $insertPersonal = $net_rrhh->prepare($query);
    $insertPersonal->bindParam(':id', $_POST['ip']);
    for ($i = 1; $i <= 23; $i++) {
        $insertPersonal->bindParam(':n'.$i, utf8_decode(htmlspecialchars($_POST['data'.$i])));
    }

    $insertPersonal->execute();

    foreach ($insertPersonal->errorInfo() as $error) {
        echo "$error <br/>";
    }

    registerLog($net_rrhh, "Profile", "Personal Information", "Add Personal Information", "Agregar Información Personal");
    redirection("../?view=profile&iu=".$_POST['ip']);

}

// INFORMACIÓN RELIGIOSA
// ----------------------------------------------------------------
else if($action == "Add Religious"){
    
    $query = "DELETE FROM employee_religious WHERE id_employee = :n1";    
    $delete = $net_rrhh->prepare($query);
    $delete->bindParam(":n1", $_POST['iu']);
    $delete->execute();

    $query = "Insert into employee_religious values(null, ";
    for ($i = 1; $i <= 11; $i++) 
    {
        if($i == 11)
            $query .= ":n".$i.")";
        else
            $query .= ":n".$i.", ";
    }

    $insertReligious = $net_rrhh->prepare($query);
    for ($i = 1; $i <= 10; $i++) {
        $insertReligious->bindParam(':n'.$i, htmlspecialchars($_POST['data'.$i]));
    }
    $insertReligious->bindParam(':n11', htmlspecialchars($_POST['iu']));
    $insertReligious->execute();



    registerLog($net_rrhh, "Profile", "Religious Information", "Add Religious Information", "Agregar Información Religiosa");
    redirection("../?view=profile");

}

// INFORMACIÓN EDUCATIVA
// ----------------------------------------------------------------
else if($action == "Add Education"){
    
    $query = "Insert into employee_education values(null, ";
    for ($i = 1; $i <= 12; $i++) {
        if($i == 12)
            $query .= ":n".$i.")";
        else
            $query .= ":n".$i.", ";
    }
    $insertEducation = $net_rrhh->prepare($query);
    for ($i = 1; $i <= 11; $i++) {
        $insertEducation->bindParam(':n'.$i, htmlspecialchars($_POST['data'.$i]));
    }
    $insertEducation->bindParam(':n12', htmlspecialchars($_POST['iu']));
    $insertEducation->execute();

    registerLog($net_rrhh, "Profile", "Education Information", "Add Education Information", "Agregar Información Educativa");
    redirection("../?view=profile");

}else if($action == "Update Education"){
    $Query = "update employee_education set level=:n1, institution=:n2, degree=:n3,
    address=:n4, phone=:n5, web=:n6, start=:n7, end=:n8, state=:n9, porcent=:n10,
    period=:n11 where id=:n12";
    $updateEducation = $net_rrhh->prepare($Query);
    for ($i = 1; $i <= 11; $i++) {
        $updateEducation->bindParam(':n'.$i, htmlspecialchars($_POST['data'.$i]));
    }
    $updateEducation->bindParam(':n12', htmlspecialchars($_POST['ie']));
    $updateEducation->execute();

    registerLog($net_rrhh, "Profile", "Education Information", "Update Education Information", "Actualizar Información Educativa");
    redirection("../?view=profile");

}else if($action == "Delete Education"){
               
    $Query = "Delete from employee_education where id=:n1";
        
    $deleteEducation = $net_rrhh->prepare($Query);
    $deleteEducation->bindParam(':n1', $_POST['ie']);        
    $deleteEducation->execute();

    registerLog($net_rrhh, "Profile", "Education Information", "Delete Education Information", "Eliminar Información Educativa");
    redirection("../?view=profile");
    
}
// INFORMACIÓN EDUCATIVA EXTRA
// ----------------------------------------------------------------
else if($action == "Update Education Register")
{
    $query = "DELETE FROM employee_education_register WHERE idemployee = :n1";
    $delete = $net_rrhh->prepare($query);
    $delete->bindParam(":n1", $_POST['ier']);
    $delete->execute();

    $query = "INSERT INTO employee_education_register VALUES(:id, :n1, :n2, :n3, :n4, CURRENT_TIMESTAMP)";
    $updateEducationR = $net_rrhh->prepare($query);
    $updateEducationR->bindParam(':id', htmlspecialchars($_POST['ier']));
    for ($i = 1; $i <= 4; $i++) {
        $updateEducationR->bindParam(':n'.$i, htmlspecialchars($_POST['data'.$i]));
    }
    $updateEducationR->execute();

    registerLog($net_rrhh, "Profile", "Education Information", "Update Education Information", "Actualizar Información Educativa Actual");
    redirection("../?view=profile");

}
// INFORMACIÓN FAMILIAR
// ----------------------------------------------------------------
else if($action == "Add Relative"){
    
    $query = "Insert into employee_familiar values(null, ";
    for ($i = 1; $i <= 9; $i++) {
        if($i == 9)
            $query .= ":n".$i.")";
        else
            $query .= ":n".$i.", ";
    }
    $insertRelative = $net_rrhh->prepare($query);
    for ($i = 1; $i <= 8; $i++) {
        $insertRelative->bindParam(':n'.$i, htmlspecialchars($_POST['data'.$i]));
    }
    $insertRelative->bindParam(':n9', htmlspecialchars($_POST['iu']));
    $insertRelative->execute();

    foreach($insertRelative->errorInfo() as $error)
        echo "$error <br/>";

    registerLog($net_rrhh, "Profile", "Family Information", "Add Family Information", "Agregar Información Familiar");
    redirection("../?view=profile");

}else if($action == "Update Relative"){

    $Query = "update employee_familiar set names=:n1, lastnames=:n2, parnert=:n3,
    phone=:n4, profession=:n5, workplace=:n6, emergency=:n7, dependen=:n8 where id=:n9";

    $updateRelative = $net_rrhh->prepare($Query);
    for ($i = 1; $i <= 8; $i++) {
        $updateRelative->bindParam(':n'.$i, htmlspecialchars($_POST['data'.$i]));
    }
    $updateRelative->bindParam(':n9', $_POST['ifm']);
    $updateRelative->execute();

    registerLog($net_rrhh, "Profile", "Family Information", "Update Family Information", "Actualizar Información Familiar");
    redirection("../?view=profile");

}else if($action == "Delete Relative"){
               
    $Query = "Delete from employee_familiar where id=:n1";
        
    $deleteRelative = $net_rrhh->prepare($Query);
    $deleteRelative->bindParam(':n1', $_POST['ifm']);        
    $deleteRelative->execute();

    registerLog($net_rrhh, "Profile", "Family Information", "Delete Family Information", "Eliminar Información Familiar");
    redirection("../?view=profile");
    
}
// MIS DOCUMENTOS
// ----------------------------------------------------------------
else if($action == "Add File")
{
    $tamano = $_FILES["file"]['size'];
    $tipo = $_FILES["file"]['type'];
    $archivo = $_FILES["file"]['name'];
    $prefijo = substr(md5(uniqid(rand())),0,4);     
    $archivo_info = pathinfo($_FILES['file']['name']);          

    if ($archivo != "") 
    {
        if($archivo_info['extension'] === 'exe') {
            echo "El archivo no puede ser un ejecutable (.exe)"; 
        }else{

            $namefile = $prefijo."_".$archivo;
            $destino =  $_SERVER['DOCUMENT_ROOT']."/process/documents/$namefile";
            if (copy($_FILES['file']['tmp_name'], $destino)) 
            {       

                echo $query = "INSERT INTO employee_files 
                        VALUES(NULL, :n1, :n2, :n3, :n4, :n5)";

                $InsertFiles = $net_rrhh->prepare($query);
                $InsertFiles->bindParam(':n1', $_SESSION['iu']); 
                $InsertFiles->bindParam(':n2', $_POST['filename']);  
                $InsertFiles->bindParam(':n3', $namefile);  
                $InsertFiles->bindParam(':n4', $_POST['type']);  
                $InsertFiles->bindParam(':n5', $_POST['ide']);  
                $InsertFiles->execute();      

                registerLog($net_rrhh, "Profile", "Documents", "Add Documents", "Agregar Documentos");
                redirection("../?view=profile");
            } 
            else             
                $status = "Error al subir el archivo. Vuelva a intentarlo";
        }                                      
    } 
    else         
        $status = "Error al subir archivo. Ingrese un archivo para guardar";

    echo $status;

}else if ($action == "Delete File"){

    $query = "DELETE FROM employee_files 
              WHERE id = :n1 AND type = :n2 AND idemployee = :n3 ";
    $deleteFiles = $net_rrhh->prepare($query);
    $deleteFiles->bindParam(':n1', $_POST['idf']);
    $deleteFiles->bindParam(':n2', $_POST['type']);
    $deleteFiles->bindParam(':n3', $_SESSION['iu']);
    $deleteFiles->execute();

    registerLog($net_rrhh, "Profile", "Documents", "Delete Documents", "Eliminar Documentos");
    redirection("../?view=profile");
}
// CONTRASEÑA
// ----------------------------------------------------------------
else if($action == "Update Password"){

    $query = "Update users set password = MD5(:n1) where id = :n2";
    $updatePassword = $net_rrhh->prepare($query);
    $updatePassword->bindParam(":n1", htmlspecialchars($_POST['password']));       
    $updatePassword->bindParam(":n2", htmlspecialchars($_POST['iu']));       
    $updatePassword->execute();

    registerLog($net_rrhh, "Profile", "Profile", "Update Password", "Actualizar Contraseña");
    redirection("../?view=profile");

}
// DATOS INSTITUCIONALES
// ----------------------------------------------------------------
else if($action == "Add Institutional"){

    $query = "INSERT INTO employee_institutional VALUES (NULL, :n1, :n2, :n3)";
    $addInstitutional = $net_rrhh->prepare($query);
    $addInstitutional->bindParam(":n1", htmlspecialchars($_POST['iu']));       
    $addInstitutional->bindParam(":n2", htmlspecialchars($_POST['txtEmail']));  
    $addInstitutional->bindParam(":n3", htmlspecialchars($_POST['txtContact']));       
    $addInstitutional->execute();

    registerLog($net_rrhh, "Profile", "Profile", "Add Institutional", "Agregar Información Institucional");
    redirection("../?view=profile&iu=".$_POST['iu']);

}
?>