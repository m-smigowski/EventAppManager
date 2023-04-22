
function getCurrentPathname () {
    return window.location.pathname
}
function getCurrentSearch () {
    return window.location.search
}

let currentPath = getCurrentPathname();
let eventShow = currentPath.toLocaleLowerCase().includes("event");
let userPanelShow = currentPath.includes("userEdit");

console.log(userPanelShow);
console.log(eventShow);

if(eventShow){
    $(".submenu-events").addClass("show");
}

if((currentPath.includes("events")) > 0){
    $('.nav-link[href="/events"]').addClass("active");
}

if((currentPath == '/pastEvents') > 0){
    $('.nav-link[href="/pastEvents"]').addClass("active");
}



