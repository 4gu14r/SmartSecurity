<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style>
            body {
            font-family: "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", Helvetica, Arial, sans-serif; 
            }
            .btn {
            border: 2px solid black;
            background-color: white;
            color: black;
            padding: 14px 28px;
            font-size: 16px;
            cursor: pointer;
            margin: 5px;
            }
            .btn-success{
                border-color: #4CAF50;
                background-color: #4CAF50;
                color: White;
            }
            .btn-success:houver{
                border-color: #4CAF50;
                color: green;
            }
            .btn-danger{
                border-color: #f44336;
                background-color: #f44336;
                color: White;
            }
            .btn-danger:houver{
                border-color: #4CAF50;
                color: white;
            }
        </style>
        <script src="js/sweetalert2.all.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            
        var intervalo = window.setTimeout(function sweetAlert() {
            
        
        
        
        
        
            
            clearInterval(intervalo);
        },5000);
        
        </script>
<?php
require_once '../dao/usuarioDAO.php';
require_once '../dto/usuarioDTO.php';


$nome = $_POST["nome"];
$sobre = $_POST["sobre"];
$dt_nascimento = $_POST["dt_nascimento"];
$cpf = $_POST["cpf"];
$sexo = $_POST["sexo"];
$email= $_POST["email"];
$senha = md5($_POST["senha"]);
$endereco = $_POST["endereco"];
$perfil=$_POST["perfil"];

$usuarioDTO = new usuarioDTO();
$usuarioDTO ->setCpf($cpf);
$usuarioDTO ->setNome($nome);
$usuarioDTO ->setSobre($sobre);
$usuarioDTO ->setDt_nascimento($dt_nascimento);
$usuarioDTO->setSexo($sexo);
$usuarioDTO->setEmail($email);
$usuarioDTO->setSenha($senha);
$usuarioDTO->setEndereco($endereco);
$usuarioDTO->setPerfil_cod($perfil);

$usuarioDAO = new usuarioDAO();
$retorno=$usuarioDAO->cadastrarUsuario($usuarioDTO);

if($retorno){
    $msg1="Usuário Cadastrado!";
    $msg2="Cadastro não realizado!";
    echo"
        <script src='../js/sweetalert2.all.min.js' type='text/javascript'></script>
    <body>
        <script type='text/javascript'>
            
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Usuário Cadastrado',
                text: 'Cadastro Realizado com Sucesso',
                showConfirmButton: false,
                timer: 1580
            })
            
            var variavel = setInterval(function sweetAlert() {
                window.location.href = '../index.php?msg={$msg1}#entre';
            },1580);
            
            </script>     
    </body>";
}else{
    header('location:../index.php?msg='.$msg2.'');
}
?>
</html>
