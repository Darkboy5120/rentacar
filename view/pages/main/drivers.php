<?php
if (!$ci0->existSession("user_data")) {
    header('Location: ?p=login');
    exit;
}
$ci0->setSession("securitykey", $ci0->getSecurityKey());
$user_name = $ci0->getSession("user_data")["nombre"];
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
        <link rel="stylesheet" href="view/pages/styles/drivers.css">

        <title></title>
    </head>
    <body>
        <main>
            <?php include "view/components/navbar.php";?>
            <nav class="main-actions">
                <ul>
                    <button type="button" id="newDriver"><i class="fas fa-user-plus"></i><span>Agregar conductor</span></button>
                    <button type="button" id="searchAction" class="main-action-search">
                        <i class="fas fa-search"></i><span>Buscar</span>
                        <input id="search" type="text" placeholder="Búscar conductor" autocomplete="off">
                    </button>
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
                    <button class="card-sale">
                        <span>14587</span>
                        <span>$2000</span>
                        <span>03/16/2021</span>
                    </button>
                    <button class="card-sale">
                        <span>14587</span>
                        <span>$2000</span>
                        <span>03/16/2021</span>
                    </button>
                    <button class="card-sale">
                        <span>14587</span>
                        <span>$2000</span>
                        <span>03/16/2021</span>
                    </button>
                    <button class="card-sale">
                        <span>14587</span>
                        <span>$2000</span>
                        <span>03/16/2021</span>
                    </button>
                    <button class="card-sale">
                        <span>14587</span>
                        <span>$2000</span>
                        <span>03/16/2021</span>
                    </button>
                    <button class="card-sale">
                        <span>14587</span>
                        <span>$2000</span>
                        <span>03/16/2021</span>
                    </button>
                    <button class="card-sale">
                        <span>14587</span>
                        <span>$2000</span>
                        <span>03/16/2021</span>
                    </button>
                    <button class="card-sale">
                        <span>14587</span>
                        <span>$2000</span>
                        <span>03/16/2021</span>
                    </button>
                    <button class="card-sale">
                        <span>14587</span>
                        <span>$2000</span>
                        <span>03/16/2021</span>
                    </button>
                    <button class="card-sale">
                        <span>14587</span>
                        <span>$2000</span>
                        <span>03/16/2021</span>
                    </button>
                </section>
                <?php include "view/components/footer.php";?>
            </div>
        </main>

        <?php include "view/components/loading-screen.php";?>
        <?php include "view/pages/modals/drivers.html";?>

    </body>
    <script>
        const userName = "<?php echo $user_name;?>";
        const userLanguage = "<?php echo $ci0->getCookie("l");?>";
        l_arr = <?php echo json_encode($l_arr);?>;
    </script>
    <script src="controller/components/modal.js"></script>
    <script src="controller/components/loading-screen.js"></script>
    <script src="controller/pages/drivers.js"></script>
</html>