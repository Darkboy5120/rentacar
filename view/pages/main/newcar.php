<?php
require "model/libraries/cookie_interface.php";
if (!$ci0->existCookie("user_data")) {
    header('Location: ?p=login');
    exit;
}
$ci0->setCookie("securitykey", $ci0->getSecurityKey());
$user_name = $ci0->getCookie("user_data")["nombre"];
?>
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
        <link rel="stylesheet" href="view/pages/styles/newcar.css">

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
                    <form class="car-info-body" id="form-car-info">
                        <div class="car-info-section">
                            <h3>General</h3>
                            <div class="input-layout">
                                <label for="input-brand">Marca</label>
                                <div class="input-field">
                                    <select class="input-secondary" id="input-brand"></select>
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                            <div class="input-layout">
                                <label for="input-model">Modelo</label>
                                <div class="input-field">
                                <select class="input-secondary" id="input-model"></select>
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                            <div class="input-layout">
                                <label for="input-type">Tipo de auto</label>
                                <div class="input-field">
                                    <select class="input-secondary" id="input-type">
                                        <option value="0">Camioneta</option>
                                        <option value="1">Compacto</option>
                                        <option value="2">Sedan</option>
                                        <option value="3">Suburban</option>
                                        <option value="4">Pickup</option>
                                    </select>
                                </div>
                            </div>
                            <div class="input-layout">
                                <label for="input-price">Precio</label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-price" type="text"
                                        placeholder="Precio">
                                    <span class="input-domain">MXN</span>
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
                                        placeholder="Puertas">
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                            <div class="input-layout">
                                <label for="input-chairs">Asientos</label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-chairs" type="text"
                                        placeholder="Asientos">
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                            <div class="input-layout">
                                <label for="input-trunk">Cajuela</label>
                                <div class="input-field">
                                    <select class="input-secondary" id="input-trunk">
                                        <option value="0">No tiene</option>
                                        <option value="1">Pequeña</option>
                                        <option value="2">Mediana</option>
                                        <option value="3">Grande</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="car-info-section">
                            <h3>Especificaciones</h3>
                            <div class="input-layout">
                                <label for="input-engine">Tipo de motor</label>
                                <div class="input-field">
                                    <select class="input-secondary" id="input-engine">
                                        <option value="0">Gasolina</option>
                                        <option value="1">Diesel</option>
                                        <option value="0">Electrico</option>
                                        <option value="1">Gas</option>
                                        <option value="0">Hibrido gasolina-electrico</option>
                                        <option value="1">Hibrido gasolina-gas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="input-layout">
                                <label for="input-transmission">Transmición</label>
                                <div class="input-field">
                                    <select class="input-secondary" id="input-transmission">
                                        <option value="0">Automatica</option>
                                        <option value="1">Manual</option>
                                    </select>
                                </div>
                            </div>
                            <div class="input-layout">
                                <label for="input-consunit">Unidad de consumo</label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-consunit" type="text"
                                        placeholder="Unidad de consumo">
                                    <span class="input-domain">Km/L</span>
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                            <div class="input-layout">
                                <label for="input-horsepower">Caballos de fuerza</label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-horsepower" type="text"
                                        placeholder="Caballos de fuerza">
                                    <span class="input-domain">HP</span>
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                            <div class="input-layout">
                                <label for="input-tankcap">Capacidad de tanque</label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-tankcap" type="text"
                                        placeholder="Capacidad de tanque">
                                    <span class="input-domain">L</span>
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                        </div>
                        <div class="car-info-section">
                            <h3>Detalles</h3>
                            <div class="input-layout">
                                <label for="input-color">Color</label>
                                <div class="input-field">
                                    <select class="input-secondary" id="input-color">
                                        <option value="0">Rojo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="switch-layout">
                                <div class="switch-field" id="switch-aircond">
                                    <i class="switch-on fas fa-toggle-on"></i>
                                    <i class="switch-off fas fa-toggle-off"></i>
                                </div>
                                <label for="switch-aircond">Aire condicionado</label>
                            </div>
                            <div class="switch-layout">
                                <div class="switch-field" id="switch-gps">
                                    <i class="switch-on fas fa-toggle-on"></i>
                                    <i class="switch-off fas fa-toggle-off"></i>
                                </div>
                                <label for="switch-gps">GPS</label>
                            </div>
                            <div class="switch-layout">
                                <div class="switch-field" id="switch-darkglass">
                                    <i class="switch-on fas fa-toggle-on"></i>
                                    <i class="switch-off fas fa-toggle-off"></i>
                                </div>
                                <label for="switch-darkglass">Vidrios polarizados</label>
                            </div>
                        </div>
                        <div class="car-info-section">
                            <h3>Seguridad</h3>
                            <div class="input-layout">
                                <label for="input-insurance">Seguros</label>
                                <div class="input-field">
                                    <select class="input-secondary" id="input-insurance">
                                        <option value="0">Cobertura amplia</option>
                                        <option value="1">Cobertura limitada</option>
                                        <option value="2">Responsabilidad civil</option>
                                    </select>
                                </div>
                            </div>
                            <div class="switch-layout">
                                <div class="switch-field" id="switch-replacement">
                                    <i class="switch-on fas fa-toggle-on"></i>
                                    <i class="switch-off fas fa-toggle-off"></i>
                                </div>
                                <label for="switch-replacement">Llanta de repuesto</label>
                            </div>
                            <div class="switch-layout">
                                <div class="switch-field" id="switch-toolbox">
                                    <i class="switch-on fas fa-toggle-on"></i>
                                    <i class="switch-off fas fa-toggle-off"></i>
                                </div>
                                <label for="switch-toolbox">Caja de herramientas</label>
                            </div>
                        </div>
                        <div class="car-info-section">
                            <h3>Presentación</h3>
                            <div class="input-layout">
                                <label for="input-thumbnail-image">Portada</label>
                                <div class="input-field">
                                    <input class="hidden" id="input-thumbnail-image" type="file" multiple="true">
                                    <div class="input-secondary file-container">
                                        <div class="file-images">
                                        </div>
                                        <span class="file-empty">Vacío</span>
                                        <div class="file-actions">
                                            <span class="file-add"><i class="fas fa-plus"></i> Agregar</span>
                                            <span class="file-edit"><i class="fas fa-edit"></i> Editar</span>
                                        </div>
                                    </div>
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                            <div class="input-layout">
                                <label for="input-other-images">Otras imagenes</label>
                                <div class="input-field">
                                    <input class="hidden" id="input-other-images" type="file" multiple="true">
                                    <div class="input-secondary file-container">
                                        <div class="file-images">
                                        </div>
                                        <span class="file-empty">Vacío</span>
                                        <div class="file-actions">
                                            <span class="file-add"><i class="fas fa-plus"></i> Agregar</span>
                                            <span class="file-edit"><i class="fas fa-edit"></i> Editar</span>
                                        </div>
                                    </div>
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                        </div>
                    </form>
                    <div class="car-info-actions">
                        <button class="button button-primary" id="create-car"><i class="fas fa-check"></i> Guardar</button>
                    </div>
                </section>
                <?php include "view/components/footer.html";?>
            </div>
        </main>

        <?php include "view/components/loading-screen.html";?>

        <script>
            const userName = "<?php echo $user_name;?>";
        </script>
        <script src="controller/components/modal.js"></script>
        <script src="controller/components/field-control.js"></script>
        <script src="controller/components/switch-control.js"></script>
        <script src="controller/components/request-me.js"></script>
        <script src="controller/components/alert-me.js"></script>
        <script src="controller/components/file-control.js"></script>
        <script src="controller/components/loading-screen.js"></script>
        <script src="controller/pages/newcar.js"></script>
    </body>
</html>