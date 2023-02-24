<?php

require_once 'AppController.php';
require_once __DIR__ .'/../models/Event.php';
require_once __DIR__ .'/../models/Item.php';
require_once __DIR__ . '/../models/UserInEvent.php';
require_once __DIR__.'/../repository/EventRepository.php';
require_once __DIR__.'/../repository/UserRepository.php';
require_once __DIR__.'/../repository/DepotRepository.php';

class DepotController extends AppController
{

    const MAX_FILE_SIZE = 2024 * 2024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/img/uploads/';

    private $messages = [];
    private $eventRepository;
    private $depotRepository;

    public function __construct()
    {
        parent:: __construct();
        $this->eventRepository = new EventRepository();
        $this->userRepository = new UserRepository();
        $this->depotRepository = new DepotRepository();
    }

    public function depot()
    {
        if (!$this->isLoggedIn()) {
            return $this->render('login', ['messages' => ['Nie masz uprawnień do przeglądania tej strony!'],
                'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }
        $items = $this->depotRepository->getItems();
        $this->render('depot',['items'=>$items]);
    }



    public function addDepotItem()
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
            if (!empty($_POST['name']) && !empty($_POST['description']) && !empty($_POST['image']) ||
                !empty($_POST['barcode']) && !empty($_POST['item_quantity'])) {

                if (is_uploaded_file($_FILES['image']['tmp_name']) && $this->validate($_FILES['image'])) {
                    move_uploaded_file(
                        $_FILES['image']['tmp_name'],
                        dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_FILES['image']['name']
                    );
                }
                $this->depotRepository->addItem($_POST['name'],$_POST['description'],$_FILES['image']['name'],$_POST['barcode'],$_POST['item_quantity']);
                return $this->redirect('/depot');
            } else {
                return $this->render('depot-add-item', ['messages' => ["Uzupełnij poprawnie wszystkie pola"],
                    'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show();"]);
            }
        }
        return $this->render('depot-add-item');
    }



    public function editDepotItem()
    {
        if (!$this->isLoggedIn()) {
            return $this->render('login', ['messages' => ['Nie masz uprawnień do przeglądania tej strony!'],
                'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }

        if($this->isGet()) {
            $item = $this->depotRepository->getItem($_GET['item_id'],$_GET['barcode']);
        }


        if($this->isPost()){
            if(isset($_POST['Update'])) {
                if (!empty($_POST['name']) && !empty($_POST['description']) ||
                    !empty($_POST['barcode']) && !empty($_POST['item_quantity']) && !empty($_POST['item_id'])) {
                    if (empty($_FILES['image']['name'])) {
                        $this->depotRepository->updateItem($_POST['name'], $_POST['description'], $_POST['old_image'], $_POST['barcode'],
                            $_POST['quantity'], $_POST['item_id']);

                        $items = $this->depotRepository->getItems();
                        return $this->render('depot', ['items' => $items]);

                    } else {
                        if (is_uploaded_file($_FILES['image']['tmp_name']) && $this->validate($_FILES['image'])) {
                            move_uploaded_file(
                                $_FILES['image']['tmp_name'],
                                dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_FILES['image']['name']
                            );
                        }
                        unlink("public/img/uploads/".$_POST['old_image']."");
                        $this->depotRepository->updateItem($_POST['name'], $_POST['description'], $_FILES['image']['name'], $_POST['barcode'],
                            $_POST['quantity'], $_POST['item_id']);

                        $items = $this->depotRepository->getItems();
                        return $this->render('depot', ['items' => $items]);
                    }
                }
            }elseif(isset($_POST['Drop'])) {
                $this->depotRepository->dropItem($_POST['item_id']);
                unlink("public/img/uploads/".$_POST['old_image']."");
                $items = $this->depotRepository->getItems();
                return $this->render('depot', ['items' => $items]);

            }
        }

        $this->render('depot-edit-item',['item'=>$item]);
    }




    private function validate($file):bool
    {
        if($file['size'] > self::MAX_FILE_SIZE){
            $this->messages[] = 'Plik jest za duży, zmiejsz jego rozmiar';
            return false;
        }

        if(!isset($file['type']) && !in_array($file['type'],self::SUPPORTED_TYPES)){
            $this->messages[] = 'Typ pliku nie jest wspierany.';
            return false;
        }

        return true;
    }


    public function eventEditEquipment(){
        if($this->isGet()){
            if(!empty($_GET['event_id'])||!empty($_GET['rental_id'])){
                $this->depotRepository->dropRentedItem($_GET['rental_id']);
            }
        }


        $event_id = $_GET['event_id'];
        $rented_items = $this->depotRepository->getRentedItemsForEvent($event_id);
        $items = $this->depotRepository->getItems();
        return $this->render('event-edit-equipment',['items'=>$items,'rented_items'=>$rented_items]);

    }

    public function addEquipmentToRent(){
        $event_id = $_POST['event_id'];
        $user_id = $_SESSION['user_id'];
        $items = $this->depotRepository->getItems();
        $rented_items = $this->depotRepository->getRentedItemsForEvent($event_id);

        if($this->isPost()){
            if(!empty($_POST['id_name_barcode_item'])&&!empty($_POST['quantity_to_rent'])&&!empty($_POST['comments'])){
                $item_det= explode(" ",$_POST['id_name_barcode_item']);
                $item_id = $item_det[0];
                $name = $item_det[1];
                $barcode = $item_det[2];
                $quantity_to_rent = $_POST['quantity_to_rent'];
                $comments = $_POST['comments'];
                $current_quantity_ability_for_rent = $this->depotRepository->abilityItemBetweenDateWhenEventIs($event_id,$item_id);

                if($quantity_to_rent>$current_quantity_ability_for_rent){
                    return $this->render('event-edit-equipment', ['messages' => ["Brak wystarczającej ilości tego sprzętu w terminie wydarzenia.
                    Maksymalna dostępność sprzętu w tym terminie to <strong>".$current_quantity_ability_for_rent."</strong>."],'items'=>$items,'rented_items'=>$rented_items,
                        'display'=>"var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
                }
                $this->depotRepository->AddItemToRent($event_id,$user_id,$item_id,$quantity_to_rent,$comments);
                return $this->redirect('/eventEditEquipment?event_id='.$event_id.' ');
            }else{
                return $this->render('event-edit-equipment', ['messages' => ["Wypełnij lub wybierz wszystkie dane"],'items'=>$items,'rented_items'=>$rented_items,
                    'display'=>"var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
            }

        }

        return $this->redirect('/eventEditEquipment?event_id='.$_GET['event_id']);

    }


    public function searchDepot(){
        $contentType = isset($_SERVER["CONTENT_TYPE"])? trim($_SERVER["CONTENT_TYPE"]) : '';

        if($contentType == "application/json"){
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content,true);

            header('Content-type:application/json');
            http_response_code(200);

            echo json_encode($this->depotRepository->getItemByName($decoded['search']));
        }


    }



}