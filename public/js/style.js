
function getCurrentPathname () {
    return window.location.pathname
}
function getCurrentSearch () {
    return window.location.search
}

const url = getCurrentPathname();
//$('.nav-link[href="'+url+'"]').addClass("active");

let result = url.toLocaleLowerCase().includes("event");
if(result){
    $(".submenu").addClass("show");
    console.log(result);
}

const search_url = getCurrentSearch();
console.log(url);
if((url == '/events') > 0){
    $('.nav-link[href="/events"]').addClass("active");
}

if((url == '/pastEvents') > 0){
    $('.nav-link[href="/pastEvents"]').addClass("active");
}


