<?php

require_once 'AppController.php';
require_once __DIR__ .'/../models/Event.php';
require_once __DIR__ . '/../models/UserInEvent.php';
require_once __DIR__.'/../repository/EventRepository.php';
require_once __DIR__.'/../repository/UserRepository.php';


class MainController extends AppController {

    private $eventRepository;

    public function __construct()
    {
        parent:: __construct();
        $this->eventRepository = new EventRepository();
        $this->userRepository = new UserRepository();
    }

    public function main() {
        if(!$this->isLoggedIn())
        {
            return $this->render('login',['messages' => ['ZALOGUJ SIĘ!']]);
        }

        $id = $_SESSION['user_id'];
        $date = date('Y-m-d');
        $events = $this->eventRepository->getUpcomingEventsById($date,$id);


        return $this->render('main', ['events' => $events,'title'=>"Nadchodzące wydarzenia"]);


    }





}