<!-- VISTA PRINCIPAL DEL PERFIL -->
<?php

//Cargar datos del empleado
$iu = isset($_GET['iu']) ? $_GET['iu'] : $_SESSION['iu'];
$query = "SELECT  u.username, u.type FROM users as u 
          LEFT JOIN employee as e on u.id = $iu";

$user = $net_rrhh->prepare($query); 
$user->execute();
$dataUser = $user->fetch();

?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<div id="main">
    <div class="inner">

        <div id="content">
            <hr style='margin-top: 0px; padding-top: 0px;' />
            
            <div class="row">

                <div class="col-lg-12 col-md-12 col-xs-12">

                    <?php
                    //Cargar área y cargo del empleado
                    $query = "SELECT a.area, c.position 
                                FROM employee as e 
                                INNER JOIN workarea_positions_assignment as ca on ca.idemployee = e.id 
                                INNER JOIN workarea_positions as c on c.id = ca.idposition 
                                INNER JOIN workarea as a on c.idarea = a.id
                                WHERE enddate = '0000-00-00' AND ca.idemployee = " . $iu;

                    $Positions = $net_rrhh->prepare($query);
                    $Positions->execute();

                    ?>
                    <table style="width: 100%;">
                        <tr>
                            <td colspan='2'><b>Detalle de Usuario</b></td>
                        </tr>
                        <tr>
                            <td>Usuario: </td>
                            <td style="padding-left: 20px;"><?= $dataUser[0] ?></td>
                        </tr>
                        <tr>
                            <td>Tipo de Usuario:</td>
                            <td style="padding-left: 20px;"><?= $dataUser[1] ?></td>
                        </tr>
                        <?php
                        if ($Positions->rowCount() > 0) {
                            $datap = $Positions->fetch();
                            echo utf8_encode("<tr><td>&Aacute;rea: </td><td>$datap[0]</td></tr>
                                        <tr><td>Cargo: </td><td>$datap[1]</td></tr>");
                        } else
                            echo "<tr><td colspan='2'><b style='color: darkred'>Cargo no Asignado</b></td></tr>";
                        ?>
                    </table>
                    
                </div>
            </div>

        </div>

        <div id="sidebar">
            <?php
            //Cargar fotografía del empleado
            $query = "SELECT picture FROM employee_picture WHERE idemployee = " . $iu;
            $picture = $net_rrhh->prepare($query);
            $picture->execute();

            if ($picture->rowCount() > 0) {
                $dataI = $picture->fetch();
                $img = $dataI[0];
            } else
                $img = "h.jpg";
            ?>
            <section class="features">
                <img class="mx-auto d-block" src="process/pictures/<?=$img?>" style='width: 80%' />
            </section>

            <!-- Mostrar botón de actualizar contraseña si es el usuario del perfil -->
            <?php
            if ($iu == $_SESSION['iu']) {
            ?>
                <section class="features">
                    <table class='table'>
                        <tr>
                            <td>Nueva Contraseña:</td>
                            <td>
                                <a data-bs-toggle='modal' data-bs-target='#FormModalProfile' onclick="update(<?= $_SESSION['iu'] ?>)" style='color: #0B79DE; cursor: pointer;'>
                                    Actualizar
                                </a>
                            </td>
                        </tr>
                    </table>
                </section>
            <?php } ?>
        </div>

    </div>

    <div class="inner">
        <div class="col-lg-12 col-md-12 col-xs-12 mt-4">

            <!-- Pestañas de navegación -->
            <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#personal" type="button" role="tab" aria-controls="home" aria-selected="true">Información Personal</a>
                </li>          
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#education" type="button" role="tab" aria-controls="profile" aria-selected="false">Información Educativa</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#family" type="button" role="tab" aria-controls="contact" aria-selected="false">Información Familiar</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#religious" type="button" role="tab" aria-controls="contact" aria-selected="false">Información Religiosa</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#documents" type="button" role="tab" aria-controls="contact" aria-selected="false">Mis Documentos</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#assignations" type="button" role="tab" aria-controls="contact" aria-selected="false">Asignaciones</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">

                <!-- TAB INFORMACIÓN PERSONAL -->
                <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="home-tab">

                    <div class="mt-5 text-center position-relative">
                        <h2><i class="bi bi-person-circle"></i> INFORMACIÓN PERSONAL</h2>

                    <?php
                    //Cargar perfil personal
                    $query = "SELECT * FROM employee WHERE id = :n1";
                    $employe = $net_rrhh->prepare($query);
                    $employe->bindParam(':n1', $iu);
                    $employe->execute();
                    
                    if ($employe->rowCount() > 0) {
                        $dataE = $employe->fetch();

                        if ($iu == $_SESSION['iu'] || $_SESSION['type'] == "Administrador" || $_SESSION['type'] == "RRHH") {
                    ?> 
                            <button type="button" class="btn btn-info position-absolute top-0 end-0" data-bs-toggle="modal" data-bs-target="#FormModalProfile" onclick="personal('update')"><i class="bi bi-pencil-square"></i> Editar</button>
                    <?php
                    }
                    ?>
                    </div>

                        <hr/>

                        <div class="row">

                            <div class="col-6">
                                <table style="width: 100%;" class="mt-3">
                                    <tr>
                                        <td>Nombres: </td>
                                        <td style="padding-left: 20px;"><?= utf8_encode($dataE[1] . " " . $dataE[2] . " " . $dataE[3]) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Apellidos:</td>
                                        <td style="padding-left: 20px;"><?= utf8_encode($dataE[4] . " " . $dataE[5])?></td>
                                    </tr>
                                    <tr>
                                        <td>Dirección:</td>
                                        <td style="padding-left: 20px;"><?= utf8_encode($dataE[6])?></td>
                                    </tr>
                                    <tr>
                                        <td>Municipio:</td>
                                        <td style="padding-left: 20px;"><?= utf8_encode($dataE[7])?></td>
                                    </tr>
                                    <tr>
                                        <td>Departamento:</td>
                                        <td style="padding-left: 20px;"><?= utf8_encode($dataE[8])?></td>
                                    </tr>
                                    <tr>
                                        <td>Teléfono:</td>
                                        <td style="padding-left: 20px;"><?= utf8_encode($dataE[9])?></td>
                                    </tr>
                                    <tr>
                                        <td>Celular:</td>
                                        <td style="padding-left: 20px;"><?= utf8_encode($dataE[10])?></td>
                                    </tr>
                                    <tr>
                                        <td>Fecha de Nacimiento:</td>
                                        <td style="padding-left: 20px;"><?= utf8_encode($dataE[11])?></td>
                                    </tr>
                                    <tr>
                                        <td>Género:</td>
                                        <td style="padding-left: 20px;"><?php
                                            $genero = ($dataE[12] == 'M') ? 'Masculino' : 'Femenino';
                                            $genero = ($dataE[12] == 'O') ? 'Otro' : $genero;
                                            echo $genero;
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Estado Civil:</td>
                                        <td style="padding-left: 20px;"><?= utf8_encode($dataE[13])?></td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-6">
                                <table style="width: 100%;" class="mt-3">
                                    <tr>
                                        <td>Nacionalidad: </td>
                                        <td style="padding-left: 20px;"><?= utf8_encode($dataE[14])?></td>
                                    </tr>
                                    <tr>
                                        <td>DUI:</td>
                                        <td style="padding-left: 20px;"><?= utf8_encode($dataE[15])?></td>
                                    </tr>
                                    <tr>
                                        <td>Correo:</td>
                                        <td style="padding-left: 20px;"><?= utf8_encode($dataE[16])?></td>
                                    </tr>
                                    <tr>
                                        <td>Profesión:</td>
                                        <td style="padding-left: 20px;"><?= utf8_encode($dataE[17])?></td>
                                    </tr>
                                    <tr>
                                        <td>AFP:</td>
                                        <td style="padding-left: 20px;"><?= utf8_encode($dataE[18])?></td>
                                    </tr>
                                    <tr>
                                        <td>Número de AFP:</td>
                                        <td style="padding-left: 20px;"><?= utf8_encode($dataE[19])?></td>
                                    </tr>
                                    <tr>
                                        <td>ISSS:</td>
                                        <td style="padding-left: 20px;"><?= utf8_encode($dataE[20])?></td>
                                    </tr>
                                    <tr>
                                        <td>NIT:</td>
                                        <td style="padding-left: 20px;"><?= utf8_encode($dataE[21])?></td>
                                    </tr>
                                    <tr>
                                        <td>Altura:</td>
                                        <td style="padding-left: 20px;"><?= utf8_encode($dataE[22])?></td>
                                    </tr>
                                    <tr>
                                        <td>Peso:</td>
                                        <td style="padding-left: 20px;"><?= utf8_encode($dataE[23])?></td>
                                    </tr>
                                </table>
                            </div>
                            

                        </div>

                    <?php } else { ?>
                        <div class="col-12 col-12-xsmall mt-5">
                            <h4>Aún no existen datos registrados</h4>

                            <?php if ($iu == $_SESSION['iu'] || $_SESSION['type'] == "Administrador" || $_SESSION['type'] == "RRHH") { ?>
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#FormModalProfile" onclick="personal('add')">Añadir Datos Personales</button>
                            <?php } ?>

                        </div>
                    <?php } ?>
                </div>

                <!-- TAB INFORMACIÓN EDUCATIVA -->
                <div class="tab-pane fade" id="education" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="col-12 col-12-xsmall mt-5">
                        <h2>INFORMACIÓN EDUCATIVA </h2>
                    </div>
                    <?php
                    //Cargar perfil educativo actual
                    $query = "SELECT * FROM employee_education_register 
                                WHERE idemployee = $iu";
                    $educationInfo = $net_rrhh->prepare($query);
                    $educationInfo->execute();
                    $data = $educationInfo->fetch();

                    $displayInfo = ($data[1] == "Si") ? 'table-row' : 'none';
                    ?>
                    <table style="width: 100%">
                        <tr>
                            <td colspan="2">
                                ¿Estudian actualmente?<b>
                                    <br /><?= $data[1] ?></b>
                            </td>

                            <?php if ($iu == $_SESSION['iu'] || $_SESSION['type'] == "Administrador" || $_SESSION['type'] == "RRHH") { ?>
                                <td><button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#FormModalProfile" onclick="eduRegister(<?= $iu; ?>)">Editar</button></td>
                            <?php } ?>

                        </tr>
                        <tr style='display: <?= $displayInfo ?>'>
                            <td>Institución<b><br /><?= $data[2] ?></b></td>
                            <td>¿Qué estudias?<b><br /><?= $data[3] ?></b></td>
                            <td>¿Qué nivel?<b><br /><?= $data[4] ?></b></td>
                        </tr>
                    </table>

                    <div class="row">
                        <div class="col-6 col-12-xsmall mt-5">
                            <h2>HISTORIAL EDUCATIVO </h2>
                        </div>

                        <?php if ($iu == $_SESSION['iu'] || $_SESSION['type'] == "Administrador" || $_SESSION['type'] == "RRHH") { ?>
                            <div class="col-6 col-12-xsmall ms-auto mt-5">
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#FormModalProfile" onclick="education(0, 'add')">Añadir Historial</button>
                            </div>
                        <?php } ?>
                    </div>

                    <table style="width: 100%;" class="mt-4">
                        <tr>
                            <th>Institución</th>
                            <th>Educación</th>
                            <th>Nivel, Título o Diploma obtenido</th>
                            <th colspan="3">Acciones</th>
                        </tr>
                        <?php
                        //Cargar historial educativo
                        $query = "SELECT * FROM employee_education WHERE idemployee = $iu";
                        $educationInfo = $net_rrhh->prepare($query);
                        $educationInfo->execute();

                        while ($datar = $educationInfo->fetch()) {
                            echo "<tr>
                                    <td>".  $datar[2] ."</td>
                                    <td>".  $datar[1] ."</td>
                                    <td>".  $datar[3] ."</td>
                                    <td>
                                        <a data-bs-toggle='modal' data-bs-target='#FormModalProfile' onclick='education($datar[0], \"watch\")'
                                        style='color: #0B79DE; cursor: pointer;'>
                                            <i class='fas fa-eye'></i>
                                        </a>
                                    </td>;";
                            if ($iu == $_SESSION['iu'] || $_SESSION['type'] == "Administrador" || $_SESSION['type'] == "RRHH") {
                                echo "<td>
                                    <a data-bs-toggle='modal' data-bs-target='#FormModalProfile' onclick='education($datar[0], \"update\")'
                                    style='color: #0B79DE; cursor: pointer;'>
                                        <i class='fas fa-edit'></i>
                                    </a>
                                </td> 
                                <td>
                                    <a data-bs-toggle='modal' data-bs-target='#FormModalProfile' onclick='education($datar[0], \"delete\")'
                                    style='color: #0B79DE; cursor: pointer;'>
                                        <i class='fas fa-trash-alt'></i>
                                    </a>
                                </td>";
                            }
                            echo "</tr>";
                        }
                        ?>
                    </table>

                </div>

                <!-- TAB INFORMACIÓN FAMILIAR -->
                <div class="tab-pane fade" id="family" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="row">
                        <div class="col-6 col-12-xsmall mt-5">
                            <h2>INFORMACIÓN DE SU GRUPO FAMILIAR </h2>
                        </div>

                        <?php if ($iu == $_SESSION['iu'] || $_SESSION['type'] == "Administrador" || $_SESSION['type'] == "RRHH") { ?>
                            <div class="col-6 col-12-xsmall ms-auto mt-5">
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#FormModalProfile" onclick="family(0, 'add')">Añadir Familiar</button>
                            </div>
                        <?php } ?>

                    </div>

                    <table style="width: 100%;" class="mt-5">
                        <tr>
                            <th>Familiar</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Teléfono</th>
                            <th>Lugar de Trabajo</th>
                            <th>Llamar en Emergencias</th>
                            <?php if ($iu == $_SESSION['iu'] || $_SESSION['type'] == "Administrador" || $_SESSION['type'] == "RRHH") { ?>
                                <th colspan="2">Acciones</th>
                            <?php } ?>
                        </tr>
                        <?php
                        //Cargar perfil familiar que no depende económicamente
                        $query = "SELECT * FROM employee_familiar WHERE (dependen = 'No' OR dependen = '') AND idemployee = " . $iu;
                        $infoFamiliar = $net_rrhh->prepare($query);
                        $infoFamiliar->execute();

                        while ($dataif = $infoFamiliar->fetch()) {
                            echo "<tr>
                                    <td>$dataif[3]</td>
                                                <td>$dataif[1]</td>
                                                <td>$dataif[2]</td>                                                        
                                                <td>$dataif[4]</td>
                                                <td>$dataif[6]</td>                                    
                                                <td>$dataif[7]</td>";
                            if ($iu == $_SESSION['iu'] || $_SESSION['type'] == "Administrador" || $_SESSION['type'] == "RRHH") {
                                echo "<td>
                                                    <a data-bs-toggle='modal' data-bs-target='#FormModalProfile' onclick='family($dataif[0], \"update\")'
                                                    style='color: #0B79DE; cursor: pointer;'>
                                                        <i class='fas fa-edit'></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a data-bs-toggle='modal' data-bs-target='#FormModalProfile' onclick='family($dataif[0], \"delete\")'
                                                    style='color: #0B79DE; cursor: pointer;'>
                                                        <i class='fas fa-trash-alt'></i>
                                                    </a>
                                                </td>";
                            }
                            echo "</tr>";
                        }
                        ?>

                    </table>
                    <hr />
                    <div class="col-12 col-12-xsmall mt-5">
                        <h2>FAMILIAR QUE DEPENDEN ECONÓMICAMENTE DE USTED </h2>
                    </div>
                    <table style="width: 100%;" class="mt-5">
                        <tr>
                            <th>Familiar</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Teléfono</th>
                            <th>Lugar de Trabajo</th>
                            <th>Llamar en Emergencias</th>

                            <?php if ($iu == $_SESSION['iu'] || $_SESSION['type'] == "Administrador" || $_SESSION['type'] == "RRHH") { ?>
                                <th colspan="2">Acciones</th>
                            <?php } ?>
                        </tr>
                        <?php
                        //Cargar perfil familiar que depende económicamente
                        $query = "SELECT * FROM employee_familiar WHERE dependen = 'Si' AND idemployee = " . $iu;
                        $infoFamiliar = $net_rrhh->prepare($query);
                        $infoFamiliar->execute();

                        while ($dataif = $infoFamiliar->fetch()) {
                            echo "<tr>
                                                    <td>$dataif[3]</td>
                                                    <td>$dataif[1]</td>
                                                    <td>$dataif[2]</td>                                                        
                                                    <td>$dataif[4]</td>
                                                    <td>$dataif[6]</td>                                    
                                                    <td>$dataif[7]</td>";
                            if ($iu == $_SESSION['iu'] || $_SESSION['type'] == "Administrador" || $_SESSION['type'] == "RRHH") {
                                echo "<td>
                                                        <a data-bs-toggle='modal' data-bs-target='#FormModalProfile' onclick='family($dataif[0], \"update\")'
                                                        style='color: #0B79DE; cursor: pointer;'>
                                                            <i class='fas fa-edit'></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a data-bs-toggle='modal' data-bs-target='#FormModalProfile' onclick='family($dataif[0], \"delete\")'
                                                        style='color: #0B79DE; cursor: pointer;'>
                                                            <i class='fas fa-trash-alt'></i>
                                                        </a>
                                                    </td>";
                            }
                            echo "</tr>";
                        }
                        ?>
                    </table>
                </div>

                <!-- TAB INFORMACIÓN RELIGIOSA -->
                <div class="tab-pane fade" id="religious" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="col-12 col-12-xsmall mt-5">
                        <h2>INFORMACIÓN RELIGIOSA </h2>
                    </div>
                    <?php
                    //Cargar perfil religioso
                    $query = "Select * from employee_religious where id_employee = " . $iu;
                    $DatosReligiosos = $net_rrhh->prepare($query);
                    $DatosReligiosos->execute();
                    if ($DatosReligiosos->rowCount() > 0) {
                        $dataR = $DatosReligiosos->fetch();
                        if ($iu == $_SESSION['iu'] || $_SESSION['type'] == "Administrador" || $_SESSION['type'] == "RRHH") {
                    ?>
                            <div class="col-12 col-12-xsmall mt-3">
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#FormModalProfile" onclick="religious(<?= $iu; ?>)">Editar</button>
                            </div>
                        <?php } ?>
                        <table style="width: 100%;" class="mt-5">
                            <tr>
                                <td>Religión: </td>
                                <td style="padding-left: 20px"><?= $dataR[1]; ?></td>
                            </tr>
                            <tr>
                                <td>Congregación: </td>
                                <td style="padding-left: 20px"><?= utf8_encode($dataR[2]); ?></td>
                            </tr>
                            <tr>
                                <td>Dirección: </td>
                                <td style="padding-left: 20px"><?= utf8_encode($dataR[3]); ?></td>
                            </tr>
                            <tr>
                                <td>Sacramento 1: </td>
                                <td style="padding-left: 20px"><?= utf8_encode($dataR[4]); ?></td>
                            </tr>
                            <tr>
                                <td>Sacramento 2: </td>
                                <td style="padding-left: 20px"><?= utf8_encode($dataR[5]); ?></td>
                            </tr>
                            <tr>
                                <td>Sacramento 3: </td>
                                <td style="padding-left: 20px"><?= utf8_encode($dataR[6]); ?></td>
                            </tr>
                            <tr>
                                <td>Sacramento 4: </td>
                                <td style="padding-left: 20px"><?= utf8_encode($dataR[7]); ?></td>
                            </tr>
                            <tr>
                                <td>Sacramento 5: </td>
                                <td style="padding-left: 20px"><?= utf8_encode($dataR[8]); ?></td>
                            </tr>
                            <tr>
                                <td>Sacramento 6: </td>
                                <td style="padding-left: 20px"><?= utf8_encode($dataR[9]); ?></td>
                            </tr>
                            <tr>
                                <td>Sacramento 7: </td>
                                <td style="padding-left: 20px"><?= utf8_encode($dataR[10]); ?></td>
                            </tr>
                        </table>

                    <?php
                    } else {
                    ?>

                        <div class="col-12 col-12-xsmall mt-5">
                            <h4>Aún no existen datos registrados</h4>

                            <?php if ($iu == $_SESSION['iu'] || $_SESSION['type'] == "Administrador" || $_SESSION['type'] == "RRHH") { ?>
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#FormModalProfile" onclick="religious(0)">Añadir Datos Religiosos</button>
                            <?php } ?>

                        </div>

                    <?php
                    }
                    ?>

                </div>

                <!-- MIS DOCUMENTOS -->
                <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="col-12 col-12-xsmall mt-5">
                        <h2>MIS DOCUMENTOS</h2>
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <th>Tipo</th>
                            <th>Archivo</th>
                            <th>Acciones</th>

                            <?php if ($iu == $_SESSION['iu'] || $_SESSION['type'] == "Administrador" || $_SESSION['type'] == "RRHH") { ?>
                                <th style='text-align: right; color: blue'>
                                    <a data-bs-toggle='modal' data-bs-target='#FormModalProfile' onclick='files()' style='color: #0B79DE; cursor: pointer;'>
                                        Añadir Documento
                                    </a>
                                </th>
                            <?php } ?>

                        </tr>
                        <?php
                        //Cargar listado de documentos
                        $query = "SELECT f.* FROM employee_files as f
                                WHERE f.type = 'Documents' AND f.idemployee = " . $iu;

                        $Files = $net_rrhh->prepare($query);
                        $Files->execute();

                        if ($Files->rowCount() > 0) {
                            while ($data = $Files->fetch()) {
                                echo "<tr>
                                    <th>$data[2]</th>
                                    <th>
                                        <a href='process/documents/$data[3]' target='_blank'>
                                            <i class='fa fa-file'></i>
                                            Descargar
                                        <a>
                                    </th>";
                                //Hablitar botón eliminar al dueño del perfil
                                if ($iu == $_SESSION['iu'] || $_SESSION['type'] == "Administrador" || $_SESSION['type'] == "RRHH") {
                                    echo "<th>
                                            <form action='process/' method='post'>
                                                <input type='hidden' name='process' value='Profile'>
                                                <input type='hidden' name='action' value='Delete File'>                     
                                                <input type='hidden' name='type' value='Documents'>  
                                                <input type='hidden' name='idf' value='$data[0]'>                                          
                                                <a onclick='DeleteFile(this)' style='color: #F50501; cursor: pointer;'>
                                                    <i class='fa fa-trash'></i>
                                                    Eliminar
                                                </a>
                                            </form>
                                        </th>";
                                }
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr>
                                <th colspan='3'>
                                    <b>No se encuentran documentos registrados</b>
                                </th>
                              </tr>";
                        }

                        ?>
                    </table>

                </div>

                <!-- TAB ASIGNACIONES -->
                <div class="tab-pane fade" id="assignations" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="col-12 col-12-xsmall mt-5">
                        <h2 class="text-center">MIS ASIGNACIONES</h2>
                    </div>

                        <?php
                        //Cargar activos asignados
                        $query = "SELECT ia.id, ia.employee, e.name1, e.lastname1, a.fixedasset, ct.value as 'tipo', 
                        cb.value as 'marca' , a.model, ia.date_assignation, ia.date_return, ia.state
                        FROM `inventory_assignation` as ia 
                        INNER JOIN employee as e ON e.id = ia.employee
                        INNER JOIN inventory_active as a ON a.id = ia.active
                        INNER JOIN catalogue as ct ON a.type = ct.id AND ct.type = 'Tipo'
                        INNER JOIN catalogue as cb ON a.brand = cb.id AND cb.type = 'Marca'
                        WHERE ia.employee = " . $iu;
                        $assignations = $net_rrhh->prepare($query);
                        $assignations->execute();

                        if ($assignations->rowCount() > 0) {

                        ?>
                        <table id="assignationsTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Equipo</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Estado</th>
                                    <th>Fecha de Asignación</th>
                                    <th>Fecha de Devolución</th>
                                    <th>Detalles</th>
                                </tr>
                            </thead>
                        <tbody>
                        <?php
                            $i=0;
                            while($dataA = $assignations->fetch()){

                                
                                $i++;
                                echo "<tr>
                                        <td>$i</td>
                                        <td>$dataA[4]</td>
                                        <td>$dataA[5]</td>
                                        <td>$dataA[7]</td>
                                        <td>$dataA[10]</td>
                                        <td>$dataA[8]</td>
                                        <td>";
                                        echo $echo = ($dataA[9] == null) ? '(Sin devolución)' : $dataA[4];
                                        echo "</td>
                                        <td>
                                            <a role='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#FormModalProfile' onclick='assignations($dataA[0])'><i class='bi bi-eye-fill'></i></button>
                                        </td>
                                    </tr>";
                            }
                        ?>
                        </tbody>
                    </table>
                            

                    <?php
                    } else {
                    ?>

                        <div class="col-12 col-12-xsmall mt-5">
                            <h4>Aún no existen datos registrados</h4>

                        </div>

                    <?php
                    }
                    ?>

                </div>


            </div>
        </div>
    </div>
</div>

<!-- MODAL PRINCIPAL -->
<div class="modal fade" id="FormModalProfile" tabindex="-1" aria-labelledby="FormModal" aria-hidden="true">
    <?php include("view/profile/profile.modal.php"); ?>
</div>

<!-- Modal Institucional -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <form action="process/" method="post">

        <input type="hidden" name="iu" id="iu" value="<?=$iu?>">
        <input type="hidden" name="process" id="process" value="Profile">
        <input type="hidden" name="action" id="action" value="Add Institutional">

      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Actualización de Datos</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div>
    </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<script>

    //Activar DataTable
    $(document).ready(function(){
        $('#assignationsTable').DataTable();
    });

    //Cargar formularios de perfil educativo
    function education(ie, action){
        $("#btnActionProfile").css('display', 'block');
        $("#loadModalProfile").load("view/profile/profile.education.php", {
            ie: ie,
            action: action
        });

        if (action == 'add') {
            $("#btnActionProfile").removeClass().addClass('btn btn-success');
            $("#btnActionProfile").text('Guardar');
            
        } else if (action == 'update') {
            $("#btnActionProfile").removeClass().addClass('btn btn-primary');
            $("#btnActionProfile").text('Actualizar');
        } else if (action == 'watch') {
            $("#btnActionProfile").removeClass().addClass('btn btn-info');
            $("#btnActionProfile").text('Visualizar');
        } else {
            $("#btnActionProfile").removeClass().addClass('btn btn-danger');
            $("#btnActionProfile").text('Eliminar');
        }
    }

    //Cargar formularios de perfil familiar
    function family(ifm, action) {
        $("#btnActionProfile").css('display', 'block');
        $("#loadModalProfile").load("view/profile/profile.family.php", {
            ifm: ifm,
            action: action
        });
        if (action == 'add') {
            $("#btnActionProfile").removeClass().addClass('btn btn-success');
            $("#btnActionProfile").text('Guardar');
        } else if (action == 'update') {
            $("#btnActionProfile").removeClass().addClass('btn btn-primary');
            $("#btnActionProfile").text('Actualizar');
        } else {
            $("#btnActionProfile").removeClass().addClass('btn btn-danger');
            $("#btnActionProfile").text('Eliminar');
        }

    }

    //Cargar formulario para actualizar contraseña 
    function update(iu) {
        $("#btnActionProfile").css('display', 'block');
        $("#loadModalProfile").load("view/profile/profile.form.php", {
            iu: iu
        });
        $("#btnActionProfile").removeClass().addClass('btn btn-primary');
        $("#btnActionProfile").text('Actualizar');
    }

    //Cargar formulario para actualizar foto de perfil
    function picture(iu) {
        $("#loadModalProfile").load("view/transcript/transcript.picture.php", {
            iu: iu
        });
        $("#btnActionProfile").removeClass();
        $("#btnActionProfile").css('display', 'none');
    }

    //Cargar formularios de perfil personal
    function personal(action) {
        $("#btnActionProfile").css('display', 'block');
        $("#loadModalProfile").load("view/profile/profile.form.php", {
            ip: <?=$iu?>,
            module: 'personal',
            action: action
        });
        if (action == 'add') {
            $("#btnActionProfile").removeClass().addClass('btn btn-success');
            $("#btnActionProfile").text('Guardar');
        } else {
            $("#btnActionProfile").removeClass().addClass('btn btn-primary');
            $("#btnActionProfile").text('Actualizar');
        }
    }

    //Cargar formularios de perfil religioso
    function religious(ir) {
        $("#btnActionProfile").css('display', 'block');
        $("#loadModalProfile").load("view/profile/profile.religious.php", {
            ir: ir
        });
        if (ir == 0) {
            $("#btnActionProfile").removeClass().addClass('btn btn-success');
            $("#btnActionProfile").text('Guardar');
        } else {
            $("#btnActionProfile").removeClass().addClass('btn btn-primary');
            $("#btnActionProfile").text('Actualizar');
        }
    }

    //Cargar formulario para subir un documento
    function files() {
        $("#btnActionProfile").css('display', 'block');
        $("#loadModalProfile").load("view/profile/profile.files.php");
        $("#btnActionProfile").removeClass().addClass('btn btn-success');
        $("#btnActionProfile").text('Guardar');
    }

    //Cargar formualario de educación actual
    function eduRegister(iu) {
        $("#btnActionProfile").css('display', 'block');
        $("#loadModalProfile").load("view/profile/profile.education.register.php", {
            iu: iu
        });
        $("#btnActionProfile").removeClass().addClass('btn btn-primary');
        $("#btnActionProfile").text('Actualizar');
    }

    //Eliminar documento
    function DeleteFile(a) {
        if (confirm("¿Estas seguro de Eliminar el archivo?"))
            $(a).parent().submit()
    }

    //Cargar información de asignaciones
    function assignations(id) {
        $("#loadModalProfile").load("view/profile/profile.assignations.php", {
            id: id
        });
        $("#btnActionProfile").css("display", "none"); 
    }
</script>