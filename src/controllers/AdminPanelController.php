<?php
require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';
require_once __DIR__.'/../repository/EventRepository.php';
require_once __DIR__.'/../repository/AdminPanelRepository.php';

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

    public function adminPanel(){

        if(!$this->isAdmin()){
            return $this->logOut();
        }

        return $this->render('admin-panel');
    }

    public function modifyEventRole(){
        if(!$this->isAdmin()){
            return $this->logOut();
        }
        $all_roles = $this->eventRepository->getAllRoles();
        return $this->render('modify-event-role',['roles'=>$all_roles]);
    }
    public function addEventRole(){
        if(!$this->isAdmin()){
            return $this->logOut();
        }

        if(isset($_POST['role_name'])){
            $role_name = $_POST['role_name'];
            $this->adminPanelRepository->addRole($role_name);
            $all_roles = $this->eventRepository->getAllRoles();
            return $this->render('modify-event-role',['roles'=>$all_roles]);
        }
    }

    public function dropEventRole(){
        if(!$this->isAdmin()){
            return $this->logOut();
        }

        if(!empty($_POST['role_name'])){
            $role_name = $_POST['role_name'];
            $this->adminPanelRepository->dropRole($role_name);
            $all_roles = $this->eventRepository->getAllRoles();
            return $this->render('modify-event-role',['roles'=>$all_roles]);
        }
    }
}