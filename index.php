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
                <?php if($users['img']) {
                        echo "<img src='" . $users['img'] . "' class='card-img-top w-50 m-auto' alt='...'>";

                        } else {
                        echo '<img src="assets/img/crudo.png" class="card-img-top w-50 m-auto" alt="...">';
                    }; ?>
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
                            echo "<button class='btn btn-primary w-25'>Delete User</button>
                                <button type='button' class='btn btn-primary w-25' data-bs-toggle='modal' data-bs-target='#exampleModal'>Update Info</button>";
                        } ?>
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <form method="POST" action="controller.php?mode=newUser">
            <div class="image-container" style="text-align: center;">
                <img class="mb-4" src="assets/img/crudo.png" alt="" width="100" />
            </div>

            <h1 class="h3 mb-3 fw-normal">Update</h1>

            <div class="form-floating">
                <input type="text" class="form-control" id="floatingInputNome" placeholder="Nome" name="nome" value="" />
                <label for="floatingInputNome">Nome</label>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control" id="floatingInputCognome" placeholder="Cognome"
                    name="cognome" value="" />
                <label for="floatingInputCognome">Cognome</label>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control" id="floatingInputCittà" placeholder="Città" name="city" value="" />
                <label for="floatingInputCittà">Città</label>
            </div>
            <div class="form-floating">
                <input type="email" class="form-control" id="floatingInputEmail" placeholder="example@example.com"
                    name="email" value="" />
                <label for="floatingInputEmail">E-mail</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Almeno 8 caratteri"
                    name="password" value="" />
                <label for="floatingPassword">Password</label>
            </div>
            <p class="mt-5 mb-3 text-body-secondary">&copy; 2017–2024</p>
        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    } ?>

<?php include_once "assets/php/footer.php"; ?>