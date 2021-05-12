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
        <link rel="stylesheet" href="view/pages/styles/newcar.css">

        <title></title>
    </head>
    <body>
        <main>
            <?php include "view/components/navbar.php";?>
            <nav class="main-actions">
                <ul>
                </ul>
            </nav>
            <div class="fixed-location">
                <span><?=$l_arr["global"]["txt_0"]?> <span data-location=""></span></span>
            </div>
            <div class="container">
                <section class="car-info">
                    <form class="car-info-body" id="form-car-info">
                        <div class="car-info-section">
                            <h3><?=$l_arr["newdriver"]["txt_0"]?></h3>
                            <div class="input-layout">
                                <label for="input-firstname"><?=$l_arr["newdriver"]["txt_1"]?></label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-firstname" type="text"
                                        placeholder="<?=$l_arr["newdriver"]["txt_1"]?>">
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                            <div class="input-layout">
                                <label for="input-lastname"><?=$l_arr["newdriver"]["txt_2"]?></label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-lastname" type="text"
                                        placeholder="<?=$l_arr["newdriver"]["txt_2"]?>">
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                            <div class="input-layout">
                                <label for="input-phone"><?=$l_arr["newdriver"]["txt_3"]?></label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-phone" type="text"
                                        placeholder="<?=$l_arr["newdriver"]["txt_3"]?>">
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                            <div class="input-layout">
                                <label for="input-email"><?=$l_arr["newdriver"]["txt_4"]?></label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-email" type="email"
                                        placeholder="<?=$l_arr["newdriver"]["txt_4"]?>">
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                            <div class="input-layout">
                                <label for="input-pass"><?=$l_arr["newdriver"]["txt_5"]?></label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-pass" type="password"
                                        placeholder="<?=$l_arr["newdriver"]["txt_5"]?>">
                                    <i class="fas fa-eye invisible" data-toggle-pass="0"></i>
                                    <i class="fas fa-eye-slash invisible hidden" data-toggle-pass="1"></i>
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                        </div>
                        <div class="car-info-section">
                            <h3><?=$l_arr["newcar"]["txt_46"]?></h3>
                            <div class="input-layout">
                                <label for="input-profile-image"><?=$l_arr["newdriver"]["txt_6"]?></label>
                                <div class="input-field">
                                    <input class="hidden" id="input-profile-image" type="file" multiple="true">
                                    <div class="input-secondary file-container">
                                        <div class="file-images">
                                        </div>
                                        <span class="file-empty"><?=$l_arr["newdriver"]["txt_6"]?></span>
                                        <div class="file-actions">
                                            <button type="button"class="file-add"><i class="fas fa-plus"></i> 
                                                <?=$l_arr["newcar"]["txt_49"]?></button>
                                            <button type="button" class="file-edit"><i class="fas fa-edit"></i> 
                                                <?=$l_arr["newcar"]["txt_50"]?></button>
                                        </div>
                                    </div>
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                        </div>
                    </form>
                    <div class="car-info-actions">
                        <button class="button button-primary" id="create-driver"><i class="fas fa-check"></i> 
                            <?=$l_arr["newcar"]["button_createcar"]?></button>
                    </div>
                </section>
                <?php include "view/components/footer.php";?>
            </div>
        </main>

        <?php include "view/components/loading-screen.php";?>

        <script>
            const userName = "<?php echo $user_name;?>";
            l_arr = <?php echo json_encode($l_arr);?>;
        </script>
        <script src="controller/components/modal.js"></script>
        <script src="controller/components/field-control.js"></script>
        <script src="controller/components/switch-control.js"></script>
        <script src="controller/components/request-me.js"></script>
        <script src="controller/components/alert-me.js"></script>
        <script src="controller/components/file-control.js"></script>
        <script src="controller/components/loading-screen.js"></script>
        <script src="controller/pages/newdriver.js"></script>
    </body>
</html>