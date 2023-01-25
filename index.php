<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url( $path, PHP_URL_PATH);

Router::get('index', 'DefaultController');
Router::get('main', 'MainController');
Router::get('projects', 'ProjectController');
Router::get('usersPanel', 'UsersPanelController');
Router::get('activate', 'SecurityController');

Router::get('forgotPass', 'PasswordResetController');
Router::get('createNewPassword', 'PasswordResetController');
Router::post('resetPasswordRequest', 'PasswordResetController');

Router::post('userEdit', 'UsersPanelController');
Router::get('userEditPass', 'UsersPanelController');
Router::post('userUpdate', 'UsersPanelController');
Router::post('userUpdatePass', 'UsersPanelController');

Router::get('events', 'EventController');
Router::get('pastEvents', 'EventController');
Router::get('eventViewDetails', 'EventController');
Router::get('eventEdit', 'EventController');
Router::get('eventEditWorkers', 'EventController');
Router::get('dropWorkerFromEvent', 'EventController');
Router::get('updateEvent', 'EventController');

Router::post('login', 'SecurityController');
Router::post('logOut', 'AppController');
Router::post('register', 'SecurityController');
Router::post('addProject', 'ProjectController');
Router::post('addEvent', 'EventController');
Router::post('addEventAction', 'EventController');
Router::post('search', 'ProjectController');

Router::run($path);