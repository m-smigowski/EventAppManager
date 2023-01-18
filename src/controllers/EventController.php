<?php

require_once 'AppController.php';
require_once __DIR__ .'/../models/Event.php';
require_once __DIR__.'/../repository/EventRepository.php';

class EventController extends AppController
{

    const MAX_FILE_SIZE = 2024 * 2024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/img/uploads/';

    private $messages = [];
    private $eventRepository;

    public function __construct()
    {
        parent:: __construct();
        $this->eventRepository = new EventRepository();
    }

    public function events()
    {
        if(!$this->isLoggedIn())
        {
            return $this->render('login',['messages' => ['ZALOGUJ SIĘ!']]);
        }

        $date = date('Y-m-d');
        $events = $this->eventRepository->getUpcomingEvents($date);
        $this->render('events', ['events' => $events]);
    }

    public function pastEvents()
    {
        if(!$this->isLoggedIn())
        {
            return $this->render('login',['messages' => ['ZALOGUJ SIĘ!']]);
        }

        $date = date('Y-m-d');
        $events = $this->eventRepository->getPastEvents($date);
        $this->render('past-events', ['events' => $events]);
    }


    public function eventEdit()
    {
        if(!$this->isLoggedIn())
        {

            return $this->render('login', ['messages' => ['Nie masz uprawnień do przeglądania tej strony!'],
                'display'=>"var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }

        $id = $_GET['id'];
        $event = $this->eventRepository->getEvent($id);
        $this->render('event-edit', ['event' => $event]);
    }

    public function updateEvent()
    {
        if(!$this->isLoggedIn())
        {
            return $this->render('login', ['messages' => ['Nie masz uprawnień do przeglądania tej strony!'],
                'display'=>"var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }

        if ($this->isPost()) {
            if(isset($_POST['EventUP'])){
                $event = new Event($_POST['id'], $_POST['title'], $_POST['description'], $_POST['status'], $_POST['type'], $_POST['event_date'],);
                $this->eventRepository->updateEvent($event);
                return $this->redirect('/events');
            }
            elseif(isset($_POST['EventDEL'])){
                $id = $_POST['id'];
                $this->eventRepository->removeEvent($id);
                return $this->redirect('/events');
            }
        }
    }

    public function addEvent()
    {
        if(!$this->isLoggedIn())
        {
            return $this->render('login', ['messages' => ['Nie masz uprawnień do przeglądania tej strony!'],
                'display'=>"var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }

        if($this->isPost())
        {
            $event = new Event($_POST['id'], $_POST['title'], $_POST['description'], $_POST['status'], $_POST['type'], $_POST['event_date'],);

            $this->eventRepository->addEvent($event);
            $events = $this->eventRepository->getEvents();

            return $this->redirect('/events');
        }
        $this->render('add-event');
    }


}