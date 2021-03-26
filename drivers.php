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
        <link rel="stylesheet" href="view/pages/drivers.css">

        <title></title>
    </head>
    <body>
        <main>
            <?php include "view/components/navbar.html";?>
            <nav class="main-actions">
                <ul>
                    <li id="newDriver"><i class="fas fa-user-plus"></i><span>Agregar conductor</span></li>
                    <li id="searchAction" class="main-action-search">
                        <i class="fas fa-search"></i><span>Buscar</span>
                        <input id="search" type="text" placeholder="Búscar conductor" autocomplete="off">
                    </li>
                </ul>
            </nav>
            <div class="fixed-location">
                <span>Estas en <span data-location=""></span></span>
            </div>
            <div class="container">
                <section class="cards-sales">
                    <div class="card-sale-header">
                        <span>Identificador</span>
                        <span>Nombre</span>
                        <span>Apellido</span>
                    </div>
                    <div class="card-sale">
                        <span>14587</span>
                        <span>$2000</span>
                        <span>03/16/2021</span>
                    </div>
                    <div class="card-sale">
                        <span>14587</span>
                        <span>$2000</span>
                        <span>03/16/2021</span>
                    </div>
                    <div class="card-sale">
                        <span>14587</span>
                        <span>$2000</span>
                        <span>03/16/2021</span>
                    </div>
                    <div class="card-sale">
                        <span>14587</span>
                        <span>$2000</span>
                        <span>03/16/2021</span>
                    </div>
                    <div class="card-sale">
                        <span>14587</span>
                        <span>$2000</span>
                        <span>03/16/2021</span>
                    </div>
                    <div class="card-sale">
                        <span>14587</span>
                        <span>$2000</span>
                        <span>03/16/2021</span>
                    </div>
                    <div class="card-sale">
                        <span>14587</span>
                        <span>$2000</span>
                        <span>03/16/2021</span>
                    </div>
                    <div class="card-sale">
                        <span>14587</span>
                        <span>$2000</span>
                        <span>03/16/2021</span>
                    </div>
                    <div class="card-sale">
                        <span>14587</span>
                        <span>$2000</span>
                        <span>03/16/2021</span>
                    </div>
                    <div class="card-sale">
                        <span>14587</span>
                        <span>$2000</span>
                        <span>03/16/2021</span>
                    </div>
                </section>
                <section class="pagination">
                    <button class="button"><i class="fas fa-arrow-left"></i></button>
                    <button class="button">1</button>
                    <button class="button">2</button>
                    <button class="button">3</button>
                    <button class="button">4</button>
                    <button class="button">5</button>
                    <button class="button"><i class="fas fa-arrow-right"></i></button>
                </section>
                <?php include "view/components/footer.html";?>
            </div>
        </main>

        <?php include "view/pages/modals/drivers.html";?>

    </body>
    <script src="controller/components/modal.js"></script>
    <script src="controller/pages/drivers.js"></script>
</html>