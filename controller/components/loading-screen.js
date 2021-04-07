let lsMsg = [l_arr.global.lsm_0, l_arr.global.lsm_1, l_arr.global.lsm_2,
        l_arr.global.lsm_3, l_arr.global.lsm_4, l_arr.global.lsm_5,
        l_arr.global.lsm_6];
const getLoadingScreenMsg = () => {
    return lsMsg[Math.floor(Math.random() * (lsMsg.length-1))];
}
var slideRight = {
    delay: 500,
    distance: '100%',
    origin: 'left',
    opacity: null,
    afterReveal: el => {
        document.querySelector(".fixed-location").classList.add("slide-left-fl");
    }
};
let loadingScreen = document.querySelector("#loading-screen");
loadingScreen.querySelector("p").textContent = getLoadingScreenMsg();
const hideLoadingScreen = () => {
    window.setTimeout(() => {
        loadingScreen.classList.add("loading-screen-done");
        ScrollReveal().reveal('.fixed-location', slideRight);
        window.setTimeout(() => {
            loadingScreen.classList.add("hidden");
        }, 300);
    }, 1000);
}