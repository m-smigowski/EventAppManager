<?php

require_once 'AppController.php';
require_once __DIR__ .'/../models/Event.php';
require_once __DIR__ . '/../models/UserInEvent.php';
require_once __DIR__.'/../repository/EventRepository.php';
require_once __DIR__.'/../repository/UserRepository.php';

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
        $this->userRepository = new UserRepository();
    }

    public function events()
    {
        if (!$this->isLoggedIn()) {
            return $this->render('login', ['messages' => ['ZALOGUJ SIĘ!']]);
        }

        $date = date('Y-m-d');
        $events = $this->eventRepository->getUpcomingEvents($date);
        $this->render('events', ['events' => $events,'title'=>"Nadchodzące wydarzenia"]);
    }

    public function pastEvents()
    {
        if (!$this->isLoggedIn()) {
            return $this->render('login', ['messages' => ['ZALOGUJ SIĘ!']]);
        }


        $date = date('Y-m-d');
        $events = $this->eventRepository->getPastEvents($date);
        $past_info = "$('.nav-item [href='/pastEvents']').addClass('active');";
        $this->render('events', ['events' => $events,'title'=>"Archiwalne wydarzenia"]);
    }


    public function eventEdit()
    {
        if (!$this->isLoggedIn()) {

            return $this->render('login', ['messages' => ['Nie masz uprawnień do przeglądania tej strony!'],
                'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }

        if (!$this->isAdmin()) {

            return $this->render('events', ['messages' => ['Nie masz uprawnień do przeglądania tej strony!'],
                'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }


        $event_id = $_GET['event_id'];
        $event = $this->eventRepository->getEvent($event_id);
        $this->render('event-edit', ['event' => $event]);
    }

    public function updateEvent()
    {
        if (!$this->isLoggedIn()) {
            return $this->render('login', ['messages' => ['Nie masz uprawnień do przeglądania tej strony!'],
                'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }

        if (!$this->isAdmin()) {

            return $this->render('events', ['messages' => ['Nie masz uprawnień do przeglądania tej strony!'],
                'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }

        if ($this->isPost()) {
            if (isset($_POST['EventUP'])) {
                $event = new Event($_POST['event_id'], $_POST['title'], $_POST['description'], $_POST['status'], $_POST['type'], $_POST['event_date'],);
                $this->eventRepository->updateEvent($event);

                return $this->redirect('/eventViewDetails?event_id=' . $_POST['id']);
            } elseif (isset($_POST['EventDEL'])) {
                $event_id = $_POST['event_id'];
                $this->eventRepository->removeEvent($event_id);
                return $this->redirect('/events');
            }
        }
    }

    public function addEvent()
    {
        if (!$this->isLoggedIn()) {
            return $this->render('login', ['messages' => ['Nie masz uprawnień do przeglądania tej strony!'],
                'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }

        if (!$this->isAdmin()) {
            return $this->render('events', ['messages' => ['Nie masz uprawnień do przeglądania tej strony!'],
                'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }

        if ($this->isPost()) {
            $event = new Event($_POST['id'], $_POST['title'], $_POST['description'], $_POST['status'], $_POST['type'], $_POST['event_date'],);

            $this->eventRepository->addEvent($event);
            $events = $this->eventRepository->getEvents();

            return $this->redirect('/events');
        }

        $this->render('add-event');
    }

    public function eventViewDetails()
    {
        if (!$this->isLoggedIn()) {
            return $this->render('login', ['messages' => ['Nie masz uprawnień do przeglądania tej strony!'],
                'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }

        $event_id = $_GET['event_id'];
        $event = $this->eventRepository->getEvent($event_id);

        $event_users_ids = $this->eventRepository->getIdUsersInEvent($event_id);
        if ($event_users_ids === null) {
            $event_users[] = new UserInEvent(
                $usersInEvent['name'] = null,
                $usersInEvent['surname'] = null,
                $usersInEvent['role_name']= null,
            );
        } else {
            $arr = array_column($event_users_ids, 'id_users');
            $arr_to_string = implode(',', $arr);
            $event_users = $this->eventRepository->getUsersInEvent($arr_to_string,$event_id);
        }

        $this->render('event-view-details', ['event' => $event, 'usersInEvent' => $event_users]);
    }

    public function eventEditWorkers()
    {
        if (!$this->isAdmin()) {

            return $this->render('login', ['messages' => ['Nie masz uprawnień do przeglądania tej strony!'],
                'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }

        $event_id = $_GET['event_id'];

        if(isset($_POST['user_name_and_surname'])|| isset($_POST['user_role'])){
            $name_surname = explode(' ',$_POST['user_name_and_surname']);
            $user_role_name = $_POST['user_role'];
            $this->eventRepository->addUserEvent($name_surname,$event_id,$user_role_name);
        }

        if(!empty($_GET['event_id']) && !empty($_GET['name']) &&
            !empty($_GET['surname']) && !empty($_GET['role_name'])){
            $this->eventRepository->dropUserEvent($_GET['event_id'],$_GET['name'],$_GET['surname'],$_GET['role_name']);
        }

        $event_users_ids = $this->eventRepository->getIdUsersInEvent($event_id);
        $all_users = $this->userRepository->getAllUsers();
        $all_roles = $this->eventRepository->getAllRoles();

        if ($event_users_ids === null) {
            $event_users[] = new UserInEvent(
                $usersInEvent['name'] = null,
                $usersInEvent['surname'] = null,
                $usersInEvent['role_name']= null,
            );
        } else {
            $arr = array_column($event_users_ids, 'id_users'); // pobieranie wartości z pojedynczej kolumny
            $arr_to_string = implode(',', $arr); // zamiana tablicy na typ string
            $event_users = $this->eventRepository->getUsersInEvent($arr_to_string,$event_id);
        }

        $this->render('event-edit-workers', ['usersInEvent' => $event_users, 'users' => $all_users,
            'roles'=> $all_roles,'event_id'=>$event_id]);
    }


}