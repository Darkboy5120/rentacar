<?php
$ci0->setSession("securitykey", $ci0->getSecurityKey());
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
        <link rel="stylesheet" href="view/pages/styles/register.css">

        <title><?=$l_arr["global"]["app_name"].$l_arr["global"]["title_separator"]
            .$l_arr["register"]["page_name"];?></title>
    </head>
    <body>
        <main>
            <?php include "view/components/navbar.php";?>
            <div class="fixed-location">
                <span><?=$l_arr["global"]["txt_0"]?> <span data-location=""></span></span>
            </div>
            <div class="container">
                <div class="form-wrapper">
                    <h1><?=$l_arr["register"]["txt_12"];?></h1>
                    <div class="form-index">
                        <div class="index-item index-active" id="personal-info-index">
                            <span class="item-number">1</span>
                            <span class="item-name"><?=$l_arr["register"]["txt_0"];?></span>
                        </div>
                        <div class="index-item" id="bussiness-info-index">
                            <span class="item-number">2</span>
                            <span class="item-name"><?=$l_arr["register"]["txt_1"];?></span>
                        </div>
                    </div>
                    <form id="form-personal-info">
                        <div class="fields-wrapper">
                            <div class="input-layout">
                                <label for="input-firstname"><?=$l_arr["register"]["txt_2"];?></label>
                                <div class="input-field">
                                    <input class="input-primary" type="text" id="input-firstname"
                                        placeholder="<?=$l_arr["register"]["txt_2"];?>" autofocus>
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                            <div class="input-layout">
                                <label for="input-lastname"><?=$l_arr["register"]["txt_3"];?></label>
                                <div class="input-field">
                                    <input class="input-primary" type="text" id="input-lastname"
                                        placeholder="<?=$l_arr["register"]["txt_3"];?>">
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                        </div>
                        <div class="input-layout">
                            <label for="input-email"><?=$l_arr["register"]["txt_8"];?></label>
                            <div class="input-field">
                                <input class="input-primary" type="email" id="input-email"
                                    placeholder="<?=$l_arr["register"]["txt_8"];?>">
                            </div>
                            <span class="input-log hidden"></span>
                        </div>
                        <div class="input-layout">
                            <label for="input-pass"><?=$l_arr["register"]["txt_4"];?></label>
                            <div class="input-field both-icons">
                                <input class="input-primary" type="password" id="input-pass"
                                    placeholder="<?=$l_arr["register"]["txt_4"];?>">
                                <i class="fas fa-eye invisible" data-toggle-pass="0"></i>
                                <i class="fas fa-eye-slash invisible hidden" data-toggle-pass="1"></i>
                                <i class="fas fa-lock"></i>
                            </div>
                            <span class="input-log hidden"></span>
                        </div>
                        <div class="input-layout">
                            <div class="input-check">
                                <input class="input-checkbox" type="checkbox" id="input-acept-policy"
                                    placeholder="<?=$l_arr["register"]["txt_14"];?>">
                                <label for="input-acept-policy">
                                    <?=$l_arr["register"]["txt_14"];?> <a href="?p=info#terms-of-use" target="_blank"><?=$l_arr["register"]["txt_16"];?></a></label>
                            </div>
                            <span class="input-log hidden"><?=$l_arr["register"]["txt_15"];?></span>
                        </div>
                        <button id="signup-step1" type="button" class="button button-primary">
                            <?=$l_arr["register"]["button_step1"];?></button>
                    </form>
                    <form class="hidden" id="form-bussiness-info">
                        <div class="input-layout">
                            <label for="input-bussiness-name"><?=$l_arr["register"]["txt_6"];?></label>
                            <div class="input-field">
                                <input class="input-primary" type="text" id="input-bussiness-name"
                                    placeholder="<?=$l_arr["register"]["txt_6"];?>">
                            </div>
                            <span class="input-log hidden"></span>
                        </div>
                        <div class="input-layout">
                            <label for="input-bussiness-phone"><?=$l_arr["register"]["txt_7"];?></label>
                            <div class="input-field">
                                <input class="input-primary" type="text" id="input-bussiness-phone"
                                    placeholder="<?=$l_arr["register"]["txt_7"];?>">
                            </div>
                            <span class="input-log hidden"></span>
                        </div>
                        <div class="input-layout">
                            <label for="input-bussiness-location"><?=$l_arr["register"]["txt_11"];?></label>
                            <div class="input-field both-icons">
                                <input class="input-primary" type="text" id="input-bussiness-location"
                                    placeholder="<?=$l_arr["register"]["txt_11"];?>">
                                <i class="fas fa-info-circle" data-support-tooltip-content="<?=$l_arr["register"]["txt_13"];?>"></i>
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <span class="input-log hidden"></span>
                        </div>
                        <button id="to-personal-info" type="button" class="button button-primary">
                            <?=$l_arr["register"]["button_tostep1"];?></button>
                        <button id="signup-step2" type="button" class="button button-primary">
                            <?=$l_arr["register"]["button_step2"];?></button>
                    </form>
                    <footer>
                        <p><?=$l_arr["register"]["txt_9"];?> <a href="?p=login">
                            <?=$l_arr["register"]["txt_10"];?></a></p>
                    </footer>
                </div>
            </div>
        </main>

        <?php include "view/pages/modals/register.php";
            include "view/components/loading-screen.php";?>

        <script>l_arr = <?php echo json_encode($l_arr);?>;</script>
        <script src="controller/components/modal.js"></script>
        <script src="controller/components/field-control.js"></script>
        <script src="controller/components/location-picker-control.js"></script>
        <script src="controller/components/request-me.js"></script>
        <script src="controller/components/alert-me.js"></script>
        <script src="controller/components/loading-screen.js"></script>
        <script src="controller/components/support-tooltip.js"></script>
        <script type="text/javascript"
          src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBBZZ6DHqFZwU9VfyTHoHGG7nYK_mdbBv8"></script>
        <script src="https://unpkg.com/location-picker/dist/location-picker.min.js"></script>
        <script src="controller/pages/register.js"></script>
    </body>
</html>