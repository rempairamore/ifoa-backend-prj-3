<?php 


namespace Users {

    abstract class StrutturaUtente {

        private $ID;
        private $nome;
        private $cognome;
        private $email;
        private $password;
        private $city;

        private $img;

        function __construct($ID, $nome, $cognome, $email, $password, $city, $img) {
            $this->ID = $ID;
            $this->nome = $nome;
            $this->cognome = $cognome;
            $this->email = $email;
            $this->password = $password;
            $this->city = $city;
            $this->img = $img;
        }

    }

    class NormalUser extends StrutturaUtente {
        private $isAdmin = false;

        function __construct($ID, $nome, $cognome, $email, $password, $city, $img, $isAdmin) {
            parent::__construct($ID, $nome, $cognome, $email, $password, $city, $img);
            $this->isAdmin = $isAdmin;
        }
    }

    class AdminUser extends StrutturaUtente {
        private $isAdmin = true;

        function __construct($ID, $nome, $cognome, $email, $password, $city, $img, $isAdmin) {
            parent::__construct($ID, $nome, $cognome, $email, $password, $city, $img);
            $this->isAdmin = $isAdmin;
        }
    }
}