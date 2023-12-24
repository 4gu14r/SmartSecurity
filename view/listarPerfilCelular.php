<?php
session_start();
require_once '../dao/celularDAO.php';

$cod=$_SESSION["cod"];

if (!empty($cod)) {
    $_SESSION["cod"] = $cod["cod"];
    header("location:../view/perfilCelular.php?cod={$cod["cod"]}");
}

