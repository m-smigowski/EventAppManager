<?php
echo '<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3 sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/main">
                            <span data-feather="home" class="align-text-bottom"></span>
                            Strona główna
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="/events">
                            <span data-feather="events" class="align-text-bottom"></span>
                            Wydarzenia
                        </a>
                        
                        <a class="nav-link hidden-link" href="/pastEvents">
                            <span data-feather="events" class="align-text-bottom"></span>
                            - Archiwalne
                        </a>
                       
                    </li>
                    
                    <!---------------<li class="nav-item">
                        <a class="nav-link" href="/meetings">
                            <span data-feather="meetings" class="align-text-bottom"></span>
                            Spotkania
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="magazine" class="align-text-bottom"></span>
                            Magazyn
                        </a>
                    </li>>-------------->
                    
                    <li class="nav-item">
                        <a class="nav-link" href="/usersPanel">
                            <span data-feather="users" class="align-text-bottom"></span>
                            Panel Użytkownika
                        </a>
                    </li>
                ';
                if($_SESSION['user_status'] === 3){
                    echo '<li class="nav-item">
                        <a class="nav-link" href="/adminPanel">
                            <span data-feather="users" class="align-text-bottom"></span>
                            Panel Administratora
                        </a>
                    </li> </div></nav></ul>';
                }else{
                    echo '</li> </div></nav></ul>';
                }
