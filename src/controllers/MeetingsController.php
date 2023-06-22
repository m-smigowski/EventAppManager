<?php

require_once 'AppController.php';
require_once __DIR__ .'/../models/Meeting.php';
require_once __DIR__.'/../repository/UserRepository.php';
require_once __DIR__.'/../repository/AdminPanelRepository.php';
require_once __DIR__.'/../repository/MeetingsRepository.php';

class MeetingsController extends AppController
{

    private $userRepository;
    private $adminPanelRepository;
    private $meetingsRepository;

    public function __construct()
    {
        parent:: __construct();
        $this->userRepository = new UserRepository();
        $this->adminPanelRepository = new adminPanelRepository();
        $this->meetingsRepository = new meetingsRepository();
    }

    public function meetings()
    {
        if (!$this->isLoggedIn()) {
            return $this->render('login', ['messages' => ['ZALOGUJ SIĘ!']]);
        }

        if ($_GET['msg'] == 'succes') {
            $messages = ['Spotkanie dodane pomyślnie.'];
            $display = "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()";
        }

        if ($_GET['msg'] == 'error') {
            $messages = ['Wystąpił błąd spróbuj ponownie'];
            $display = "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()";
        }

        $date = date('Y-m-d');
        $meetings = $this->meetingsRepository->getUpcomingMeetings($date);


        $this->render('meetings', ['meetings' => $meetings, 'messages' => $messages, 'display' => $display, 'title' => "Aktualne spotkania"]);
    }


    public function addMeeting(){

        $clients = $this->adminPanelRepository->getClients();

        if (!$this->isLoggedIn()) {
            return $this->render('login', ['messages' => ['ZALOGUJ SIĘ!']]);
        }

        if($this->isPost())
        {
            if(!empty($_POST['topic']&&!empty($_POST['date'])&&!empty($_POST['tasks'])&&!empty($_POST['location'])&&$_POST['client_id'])) {
            $meeting = new Meeting(NULL, $_POST['topic'], $_POST['date'], $_POST['tasks'], $_POST['location'], $_POST['client_id']);
            $this->meetingsRepository->addMeeting($meeting);
            return $this->redirect('meetings?msg=succes');
            }else return $this->redirect('meetings?msg=error');
        }

        $this->render('meeting-add',['clients' => $clients]);
    }

    public function meetingDetails(){

        if (!$this->isLoggedIn()) {
            return $this->render('login', ['messages' => ['ZALOGUJ SIĘ!']]);
        }

        $meeting_id = $_GET['meeting_id'];
        $meeting = $this->meetingsRepository->getMeeting($meeting_id);

        $users_in_meeting = $this->meetingsRepository->getUsersInMeeting($meeting_id);

        $this->render('meeting-details',['meeting' => $meeting,'users_in_meeting' => $users_in_meeting]);
    }


    public function editMeeting(){

        if (!$this->isLoggedIn()) {
            return $this->render('login', ['messages' => ['ZALOGUJ SIĘ!']]);
        }


        $meeting_id = $_GET['meeting_id'];
        $meeting = $this->meetingsRepository->getMeeting($meeting_id);

        $meeting_client_id = $meeting->getClient()[0]['id'];
        $clients = $this->meetingsRepository->getClientsOrderByMeetingClient($meeting_client_id);

        $users_in_meeting = $this->meetingsRepository->getUsersInMeeting($meeting_id);
        $all_active_users = $this->meetingsRepository->getAllMeetingUsers($meeting_id);

        $this->render('meeting-edit',['meeting' => $meeting,'users_in_meeting' => $users_in_meeting,'all_active_users' => $all_active_users,'clients'=>$clients]);
    }


    public function updateMeeting(){
        if (!$this->isLoggedIn()) {
            return $this->render('login', ['messages' => ['ZALOGUJ SIĘ!']]);
        }

        if($this->isPost()){
            $client = $_POST['client_id'];
            $topic = $_POST['topic'];
            $date = $_POST['date'];
            $location = $_POST['location'];
            $tasks = $_POST['tasks'];
            $meeting_id = $_POST['meeting_id'];

            $this->meetingsRepository->updateMeetings($client,$topic,$date,$location,$tasks,$meeting_id);

            return $this->redirect('/meetingDetails?meeting_id='.$meeting_id);
        }


    }

    public function addUserMeetings(){

        if (!$this->isLoggedIn()) {
            return $this->render('login', ['messages' => ['ZALOGUJ SIĘ!']]);
        }

        if($this->isPost()){
            $user_id = $_POST['user_id'];
            $meeting_id = $_POST['meeting_id'];
            $this->meetingsRepository->addUserToMeeting($user_id,$meeting_id);
            return $this->redirect('/editMeeting?meeting_id='.$meeting_id);

        }

    }

    public function dropUserMeetings(){

        if (!$this->isLoggedIn()) {
            return $this->render('login', ['messages' => ['ZALOGUJ SIĘ!']]);
        }

        if($this->isGet()){
            $meeting_id = $_GET['meeting_id'];
            $user_id = $_GET['user_id'];
            $this->meetingsRepository->dropUserMeeting($user_id,$meeting_id);
            return $this->redirect('/editMeeting?meeting_id='.$meeting_id);
        }

    }





}