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
        <link rel="stylesheet" href="view/pages/styles/profile.css">

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
                <section class="profile-layout">
                    <form class="profile-section" id="personal_info">
                        <div class="profile-item">
                            <h3><?=$l_arr["profile"]["txt_0"]?></h3>
                            <div class="input-layout">
                                <label for="input-firstname"><?=$l_arr["profile"]["txt_1"]?></label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-firstname" type="text"
                                        placeholder="<?=$l_arr["profile"]["txt_1"]?>">
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                            <div class="input-layout">
                                <label for="input-lastname"><?=$l_arr["profile"]["txt_2"]?></label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-lastname" type="text"
                                        placeholder="<?=$l_arr["profile"]["txt_2"]?>">
                                </div>
                                <span class="input-log hidden"></span>
                                </div>
                            <div class="input-layout">
                                <label for="input-email"><?=$l_arr["profile"]["txt_3"]?></label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-email" type="email"
                                        placeholder="<?=$l_arr["profile"]["txt_3"]?>" disabled="disabled">
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                        </div>
                        <button class="button button-primary" id="save-personal-info" type="button">
                            <i class="fas fa-edit"></i> <?=$l_arr["profile"]["button_savepersonalinfo"]?></button>
                    </form>
                    <form class="profile-section" id="bussiness-info">
                        <div class="profile-item">
                            <h3><?=$l_arr["profile"]["txt_4"]?></h3>
                            <div class="input-layout">
                                <label for="input-bussinessname"><?=$l_arr["profile"]["txt_5"]?></label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-bussinessname" type="text"
                                        placeholder="<?=$l_arr["profile"]["txt_5"]?>">
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                            <div class="input-layout">
                                <label for="input-phone"><?=$l_arr["profile"]["txt_6"]?></label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-phone" type="text"
                                        placeholder="<?=$l_arr["profile"]["txt_6"]?>">
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                        </div>
                        <button class="button button-primary" id="save-bussiness-info" type="button">
                            <i class="fas fa-edit"></i> <?=$l_arr["profile"]["button_savebussinessinfo"]?></button>
                    </form>
                    <form class="profile-section" id="preferences_info">
                        <div class="profile-item">
                            <h3><?=$l_arr["profile"]["txt_7"]?></h3>
                            <div class="input-layout">
                                <label for="input-coin"><?=$l_arr["profile"]["txt_8"]?></label>
                                <select class="input-secondary" id="input-coin">
                                    <option value="mxn">MXN</option>
                                    <option value="usd">USD</option>
                                </select>
                            </div>
                            <div class="input-layout">
                                <label for="input-language"><?=$l_arr["profile"]["txt_9"]?></label>
                                <select class="input-secondary" id="input-language">
                                    <option value="spanish">Español</option>
                                    <option value="english">English</option>
                                </select>
                            </div>
                        </div>
                        <button class="button button-primary" id="save-preferences-info" type="button">
                            <i class="fas fa-edit"></i> <?=$l_arr["profile"]["button_savepreferencesinfo"]?></button>
                    </form>
                    <form class="profile-section" id="password-info">
                        <div class="profile-item">
                            <h3><?=$l_arr["profile"]["txt_10"]?></h3>
                            <div class="input-layout">
                                <label for="input-passold"><?=$l_arr["profile"]["txt_11"]?></label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-passold" type="password"
                                        placeholder="<?=$l_arr["profile"]["txt_11"]?>">
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                            <div class="input-layout">
                                <label for="input-pass"><?=$l_arr["profile"]["txt_12"]?></label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-pass" type="password"
                                        placeholder="<?=$l_arr["profile"]["txt_12"]?>">
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                            <div class="input-layout">
                                <label for="input-passconfirm"><?=$l_arr["profile"]["txt_13"]?></label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-passconfirm" type="password"
                                        placeholder="<?=$l_arr["profile"]["txt_13"]?>">
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                        </div>
                        <button class="button button-primary" id="save-password-info" type="button">
                            <i class="fas fa-edit"></i> <?=$l_arr["profile"]["button_savepasswordinfo"]?></button>
                    </form>
                </section>
                <?php include "view/components/footer.php";?>
            </div>
        </main>

        <?php include "view/components/loading-screen.php";?>

    </body>

    <script>
        var userName = "<?php echo $user_name;?>";
        const userLanguage = "<?php echo $ci0->getCookie("l");?>";
        const userCurrency = "<?php echo $ci0->getCookie("c");?>";
        l_arr = <?php echo json_encode($l_arr);?>;
    </script>
    <script src="controller/components/field-control.js"></script>
    <script src="controller/components/alert-me.js"></script>
    <script src="controller/components/request-me.js"></script>
    <script src="controller/components/loading-screen.js"></script>
    <script src="controller/pages/profile.js"></script>
</html>