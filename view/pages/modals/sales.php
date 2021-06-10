<div class="modal hidden" id="saleInfo">
    <div class="modal-card-small">
        <div class="modal-header">
            <h2><?=$l_arr["sales"]["txt_0"]?></h2>
            <button><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <div class="modal-row">
                <a id="sale-info-auto" target="_blank"><?=$l_arr["sales"]["txt_1"]?></a>
                <a id="sale-info-driver" target="_blank"><?=$l_arr["sales"]["txt_2"]?></a>
            </div>
            <h3><?=$l_arr["sales"]["txt_3"]?></h3>
            <button class="button button-primary" id="sale-info-return"><i class="fas fa-download"></i> <?=$l_arr["sales"]["txt_4"]?></button>
        </div>
    </div>
</div>
<div class="modal hidden" id="sale-filter">
    <div class="modal-card-small">
        <div class="modal-header">
            <h2><?=$l_arr["home"]["txt_4"];?></h2>
            <button><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <div class="modal-row">
                <div class="switch-layout">
                    <button type="button" class="switch-field" id="switch-mingain">
                        <i class="switch-on fas fa-toggle-on"></i>
                        <i class="switch-off fas fa-toggle-off"></i>
                    </button>
                    <label for="switch-mingain"></label>
                </div>
                <div class="input-layout">
                    <label for="input-mingain"><?=$l_arr["drivers"]["txt_4"]?></label>
                    <div class="input-field">
                        <input class="input-secondary" id="input-mingain" type="text"
                            placeholder="<?=$l_arr["drivers"]["txt_4"]?>">
                    </div>
                    <span class="input-log hidden"></span>
                </div>
            </div>
            <div class="modal-row">
                <div class="switch-layout">
                    <button type="button" class="switch-field" id="switch-maxgain">
                        <i class="switch-on fas fa-toggle-on"></i>
                        <i class="switch-off fas fa-toggle-off"></i>
                    </button>
                    <label for="switch-maxgain"></label>
                </div>
                <div class="input-layout">
                    <label for="input-maxgain"><?=$l_arr["drivers"]["txt_5"]?></label>
                    <div class="input-field">
                        <input class="input-secondary" id="input-maxgain" type="text"
                            placeholder="<?=$l_arr["drivers"]["txt_5"]?>">
                    </div>
                    <span class="input-log hidden"></span>
                </div>
            </div>
            <button class="button button-primary" id="sale-filter-submit"><i class="fas fa-search"></i><?=$l_arr["home"]["txt_5"];?></button>
        </div>
    </div>
</div>