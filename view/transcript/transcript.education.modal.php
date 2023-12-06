<?php include('../../config/net.php');

if(isset($_REQUEST['ide']))
{
    $ide = $_REQUEST['ide'];
    $query = "SELECT * FROM employee_education WHERE id = $ide AND idemployee = ". $_SESSION['iu'];
    $Education = $net_rrhh->prepare($query);
    $Education->execute();
    echo $query;
    $datae = $Education->fetch();
    $abm = "Update Education";
    $hide = "<input type='hidden' name='ide' value='$ide'> ";
}
else
{
    $datae = array();
    $abm = "Add Education";
    $hide = "";
}

?>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form method="post" action="process/">
            <input type="hidden" name="process" value="Transcript">
            <input type="hidden" name="action" value="<?=$abm?>"> 
            <?=$hide?>
            <div class="row gtr-uniform">


                <div class="col-12 col-12-xsmall">
                    <h2>Información Educativa</h2>
                </div>

                <div class="col-12 col-12-xsmall">
                    EDUCACIÓN (DETALLAR FINALIZACIÓN DE CARRERA, CURSOS CAPACITACIONES, ETC)
                    <input type="text" name="institution" value="<?=$datae[1]?>">
                </div>

                <div class="col-12 col-12-xsmall">
                    CENTRO EDUCATIVO	
                    <input type="text" name="whatstudy" value="<?=$datae[2]?>">
                </div>

                <div class="col-12 col-12-xsmall">
                    NIVEL, TITULO O DIPLOMA OBTENIDO	
                    <input type="text" name="level" value="<?=$datae[3]?>">
                </div>
                
                <!-- Break -->
                <div class="col-12">
                    <ul class="actions fixed">
                        <li><input type="submit" value="Actualizar Información"></li>
                    </ul>
                </div>

            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
</div>