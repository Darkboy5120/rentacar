<div class="modal hidden" id="car-options">
    <div class="modal-card-small">
        <div class="modal-header">
            <h2><?=$l_arr["global"]["mdal_title_1"];?></h2>
            <button><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <button class="button button-primary" id="car-options-ratings"><i class="fas fa-star-half-alt"></i><?=$l_arr["home"]["txt_7"];?></button>
            <button class="button button-primary" id="car-options-edit"><i class="fas fa-edit"></i><?=$l_arr["global"]["mdal_btn_1"];?></button>
            <button class="button button-danger" id="car-options-delete"><i class="fas fa-trash"></i><?=$l_arr["global"]["mdal_btn_2"];?></button>
        </div>
    </div>
</div>
<div class="modal hidden" id="car-delete-confirm">
    <div class="modal-card-small">
        <div class="modal-header">
            <h2><?=$l_arr["home"]["txt_3"];?></h2>
            <button><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <button class="button button-danger" id="car-delete-yes"><i class="fas fa-edit"></i><?=$l_arr["global"]["mdal_btn_2"];?></button>
            <button class="button button-primary" id="car-delete-no"><i class="fas fa-trash"></i><?=$l_arr["global"]["mdal_btn_3"];?></button>
        </div>
    </div>
</div>
<div class="modal hidden" id="car-filter">
    <div class="modal-card-small">
        <div class="modal-header">
            <h2><?=$l_arr["home"]["txt_4"];?></h2>
            <button><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <div class="modal-row">
                <div class="switch-layout">
                    <button type="button" class="switch-field" id="switch-brand">
                        <i class="switch-on fas fa-toggle-on"></i>
                        <i class="switch-off fas fa-toggle-off"></i>
                    </button>
                    <label for="switch-brand"></label>
                </div>
                <div class="input-layout">
                    <label for="input-brand"><?=$l_arr["newcar"]["txt_1"]?></label>
                    <div class="input-field">
                        <select class="input-secondary" id="input-brand"></select>
                    </div>
                    <span class="input-log hidden"></span>
                </div>
            </div>
            <div class="modal-row">
                <div class="switch-layout">
                    <button type="button" class="switch-field" id="switch-model">
                        <i class="switch-on fas fa-toggle-on"></i>
                        <i class="switch-off fas fa-toggle-off"></i>
                    </button>
                    <label for="switch-model"></label>
                </div>
                <div class="input-layout">
                    <label for="input-model"><?=$l_arr["newcar"]["txt_2"]?></label>
                    <div class="input-field">
                    <select class="input-secondary" id="input-model"></select>
                    </div>
                    <span class="input-log hidden"></span>
                </div>
            </div>
            <div class="modal-row">
                <div class="switch-layout">
                    <button type="button" class="switch-field" id="switch-color">
                        <i class="switch-on fas fa-toggle-on"></i>
                        <i class="switch-off fas fa-toggle-off"></i>
                    </button>
                    <label for="switch-color"></label>
                </div>
                <div class="input-layout">
                    <label for="input-color"><?=$l_arr["newcar"]["txt_35"]?></label>
                    <div class="input-field">
                        <select class="input-secondary" id="input-color">
                            <option value="0">Rojo</option>
                        </select>
                    </div>
                </div>
            </div>
            <button class="button button-primary" id="car-filter-submit"><i class="fas fa-search"></i><?=$l_arr["home"]["txt_5"];?></button>
        </div>
    </div>
</div>
<div class="modal hidden" id="car-ratings">
    <div class="modal-card-small">
        <div class="modal-header">
            <h2><?=$l_arr["home"]["txt_8"];?></h2>
            <button><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <span class="ratings-empty hidden" id="ratings-empty"><?=$l_arr["home"]["txt_9"];?></span>
        </div>
    </div>
</div>