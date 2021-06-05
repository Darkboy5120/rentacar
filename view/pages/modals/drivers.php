<div class="modal hidden" id="driver-options">
    <div class="modal-card-small">
        <div class="modal-header">
            <h2><?=$l_arr["global"]["mdal_title_1"];?></h2>
            <button><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <div class="driver-info-layout">
                <img id="driver-options-image" src="" alt="foo">
                <div class="generic-valoration">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <div class="driver-info">
                    <span id="driver-options-fullname">Juanito Camela Rosas Sosa</span>
                    <span id="driver-options-email">hmaldonado0@ucol.mx</span>
                    <span id="driver-options-phone">3142231231</span>
                </div>
            </div>
            <button class="button button-danger" id="driver-options-fire"><i class="fas fa-trash"></i><?=$l_arr["global"]["mdal_btn_4"];?></button>
        </div>
    </div>
</div>
<div class="modal hidden" id="driver-fire-confirm">
    <div class="modal-card-small">
        <div class="modal-header">
            <h2><?=$l_arr["drivers"]["txt_0"];?></h2>
            <button><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <button class="button button-danger" id="driver-fire-yes"><i class="fas fa-edit"></i><?=$l_arr["drivers"]["txt_1"];?></button>
            <button class="button button-primary" id="driver-fire-no"><i class="fas fa-trash"></i><?=$l_arr["global"]["mdal_btn_3"];?></button>
        </div>
    </div>
</div>
<div class="modal hidden" id="driver-filter">
    <div class="modal-card-small">
        <div class="modal-header">
            <h2><?=$l_arr["home"]["txt_4"];?></h2>
            <button><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <div class="modal-row">
                <div class="switch-layout">
                    <button type="button" class="switch-field" id="switch-firstname">
                        <i class="switch-on fas fa-toggle-on"></i>
                        <i class="switch-off fas fa-toggle-off"></i>
                    </button>
                    <label for="switch-firstname"></label>
                </div>
                <div class="input-layout">
                    <label for="input-firstname"><?=$l_arr["drivers"]["txt_4"]?></label>
                    <div class="input-field">
                        <input class="input-secondary" id="input-firstname" type="text"
                            placeholder="<?=$l_arr["drivers"]["txt_4"]?>">
                    </div>
                    <span class="input-log hidden"></span>
                </div>
            </div>
            <div class="modal-row">
                <div class="switch-layout">
                    <button type="button" class="switch-field" id="switch-lastname">
                        <i class="switch-on fas fa-toggle-on"></i>
                        <i class="switch-off fas fa-toggle-off"></i>
                    </button>
                    <label for="switch-lastname"></label>
                </div>
                <div class="input-layout">
                    <label for="input-lastname"><?=$l_arr["drivers"]["txt_5"]?></label>
                    <div class="input-field">
                        <input class="input-secondary" id="input-lastname" type="text"
                            placeholder="<?=$l_arr["drivers"]["txt_5"]?>">
                    </div>
                    <span class="input-log hidden"></span>
                </div>
            </div>
            <button class="button button-primary" id="driver-filter-submit"><i class="fas fa-search"></i><?=$l_arr["home"]["txt_5"];?></button>
        </div>
    </div>
</div>