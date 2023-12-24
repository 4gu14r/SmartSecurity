<?php
require_once '../dao/ocorrenciaDAO.php';
require_once '../dto/ocorrenciaDTO.php';
session_start();
$tipo=$_POST["tipo"];
$localizacao=$_POST["localizacao"];
$referencia=$_POST["referencia"];
$dt_registro=$_POST["dt_registro"];
$hr_registro=$_POST["hr_registro"];
$titulo_registro=$_POST["titulo_registro"];
$marca= !empty($_POST["marca"])?$_POST["marca"]  :$_POST["marcasoutras"];
$modelo=$_POST["modelo"];
$cor=!empty($_POST["cor"])?$_POST["cor"]:$_POST["outra"];
$imei=$_POST["imei"];
$descricao=$_POST["descricao"];
$usuario_id=$_SESSION["id"];
         

$ocorrenciaDTO=new ocorrenciaDTO();
$ocorrenciaDTO->setTipo($tipo);
$ocorrenciaDTO->setLocalizacao($localizacao);
$ocorrenciaDTO->setReferencia($referencia);
$ocorrenciaDTO->setDt_registro($dt_registro);
$ocorrenciaDTO->setHr_registro($hr_registro);
$ocorrenciaDTO->setTitulo_registro($titulo_registro);
$ocorrenciaDTO->setMarca($marca);
$ocorrenciaDTO->setModelo($modelo);
$ocorrenciaDTO->setCor($cor);
$ocorrenciaDTO->setImei($imei);
$ocorrenciaDTO->setDescricao($descricao);
$ocorrenciaDTO->setUsuario_id($usuario_id);

$ocorrenciaDAO=new ocorrenciaDAO();
$retorno=$ocorrenciaDAO->registrarOcorrencia($ocorrenciaDTO);

if($retorno){
    $msg1="ocorrencia registrada!";
    echo"
        <script src='../js/sweetalert2.all.min.js' type='text/javascript'></script>
    <body>
        <script type='text/javascript'>
            
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Ocorrência Registrada!',
              text: 'A sua ocorrência foi realizada com sucesso ;)',
              showConfirmButton: false,
              timer: 1500
            })
                var variavel = setInterval(function() {
                    window.location.href = '../view/principal.php?msg={$msg1}';
                }, 1500);
            </script>
    </body>";
}else{
    
    $msg2="ocorrencia não realizada!";
    echo"
        <body>
        <script type='text/javascript'>
            
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Ocorrência não realizada!',
                text: 'Ocorrência não foi registrada :(',
                showConfirmButton: false,
                timer: 1500
            })
                var variavel = setInterval(function() {
                    window.location.href = '../view/principal.php?msg={$msg2}';
                }, 1500);
            </script>
    </body>";
}
