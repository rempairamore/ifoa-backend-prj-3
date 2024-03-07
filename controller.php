<?php
// Start or continue the session (if needed).
session_start();
// Include the necessary files
require_once("assets/php/classes/UsersDto.php");
require_once("assets/php/db.php");
require_once("assets/php/classes/Users.php");
$config = require_once("assets/php/config.php");
use db\DB_PDO as Database;
use dto\UserDTO as Dto;
use Users\NormalUser as UtenteNormale;



if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_REQUEST['mode'] === 'newUser'){

    

    $pdoConn = Database::getInstance($config);
    $conn = $pdoConn->getConnection();

    $userManager = new Dto($conn);

    $isAdmin = 0;

    if(isset($_POST['isAdmin'])) {
        $isAdmin = 1;
    } 

    $userData = [
        'Nome' => $_POST['nome'],
        'Cognome' => $_POST['cognome'],
        'City' => $_POST['city'],
        'email' => $_POST['email'],
        'img' => $_POST['img'],
        'isAdmin' => $isAdmin,
        'Password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
    ];

    // $userData = new UtenteNormale(      $_POST['nome'],
    //                                     $_POST['cognome'],
    //                                     $_POST['city'],
    //                                     $_POST['email'],
    //                                     $_POST['img'],
    //                                     password_hash($_POST['password'], PASSWORD_DEFAULT),
                                        
    //                             );

    
  



    $result = $userManager->saveUser($userData);



    if ($result > 0) {
        echo "User saved successfully!";
        exit(header("Location:login.php"));
    } else {
        echo "An error occurred while saving the user.";
        exit(header("Location:register.php?error=true"));
    }
};



if ($_REQUEST["mode"] === 'login') {
    $pdoConn = Database::getInstance($config);
    $conn = $pdoConn->getConnection();

    $userManager = new Dto($conn);

    echo "prima di utente";
   



    $utente = $userManager->getUserByEmail($_POST['email']);


   

    if ($utente) {
        // Verifica la password
        if (password_verify($_REQUEST['password'], $utente['Password'])) {
            // Inizializzazione della sessione e impostazione delle variabili di sessione
            $_SESSION['login'] = 'true';
            $_SESSION["user_id"] = $utente['ID'];
            $_SESSION["nome"] = $utente['Nome'];
            $_SESSION["cognome"] = $utente['Cognome'];
            $_SESSION["email"] = $utente['email'];
            $_SESSION["img"] = $utente['img'];

            if($utente['isAdmin'] === 1) {
                $_SESSION["isAdmin"] = true; 
            };

            // Dopo aver impostato le variabili di sessione, reindirizza all'indice
            exit(header('Location: index.php'));
        } else {
            // Password non valida, reindirizza al login con errore
            exit(header('Location: login.php?errore=pwd'));
        }
    } else {
        // Utente non trovato, reindirizza al login con errore
        exit(header('Location: login.php?error=user'));
    }
}

/* Logout*/

if ($_REQUEST["mode"] === 'logout') {
    session_destroy();
    session_write_close();
    exit(header('Location: register.php'));
}