<!DOCTYPE html>
<html>
<?php
require_once '../dao/celularDAO.php';
require_once '../dto/celularDTO.php';
session_start();
$marca= !empty($_POST["marca"])?$_POST["marca"]  :$_POST["marcasoutras"];
$modelo=$_POST["modelo"];
$cor=!empty($_POST["cor"])?$_POST["cor"]:$_POST["outra"];
$imei=$_POST["imei"];
$usuario_id=$_SESSION["id"];

$celularDTO=new celularDTO();
$celularDTO->setMarca($marca);
$celularDTO->setModelo($modelo);
$celularDTO->setCor($cor);
$celularDTO->setUsuario_id($usuario_id);

$celularDAO=new celularDAO();
$retorno=$celularDAO->cadastrarCelular($celularDTO);

if($retorno){
    $msg="celular cadastrado";
    echo"
        <script src='../js/sweetalert2.all.min.js' type='text/javascript'></script>
    <body>
        <script type='text/javascript'>
            
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Celular cadastrado!',
              showConfirmButton: false,
              timer: 2000
            })
                var variavel = setInterval(function() {
                    window.location.href = '../view/meusCelulares.php?msg={$msg}';
                }, 2000);
            </script>
    </body>";
}
?>
</html>