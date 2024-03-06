<?php
session_start();
if ($_SESSION['login'] !== 'true') {
    // Reindirizza l'utente alla pagina di login
    header('Location: login.php');
    exit; // Assicurati di chiamare exit dopo il reindirizzamento per fermare l'esecuzione dello script
}
session_write_close();
?>

<?php include_once "assets/php/header.php"; ?>













<?php include_once "assets/php/footer.php"; ?>