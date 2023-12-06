<!-- FORMULARIO DEL PERFIL PERSONAL -->

<?php include("../../config/net.php"); //Conexión a BDD

//Actualizar contraseña
if (isset($_REQUEST['iu'])) {
    $iu = $_REQUEST['iu'];
?>

    <form action="process/" method="post" id="formProfile">
        <h2 class="text-uppercase fw-bolder">Actualizar Contraseña</h2>
        <input type="hidden" class="form-control" name="process" value="Profile">
        <input type="hidden" class="form-control" name="action" value="Update Password" />
        <input type="hidden" name="iu" value="<?= $iu; ?>" />

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Nueva Contraseña:</label>
            <input type="password" class="form-control" name="password">
        </div>

    </form>
<?php
//Agregar datos personales
} else if (isset($_REQUEST['ip'])) 
{
    $ip = $_REQUEST['ip'];
    $action = "Add Personal";
    $query = "SELECT * FROM employee WHERE id = " . $ip;
    $employee = $net_rrhh->prepare($query);
    $employee->execute();
    $dataE = $employee->fetch();
        
    $verf = (isset($_REQUEST['module'])) ? 1 : 0;  
}
?>

<?php
        if ($ip != 0){
            echo '<h2 class="text-uppercase fw-bolder">Actualizar Información Personal</h2>';
        }else{
            echo '<h2 class="text-uppercase fw-bolder">Agregar Información Personal</h2>';
        }
    ?>
    
    <!-- Formulario -->
    <form action="process/" method="post" id="formProfile">

        <input type="hidden" class="form-control" name="process" value="Profile">
        <input type="hidden" class="form-control" name="module" id="module" value="<?= $verf; ?>">
        <input type="hidden" class="form-control" name="action" value="<?= $action; ?>" />
        <input type="hidden" name="ip" value="<?= $ip; ?>" />

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Primer Nombre: <b class="text-center text-danger">*</b></label>
            <input type="text" class="form-control" name="data1" value="<?= utf8_encode($dataE[1]); ?>" maxlength="50" required> 
        </div>

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Segundo Nombre: <b class="text-center text-danger">*</b></label>
            <input type="text" class="form-control" name="data2" value="<?= utf8_encode($dataE[2]); ?>" maxlength="25" required>
        </div>

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Tercer Nombre (Si posee):</label>
            <input type="text" id="txtThirdName" class="form-control" name="data3" value="<?= utf8_encode($dataE[3]); ?>" maxlength="25" required>
        </div>

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Primer Apellido: <b class="text-center text-danger">*</b></label>
            <input type="text" class="form-control" name="data4" value="<?= utf8_encode($dataE[4]); ?>" maxlength="50" required>
        </div>

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Segundo Apellido: <b class="text-center text-danger">*</b></label>
            <input type="text" class="form-control" name="data5" value="<?= utf8_encode($dataE[5]); ?>" maxlength="25" required>
        </div>

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Dirección: <b class="text-center text-danger">*</b></label>
            <input type="text" class="form-control" name="data6" value="<?= utf8_encode($dataE[6]); ?>" maxlength="100" required>
        </div>

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Municipio: <b class="text-center text-danger">*</b></label>
            <input type="text" class="form-control" name="data7" value="<?= utf8_encode($dataE[7]); ?>" maxlength="50" required>
        </div>

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Departamento: <b class="text-center text-danger">*</b></label>
            <input type="text" class="form-control" name="data8" value="<?= utf8_encode($dataE[8]); ?>" maxlength="50" required>
        </div>

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Teléfono: <b class="text-center text-danger">*</b></label>
            <input type="text" class="form-control" name="data9" value="<?= utf8_encode($dataE[9]); ?>" maxlength="20" required>
        </div>

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Celular: <b class="text-center text-danger">*</b></label>
            <input type="text" class="form-control" name="data10" value="<?= utf8_encode($dataE[10]); ?>" maxlength="9" required>
        </div>

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Fecha de Nacimiento: <b class="text-center text-danger">*</b></label>
            <input type="date" class="form-control" name="data11" value="<?= utf8_encode($dataE[11]); ?>" required>
        </div>

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Género: <b class="text-center text-danger">*</b></label>
            <select class="form-select" name="data12" required>
                <?php
                    if(isset($dataE[12])){
                        if($dataE[12] == 'M'){
                            echo '<option value="M" Selected>Masculino</option>
                            <option value="F">Femenino</option>
                            <option value="O">Otro</option>';
                        }else if($dataE[12] == 'F'){
                            echo '<option value="M">Masculino</option>
                            <option value="F" Selected>Femenino</option>
                            <option value="O">Otro</option>';
                        }else{
                            echo '<option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                            <option value="O" Selected>Otro</option>';
                        }
                    }else{
                ?>
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
                <option value="O">Otro</option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Estado Civil: <b class="text-center text-danger">*</b></label>
            <input type="text" class="form-control" name="data13" value="<?= utf8_encode($dataE[13]); ?>" maxlength="45" required>
        </div>

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Nacionalidad: <b class="text-center text-danger">*</b></label>
            <input type="text" class="form-control" name="data14" value="<?= utf8_encode($dataE[14]); ?>" maxlength="30" required>
        </div>

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">DUI: <b class="text-center text-danger">*</b></label>
            <input type="text" class="form-control" name="data15" value="<?= utf8_encode($dataE[15]); ?>" maxlength="45" required>
        </div>

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Correo: <b class="text-center text-danger">*</b></label>
            <input type="text" class="form-control" name="data16" value="<?= utf8_encode($dataE[16]); ?>" maxlength="50" required>
        </div>

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Profesión: <b class="text-center text-danger">*</b></label>
            <input type="text" class="form-control" name="data17" value="<?= utf8_encode($dataE[17]); ?>" maxlength="45" required>
        </div>

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">AFP: <b class="text-center text-danger">*</b></label>
            <input type="text" class="form-control" name="data18" value="<?= utf8_encode($dataE[18]); ?>" maxlength="45" required>
        </div>

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Número de AFP: <b class="text-center text-danger">*</b></label>
            <input type="text" class="form-control" name="data19" value="<?= utf8_encode($dataE[19]); ?>" maxlength="25" required>
        </div>

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">ISSS: <b class="text-center text-danger">*</b></label>
            <input type="text" class="form-control" name="data20" value="<?= utf8_encode($dataE[20]); ?>" maxlength="25" required>
        </div>

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">NIT: <b class="text-center text-danger">*</b></label>
            <input type="text" class="form-control" name="data21" value="<?= utf8_encode($dataE[21]); ?>" maxlength="25" required>
        </div>

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Altura (mts): <b class="text-center text-danger">*</b></label>
            <input type="text" class="form-control" name="data22" value="<?= utf8_encode($dataE[22]); ?>" maxlength="25" required>
        </div>

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Peso (lb): <b class="text-center text-danger">*</b></label>
            <input type="text" class="form-control" name="data23" value="<?= utf8_encode($dataE[23]); ?>" maxlength="25" required>
        </div>
    </form>