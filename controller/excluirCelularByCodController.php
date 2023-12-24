<?php

require_once '../dao/celularDAO.php';

$celularDAO= new celularDAO();
$cod=$_GET["cod"];

$retorno=$celularDAO->excluirCelular($cod);

if ($retorno) {
        $msg1 = "Aparelho Removido!";
        echo"
        <script src='../js/sweetalert2.all.min.js' type='text/javascript'></script>
    <body>
        <script type='text/javascript'>
            
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Celular Deletado!',
                text: 'Aparelho removido com Sucesso',
                showConfirmButton: false,
                timer: 1580
            })
            
            var variavel = setInterval(function sweetAlert() {
                window.location.href = '../view/listarCelular.php?msg={$msg1}';
            },1580);
            
            </script>     
    </body>";
    } else {
        $msg2 = "Remoção não realizada!";
        echo"
    <body>
        <script type='text/javascript'>
            
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Celular não foi Deletado!',
                text: 'Exclusão não foi Realizada',
                showConfirmButton: false,
                timer: 1580
            })
            
            var variavel = setInterval(function sweetAlert() {
                window.location.href = '../view/listarCelular.php?msg={$msg2}';
            },1580);
            
            </script>     
    </body>";
    }