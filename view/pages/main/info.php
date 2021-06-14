<?php
$ci0->setSession("securitykey", $ci0->getSecurityKey());
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
        <!-- Custom RequestMe -->
        <script src="controller/components/request-me.js"></script>
        <!-- Custom CSS -->
        <link rel="stylesheet" href="view/pages/styles/info.css">

        <title></title>
    </head>
    <body>
        <main>
            <?php include "view/components/navbar.php";?>
            <div class="fixed-location">
                <span><?=$l_arr["info"]["page_name"]?> <span data-location=""></span></span>
            </div>
            <div class="container">
                <section class="content">
                    <section class="content-item" id="privacy-policy">
                        <h2>Politica de privadidad</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum beatae deserunt ex eos minima natus nisi porro deleniti praesentium animi! Harum fuga aperiam rerum vitae laboriosam nesciunt eligendi unde! Deleniti.</p>
                    </section>
                </section>
                <?php include "view/components/footer.php";?>
            </div>
        </main>

        <?php include "view/components/loading-screen.php";?>        
    </body>
    <script>
        const userLanguage = "<?php echo $ci0->getCookie("l");?>";
        l_arr = <?php echo json_encode($l_arr);?>;
    </script>
    <script src="controller/components/field-control.js"></script>
    <script src="controller/components/switch-control.js"></script>
    <script src="controller/components/alert-me.js"></script>
    <script src="controller/components/loading-screen.js"></script>
    <script src="controller/pages/info.js"></script>
</html>