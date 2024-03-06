<?php
// Start or continue the session (if needed).
session_start();
// Include the necessary files
require_once("assets/php/classes/UsersDto.php");
require_once("assets/php/db.php");
$config = require_once("assets/php/config.php");
use db\DB_PDO as Database;
use dto\UserDTO as Dto;


// $pdoConn = Database::getInstance($config);
// $conn = $pdoConn->getConnection();

// $userManager = new Dto($conn);


// var_dump($_POST);
// exit();



// Check if the form was submitted via POST and the operation is 'newuser'.
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_REQUEST['mode'] === 'newUser'){
    // Initialize the PDO connection using the Database class
    $pdoConn = Database::getInstance($config);
    $conn = $pdoConn->getConnection();

    // Instantiate the UserDTO object with the PDO connection
    $userManager = new Dto($conn);

    // Prepare the user data array from the POST data.
    $userData = [
        'Nome' => $_POST['nome'],
        'Cognome' => $_POST['cognome'],
        'City' => $_POST['city'],
        'email' => $_POST['email'],
        'Password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
    ];



    // Call the saveUser function with the user data.
    $result = $userManager->saveUser($userData);



    // Check if the user was saved successfully.
    if ($result > 0) {
        // User was saved, redirect or display a success message.
        echo "User saved successfully!";
        exit(header("Location:index.php"));
    } else {
        // User was not saved, handle the error.
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

