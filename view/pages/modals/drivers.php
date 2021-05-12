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