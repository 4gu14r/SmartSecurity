<?php

require_once '../dao/celularDAO.php';
require_once '../dto/celularDTO.php';

$marca= !empty($_POST["marca"])?$_POST["marca"]  :$_POST["marcasoutras"];
$modelo=$_POST["modelo"];
$cod=$_POST["cod"];

$celularDTO=new celularDTO();
$celularDTO->setMarca($marca);
$celularDTO->setModelo($modelo);
$celularDTO->setCod($cod);

$celularDAO=new celularDAO();
$retorno=$celularDAO->alterarCelular($celularDTO);

if($retorno){
    $msg1="Celular Alterado!";
    echo"
        <script src='../js/sweetalert2.all.min.js' type='text/javascript'></script>
    <body>
        <script type='text/javascript'>
            
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Celular Alterado!',
              text: 'A alteração foi realizada com sucesso ;)',
              showConfirmButton: false,
              timer: 1500
            })
                var variavel = setInterval(function() {
                    window.location.href = '../view/listarCelular.php?msg={$msg1}';
                }, 1500);
            </script>
    </body>";
}else{
    $msg2="celular não foi alterada!";
    echo"
        <body>
        <script type='text/javascript'>
            
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Celular não foi alterado!',
                text: 'Celular processo não realizado :(',
                showConfirmButton: false,
                timer: 1500
            })
                var variavel = setInterval(function() {
                    window.location.href = '../view/listarCelular.php?msg={$msg2}';
                }, 1500);
            </script>
    </body>";
}
