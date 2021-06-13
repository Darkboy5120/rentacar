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
        <!-- Custom RequestMe -->
        <script src="controller/components/request-me.js"></script>
        <!-- Custom CSS -->
        <link rel="stylesheet" href="view/pages/styles/sales.css">

        <title></title>
    </head>
    <body>
        <main>
            <?php include "view/components/navbar.php";?>
            <div class="fixed-location">
                <span><?=$l_arr["global"]["txt_0"]?> <span data-location=""></span></span>
            </div>
            <div class="container">
                <section class="cards-sales" id="cards-sales">
                    <div class="card-sale-header">
                        <span><?=$l_arr["sales"]["txt_5"]?></span>
                        <span><?=$l_arr["sales"]["txt_6"]?></span>
                        <span><?=$l_arr["sales"]["txt_7"]?></span>
                    </div>
                    <span class="cards-empty hidden" id="cards-empty">
                        <?=$l_arr["sales"]["txt_11"]?></span>
                </section>
                <section class="load-more hidden" id="load-more-layout">
                    <button class="button button-primary" id="load-more">
                        <?=$l_arr["home"]["button_loadmore"]?></button>
                </section>
                <?php include "view/components/footer.php";?>
            </div>
        </main>

        <?php include "view/components/loading-screen.php";?>
        <?php include "view/pages/modals/sales.php";?>
        
    </body>
    <script>
        const userName = "<?php echo $user_name;?>";
        const userLanguage = "<?php echo $ci0->getCookie("l");?>";
        const saleId = "<?php echo (isset($_GET["sale"])) ? $_GET["sale"] : "";?>";
        l_arr = <?php echo json_encode($l_arr);?>;
    </script>
    <script src="controller/components/modal.js"></script>
    <script src="controller/components/field-control.js"></script>
    <script src="controller/components/switch-control.js"></script>
    <script src="controller/components/alert-me.js"></script>
    <script src="controller/components/loading-screen.js"></script>
    <script src="controller/pages/sales.js"></script>
</html>