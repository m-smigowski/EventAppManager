<?php
require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Client.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../repository/EventRepository.php';
require_once __DIR__ . '/../repository/AdminPanelRepository.php';

class AdminPanelController extends AppController
{
    private $userRepository;
    private $adminPanelRepository;
    private $eventRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->adminPanelRepository = new AdminPanelRepository();
        $this->eventRepository = new EventRepository();
    }

    public function adminPanel()
    {

        if (!$this->isLoggedIn()) {
            return $this->render('login', ['messages' => ['Nie masz uprawnień do przeglądania tej strony!'],
                'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }

        if (!$this->isAdmin()) {
            return $this->render('login', ['messages' => ['Nie masz uprawnień do przeglądania tej strony!'],
                'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }

        return $this->render('admin-panel');
    }

    public function modifyEventRole()
    {

        if (!$this->isLoggedIn()) {
            return $this->render('login', ['messages' => ['Nie masz uprawnień do przeglądania tej strony!'],
                'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }

        if (!$this->isAdmin()) {
            return $this->render('login', ['messages' => ['Nie masz uprawnień do przeglądania tej strony!'],
                'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }

        $all_roles = $this->eventRepository->getAllRoles();
        return $this->render('modify-event-role', ['roles' => $all_roles]);
    }

    public function addEventRole()
    {
        if (!$this->isLoggedIn()) {
            return $this->render('login', ['messages' => ['Nie masz uprawnień do przeglądania tej strony!'],
                'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }

        if (!$this->isAdmin()) {
            return $this->render('login', ['messages' => ['Nie masz uprawnień do przeglądania tej strony!'],
                'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }


        if (isset($_POST['role_name'])) {
            $role_name = $_POST['role_name'];
            $this->adminPanelRepository->addRole($role_name);
            $all_roles = $this->eventRepository->getAllRoles();
            return $this->render('modify-event-role', ['roles' => $all_roles]);
        }
    }

    public function dropEventRole()
    {
        if (!$this->isLoggedIn()) {
            return $this->render('login', ['messages' => ['Nie masz uprawnień do przeglądania tej strony!'],
                'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }

        if (!$this->isAdmin()) {
            return $this->render('login', ['messages' => ['Nie masz uprawnień do przeglądania tej strony!'],
                'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }

        if (!empty($_POST['role_name'])) {
            $role_name = $_POST['role_name'];
            $this->adminPanelRepository->dropRole($role_name);
            $all_roles = $this->eventRepository->getAllRoles();
            return $this->render('modify-event-role', ['roles' => $all_roles]);
        }
    }

    public function usersList()
    {
        $users = $this->adminPanelRepository->getAllUsers();
        return $this->render('admin-panel-users-list', ['users' => $users]);
    }

    public function usersListEdit()
    {
        $user_id = $_GET['user_id'];
        $user = $this->adminPanelRepository->getUserById($user_id);

        if ($this->isPost()) {
            if (isset($_POST['Update'])) {
                if ((!empty($_POST['name'])) && (!empty($_POST['surname'])) && (!empty($_POST['phone']))
                    && (!empty($_POST['status'])) && (!empty($_POST['active'])) && (!empty($_POST['id']))
                    && (!empty($_POST['id_user_det']))) {
                    $this->adminPanelRepository->updateUser($_POST['name'], $_POST['surname'], $_POST['email'],
                        $_POST['phone'], $_POST['status'], $_POST['active'], $_POST['id'], $_POST['id_user_det']);

                    $users = $this->adminPanelRepository->getAllUsers();
                    return $this->render('admin-panel-users-list', ['users' => $users]);
                }
            }
            if (isset($_POST['Drop'])) {
                $this->adminPanelRepository->dropUser($_POST['id'], $_POST['id_user_det']);

                $users = $this->adminPanelRepository->getAllUsers();
                return $this->render('admin-panel-users-list', ['users' => $users]);
            }

        }
        return $this->render('admin-panel-users-list-edit', ['user' => $user]);
    }

    public function clientsList()
    {
        $clients = $this->adminPanelRepository->getClients();

        if($_GET['msg'] == 'success'){
            return $this->render('admin-panel-clients-list', ['clients' => $clients,'messages' => ['Klient został dodany pomyślnie'],
                'display'=>"var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }

        if($_GET['msg'] == 'drop_success'){
            return $this->render('admin-panel-clients-list', ['clients' => $clients,'messages' => ['Klient został pomyślnie usunięty'],
                'display'=>"var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }

        if($_GET['msg'] == 'update_success'){
            return $this->render('admin-panel-clients-list', ['clients' => $clients,'messages' => ['Klient został pomyślnie zaktualizowany.'],
                'display'=>"var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }



        return $this->render('admin-panel-clients-list', ['clients' => $clients]);
    }

    public function addClient()
    {
        if ($this->isPost()){
            if(isset($_POST['addClient'])){
                if( (!empty($_POST['company_name'])) && (!empty($_POST['name'])) && (!empty($_POST['surname'])) && (!empty($_POST['email']))
                        && (!empty($_POST['phone'])) && (!empty($_POST['description'])))
                {

                    $client = new Client(null,$_POST['name'],$_POST['surname'],$_POST['description'],$_POST['phone'],
                        $_POST['email'],$_POST['company_name']);

                    $this->adminPanelRepository->addClient($client);
                    $clients = $this->adminPanelRepository->getClients();
                    $this->redirect('clientsList?msg=success');

                }
            }
        }
        return $this->render('admin-panel-clients-list-add', ['clients' => $clients]);
    }


    public function editClient()
    {

        if($this->isGet()) {
            if (isset($_GET['client_id'])) {
                $client = $this->adminPanelRepository->getClient($_GET['client_id']);
                return $this->render('admin-panel-clients-list-edit', ['client' => $client]);
            }
        }

        if($this->isPost()){

            if(isset($_POST['updateClient'])){
                $client = new Client($_POST['client_id'],$_POST['name'],$_POST['surname'],$_POST['description'],$_POST['phone'],
                    $_POST['email'],$_POST['company_name']);

                $this->adminPanelRepository->updateClient($client);

                return $this->redirect('clientsList?msg=update_success');
            }

            if(isset($_POST['dropClient'])){
                $this->adminPanelRepository->dropClient($_POST['client_id']);
                return $this->redirect('clientsList?msg=drop_success');
            }


        }


    }








}

