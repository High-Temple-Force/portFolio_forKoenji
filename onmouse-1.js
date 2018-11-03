var target = document.getElementsByClassName('col');

for (let i = 0; i < target.length; i++) {
    //ON
    setborder(target[i],
        'mouseenter',
        "1px solid rgb(136, 136, 136)");
    //OUT
    setborder(target[i],
        'mouseleave',
        "1px solid #d9d9d9");
}
function getelement(element, mouse) {
    element.addEventListener()
}
function setborder(element, mouse, border) {
    element.addEventListener(mouse, () => {
        element.style.border = border;
        
    }, false);
}