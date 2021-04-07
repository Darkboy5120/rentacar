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
        <link rel="stylesheet" href="view/pages/styles/login.css">

        <title><?=$l_arr["global"]["app_name"].$l_arr["global"]["title_separator"]
            .$l_arr["login"]["page_name"];?></title>
    </head>
    <body>
        <main>
            <div class="container">
                <h1><?=$l_arr["login"]["page_name"];?></h1>
                <img src="media/images/main_logo.png" alt="mainlogo">
                <form id="login_info">
                    <div class="input-layout">
                        <label for="input-email"><?php echo $l_arr["login"]["txt_0"];?></label>
                        <div class="input-field">
                            <input class="input-primary" type="email" id="input-email"
                                placeholder="<?php echo $l_arr["login"]["txt_0"];?>" autofocus>
                            <i class="fas fa-envelope"></i>
                        </div>
                        <span class="input-log"></span>
                    </div>
                    <div class="input-layout">
                        <label for="input-pass"><?=$l_arr["login"]["txt_1"];?></label>
                        <div class="input-field">
                            <input class="input-primary" type="password" id="input-pass"
                                placeholder="<?=$l_arr["login"]["txt_1"];?>">
                            <i class="fas fa-lock"></i>
                        </div>
                        <span class="input-log"></span>
                    </div>
                    <button id="signin" type="button" class="button button-primary">
                        <?=$l_arr["login"]["button_signin"];?>
                    </button>
                </form>
                <footer>
                    <p><?=$l_arr["login"]["txt_2"];?> <a href="?p=register">
                        <?=$l_arr["login"]["txt_3"];?></a></p>
                    <p><?=$l_arr["login"]["txt_4"];?> <a href="#"><?=$l_arr["login"]["txt_5"];?></a></p>
                </footer>
            </div>
        </main>

        <script>l_arr = <?php echo json_encode($l_arr);?>;</script>
        <script src="controller/components/field-control.js"></script>
        <script src="controller/components/request-me.js"></script>
        <script src="controller/components/alert-me.js"></script>
        <script src="controller/pages/login.js"></script>
    </body>
</html>