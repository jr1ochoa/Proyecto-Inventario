<style>
    a{
        text-decoration: none;
        cursor: pointer;
    }
    i{
        margin-right: 15px;
    }
</style>

<!-- Main -->
<div id="main" style='font-size: 18px'>
    <div class="inner">

    <!-- Content -->
        <div id="content">

        <!-- Posts -->
        <section id="contentExp" style="padding-top: 1.5rem;">  
            <?php

                $part = (isset($_GET['part'])) ? $_GET['part'] : '';

                if($part == "personal")
                    include("view/transcript/transcript.personal.php");

                else if($part == "familiar")
                    include("view/transcript/transcript.familiar.php");

                else if($part == "education")                
                    include("view/transcript/transcript.education.php"); 

                else if($part == "picture")
                    include("view/transcript/transcript.picture.php");    

                else if($part == "documents")
                    include("view/transcript/transcript.documents.php");                                        
                
                else
                    include("view/transcript/transcript.personal.php");

            ?>
        </section>

        </div>
        <!-- Sidebar -->
        <div id="sidebar" style="min-width: 18rem; width: 18rem;">

            <?php

                $query = "SELECT picture FROM employee_picture WHERE idemployee = " . $_SESSION['iu'];
                $picture = $net_rrhh->prepare($query);
                $picture->execute();

                if($picture->rowCount() > 0)
                {
                    $dataI = $picture->fetch();
                    $img = $dataI[0];
                }
                else
                    $img = "h.jpg";

                $query = "SELECT 
                    SUM(CASE WHEN (part = 'Personal') THEN 1 ELSE 0 END) AS p1,
                    SUM(CASE WHEN (part = 'Familiar') THEN 1 ELSE 0 END) AS p2,
                    SUM(CASE WHEN (part = 'Education') THEN 1 ELSE 0 END) AS p3,
                    SUM(CASE WHEN (part = 'Picture') THEN 1 ELSE 0 END) AS p4,
                    SUM(CASE WHEN (part = 'Files') THEN 1 ELSE 0 END) AS p5
                    FROM employee_updates
                    WHERE idemployee = ". $_SESSION['iu'];
                    
                $viewPart = $net_rrhh->prepare($query);
                $viewPart->execute();
                $datav = $viewPart->fetch();

                $color1 = ($datav[0] == 1) ? "green" : "orange";
                $color2 = ($datav[1] == 1) ? "green" : "orange";
                $color3 = ($datav[2] == 1) ? "green" : "orange";
                $color4 = ($datav[3] == 1) ? "green" : "orange";
                $color5 = ($datav[4] == 1) ? "green" : "orange";
            ?>

            <img src="process/pictures/<?=$img?>" style='width: 100%'/>

            <p>Actualización de Expediente</p>  
            <ul style="list-style: none;">
                <li><a href='?view=transcript&part=personal'>
                        <i class="fas fa-user-edit" style='color:<?=$color1?>'></i>Información Personal
                    </a>                
                </li>
                <li><a href='?view=transcript&part=familiar'>
                        <i class="fas fa-users" style='color:<?=$color2?>'></i>Información Familiar
                    </a>
                </li>
                <li><a href='?view=transcript&part=education'>
                        <i class="fas fa-school" style='color:<?=$color3?>'></i>Información Educativa
                    </a>
                </li>
                <!--
                <li><a href='?view=transcript&part=picture'>
                        <i class="fas fa-camera" style='color:<?=$color4?>'></i>Actualizar Imagen
                    </a>
                </li> -->
                <li>
                    <a href='?view=transcript&part=documents'>
                        <i class="fas fa-file" style='color:<?=$color5?>'></i>Mis Documentos
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<?php include("view/transcript/transcript.notification.php");?>
