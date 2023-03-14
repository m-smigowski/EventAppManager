<?php

if($past===true){
    $past_event_active = htmlspecialchars("$('.nav-link[href=\"/pastEvents\"]').addClass('active')",ENT_HTML5);
}
if($past===false){
    $past_event_active = htmlspecialchars("$('.nav-link[href=\"/events\"]').addClass('active')",ENT_HTML5);
}

echo '
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
            crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script type="text/javascript" src="./public/js/style.js"></script>
    <script type="text/javascript" src="./public/js/submenu.js"></script>
    <script>'.$past_event_active.'</script>
';