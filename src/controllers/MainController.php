<?php

require_once 'AppController.php';

class MainController extends AppController {

    public function main() {
        if(!$this->isLoggedIn())
        {
            return $this->render('login',['messages' => ['ZALOGUJ SIĘ!']]);
        }

        $this->render('main');
    }


}