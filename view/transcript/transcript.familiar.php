<?php 
    session_start();
    include("../../config/net.php");
?>
<style>
    table th, td{
        font-size: 16px;
    }
</style>
<section >
        <div class="row gtr-uniform">
        <div class="col-12 col-12-xsmall">
                <h2>INFORMACIÓN DE SU GRUPO FAMILIAR </h2>
            </div>  

            <div class="col-12 col-12-xsmall">
            <table id='tableFamily'>
                    <tr>
                        <th style='width: 10%;'>Familiar</th>
                        <th style='width: 20%;'>Nombres</th>
                        <th style='width: 20%;'>Apellidos</th>
                        <th style='width: 15%;'>Teléfono</th>
                        <th style='width: 10%;'>Lugar de trabajo</th>
                        <th style='width: 10%;'>Llamar en emergencia</th>
                        <th style='width: 15%; color: royalblue; text-align: right;'>
                            <a data-bs-toggle="modal" data-bs-target="#FormModal" onclick='AddFamiliar()'>
                                Añadir Familiar
                            </a>
                        </th>
                    </tr>
                    
                    <?php 

                        $query = "SELECT * FROM employee_familiar WHERE (dependen = 'No' OR dependen = '') AND idemployee = " . $_SESSION['iu'];                        
                        $infoFamiliar = $net_rrhh->prepare($query);
                        $infoFamiliar->execute();
                        
                        while($dataif = $infoFamiliar->fetch())
                        {   
                            echo "<tr>
                                    <td>$dataif[3]</td>
                                    <td>$dataif[1] </td>
                                    <td>$dataif[2] </td>                                                        
                                    <td>$dataif[4]</td>
                                    <td>$dataif[6]</td>                                    
                                    <td>$dataif[7]</td>
                                    <td>
                                        <a onclick='LoadFamiliar($dataif[0])' data-bs-toggle='modal' data-bs-target='#FormModal'>
                                            <i class='fas fa-pencil-alt'></i>Editar
                                        </a><br/>
                                        <a onclick='DeleteFamiliar($dataif[0])' data-bs-toggle='modal' data-bs-target='#DeleteModal'>
                                            <i class='fas fa-times-circle'></i>Eliminar
                                        </a>
                                    </td>                                    
                                    </tr>";
                        }                                            
                    ?>

                </table>
                <hr/>
                <h2>Familiares que dependen economicamente de usted</h2>
                <table id='tableFamily'>
                    <tr>
                        <th style='width: 10%;'>Familiar</th>
                        <th style='width: 20%;'>Nombres</th>
                        <th style='width: 20%;'>Apellidos</th>
                        <th style='width: 15%;'>Teléfono</th>
                        <th style='width: 10%;'>Lugar de trabajo</th>
                        <th style='width: 10%;'>Llamar en emergencia</th>
                        <th style='width: 15%; color: royalblue; text-align: right;'></th>
                    </tr>
                    
                    <?php 

                        $query = "SELECT * FROM employee_familiar WHERE dependen = 'Si' AND idemployee = " . $_SESSION['iu'];                        
                        $infoFamiliar = $net_rrhh->prepare($query);
                        $infoFamiliar->execute();
                        
                        while($dataif = $infoFamiliar->fetch())
                        {   
                            echo "<tr>
                                    <td>$dataif[3]</td>
                                    <td>$dataif[1] </td>
                                    <td>$dataif[2] </td>                                                        
                                    <td>$dataif[4]</td>
                                    <td>$dataif[6]</td>                                    
                                    <td>$dataif[7]</td>
                                    <td>
                                        <a onclick='LoadFamiliar($dataif[0])' data-bs-toggle='modal' data-bs-target='#FormModal'>
                                            <i class='fas fa-pencil-alt'></i>Editar
                                        </a><br/>
                                        <a onclick='DeleteFamiliar($dataif[0])' data-bs-toggle='modal' data-bs-target='#DeleteModal'>
                                            <i class='fas fa-times-circle'></i>Eliminar
                                        </a>
                                    </td>                                    
                                    </tr>";
                        }                                            
                    ?>

                </table>                
            </div>
        </div>
    </form>
</section>



<!-- Modal -->
<div class="modal fade" id="FormModal" tabindex="-1" aria-labelledby="FormModal" aria-hidden="true">  
    <?php include("view/transcript/transcript.familiar.modal.php");?>
</div>

<!-- Modal -->
<div class="modal fade" id="DeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">  
<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form method="post" action="process/">
        <input type="hidden" name="process" value="Transcript">
        <input type="hidden" name="action" value="Delete Familiar"> 
        <input type="hidden" id='idf' name="idf" value=""> 
        <div class="row gtr-uniform">


            <div class="col-12 col-12-xsmall">
                <h2>Eliminar Familiar</h2>
            </div>
        

            <div class="col-12 col-12-xsmall">
                <h3>¿Está seguro de eliminar este registro?</h3>
            </div>
                    

            <div class="col-12">
                <ul class="actions fixed">
                    <li><input type="submit" value="Eliminar Información"></li>
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
</div>

<script>
    $(document).ready(function() 
    {
        $('#FormModal').load("view/transcript/transcript.familiar.modal.php"); 
    }) 

    function AddFamiliar(){
        $('#FormModal').load("view/transcript/transcript.familiar.modal.php");
    }

    function LoadFamiliar(idf){
        $('#FormModal').load("view/transcript/transcript.familiar.modal.php", { idf: idf});
    }
    function DeleteFamiliar(idf){
        $('#DeleteModal').modal('show');
        $("#idf").val(idf)
    }    
</script>
