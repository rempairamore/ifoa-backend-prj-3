<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRUDo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

  <div id="myNavbar">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a href="index.php">
          <img class="navbar-brand" src="assets/img/crudo.png">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarSupportedContent">
          <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">Home</a>
            </li>


            <?php
            if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
              echo '<li class="nav-item"><a class="nav-link" href="controller.php?mode=logout">Logout</a></li>';
            }
            ?>
            
          </ul>
          <?php
            if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === true) {
              echo '
                <span class="nav-link text-danger float-end" >Welcome, you are an Admin!</span>';
            }?>
        </div>
      </div>
    </nav>
  </div>