<?php

require_once '../dao/comentarioDAO.php';

$comentarioDAO = new comentarioDAO();
$cod=$_GET["cod"];

$retorno=$comentarioDAO->excluirComentario($cod);

if ($retorno) {
        $msg1 = "Comentário Deletado!";
        echo"
        <script src='../js/sweetalert2.all.min.js' type='text/javascript'></script>
    <body>
        <script type='text/javascript'>
            
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Comentário Deletado!',
                text: 'Comentário Apagado com Sucesso',
                showConfirmButton: false,
                timer: 1580
            })
            
            var variavel = setInterval(function sweetAlert() {
                window.location.href = '../view/listarComentario.php?msg={$msg1}';
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
                title: 'Comentário não foi Apagado!',
                text: 'Exclusão não foi Realizada',
                showConfirmButton: false,
                timer: 1580
            })
            
            var variavel = setInterval(function sweetAlert() {
                window.location.href = '../view/listarComentario.php?msg={$msg2}';
            },1580);
            
            </script>     
    </body>";
    }

