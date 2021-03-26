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
                        <div class="profile-item">
                            <h3>Datos personales</h3>
                            <div class="input-layout">
                                <label for="input-firstname">Nombre</label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-firstname" type="text"
                                        value="Juanito" placeholder="Nombre">
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                            <div class="input-layout">
                                <label for="input-lastname">Apellido</label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-lastname" type="text"
                                        value="Morales" placeholder="Apellido">
                                </div>
                                <span class="input-log hidden"></span>
                                </div>
                            <div class="input-layout">
                                <label for="input-email">Correo</label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-email" type="email"
                                        value="hmaldonado0@ucol.mx" placeholder="Correo">
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                        </div>
                        <button class="button button-primary"><i class="fas fa-edit"></i> Actualizar</button>
                    </div>
                    <div class="profile-section">
                        <div class="profile-item">
                            <h3>Datos de la empresa</h3>
                            <div class="input-layout">
                                <label for="input-bussinessname">Nombre</label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-bussinessname" type="text"
                                        value="Rentacar" placeholder="Nombre">
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                            <div class="input-layout">
                                <label for="input-phone">Telefono</label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-phone" type="text"
                                        value="3141637234" placeholder="Telefono">
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                        </div>
                        <button class="button button-primary"><i class="fas fa-edit"></i> Actualizar</button>
                    </div>
                    <div class="profile-section">
                        <div class="profile-item">
                            <h3>Preferencias</h3>
                            <div class="input-layout">
                                <label for="input-coin">Divisa</label>
                                <select class="input-secondary" id="input-coin">
                                    <option value="mxn">MXN</option>
                                    <option value="usd">USD</option>
                                </select>
                            </div>
                            <div class="input-layout">
                                <label for="input-language">Idioma</label>
                                <select class="input-secondary" id="input-language">
                                    <option value="spanish">Español</option>
                                    <option value="english">Ingles</option>
                                </select>
                            </div>
                        </div>
                        <button class="button button-primary"><i class="fas fa-edit"></i> Actualizar</button>
                    </div>
                    <div class="profile-section">
                        <div class="profile-item">
                            <h3>Contraseña</h3>
                            <div class="input-layout">
                                <label for="input-passold">Anterior contraseña</label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-passold" type="text"
                                        placeholder="Anterior contraseña">
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                            <div class="input-layout">
                                <label for="input-pass">Contraseña</label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-pass" type="text"
                                        placeholder="Contraseña">
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                            <div class="input-layout">
                                <label for="input-passconfirm">Confirmar contraseña</label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-passconfirm" type="text"
                                        placeholder="Confirmar contraseña">
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                        </div>
                        <button class="button button-primary"><i class="fas fa-edit"></i> Restablecer contraseña</button>
                    </div>
                </section>
                <?php include "view/components/footer.html";?>
            </div>
        </main>
    </body>

    <script src="controller/components/field-control.js"></script>
    <script src="controller/pages/profile.js"></script>
</html>