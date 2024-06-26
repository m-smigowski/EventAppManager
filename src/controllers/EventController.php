<?php

require_once 'AppController.php';
require_once __DIR__ .'/../models/Event.php';
require_once __DIR__ . '/../models/UserInEvent.php';
require_once __DIR__ . '/../models/Item.php';
require_once __DIR__.'/../repository/EventRepository.php';
require_once __DIR__.'/../repository/UserRepository.php';
require_once __DIR__.'/../repository/DepotRepository.php';
require_once __DIR__.'/../repository/AdminPanelRepository.php';

class EventController extends AppController
{

    private $eventRepository;
    private $userRepository;
    private $depotRepository;
    private $adminPanelRepository;

    public function __construct()
    {
        parent:: __construct();
        $this->eventRepository = new EventRepository();
        $this->userRepository = new UserRepository();
        $this->depotRepository = new DepotRepository();
        $this->adminPanelRepository = new adminPanelRepository();
    }

    public function events()
    {
        if (!$this->isLoggedIn()) {
            return $this->render('login', ['messages' => ['ZALOGUJ SIĘ!']]);
        }

        $date = date('Y-m-d');
        $events = $this->eventRepository->getUpcomingEvents($date);

        if($_GET['msg'] == 'permission_denied'){
            $messages = ['Nie masz wystarczająco uprawnień'];
            $display = "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()";
        }
        if($_GET['msg'] == 'succes'){
            $messages = ['Wydarzenie dodane pomyślnie.'];
            $display = "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()";
        }

        $this->render('events', ['events' => $events,'messages' => $messages,
            'display' => $display,'title'=>"Aktualne wydarzenia"]);
    }



    public function pastEvents()
    {
        if (!$this->isLoggedIn()) {
            return $this->render('login', ['messages' => ['ZALOGUJ SIĘ!']]);
        }

        $date = date('Y-m-d');
        $events = $this->eventRepository->getPastEvents($date);

        $this->render('events', ['events' => $events,'past_info'=>$past_info,'title'=>"Archiwalne wydarzenia"]);
    }


    public function eventEdit()
    {
        if (!$this->isLoggedIn()) {
            return $this->render('login', ['messages' => ['Nie masz uprawnień do przeglądania tej strony!'],
                'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }

        if (!$this->isMod()) {
            return $this->render('events', ['messages' => ['Nie masz uprawnień do przeglądania tej strony!'],
                'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }


        $event_id = $_GET['event_id'];
        $past = $this->isEventPast($event_id);
        $event = $this->eventRepository->getEvent($event_id);
        $clients = $this->adminPanelRepository->getClients();
        $event_clients = $this->eventRepository->getClientsOrderByCurrentEventClient($event_id);

        $this->render('event-edit', ['event' => $event,'event_clients'=>$event_clients,'clients'=>$clients,'past'=>$past]);
    }

    public function updateEvent()
    {
        if (!$this->isLoggedIn()) {
            return $this->render('login', ['messages' => ['Nie masz uprawnień do przeglądania tej strony!'],
                'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }

        if (!$this->isMod()) {
            return $this->render('events', ['messages' => ['Nie masz uprawnień do przeglądania tej strony!'],
                'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }

        if ($this->isPost()) {
            if (isset($_POST['update'])) { // aktualizowanie wydarzenia
                $event = new Event($_POST['event_id'], $_POST['title'], $_POST['description'], $_POST['status'], $_POST['type'],
                    $_POST['event_start'],$_POST['assigned_by_id'],$_POST['event_end'],$_POST['location']);
                $this->eventRepository->updateEvent($event,$_POST['client_id']);
                $this->eventRepository->addLog($_SESSION['user_id'],"Zaktualizował szczegóły wydarzenia ".
                "<a href='/eventViewDetails?event_id=".$_POST['event_id']."'>".$_POST['title'])."</a>";
                return $this->redirect('/eventViewDetails?event_id='.$_POST['event_id']);
            } elseif (isset($_POST['drop'])) { // usuwanie wydarzenia
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

        if (!$this->isMod()) {
            return $this->redirect('/events?msg=permission_denied');
        }

        if ($this->isPost()) {
            $event_id = ($this->eventRepository->getLastEventId())+1;
            $event = new Event($event_id,$_POST['title'], $_POST['description'], $_POST['status'],
                $_POST['type'], $_POST['event_start'],$_SESSION['user_id'],$_POST['event_end'],$_POST['location'],);
            $this->eventRepository->addEvent($event);
            $this->eventRepository->addClientEvent($_POST['client_id'],$event_id);

            $this->eventRepository->addLog($_SESSION['user_id'],"Dodał wydarzenie <a href='/eventViewDetails?event_id=".$event_id."'>".$_POST['title'])."</a>";

            return $this->redirect('/events?msg=succes');
        }

        $clients = $this->adminPanelRepository->getClients();

        $this->render('event-add',['clients'=>$clients]);
    }

    public function isEventPast($event_id){ //sprawdzanie czy dany event jest archiwalny
        $current_date = date("Y-m-d");
        $is_past = $this->eventRepository->isPastEvent($event_id);
        if($current_date>$is_past){
            return true;
        }
        return false;
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

        $event_clients = $this->eventRepository->getEventClient($event_id);
        $event_schedules = $this->eventRepository->getEventSchedules($event_id);
        $past = $this->isEventPast($event_id);
        $event_users = $this->eventRepository->getUsersInEvent($event_id);

        if ($event_users === null) {
            $event_users[] = new UserInEvent(
                $usersInEvent['name'] = null,
                $usersInEvent['surname'] = null,
                $usersInEvent['role_name']= null,
            );
        }
        $rented_items = $this->depotRepository->getRentedItemsForEvent($event_id);

        $this->render('event-view-details', ['event' => $event,'past'=>$past,
            'event_clients'=>$event_clients,'event_schedules'=> $event_schedules,
            'usersInEvent' => $event_users,'user'=>$user,'rented_items'=>$rented_items]);
    }

    public function eventEditSchedules()
    {
        if (!$this->isLoggedIn()) {
            return $this->render('login', ['messages' => ['Nie masz uprawnień do przeglądania tej strony!'],
                'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }

        if (!$this->isMod()) {
            return $this->render('login', ['messages' => ['Nie masz uprawnień do przeglądania tej strony!'],
                'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }

        $event = $this->eventRepository->getEvent($_GET['event_id']);
        $event_schedules = $this->eventRepository->getEventSchedules($_GET['event_id']);
        $past = $this->isEventPast($_GET['event_id']);

        if($this->isPost()){
            if(!empty($_POST['start_date'])&&!empty($_POST['end_date'])
                &&!empty($_POST['title'])&&!empty($_POST['description'])&&!empty($_POST['event_id'])){
                $this->eventRepository->addEventSchedule($_POST['event_id'],$_POST['title'],$_POST['description'],$_POST['start_date'],$_POST['end_date']);
                $event_schedules = $this->eventRepository->getEventSchedules($_GET['event_id']);
                }
            }

        if($this->isGet()){
            if(!empty($_GET['event_id'])&&!empty($_GET['event_schedule_id'])){
                $this->eventRepository->dropEventSchedule($_GET['event_id'],$_GET['event_schedule_id']);
                $event_schedules = $this->eventRepository->getEventSchedules($_GET['event_id']);
            }
        }

        return $this->render('event-edit-schedules',['event_schedules'=>$event_schedules,'event'=>$event,'past'=>$past]);

    }

    public function eventEditWorkers()
    {
        if (!$this->isLoggedIn()) {
            return $this->render('login', ['messages' => ['Nie masz uprawnień do przeglądania tej strony!'],
                'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }

        if (!$this->isMod()) {
            return $this->render('login', ['messages' => ['Nie masz uprawnień do przeglądania tej strony!'],
                'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }

        $event_id = $_GET['event_id'];
        $admin_id = $_SESSION['user_id'];
        $past = $this->isEventPast($event_id);

        $admin = $this->userRepository->getUserById($admin_id);
        $url = "http://$_SERVER[HTTP_HOST]";
        if(isset($_POST['user_name_and_surname'])|| isset($_POST['user_role'])){
            $name_surname = explode(' ',$_POST['user_name_and_surname']);
            $user_role_name = $_POST['user_role'];
            $user_id = (int)$name_surname[2];
            $user = $this->userRepository->getUserById($user_id);
            $email = $user->getEmail();
            $event = $this->eventRepository->getEvent($event_id);

            $this->sendEmail($email,
                'Zostałeś dodany do wydarzenia '.$event->getTitle().' '.$event->getEventStart(),
                'Witaj '.$user->getName().' '.$user->getSurname().',<br>'.
                'Zostałeś dodany do wydarzenia <strong>'.$event->getTitle().'</strong>, które odbywa się od <strong>'.$event->getEventStart().' do '.$event->getEventEnd().'. </strong><br>'.
                'Stanowisko do którego zostałeś wybrany to: '.$user_role_name.'. Link do sprawdzenia wydarzenia: <a href="'.$url.'/eventViewDetails?event_id='.$event_id.'">LINK</a>'.'<br><br><br>--------------------------<br>'.
                'Jeżeli ten mail to pomyłka to niezwłocznie skontaktuj się z '.$admin->getName().' '.$admin->getSurname().' '.$admin->getPhone().'.'
            ); // Wysłanie wiadomości do użytkownika o dodaniu do wydarzenia
            $this->eventRepository->addUserEvent($name_surname,$event_id,$user_role_name); // dodanie uzytkownika do wydarzenia

            $this->eventRepository->addLog($_SESSION['user_id'],"Dodał pracownika ".$_POST['user_name_and_surname']. // dodanie wpisu w systemie logów
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
            'roles'=> $all_roles,'event_id'=>$event_id,'past'=>$past]);
    }

    public function calendar(){
        $this->render('event-calendar');
    }

    public function calendarSearch(){
        $contentType = isset($_SERVER["CONTENT_TYPE"])? trim($_SERVER["CONTENT_TYPE"]) : '';

        if($contentType == "application/json"){
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content,true);

            header('Content-type:application/json');
            http_response_code(200);

            $input = $decoded['search'];
            $date = strtotime($input);

            echo json_encode($this->eventRepository->getEventByDate(date('Y-m-d', $date)));
        }
    }



    public function search(){
        $contentType = isset($_SERVER["CONTENT_TYPE"])? trim($_SERVER["CONTENT_TYPE"]) : '';

        if($contentType == "application/json"){
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content,true);

            header('Content-type:application/json');
            http_response_code(200);

            echo json_encode($this->eventRepository->getEventByTitle($decoded['search']));
        }


    }



}