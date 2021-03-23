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

        <title>Rentacar | Login</title>
    </head>
    <body>
        <main>
            <div class="container">
                <h1>Login</h1>
                <img src="media/images/main_logo.png" alt="mainlogo">
                <form action="">
                    <div class="input-layout">
                        <label for="email">Correo electronico</label>
                        <div class="input-field">
                            <input type="email" id="email" placeholder="Correo electronico">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                    <div class="input-layout">
                        <label for="pass">Contraseña</label>
                        <div class="input-field">
                            <input type="password" id="pass" placeholder="Contraseña">
                            <i class="fas fa-lock"></i>
                        </div>
                    </div>
                    <button id="signIn" type="button" class="button button-primary">Entrar</button>
                </form>
                <footer>
                    <p>¿Aun no tienes una cuenta? <a href="register.php">Registrate</a></p>
                    <p>Recuperar <a href="#">contraseña</a></p>
                </footer>
            </div>
        </main>

        <script src="controller/pages/login.js"></script>
    </body>
</html>