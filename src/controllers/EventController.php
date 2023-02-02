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
            if (isset($_POST['EventUP'])) { // aktualizowanie wydarzenia

                $event = new Event($_POST['event_id'], $_POST['title'], $_POST['description'], $_POST['status'], $_POST['type'], $_POST['event_date'],$_POST['assigned_by_id']);
                $this->eventRepository->updateEvent($event);
                $this->eventRepository->addLog($_SESSION['user_id'],"Zaktualizował szczegóły wydarzenia ".
                "<a href='/eventViewDetails?event_id=".$_POST['event_id']."'>".$_POST['title'])."</a>";
                return $this->redirect('/eventViewDetails?event_id=' . $_POST['event_id']);
            } elseif (isset($_POST['EventDEL'])) { // usuwanie wydarzenia
                $event_id = $_POST['event_id'];
                $this->eventRepository->removeEvent($event_id);
                $this->eventRepository->addLog($_SESSION['user_id'],"Usunął wydarzenie  ".$_POST['title']);
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
            $event_id = ($this->eventRepository->getLastEventId())+1;
            $event = new Event($event_id,$_POST['title'], $_POST['description'], $_POST['status'], $_POST['type'], $_POST['event_date'],$_SESSION['user_id']);
            $this->eventRepository->addEvent($event);
            $this->eventRepository->addLog($_SESSION['user_id'],"Dodał wydarzenie <a href='/eventViewDetails?event_id=".$event_id."'>".$_POST['title'])."</a>";
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
        $assignedBy_id = $event->getIdAssignedBy();
        $user = $this->userRepository->getUserById($assignedBy_id);



        if($event==null){
            return $this->redirect('/events');
        }
        $event_users = $this->eventRepository->getUsersInEvent($event_id);

        if ($event_users === null) {
            $event_users[] = new UserInEvent(
                $usersInEvent['name'] = null,
                $usersInEvent['surname'] = null,
                $usersInEvent['role_name']= null,
            );
        }

        $this->render('event-view-details', ['event' => $event, 'usersInEvent' => $event_users,'user'=>$user]);
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
            $event = $this->eventRepository->getEvent($event_id);
            $this->eventRepository->addLog($_SESSION['user_id'],"Dodał pracownika ".$_POST['user_name_and_surname'].
                " do wydarzenia <a href='/eventViewDetails?event_id=".$event_id."'>".$event->getTitle()."</a>");
        }

        if(!empty($_GET['event_id']) && !empty($_GET['name']) &&
            !empty($_GET['surname']) && !empty($_GET['role_name'])){
            $this->eventRepository->dropUserEvent($_GET['event_id'],$_GET['name'],$_GET['surname'],$_GET['role_name']);
            $event = $this->eventRepository->getEvent($event_id);
            $this->eventRepository->addLog($_SESSION['user_id'],"Usunął pracownika ".$_GET['name']." ".$_GET['surname'].
                " z wydarzenia <a href='/eventViewDetails?event_id=".$event_id."'>".$event->getTitle()."</a>");
        }

        $all_users = $this->eventRepository->getAllUsers($event_id);
        $all_roles = $this->eventRepository->getAllRoles();

        $event_users = $this->eventRepository->getUsersInEvent($event_id);


        if ($event_users === null) {
            $event_users[] = new UserInEvent(
                $usersInEvent['name'] = null,
                $usersInEvent['surname'] = null,
                $usersInEvent['role_name']= null,
            );
        }

        $this->render('event-edit-workers', ['usersInEvent' => $event_users, 'users' => $all_users,
            'roles'=> $all_roles,'event_id'=>$event_id]);
    }




}