<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

<header id="header">
    <div class="inner">
        <a class="logo" href="?view=main"><strong>Sistema</strong> <small>Proyecto de catedra</small></a>
        <nav id="nav">
            <?php if(isset($_SESSION['iu'])){?>
            <ul>
                <li><a href="?view=main">Inicio</a></li>  
                <li><a href="?view=profile">Mi Perfil</a></li> 
                    <?php
                     
                    if($_SESSION['type'] == "RRHH" || $_SESSION['type'] == "Administrador")
                    {
                        ?>
                        <li><a>Empleados</a>
                            <ul>
                                <li><a href="?view=area">Áreas</a></li>
                                <li><a href="?view=employee">Empleados</a></li>
                            </ul>                                               
                        </li>                           
                        <?php
                    }    
                   

                    if($_SESSION['type'] == "Administrador")
                    {
                        ?>
                        <li><a href="">Administrativo</a>
                            <ul>
                                <li><a href="?view=user">Usuarios</a></li>
                            </ul>                                               
                        </li>                          
                        <?php
                    }

                    ?>
                  
                   <?php

                    if($_SESSION['type'] == "Inventario" || $_SESSION['type'] == "Administrador" || $_SESSION['iu'] == 2595 || $_SESSION['iu'] == 220610)
                    {
                        ?>
                        <li><a href="?view=inventory">Inventario</a></li>                          
                        <?php
                    }                    
                    ?> 
                <li><a href="?view=logoff">Salir</a></li>                
            </ul>
            <?php }?>
        </nav>
    </div>
</header>