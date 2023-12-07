<?php
$idPosition = $_REQUEST['pp'];

$query = "Select * from workarea_positions_assignment where idposition = $idPosition and enddate = '0000-00-00'";
$position = $net_rrhh->prepare($query);
$position->execute();

$query = "Select * from workarea_hierarchy where idposition = $idPosition and idboss != ''"; 
$bPosition = $net_rrhh->prepare($query);
$bPosition->execute();

if ($bPosition->rowCount() > 0) 
{
    $dataBp = $bPosition->fetch();
    $query = "SELECT wb.area, wpb.position, wpab.idemployee, wpab.stardate, wpab.enddate, e.id, e.name1, e.name2, e.lastname1, e.lastname2 
              FROM workarea as wb  
              INNER JOIN workarea_positions as wpb ON wpb.idarea = wb.id
              INNER JOIN workarea_positions_assignment as wpab ON wpb.id = wpab.idposition AND wpab.enddate = '0000-00-00'
              LEFT JOIN employee as e  ON wpab.idemployee = e.id
              WHERE wpab.idposition = " . $dataBp[2];

    $boss = $net_rrhh->prepare($query);
    $boss->execute();
    $dataB = $boss->fetch();
?>

    <div class="row mb-3">
        <div class="col-9">
            <h2>Jefe del Cargo</h2>
        </div>
        <div class="col-3">
            <form action='process/' method='post'>
                <input type='hidden' name='process' value='Area'>
                <input type='hidden' name='action' value='Remove Boss' />
                <input type='hidden' name='idPosition' value='<?=$dataBp[1]?>' />
                <input type='hidden' name='id' value='<?=$dataBp[0]?>' />
                <button type="submit" class="btn btn-danger me-md-2" onclick="return confirm('¿Realmente deseas quitar a este Jefe?')">Quitar del Cargo</button>
            </form>
        </div>
    </div>

    <div class="card mb-5">
        <div class="card-body">
            <p>Nombre del Jefe: <?= utf8_encode($dataB[6] . " " . $dataB[7] . " " . $dataB[8] . " " . $dataB[9]); ?></p>
            <p>Área: <?= utf8_encode($dataB[0]); ?></p>
            <p>Cargo: <?= utf8_encode($dataB[1]); ?></p>
        </div>
    </div>

<?php
} else {
?>
    <h2 class="mb-3">Jefe del Cargo</h2>
    <div class="row mb-5">
        <div class="col-9">
            <p>Aún no hay ningún jefe asignado.</p>
        </div>
        <div class="col-3">
            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#FormModal" onclick="addBossPosition('boss', <?= $idPosition ?>)">Asignar Jefe</button>
        </div>
    </div>

<?php } ?>

<hr style='margin-top: 0px; padding-top: 0px;' />


<?php
if ($position->rowCount() > 0) {
    $dataP = $position->fetch();

    $query = "Select name1, name2, lastname1, lastname2 from employee where id = '" . $dataP[2]. "'";
    $employee = $net_rrhh->prepare($query);
    $employee->execute();
    $dataE = $employee->fetch();
?>
    <div class="row mb-3">
        <div class="col-8">
            <h2>Empleado Actual del Cargo</h2>
        </div>
        <div class="col-4">

            <button type="button" class="btn btn-danger inline" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Finalizar Cargo
            </button>

            <button type="button" class="btn btn-primary inline" data-bs-toggle="modal" data-bs-target="#FormModal" onclick="editBossPosition('employee', '<?=$idPosition?>')">
                Editar Cargo
            </button>

        </div>
    </div>

    <div class="card mb-5">
        <div class="card-body">
            <p>Nombre Empleado: <?= utf8_encode($dataE[0] . " " . $dataE[1] . " " . $dataE[2] . " " . $dataE[3] . " " . $dataE[4]); ?></p>
            <p>Tipo de Contrato: <?= utf8_encode($dataP[3]); ?></p>
            <p>Fecha de Contrato: <?= utf8_encode($dataP[6]); ?></p>
            <p>Salario: $<?= utf8_encode($dataP[5]); ?></p>
        </div>
    </div>
<?php
} else {
    echo '<div class="row mb-5">
    <h2 class="mb-3">Empleado Actual del Cargo</h2>
    <div class="col-9">
        <p>Aún no hay ningún empleado asignado.</p>
    </div>
    <div class="col-3">
    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#FormModal" onclick="addBossPosition(\'employee\', ' . $idPosition . ')">Asignar Empleado</button>
    </div> 
</div>';
}
?>

<hr style='margin-top: 0px; padding-top: 0px;' />

<div class="row mb-3">
    <div class="col-8">
        <h2>Historial del Cargo</h2>
    </div>
</div>

<?php
$query = "Select * from workarea_positions_assignment where idposition = $idPosition";
$positionHistory = $net_rrhh->prepare($query);
$positionHistory->execute();
if ($positionHistory->rowCount() > 0) {
    while ($data = $positionHistory->fetch()) {
        $query = "Select name1, name2, lastname1, lastname2 from employee where id = '" . $data[2]. "'";
        $employee = $net_rrhh->prepare($query);
        $employee->execute();
        $dataE = $employee->fetch();

        echo '<div class="card mb-3">
        <div class="card-body">
              <p>Nombre Empleado: ' . utf8_encode($dataE[0] . ' ' . $dataE[1] . ' ' . $dataE[2] . ' ' . $dataE[3]) . '</p>
              <p>Tipo de Contrato: ' . utf8_encode($data[3]) . '</p>
              <p>Fecha de Contrato: ' . utf8_encode($data[6]) . '</p>';
        if ($data[7] == "0000-00-00") {
            echo '<p>Fecha de finalización: Empleado Activo</p>';
        } else {
            echo '<p>Fecha de finalización: ' . utf8_encode($data[7]) . '</p>';
        }
        echo '<p>Salario: $' . utf8_encode($data[5]) . '</p>
        </div>
      </div>';
    }
} else {
    echo '<p>No hay registros de empleados para este cargo</p>';
}

?>

        

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action='process/' method='post' id='FormEndPosition'>
            <input type='hidden' name='process' value='Area'>
            <input type='hidden' name='action' value='Remove Employee' />
            <input type='hidden' name='id' value='<?=$dataP[0]?>' />
            <input type='hidden' name='idPosition' value='<?=$idPosition?>' />
            <label for='dateend'>Fecha de Finalización</label>
            <input type='date' name='dateend' id='dateend' value='' />
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger" onclick="$('#FormEndPosition').submit()">Finalizar</button>
      </div>
    </div>
  </div>
</div>
