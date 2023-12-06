<?php
    if(isset($_SESSION['iu']))
        redirection("../?view=main");
?>
<div id="main" style="padding: 2rem 0 2rem 0">
    <div class="inner">

    <!-- Content -->
        <div id="content" class="container">
            <h2>Acceso al Sistema</h2>
            <div class="row" style="margin-top: 0px; padding-top: 2.5rem;">

                <div class="col-4 col-md-12">
                    <form id="LoginForm" action="process/" method="post">
                        <input type="hidden" name="process" value="LogIn">
                        <input type="hidden" name="action" value="LogIn">                

                        <table class="alt table table-bordered w100" >
                            <tr><td style="color: transparent">.</td></tr>
                            <tr><td>
                                    Nombre de Usuario:
                                    <input type="text" name="username">
                                    <br>
                                    Contraseña de Usuario:
                                    <input type="password" name="password">
                                </td>
                            </tr>
                            <tr><td style="text-align: right;">
                                    <button class="button icon solid fa-sign-in-alt" name="Enviar">
                                        Iniciar Sesión 
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>                                                 
                </div>      
                <div class="col-8 col-md-8">
                    <img src="assets/images/logo.jfif" style="width: 40%; margin-left: 35%">
                </div>                                    
            </div>
        </div>    
    </div>
</div>