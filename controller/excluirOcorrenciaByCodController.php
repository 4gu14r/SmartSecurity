<?php

require_once '../dao/ocorrenciaDAO.php';

$ocorrenciaDAO = new ocorrenciaDAO();
$cod=$_GET["cod"];

$retorno=$ocorrenciaDAO->excluirOcorrencia($cod);

if ($retorno) {
        $msg1 = "Ocorrência Deletada!";
        echo"
        <script src='../js/sweetalert2.all.min.js' type='text/javascript'></script>
    <body>
        <script type='text/javascript'>
            
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Ocorrência Deletada!',
                text: 'A ocorrência foi excluída com Sucesso',
                showConfirmButton: false,
                timer: 1580
            })
            
            var variavel = setInterval(function sweetAlert() {
                window.location.href = '../view/listarOcorrencia.php?msg={$msg1}';
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
                title: 'Ocorrência não foi Deletada!',
                text: 'Exclusão não foi Realizada',
                showConfirmButton: false,
                timer: 1580
            })
            
            var variavel = setInterval(function sweetAlert() {
                window.location.href = '../view/listarOcorrencia.php?msg={$msg2}';
            },1580);
            
            </script>     
    </body>";
    }
