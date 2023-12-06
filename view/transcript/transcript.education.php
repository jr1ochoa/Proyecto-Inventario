<?php   

    $query = "SELECT * FROM employee_education_register 
              WHERE idemployee = ".$_SESSION['iu'];
    $educationInfo = $net_rrhh->prepare($query);
    $educationInfo->execute();
    $data = $educationInfo->fetch();

    $displayInfo = ($data[1] == "Si") ? 'table-row' : 'none';

?>

<style>
    td {
    font-size: 15px;
}
</style>
<section>
        <div class="row gtr-uniform">


            <div class="col-12 col-12-xsmall">
                <h2>INFORMACIÓN EDUCATIVA</h2>
            </div>
            <div class="col-12 col-12-xsmall">
                
                <table style="width: 100%">
                    <tr>
                        <td colspan="3">
                            ¿Estudian actualmente?<b>
                            <input id='btnEducation' style='float: right;' type='button' value='Editar' data-bs-toggle="modal" data-bs-target="#EducationInfo" />                             
                            <br/><?=$data[1]?></b>
                        </td>
                    </tr>
                    <tr style='display: <?=$displayInfo?>'>
                        <td>Institución<b><br/><?=$data[2]?></b></td>
                        <td>¿Qué estudias?<b><br/><?=$data[3]?></b></td>
                        <td>¿Qué nivel?<b><br/><?=$data[4]?></b></td>
                    </tr>
                </table>

            </div>            

            <div class="col-12 col-12-xsmall">
                <table id="tableEducation">
                    <tr><td colspan="5">Histórico Educativo</td></tr>
                    <tr style="background-color: #ffffff;">
                        <th style='width: 30%'>Educación, Institución Educativa</th>
                        <th style='width: 40%'>Nivel, Título o Diploma obtenido</th>
                        <th style='width: 15%'>Acciones</th>
                        <th style='width: 15%'><input id='btnRegister' type='button' value='Añadir' data-bs-toggle="modal" data-bs-target="#EducationRegister" /></th>
                    </tr>
                    <?php
                        $query = "SELECT * FROM employee_education WHERE idemployee = ".$_SESSION['iu'];
                        $educationInfo = $net_rrhh->prepare($query);
                        $educationInfo->execute();
                        
                        while($datar = $educationInfo->fetch())
                        {
                            echo "<tr>
                                    <td>$datar[1]<br/>$datar[2]</td>
                                    <td>$datar[3]</td>
                                    <td>
                                        <a onclick='UpdateForm($datar[0])' data-bs-toggle='modal' data-bs-target='#EducationRegister'>
                                            <i class='fa fa-trash'></i> Editar
                                        </a><br/>
                                        <a onclick='$(\"#ide\").val($datar[0])' data-bs-toggle='modal' data-bs-target='#EducationDelete'>
                                            <i class='fa fa-pen'></i> Eliminar
                                        </a>
                                    </td>
                                    <td>
                                        <a onclick='ViewFile($datar[0])' data-bs-toggle='modal' data-bs-target='#EducationFile'>
                                            <i class='fa fa-file'></i> Ver
                                        </a>
                                    </td>                                    
                                  </tr>";
                        }
                    ?>
                </table>
            </div>
</section>
<style>
    .study
    {
        display: none;
    }
</style>

<!-- Modal -->
<div class="modal fade" id="EducationInfo">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form method="post" action="process/">
            <input type="hidden" name="process" value="Transcript">
            <input type="hidden" name="action" value="Education Informaction"> 
            <div class="row gtr-uniform">


                <div class="col-12 col-12-xsmall">
                    <h2>Información Educativa</h2>
                </div>

                <div class="col-12 col-12-xsmall">
                    ¿Estudia actualmente?
                    <select id="study" name="study">
                        <?php
                            $options = array("No", "Si");
                            foreach ($options as $option)
                            {
                                $selected = ($option == $data[1]) ? "selected='true'" : "";
                                echo "<option value='$option' $selected>$option</option>";
                            }
                        ?>                        
                    </select>
                </div>

                <div class="col-12 col-12-xsmall study" style='display: <?=$displayInfo?>'>
                    Institución
                    <input type="text" name="institution" value="<?=$data[2]?>">
                </div>

                <div class="col-12 col-12-xsmall study" style='display: <?=$displayInfo?>'>
                    ¿Qué estudia?
                    <input type="text" name="whatstudy" value="<?=$data[3]?>">
                </div>

                <div class="col-12 col-12-xsmall study" style='display: <?=$displayInfo?>'>
                    ¿Qué Nivel?
                    <input type="text" name="level" value="<?=$data[4]?>">
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
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="EducationRegister">
    <?php include("view/transcript/transcript.education.modal.php")?>
</div>

<div class="modal fade" id="EducationDelete">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form method="post" action="process/">
            <input type="hidden" name="process" value="Transcript">
            <input type="hidden" name="action" value="Delete Education"> 
            <input type="hidden" id='ide' name="ide" value=""> 
            <div class="row gtr-uniform">


                <div class="col-12 col-12-xsmall">
                    ¿Estás seguro de eliminar este registro educativo?
                </div>

                <!-- Break -->
                <div class="col-12">
                    <ul class="actions fixed">
                        <li><input type="submit" value="Eliminar Registro"></li>
                    </ul>
                </div>

            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="EducationFile">
    <?php include("view/transcript/transcript.education.file.php")?>
</div>


<script>

    $(document).ready(function() {
        $("#study").change(function(){
            var display = ($("#study").val() == "Si") ? "inline" : "none";
            $(".study").each(function(){
                $(this).attr("style", "display: " + display);
            });
        })  
        $("#btnRegister").click(function(){
            $("#EducationRegister").load("view/transcript/transcript.education.modal.php");
        })      
    }) 

    function UpdateForm(ide)
    {
        $("#EducationRegister").load("view/transcript/transcript.education.modal.php", {ide:ide});
    }

    function ViewFile(ide)
    {
        $("#EducationFile").load("view/transcript/transcript.education.file.php", {ide:ide});
    }    
</script>
