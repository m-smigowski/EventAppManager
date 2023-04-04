<?php



echo '
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="d-flex flex-column flex-shrink-0 p-2 text-bg-dark">
                <ul class="nav nav-pills flex-column d-flex">
                    <li class="nav-item">
                        <a href="/main" class="nav-link text-white" aria-current="page">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#home"/>
                            </svg>
                            Strona Główna
                        </a>
                    </li>
                    <li class="nav-item has-submenu">
                        <a href="#" class="nav-link text-white">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#table"/>
                            </svg>
                            Wydarzenia
                        </a>
                        <ul class="submenu collapse">
                            <li><a class="nav-link" href="/events">Najbliższe</a></li>
                            <li><a class="nav-link" href="/pastEvents">Archiwalne </a></li>
                            <li><a class="nav-link" href="/calendar">Kalendarz</a> </li>
                        </ul>
                       
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link text-white">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#table"/>
                            </svg>
                            Spotkania
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/depot" class="nav-link text-white">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#grid"/>
                            </svg>
                            Magazyn
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/usersPanel" class="nav-link text-white">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#people-circle"/>
                            </svg>
                            Panel Użytkownika
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/adminPanel" class="nav-link text-white mt-auto">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#people-circle"/>
                            </svg>
                            Panel Administratora
                        </a>
                    </li>
                </ul>
                <hr>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle "
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="public/img/app-image/'.$_SESSION['user_profile_photo'].'" alt="" width="32" height="32" class="rounded-circle me-2">
                        <strong>'.$_SESSION['user_name'].' '.$_SESSION['user_surname'].'</strong>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                        <li><a class="dropdown-item" href="#">Ustawienia</a></li>
                        <li><a class="dropdown-item" href="#">Profil</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="/logOut">Wyloguj się</a></li>
                    </ul>
                </div>
            </div>
        </nav>


';