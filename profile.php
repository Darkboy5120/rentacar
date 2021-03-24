<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" type="image/png" sizes="32x32" href="media/images/main_logo.png " />
        <!-- ScrollReveal -->
        <script src="https://unpkg.com/scrollreveal"></script>
        <!-- Font Awesome -->
        <script src="https://kit.fontawesome.com/0d40d8f017.js" crossorigin="anonymous"></script>
        <!-- Custom CSS -->
        <link rel="stylesheet" href="view/pages/profile.css">

        <title></title>
    </head>
    <body>
        <main>
            <?php include "view/components/navbar.html";?>
            <nav class="main-actions">
                <ul>
                </ul>
            </nav>
            <div class="fixed-location">
                <span>Estas en <span data-location=""></span></span>
            </div>
            <div class="container">
                <section class="profile-layout">
                    <div class="profile-section">
                        <h3>Datos personales</h3>
                        <label for="firstname">Nombre</label>
                        <input id="firstname" type="text" value="Juanito">
                        <label for="lastname">Apellido</label>
                        <input id="lastname" type="text" value="Morales">
                        <label for="email">Correo</label>
                        <input id="email" type="email" value="hmaldonado0@ucol.mx">
                    </div>
                    <div class="profile-section">
                        <h3>Datos de la empresa</h3>
                        <label for="bussinessname">Nombre</label>
                        <input id="bussinessname" type="text" value="Rentacar">
                        <label for="phone">Nombre</label>
                        <input id="phone" type="text" value="Telefono">
                    </div>
                    <button class="button button-primary">Actualizar perfil</button>
                    <div class="profile-divisor"></div>
                    <div class="profile-section">
                        <h3>Preferencias</h3>
                        <label for="coin">Divisa</label>
                        <select id="coin">
                            <option value="mxn">MXN</option>
                            <option value="usd">USD</option>
                        </select>
                        <label for="language">Idioma</label>
                        <input id="language" type="text" value="Español">
                    </div>
                    <button class="button button-primary">Actualizar preferencias</button>
                    <div class="profile-divisor"></div>
                    <div class="profile-section">
                        <h3>Contraseña</h3>
                        <input type="text" placeholder="Anterior contraseña">
                        <input type="text" placeholder="Contraseña">
                        <input type="text" placeholder="Confirmar contraseña">
                    </div>
                    <button class="button button-primary">Restablecer contraseña</button>
                </section>
                <?php include "view/components/footer.html";?>
            </div>
        </main>
    </body>
    <script src="controller/pages/profile.js"></script>
</html>