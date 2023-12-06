<section>
    <form method="post" action="process/">
        <input type="hidden" name="process" value="Transcript">
        <input type="hidden" name="action" value="Personal">     
        <div class="row gtr-uniform">
            <?php 

                $query = "SELECT name1, name2, name3, lastname1, lastname2, address, phone, celphone, civil, profession, dui 
                FROM employee
                WHERE id = " . $_SESSION['iu']; 

                $infoPersonal = $net_rrhh->prepare($query);
                $infoPersonal->execute();
                $Dataip = $infoPersonal->fetch();

                $query = "SELECT religion FROM employee_religious WHERE id_employee = " . $_SESSION['iu']; 

                $infoReligioso = $net_rrhh->prepare($query);
                $infoReligioso->execute();
                $Datair = $infoReligioso->fetch();

            ?>

            <div class="col-12 col-12-xsmall">
                <h2>INFORMACIÓN PERSONAL</h2>
            </div>
            <div class="col-12 col-12-xsmall">                                    
                Nombre completo del Empleado
            </div>                                
            <div class="col-4 col-12-xsmall">                                    
                <input type="text" name="name1" placeholder='Nombre 1' value="<?=$Dataip[0]?>">
            </div>
            <div class="col-4 col-12-xsmall">
                <input type="text" name="name2" placeholder='Nombre 2' value="<?=$Dataip[1]?>">
            </div>
            <div class="col-4 col-12-xsmall">
                <input type="text" name="name3" placeholder='Nombre 3' value="<?=$Dataip[2]?>">
            </div>
            <div class="col-4 col-12-xsmall">
                <input type="text" name="name4" placeholder='Apellido 1' value="<?=$Dataip[3]?>">
            </div>
            <div class="col-4 col-12-xsmall">
                <input type="text" name="name5" placeholder='Apellido 2' value="<?=$Dataip[4]?>">
            </div>   

            <div class="col-12 col-12-xsmall">
                Dirección de residencia exacta
                <textarea name="address" rows="3"><?=$Dataip[5]?></textarea>
            </div>          
                                  
            <div class="col-4 col-12-xsmall">
                Teléfono de casa
                <input type="text" name="phone1" value="<?=$Dataip[6]?>" >
            </div>

            <div class="col-4 col-12-xsmall">
                Teléfono celular
                <input type="text" name="phone2" value="<?=$Dataip[7]?>" >
            </div> 
            <div class="col-4 col-12-xsmall">
                Religión
                <select name="religion" >
                    <?php
                        $Options = array('Cristiano Católico', 'Cristiano Evangélico', 'Otros', 'No Pratico');
                        foreach($Options as $option)
                        {
                            $selected = ($Datair[0] == $option) ? "selected='true'" : "";
                            echo "<option value='$option' $selected>$option</option>";
                        }

                    ?>
                </select>                
            </div>

            <div class="col-4 col-12-xsmall">
                Estado Civil
                <select name="civil" >
                    <?php
                        $Options = array('Soltero', 'Acompañado', 'Casado', 'Divorciado', 'Viudo');
                        foreach($Options as $option)
                        {
                            $selected = ($Dataip[8] == $option) ? "selected='true'" : "";
                            echo "<option value='$option' $selected>$option</option>";
                        }

                    ?>
                </select>
            </div>    
            
            <div class="col-8 col-12-xsmall">
                Profesión u oficio
                <input type="text" name="profession" value="<?=$Dataip[9]?>" >
            </div>   
            <?php $DUI = explode("@", $Dataip[10]); ?>
            <div class="col-4 col-12-xsmall">
                Número de DUI
                <input type="text" name="dui" value="<?=$DUI[0]?>" placeholder="12345678-9">
            </div>   
            
            <div class="col-6 col-12-xsmall">
                Lugar y Fecha de Expedición (DUI)
                <input type="date" name="datedui" value="<?=$DUI[1]?>">
            </div> 
            
            <div class="col-6 col-12-xsmall">                
                <input type="submit" name="Enviar" value="Guardar Cambios">
            </div>             
        </div>   
    </form>
</section>