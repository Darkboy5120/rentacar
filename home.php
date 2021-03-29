<?php
require "model/libraries/cookie_interface.php";
if (!$ci0->existCookie("user_data")) {
    header('Location: login.php');
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

        <link rel="icon" type="image/png" sizes="32x32" href="media/images/main_logo.png" />
        <!-- ScrollReveal -->
        <script src="https://unpkg.com/scrollreveal"></script>
        <!-- Font Awesome -->
        <script src="https://kit.fontawesome.com/0d40d8f017.js" crossorigin="anonymous"></script>
        <!-- Custom CSS -->
        <link rel="stylesheet" href="view/pages/home.css">

        <title></title>
    </head>
    <body>
        <main>
            <?php include "view/components/navbar.html";?>
            <nav class="main-actions">
                <ul>
                    <li><i class="fas fa-plus"></i><span>Agregar auto</span></li>
                    <li><i class="fas fa-search"></i><span>Buscar</span></li>
                </ul>
            </nav>
            <div class="fixed-location">
                <span>Estas en <span data-location=""></span></span>
            </div>
            <div class="container">
                <section class="cards-cars">
                    <article class="card-car">
                        <h2>Bocho</h2>
                        <img src="media/images/foo.jpeg" alt="imagen">
                        <i class="fas fa-ellipsis-v"></i>
                    </article>
                    <article class="card-car">
                        <h2>Bocho</h2>
                        <img src="media/images/foo.jpeg" alt="imagen">
                        <i class="fas fa-ellipsis-v"></i>
                    </article>
                    <article class="card-car">
                        <h2>Bocho</h2>
                        <img src="media/images/foo.jpeg" alt="imagen">
                        <i class="fas fa-ellipsis-v"></i>
                    </article>
                    <article class="card-car">
                        <h2>Bocho</h2>
                        <img src="media/images/foo.jpeg" alt="imagen">
                        <i class="fas fa-ellipsis-v"></i>
                    </article>
                    <article class="card-car">
                        <h2>Bocho</h2>
                        <img src="media/images/foo.jpeg" alt="imagen">
                        <i class="fas fa-ellipsis-v"></i>
                    </article>
                    <article class="card-car">
                        <h2>Bocho</h2>
                        <img src="media/images/foo.jpeg" alt="imagen">
                        <i class="fas fa-ellipsis-v"></i>
                    </article>
                    <article class="card-car">
                        <h2>Bocho</h2>
                        <img src="media/images/foo.jpeg" alt="imagen">
                        <i class="fas fa-ellipsis-v"></i>
                    </article>
                    <article class="card-car">
                        <h2>Bocho</h2>
                        <img src="media/images/foo.jpeg" alt="imagen">
                        <i class="fas fa-ellipsis-v"></i>
                    </article>
                    <article class="card-car">
                        <h2>Bocho</h2>
                        <img src="media/images/foo.jpeg" alt="imagen">
                        <i class="fas fa-ellipsis-v"></i>
                    </article>
                    <article class="card-car">
                        <h2>Bocho</h2>
                        <img src="media/images/foo.jpeg" alt="imagen">
                        <i class="fas fa-ellipsis-v"></i>
                    </article>
                    
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

        <?php include "view/pages/modals/home.html";?>

        <script>
            const userName = "<?php echo $user_name;?>";
        </script>
        <script src="controller/components/modal.js"></script>
        <script src="controller/components/request-me.js"></script>
        <script src="controller/pages/home.js"></script>
    </body>
</html>