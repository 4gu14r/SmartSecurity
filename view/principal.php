<?php
    session_start();
    include 'validaLogin.php';
    
    if(!empty($_POST['email']) && !empty($_POST['senha'])){
             header('location:../index.php#entre');
             exit();
    } 
    
    switch ($_SESSION["perfil"]) {
        case "Administrador":
            include './menuAdministrador.php';break;
        case "Usuário":
            include './menuUsuario.php';break;
    }
    
    
    