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
        <link rel="stylesheet" href="view/pages/carview.css">

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
                <section class="car-info">
                    <div class="car-info-header">
                        <div class="generic-valoration">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <h3>Se agregó hace 2 años</h3>
                        <h3>Se editó hace 2 meses</h3>
                    </div>
                    <div class="car-info-body">
                        <div class="car-info-section">
                            <h3>General</h3>
                            <div class="input-layout">
                                <label for="input-name">Modelo</label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-name" type="text"
                                        value="Bocho" placeholder="Modelo">
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                            <div class="input-layout">
                                <label for="input-price">Precio</label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-price" type="text"
                                        value="500 MXN" placeholder="Precio">
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                        </div>
                        <div class="car-info-section">
                            <h3>Espacios</h3>
                            <div class="input-layout">
                                <label for="input-doors">Puertas</label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-doors" type="text"
                                        value="4" placeholder="Puertas">
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                            <div class="input-layout">
                                <label for="input-chairs">Asientos</label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-chairs" type="text"
                                        value="4" placeholder="Asientos">
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                        </div>
                        <div class="car-info-section">
                            <h3>Motor</h3>
                            <div class="input-layout">
                                <label for="input-tank">Tanque</label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-tank" type="text"
                                        value="3Km/L" placeholder="Tanque">
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                            <div class="input-layout">
                                <label for="input-transmission">Transmición</label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-transmission" type="text"
                                        value="Automatica" placeholder="Transmición">
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                        </div>
                        <div class="car-info-section">
                            <h3>Detalles</h3>
                            <div class="input-layout">
                                <label for="input-aircond">Aire condicionado</label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-aircond" type="text"
                                        value="Si" placeholder="Aire acondicionado">
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                            <div class="input-layout">
                                <label for="input-gps">GPS</label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-gps" type="text" value="Si">
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                            <div class="input-layout">
                                <label for="input-darkglass">Vidrios polarizados</label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-darkglass" type="text"
                                        value="Si" placeholder="Vidrios polarizados">
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                        </div>
                    </div>
                    <div class="car-info-actions">
                        <button class="button button-primary"><i class="fas fa-edit"></i> Actualizar</button>
                        <button class="button button-danger"><i class="fas fa-trash"></i> Eliminar</button>
                    </div>
                </section>
                <?php include "view/components/footer.html";?>
            </div>
        </main>

        <?php include "view/pages/modals/drivers.html";?>

    </body>
    <script src="controller/components/modal.js"></script>
    <script src="controller/components/field-control.js"></script>
    <script src="controller/pages/carview.js"></script>
</html>