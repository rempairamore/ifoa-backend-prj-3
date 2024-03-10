<?php
session_start();
if ($_SESSION['login'] !== 'true') {
    // Reindirizza l'utente alla pagina di login
    header('Location: register.php');
    exit; // Assicurati di chiamare exit dopo il reindirizzamento per fermare l'esecuzione dello script
}
session_write_close();
?>

<?php include_once "assets/php/header.php";
require_once "assets/php/classes/UsersDto.php";
require_once "assets/php/db.php";
$config = require_once "assets/php/config.php";
use db\DB_PDO as Database;
use dto\UserDTO as Dto;

$pdoConn = Database::getInstance($config);
$conn = $pdoConn->getConnection();
$usersCard = new Dto($conn);
$res = $usersCard->getAll();
?>


<div class="mt-5 row row-cols-1 row-cols-md-3 g-4 px-5">

    <?php if ($res) {
        foreach ($res as $users) {
            ?>
            <div class="col">
                <div class="card">
                    <?php if ($users['img']) {
                        echo "<img src='" . $users['img'] . "' class='card-img-top m-auto' alt='...'>";

                    } else {
                        echo '<img src="assets/img/crudo.png" class="card-img-top m-auto" alt="...">';
                    }
                    ; ?>
                    <div class="card-body">
                        <h5 class="card-title">
                            <?= $users['Nome'] . " " . $users['Cognome'] ?>
                        </h5>
                        <p class="card-text">Email:
                            <?= $users['email'] ?>
                        </p>
                        <p class="card-text">Città:
                            <?= $users['City'] ?>
                        </p>
                        <p class="card-text" hidden>
                            <?= $users['ID'] ?>
                        </p>
                        <?php if ($_SESSION['user_id'] === $users['ID'] || $_SESSION['isAdmin'] === true) {
                            echo "<form action='update.php' method='get' class='d-inline'>
                            <input type='hidden' name='idUtente' value='".$users['ID']."'>
                            <button type='submit' class='btn btn-primary w-25'>Update Info</button>
                        </form>
                        <form action='controller.php?mode=deleteUser&id=".$users['ID']."' method='post' class='d-inline'>
                            <input type='hidden' name='idUtente' value='".$users['ID']."'>
                            <button type='submit' class='btn btn-primary w-25'>Delete User</button>
                        </form>";
                        } ?>
                    </div>
                </div>
            </div>
            <?php
        }
    } ?>

    <?php include_once "assets/php/footer.php"; ?>