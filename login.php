<?php
require "model/libraries/cookie_interface.php";
$ci0->setCookie("securitykey", $ci0->getSecurityKey());
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" type="image/png" sizes="32x32" href="media/images/main_logo.png" />
        <!-- ScrollReveal -->
        <script src="https://unpkg.com/scrollreveal"></script>
        <!-- Font Awesome -->
        <script src="https://kit.fontawesome.com/0d40d8f017.js" crossorigin="anonymous"></script>
        <!-- Custom CSS -->
        <link rel="stylesheet" href="view/pages/login.css">

        <title>Rentacar | Login</title>
    </head>
    <body>
        <main>
            <div class="container">
                <h1>Login</h1>
                <img src="media/images/main_logo.png" alt="mainlogo">
                <form id="login_info">
                    <div class="input-layout">
                        <label for="input-email">Correo electronico</label>
                        <div class="input-field">
                            <input class="input-primary" type="email" id="input-email"
                                placeholder="Correo electronico" autofocus>
                            <i class="fas fa-envelope"></i>
                        </div>
                        <span class="input-log"></span>
                    </div>
                    <div class="input-layout">
                        <label for="input-pass">Contraseña</label>
                        <div class="input-field">
                            <input class="input-primary" type="password" id="input-pass" placeholder="Contraseña">
                            <i class="fas fa-lock"></i>
                        </div>
                        <span class="input-log"></span>
                    </div>
                    <button id="signin" type="button" class="button button-primary">Entrar</button>
                </form>
                <footer>
                    <p>¿Aun no tienes una cuenta? <a href="register.php">Registrate</a></p>
                    <p>Recuperar <a href="#">contraseña</a></p>
                </footer>
            </div>
        </main>

        <script src="controller/components/field-control.js"></script>
        <script src="controller/components/request-me.js"></script>
        <script src="controller/components/alert-me.js"></script>
        <script src="controller/pages/login.js"></script>
    </body>
</html>