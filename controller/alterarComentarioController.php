<?php
require_once '../dao/comentarioDAO.php';
require_once '../dto/comentarioDTO.php';

$comentario=$_POST["comentario"];
$cod=$_POST["cod"];

$comentarioDTO=new comentarioDTO();
$comentarioDTO->setComentario($comentario);
$comentarioDTO->setCod($cod);

$comentarioDAO=new comentarioDAO();
$retorno=$comentarioDAO->alterarComentario($comentarioDTO);

if($retorno){
    $msg1="comentario postado!";
    
    echo"
        <script src='../js/sweetalert2.all.min.js' type='text/javascript'></script>
    <body>
        <script type='text/javascript'>
            
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Comentário Alterado!',
              showConfirmButton: false,
              timer: 1500
            })
                var variavel = setInterval(function() {
                    window.location.href = '../view/listarComentario.php?msg={$msg1}';
                }, 1500);
            </script>
    </body>";
}else{
    $msg2="erro no comentario";
    echo"
        <script src='../js/sweetalert2.all.min.js' type='text/javascript'></script>
    <body>
        <script type='text/javascript'>
            
            Swal.fire({
              position: 'center',
              icon: 'error',
              title: 'Comentario não Postado!',
              showConfirmButton: false,
              timer: 1500
            })
                var variavel = setInterval(function() {
                    window.location.href = '../view/listarComentario.php?msg={$msg2}';
                }, 1500);
            </script>
    </body>";
}