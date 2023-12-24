<?php
session_start();
require_once '../dao/loginDAO.php';

$email = $_POST["email"];
$senha = md5($_POST["senha"]);

$loginDAO = new loginDAO();
$usuario = $loginDAO->login($email, $senha);

if (!empty($usuario)) {
    $_SESSION["email"] = $email["email"];
    $_SESSION["perfil"] = $usuario["perfil"];
    $_SESSION["id"] = $usuario["id"];
    $_SESSION["nome"] = $usuario["nome"];
   
    header("location:../view/principal.php");
}else{
    $msg="Email e/ou senha incorreta!";
    echo"
        <script src='../js/sweetalert2.all.min.js' type='text/javascript'></script>
    <body>
        <script type='text/javascript'>
            
            Swal.fire({
              position: 'center',
              icon: 'error',
              title: 'Email e/ou senha incorreta!',
              showConfirmButton: false,
              timer: 1000
            })
                var variavel = setInterval(function() {
                    window.location.href = '../index.php?msg={$msg}#entre';
                }, 1000);
            </script>
    </body>";
    
}

