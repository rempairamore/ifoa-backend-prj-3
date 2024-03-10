<?php 
include_once "assets/php/header.php";
require_once "assets/php/classes/UsersDto.php";
require_once "assets/php/db.php";
$config = require_once "assets/php/config.php";
use db\DB_PDO as Database;
use dto\UserDTO as Dto;

$pdoConn = Database::getInstance($config);
$conn = $pdoConn->getConnection();
$usersCard = new Dto($conn);
$res = $usersCard->getUsersID($_GET['idUtente']);
// var_dump($res);

// var_dump($_POST['idUtente']);

if($_SESSION['isAdmin'] == false && $_REQUEST['idUtente'] != $_SESSION['user_id']) {
    echo "<h1 class='m-5'>Sei un h4k3rino???? Prof nun ce provà</h1>";
    exit();
}
?>

<div class="container mt-5 p-3 w-50">
    <h2>Modifica Utente</h2>
    <form action="controller.php?mode=updateInfo" method="post">
        <?php 
        $_SESSION['actualUpdateId'] = $_REQUEST['idUtente'];
        ?>
        <div class="form-group py-3">
            <label for="nome">Nome:</label>
            <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $res[0]['Nome'] ?? ''; ?>" required>
        </div>
        <div class="form-group py-3">
            <label for="cognome">Cognome:</label>
            <input type="text" class="form-control" id="cognome" name="cognome" value="<?php echo $res[0]['Cognome'] ?? ''; ?>" required>
        </div>
        <div class="form-group py-3">
            <label for="citta">Città:</label>
            <input type="text" class="form-control" id="citta" name="city" value="<?php echo $res[0]['City'] ?? ''; ?>" required>
        </div>
        <div class="form-group py-3">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $res[0]['email'] ?? ''; ?>" required>
        </div>
        <div class="form-group py-3">
            <label for="email">Link Immagine</label>
            <input type="text" class="form-control" id="linkimmagine" name="img" value="<?php echo $res[0]['img'] ?? ''; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Aggiorna</button>
    </form>
</div>





<?php include_once "assets/php/footer.php"; ?>