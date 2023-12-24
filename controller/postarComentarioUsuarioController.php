<?php

require_once '../dao/comentarioDAO.php';
require_once '../dto/comentarioDTO.php';

session_start();

$comentario=$_POST["comentario"];
$usuario_id=$_SESSION["id"];

$comentarioDTO=new comentarioDTO();
$comentarioDTO->setComentario($comentario);
$comentarioDTO->setUsuario_id($usuario_id);

$comentarioDAO=new comentarioDAO();
$returno=$comentarioDAO->postarComentario($comentarioDTO);

if($returno){
    $msg="comentario postado!";
    echo"
        <script src='../js/sweetalert2.all.min.js' type='text/javascript'></script>
    <body>
        <script type='text/javascript'>
            
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Comentario Postado!',
              showConfirmButton: false,
              timer: 1500
            })
                var variavel = setInterval(function() {
                    window.location.href = '../view/comentariosUsuario.php?msg={$msg}';
                }, 1500);
            </script>
    </body>";
}