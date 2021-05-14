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
            <div class="fixed-location">
                <span><?=$l_arr["global"]["txt_0"]?> <span data-location=""></span></span>
            </div>
            <div class="container">
                <section class="car-info">
                    <form class="car-info-body" id="form-car-info">
                        <div class="car-info-section">
                            <h3><?=$l_arr["newcar"]["txt_0"]?></h3>
                            <div class="input-layout">
                                <label for="input-brand"><?=$l_arr["newcar"]["txt_1"]?></label>
                                <div class="input-field">
                                    <select class="input-secondary" id="input-brand"></select>
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                            <div class="input-layout">
                                <label for="input-model"><?=$l_arr["newcar"]["txt_2"]?></label>
                                <div class="input-field">
                                <select class="input-secondary" id="input-model"></select>
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                            <div class="input-layout">
                                <label for="input-type"><?=$l_arr["newcar"]["txt_3"]?></label>
                                <div class="input-field">
                                    <select class="input-secondary" id="input-type">
                                        <option value="0"><?=$l_arr["newcar"]["txt_4"]?></option>
                                        <option value="1"><?=$l_arr["newcar"]["txt_5"]?></option>
                                        <option value="2"><?=$l_arr["newcar"]["txt_6"]?></option>
                                        <option value="3"><?=$l_arr["newcar"]["txt_7"]?></option>
                                        <option value="4"><?=$l_arr["newcar"]["txt_8"]?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="input-layout">
                                <label for="input-price"><?=$l_arr["newcar"]["txt_9"]?></label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-price" type="text"
                                        placeholder="<?=$l_arr["newcar"]["txt_9"]?>">
                                    <span class="input-domain">MXN</span>
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                        </div>
                        <div class="car-info-section">
                            <h3><?=$l_arr["newcar"]["txt_10"]?></h3>
                            <div class="input-layout">
                                <label for="input-doors"><?=$l_arr["newcar"]["txt_11"]?></label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-doors" type="text"
                                        placeholder="<?=$l_arr["newcar"]["txt_11"]?>">
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                            <div class="input-layout">
                                <label for="input-chairs"><?=$l_arr["newcar"]["txt_12"]?></label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-chairs" type="text"
                                        placeholder="<?=$l_arr["newcar"]["txt_12"]?>">
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                            <div class="input-layout">
                                <label for="input-trunk"><?=$l_arr["newcar"]["txt_13"]?></label>
                                <div class="input-field">
                                    <select class="input-secondary" id="input-trunk">
                                        <option value="0"><?=$l_arr["newcar"]["txt_14"]?></option>
                                        <option value="1"><?=$l_arr["newcar"]["txt_15"]?></option>
                                        <option value="2"><?=$l_arr["newcar"]["txt_16"]?></option>
                                        <option value="3"><?=$l_arr["newcar"]["txt_17"]?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="car-info-section">
                            <h3><?=$l_arr["newcar"]["txt_18"]?></h3>
                            <div class="input-layout">
                                <label for="input-engine"><?=$l_arr["newcar"]["txt_19"]?></label>
                                <div class="input-field">
                                    <select class="input-secondary" id="input-engine">
                                        <option value="0"><?=$l_arr["newcar"]["txt_20"]?></option>
                                        <option value="1"><?=$l_arr["newcar"]["txt_21"]?></option>
                                        <option value="2"><?=$l_arr["newcar"]["txt_22"]?></option>
                                        <option value="3"><?=$l_arr["newcar"]["txt_23"]?></option>
                                        <option value="4"><?=$l_arr["newcar"]["txt_24"]?></option>
                                        <option value="5"><?=$l_arr["newcar"]["txt_25"]?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="input-layout">
                                <label for="input-transmission"><?=$l_arr["newcar"]["txt_26"]?></label>
                                <div class="input-field">
                                    <select class="input-secondary" id="input-transmission">
                                        <option value="0"><?=$l_arr["newcar"]["txt_27"]?></option>
                                        <option value="1"><?=$l_arr["newcar"]["txt_28"]?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="input-layout">
                                <label for="input-consunit"><?=$l_arr["newcar"]["txt_29"]?></label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-consunit" type="text"
                                        placeholder="<?=$l_arr["newcar"]["txt_29"]?>">
                                    <span class="input-domain"><?=$l_arr["newcar"]["txt_30"]?></span>
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                            <div class="input-layout">
                                <label for="input-horsepower"><?=$l_arr["newcar"]["txt_31"]?></label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-horsepower" type="text"
                                        placeholder="<?=$l_arr["newcar"]["txt_31"]?>">
                                    <span class="input-domain"><?=$l_arr["newcar"]["txt_32"]?></span>
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                            <div class="input-layout">
                                <label for="input-tankcap"><?=$l_arr["newcar"]["txt_33"]?></label>
                                <div class="input-field">
                                    <input class="input-secondary" id="input-tankcap" type="text"
                                        placeholder="<?=$l_arr["newcar"]["txt_33"]?>">
                                    <span class="input-domain">L</span>
                                </div>
                                <span class="input-log hidden"></span>
                            </div>
                        </div>
                        <div class="car-info-section">
                            <h3><?=$l_arr["newcar"]["txt_34"]?></h3>
                            <div class="input-layout">
                                <label for="input-color"><?=$l_arr["newcar"]["txt_35"]?></label>
                                <div class="input-field">
                                    <select class="input-secondary" id="input-color">
                                        <option value="0">Rojo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="switch-layout">
                                <button type="button" class="switch-field" id="switch-aircond">
                                    <i class="switch-on fas fa-toggle-on"></i>
                                    <i class="switch-off fas fa-toggle-off"></i>
                                    <label for="switch-aircond"><?=$l_arr["newcar"]["txt_36"]?></label>
                                </button>
                            </div>
                            <div class="switch-layout">
                                <button type="button" class="switch-field" id="switch-gps">
                                    <i class="switch-on fas fa-toggle-on"></i>
                                    <i class="switch-off fas fa-toggle-off"></i>
                                    <label for="switch-gps"><?=$l_arr["newcar"]["txt_37"]?></label>
                                </button>
                            </div>
                            <div class="switch-layout">
                                <button type="button" class="switch-field" id="switch-darkglass">
                                    <i class="switch-on fas fa-toggle-on"></i>
                                    <i class="switch-off fas fa-toggle-off"></i>
                                    <label for="switch-darkglass"><?=$l_arr["newcar"]["txt_38"]?></label>
                                </button>
                            </div>
                        </div>
                        <div class="car-info-section">
                            <h3><?=$l_arr["newcar"]["txt_39"]?></h3>
                            <div class="input-layout">
                                <label for="input-insurance"><?=$l_arr["newcar"]["txt_40"]?></label>
                                <div class="input-field">
                                    <select class="input-secondary" id="input-insurance">
                                        <option value="0"><?=$l_arr["newcar"]["txt_41"]?></option>
                                        <option value="1"><?=$l_arr["newcar"]["txt_42"]?></option>
                                        <option value="2"><?=$l_arr["newcar"]["txt_43"]?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="switch-layout">
                                <button type="button" class="switch-field" id="switch-replacement">
                                    <i class="switch-on fas fa-toggle-on"></i>
                                    <i class="switch-off fas fa-toggle-off"></i>
                                    <label for="switch-replacement"><?=$l_arr["newcar"]["txt_44"]?></label>
                                </button>
                            </div>
                            <div class="switch-layout">
                                <button type="button" class="switch-field" id="switch-toolbox">
                                    <i class="switch-on fas fa-toggle-on"></i>
                                    <i class="switch-off fas fa-toggle-off"></i>
                                    <label for="switch-toolbox"><?=$l_arr["newcar"]["txt_45"]?></label>
                                </button>
                            </div>
                        </div>
                        <div class="car-info-section">
                            <h3><?=$l_arr["newcar"]["txt_46"]?></h3>
                            <div class="input-layout">
                                <label for="input-thumbnail-image"><?=$l_arr["newcar"]["txt_47"]?></label>
                                <div class="input-field">
                                    <input class="hidden" id="input-thumbnail-image" type="file" multiple="true">
                                    <div class="input-secondary file-container">
                                        <div class="file-images">
                                        </div>
                                        <span class="file-empty"><?=$l_arr["newcar"]["txt_48"]?></span>
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
                            <div class="input-layout">
                                <label for="input-other-images"><?=$l_arr["newcar"]["txt_51"]?></label>
                                <div class="input-field">
                                    <input class="hidden" id="input-other-images" type="file" multiple="true">
                                    <div class="input-secondary file-container">
                                        <div class="file-images">
                                        </div>
                                        <span class="file-empty"><?=$l_arr["newcar"]["txt_48"]?></span>
                                        <div class="file-actions">
                                            <button type="button" class="file-add"><i class="fas fa-plus"></i> 
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
                        <button class="button button-primary" id="create-car"><i class="fas fa-check"></i> 
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
        <script src="controller/pages/newcar.js"></script>
    </body>
</html>