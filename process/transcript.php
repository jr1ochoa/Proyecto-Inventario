<?php

if($action == 'Personal')
{
    $query = "SELECT * FROM employee WHERE id = ".$_SESSION['iu'];
    $Select = $net_rrhh->prepare($query);
    $Select->execute();

    if($Select->rowCount() == 0)
    {
        $query = "INSERT INTO employee (id) VALUE(".$_SESSION['iu'].")";
        $Insert = $net_rrhh->prepare($query);
        $Insert->execute();
    }


    $Dui = $_POST['dui']."@".$_POST['datedui'];
    // Personal table
    $query = "UPDATE employee SET
                name1 = :n1,
                name2 = :n2,
                name3 = :n3,
                lastname1 = :n4,
                lastname2 = :n5,
                address = :n6,
                phone = :n7,
                celphone = :n8,
                civil = :n9,
                profession = :n10,
                dui = :n11
              WHERE id = :n12";

    $update = $net_rrhh->prepare($query);
    $update->bindParam(':n1', htmlspecialchars($_POST['name1']));
    $update->bindParam(':n2', htmlspecialchars($_POST['name2']));
    $update->bindParam(':n3', htmlspecialchars($_POST['name3']));
    $update->bindParam(':n4', htmlspecialchars($_POST['name4']));
    $update->bindParam(':n5', htmlspecialchars($_POST['name5']));
    $update->bindParam(':n6', htmlspecialchars($_POST['address']));
    $update->bindParam(':n7', htmlspecialchars($_POST['phone1']));
    $update->bindParam(':n8', htmlspecialchars($_POST['phone2']));
    $update->bindParam(':n9', htmlspecialchars($_POST['civil']));
    $update->bindParam(':n10', htmlspecialchars($_POST['profession']));
    $update->bindParam(':n11', htmlspecialchars($Dui));
    $update->bindParam(':n12', $_SESSION['iu']);
    $update->execute();
    
    // Religion table
    $query = "UPDATE employee_religious SET
                religion = :n1
              WHERE id_employee = :n2";

    $update = $net_rrhh->prepare($query);
    $update->bindParam(':n1', htmlspecialchars($_POST['religion']));
    $update->bindParam(':n2', $_SESSION['iu']);
    $update->execute();

    //Guardar Registro de Actualización
    $query = "DELETE FROM employee_updates WHERE part = 'Personal' AND idemployee = ".$_SESSION['iu'];
    $Delete = $net_rrhh->prepare($query);
    $Delete->execute();

    $query = "INSERT INTO employee_updates VALUES(NUll, :n1, 'Personal', CURRENT_TIMESTAMP)";
    $Insert = $net_rrhh->prepare($query);
    $Insert->bindParam(':n1', $_SESSION['iu']);
    $Insert->execute();    

    registerLog($net_rrhh, "Employee", $process, $action, "Actualización de Información Personal");
    redirection('../?view=transcript&part=personal&msg=1');
}

else if($action == 'Add Familiar')
{
    $query = "INSERT INTO employee_familiar 
              VALUES(Null, :n1, :n2, :n3, :n4, :n5, :n6, :n7, :n8, :iu)";

    $insert = $net_rrhh->prepare($query);
    $insert->bindParam(':n1', htmlspecialchars($_POST['names']));
    $insert->bindParam(':n2', htmlspecialchars($_POST['surnames']));
    $insert->bindParam(':n3', htmlspecialchars($_POST['relationship']));
    $insert->bindParam(':n4', htmlspecialchars($_POST['phone']));
    $insert->bindParam(':n5', htmlspecialchars($_POST['profession']));
    $insert->bindParam(':n6', htmlspecialchars($_POST['workplace']));
    $insert->bindParam(':n7', htmlspecialchars($_POST['emergency']));
    $insert->bindParam(':n8', htmlspecialchars($_POST['depend']));
    $insert->bindParam(':iu', $_SESSION['iu']);
    $insert->execute();

    //Guardar Registro de Actualización
    $query = "DELETE FROM employee_updates WHERE part = 'Familiar' AND idemployee = ".$_SESSION['iu'];
    $Delete = $net_rrhh->prepare($query);
    $Delete->execute();

    $query = "INSERT INTO employee_updates VALUES(NUll, :n1, 'Familiar', CURRENT_TIMESTAMP)";
    $Insert = $net_rrhh->prepare($query);
    $Insert->bindParam(':n1', $_SESSION['iu']);
    $Insert->execute();    

    registerLog($net_rrhh, "Employee", $process, $action, "Ingreso de Familiar");
    redirection('../?view=transcript&part=familiar&msg=2');    
}

else if($action == 'Delete Familiar')
{
    $query = "DELETE FROM employee_familiar 
              WHERE id = :n1 AND idemployee = :iu";

    $Delete = $net_rrhh->prepare($query);
    $Delete->bindParam(':n1', $_POST['idf']);
    $Delete->bindParam(':iu', $_SESSION['iu']);
    $Delete->execute();

    //Guardar Registro de Actualización
    $query = "DELETE FROM employee_updates WHERE part = 'Familiar' AND idemployee = ".$_SESSION['iu'];
    $Delete = $net_rrhh->prepare($query);
    $Delete->execute();

    $query = "INSERT INTO employee_updates VALUES(NUll, :n1, 'Familiar', CURRENT_TIMESTAMP)";
    $Insert = $net_rrhh->prepare($query);
    $Insert->bindParam(':n1', $_SESSION['iu']);
    $Insert->execute();    

    registerLog($net_rrhh, "Employee", $process, $action, "Eliminar de Familiar");
    redirection('../?view=transcript&part=familiar&msg=3'); 

}

else if($action == "Update Familiar")
{
    $query = "UPDATE employee_familiar SET
                names = :n1,
                lastnames = :n2, 
                parnert = :n3,
                phone = :n4, 
                profession = :n5, 
                workplace = :n6,
                emergency = :n7,
                dependen = :n8
              WHERE id = :n9 AND idemployee = :iu";

    $Update = $net_rrhh->prepare($query);
    $Update->bindParam(':n1', htmlspecialchars($_POST['names']));
    $Update->bindParam(':n2', htmlspecialchars($_POST['surnames']));
    $Update->bindParam(':n3', htmlspecialchars($_POST['relationship']));
    $Update->bindParam(':n4', htmlspecialchars($_POST['phone']));
    $Update->bindParam(':n5', htmlspecialchars($_POST['profession']));
    $Update->bindParam(':n6', htmlspecialchars($_POST['workplace']));
    $Update->bindParam(':n7', htmlspecialchars($_POST['emergency']));
    $Update->bindParam(':n8', htmlspecialchars($_POST['depend']));
    $Update->bindParam(':n9', htmlspecialchars($_POST['idf']));
    $Update->bindParam(':iu', $_SESSION['iu']);
    $Update->execute();    

    //Guardar Registro de Actualización
    $query = "DELETE FROM employee_updates WHERE part = 'Familiar' AND idemployee = ".$_SESSION['iu'];
    $Delete = $net_rrhh->prepare($query);
    $Delete->execute();

    $query = "INSERT INTO employee_updates VALUES(NUll, :n1, 'Familiar', CURRENT_TIMESTAMP)";
    $Insert = $net_rrhh->prepare($query);
    $Insert->bindParam(':n1', $_SESSION['iu']);
    $Insert->execute();    

    registerLog($net_rrhh, "Employee", $process, $action, "Actualizar Familiar");
    redirection('../?view=transcript&part=familiar&msg=4'); 
}

else if($action == "Education Informaction")
{
    $query = "DELETE FROM employee_education_register 
              WHERE idemployee = :n1";
    $Delete = $net_rrhh->prepare($query);
    $Delete->bindParam(':n1', $_SESSION['iu']);
    $Delete->execute();

    $query = "INSERT INTO employee_education_register 
              VALUES(:n1, :n2, :n3, :n4, :n5, CURRENT_TIMESTAMP)";        
    $Insert = $net_rrhh->prepare($query);
    $Insert->bindParam(':n1', $_SESSION['iu']);
    $Insert->bindParam(':n2', htmlspecialchars($_POST['study']));
    $Insert->bindParam(':n3', htmlspecialchars($_POST['institution']));
    $Insert->bindParam(':n4', htmlspecialchars($_POST['whatstudy']));    
    $Insert->bindParam(':n5', htmlspecialchars($_POST['level']));
    $Insert->execute();

    //Guardar Registro de Actualización
    $query = "DELETE FROM employee_updates WHERE part = 'Education' AND idemployee = ".$_SESSION['iu'];
    $Delete = $net_rrhh->prepare($query);
    $Delete->execute();

    $query = "INSERT INTO employee_updates VALUES(NUll, :n1, 'Education', CURRENT_TIMESTAMP)";
    $Insert = $net_rrhh->prepare($query);
    $Insert->bindParam(':n1', $_SESSION['iu']);
    $Insert->execute();    

    registerLog($net_rrhh, "Employee", $process, $action, "Actualizar Información Educativa Actual");
    redirection('../?view=transcript&part=education&msg=5');     
}


else if($action == "Add Education")
{
    $query = "INSERT INTO employee_education 
              VALUES(NULL, :n1, :n2, :n3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, :n4)";        
    $Insert = $net_rrhh->prepare($query);
    $Insert->bindParam(':n1', htmlspecialchars($_POST['level']));
    $Insert->bindParam(':n2', htmlspecialchars($_POST['institution']));    
    $Insert->bindParam(':n3', htmlspecialchars($_POST['whatstudy']));
    $Insert->bindParam(':n4', $_SESSION['iu']);
    $Insert->execute();

    //Guardar Registro de Actualización
    $query = "DELETE FROM employee_updates WHERE part = 'Education' AND idemployee = ".$_SESSION['iu'];
    $Delete = $net_rrhh->prepare($query);
    $Delete->execute();

    $query = "INSERT INTO employee_updates VALUES(NUll, :n1, 'Education', CURRENT_TIMESTAMP)";
    $Insert = $net_rrhh->prepare($query);
    $Insert->bindParam(':n1', $_SESSION['iu']);
    $Insert->execute();    
    
    registerLog($net_rrhh, "Employee", $process, $action, "Añadir Registro de Educación");
    redirection('../?view=transcript&part=education&msg=6');     
}

else if($action == "Delete Education")
{
    $query = "DELETE FROM employee_education 
              WHERE IdDatoAcademico = :n1 AND IdEmpleado_Fk = :n2";        
    $Insert = $net_rrhh->prepare($query);
    $Insert->bindParam(':n1', $_POST['ide']);
    $Insert->bindParam(':n2', $_SESSION['iu']);
    $Insert->execute();

    //Guardar Registro de Actualización
    $query = "DELETE FROM employee_updates WHERE part = 'Education' AND idemployee = ".$_SESSION['iu'];
    $Delete = $net_rrhh->prepare($query);
    $Delete->execute();

    $query = "INSERT INTO employee_updates VALUES(NUll, :n1, 'Education', CURRENT_TIMESTAMP)";
    $Insert = $net_rrhh->prepare($query);
    $Insert->bindParam(':n1', $_SESSION['iu']);
    $Insert->execute();    

    registerLog($net_rrhh, "Employee", $process, $action, "Eliminar Registro de Educación");
    redirection('../?view=transcript&part=education&msg=7');     
}

else if($action == "Update Education")
{
    $query = "UPDATE employee_education SET 
                level = :n1, 
                institution = :n2, 
                degree = :n3 
              WHERE IdDatoAcademico = :n4 AND IdEmpleado_Fk = :iu"; 

    $Update = $net_rrhh->prepare($query);
    $Update->bindParam(':n1', htmlspecialchars($_POST['level']));
    $Update->bindParam(':n2', htmlspecialchars($_POST['institution']));
    $Update->bindParam(':n3', htmlspecialchars($_POST['whatstudy']));
    $Update->bindParam(':n4', htmlspecialchars($_POST['ide']));
    $Update->bindParam(':iu', $_SESSION['iu']);
    $Update->execute();

    //Guardar Registro de Actualización
    $query = "DELETE FROM employee_updates WHERE part = 'Education' AND idemployee = ".$_SESSION['iu'];
    $Delete = $net_rrhh->prepare($query);
    $Delete->execute();

    $query = "INSERT INTO employee_updates VALUES(NUll, :n1, 'Education', CURRENT_TIMESTAMP)";
    $Insert = $net_rrhh->prepare($query);
    $Insert->bindParam(':n1', $_SESSION['iu']);
    $Insert->execute();    

    registerLog($net_rrhh, "Employee", $process, $action, "Actualizar Registro de Educación");
    redirection('../?view=transcript&part=education&msg=8');     
}

?>