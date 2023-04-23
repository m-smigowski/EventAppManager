<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url( $path, PHP_URL_PATH);

Router::get('index', 'DefaultController');
Router::get('main', 'MainController');
Router::get('userEdit', 'UsersPanelController');
Router::get('activate', 'SecurityController');


Router::post('addUser', 'AdminPanelController');
Router::get('usersList', 'AdminPanelController');
Router::post('usersListEdit', 'AdminPanelController');
Router::post('clientsList', 'AdminPanelController');
Router::post('addClient', 'AdminPanelController');
Router::post('editClient', 'AdminPanelController');
Router::get('rolesList', 'AdminPanelController');
Router::get('addEventRole', 'AdminPanelController');
Router::get('dropEventRole', 'AdminPanelController');

Router::get('forgotPass', 'PasswordResetController');
Router::get('createNewPassword', 'PasswordResetController');
Router::post('resetPasswordRequest', 'PasswordResetController');


Router::get('userEditPass', 'UsersPanelController');
Router::post('userUpdate', 'UsersPanelController');
Router::post('userUpdatePhoto', 'UsersPanelController');
Router::post('userUpdatePass', 'UsersPanelController');

Router::get('events', 'EventController');
Router::get('pastEvents', 'EventController');
Router::get('eventViewDetails', 'EventController');
Router::get('eventEdit', 'EventController');
Router::get('eventEditWorkers', 'EventController');
Router::get('dropWorkerFromEvent', 'EventController');
Router::get('updateEvent', 'EventController');

Router::get('calendar', 'EventController');

Router::post('searchDepot', 'DepotController');
Router::get('eventEditSchedules', 'EventController');
Router::get('eventEditEquipment', 'DepotController');
Router::post('addEquipmentToRent', 'DepotController');
Router::get('depot', 'DepotController');
Router::post('addDepotItem', 'DepotController');
Router::post('editDepotItem', 'DepotController');



Router::post('login', 'SecurityController');
Router::post('logOut', 'AppController');
Router::post('addEvent', 'EventController');
Router::post('addEventAction', 'EventController');
Router::post('search', 'EventController');
Router::post('calendarSearch', 'EventController');

Router::run($path);