<?php
session_start();
require_once '../dao/usuarioDAO.php';

$id=$_SESSION["id"];
if (!empty($id)) {
   
    header("location:../view/perfilUsuario.php?id=$id");
}