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
        <link rel="stylesheet" href="view/pages/sign.css">

        <title>Rentacar | Registro</title>
    </head>
    <body>
        <main>
            <div class="container">
                <h1>Registro</h1>
                <form action="">
                    <div class="input-layout">
                        <label for="firstname">Nombres</label>
                        <div class="input-field">
                            <input class="input-primary" type="text" id="firstname" placeholder="Nombres">
                            <i class="fas fa-address-card"></i>
                        </div>
                        <span class="input-log hidden"></span>
                    </div>
                    <div class="input-layout">
                        <label for="lastname">Apellidos</label>
                        <div class="input-field">
                            <input class="input-primary" type="text" id="lastname" placeholder="Apellidos">
                            <i class="fas fa-address-card"></i>
                        </div>
                    </div>
                    <div class="input-layout">
                        <label for="email">Correo electronico</label>
                        <div class="input-field">
                            <input class="input-primary" type="email" id="email" placeholder="Correo electronico">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                    <div class="input-layout">
                        <label for="pass">Contraseña</label>
                        <div class="input-field">
                            <input class="input-primary" type="password" id="pass" placeholder="Contraseña">
                            <i class="fas fa-lock"></i>
                        </div>
                    </div>
                    <div class="input-layout">
                        <label for="confirmPass">Contraseña</label>
                        <div class="input-field">
                            <input class="input-primary" type="password" id="confirmPass" placeholder="Contraseña">
                            <i class="fas fa-lock"></i>
                        </div>
                    </div>
                        <button id="signUp" type="button" class="button button-primary">Guardar</button>
                </form>
                <footer>
                    <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión</a></p>
                </footer>
            </div>
        </main>

        <script src="controller/components/field-control.js"></script>
        <script src="controller/pages/register.js"></script>
    </body>
</html>