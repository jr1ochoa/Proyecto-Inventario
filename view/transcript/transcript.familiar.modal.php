<?php include('../../config/net.php');

if(isset($_REQUEST['idf']))
{

    $idf = $_REQUEST['idf'];
    $query = "SELECT * FROM employee_familiar WHERE id = $idf AND idemployee = ". $_SESSION['iu'];
    $Familiar = $net_rrhh->prepare($query);
    $Familiar->execute();

    $dataf = $Familiar->fetch();
    $abm = "Update Familiar";
    $hide = "<input type='hidden' name='idf' value='$idf '> ";
}
else
{
    $dataf = array();
    $abm = "Add Familiar";
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
                <h2>Formulario de Familiar</h2>
            </div>

            <div class="col-12 col-12-xsmall">
                Parentesco
                <select name="relationship">
                    <?php
                        $options = array("Padre", "Madre", "Hijo/a", "Conyuge", "Hermano/a", "Abuelo/a", "Tio/a", "Primo/a", "Otro");
                        foreach($options as $option)
                        {
                            $selected = ($dataf[3] == $option) ? "selected='true'" : "";
                            echo "<option value='$option' $selected> $option</option>";
                        }
                    ?>
                </select>
            </div>

            <div class="col-12 col-12-xsmall">
                Nombres
                <input type="text" name="names" value="<?=$dataf[1]?>">
            </div>

            <div class="col-12 col-12-xsmall">
                Apellidos
                <input type="text" name="surnames" value="<?=$dataf[2]?>">
            </div>

            <div class="col-12 col-12-xsmall">
                Teléfono
                <input type="text" name="phone" value="<?=$dataf[4]?>">
            </div>

            <div class="col-12 col-12-xsmall">
                Profesion
                <input type="text" name="profession" value="<?=$dataf[5]?>">
            </div>

            <div class="col-12 col-12-xsmall">
                Lugar de Trabajo
                <input type="text" name="workplace" value="<?=$dataf[6]?>">
            </div>            
            
            <div class="col-12 col-12-xsmall">
                Llamar en Emergencia
                <select name="emergency">
                    <?php
                        $options = array("No", "Si");
                        foreach($options as $option)
                        {
                            $selected = ($dataf[7] == $option) ? "selected='true'" : "";
                            echo "<option value='$option'> $option</option>";
                        }
                    ?>
                </select>
            </div>   
            
            <div class="col-12 col-12-xsmall">
                ¿Dependen económicamente de usted?
                <select name="depend">
                    <?php
                        $options = array("No", "Si");
                        foreach($options as $option)
                        {
                            $selected = ($dataf[7] == $option) ? "selected='true'" : "";
                            echo "<option value='$option'> $option</option>";
                        }
                    ?>
                </select>
            </div>               

            <div class="col-12">
                <ul class="actions fixed">
                    <li><input type="submit" value="Guardar Información"></li>
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