<?php
require_once '../dao/ocorrenciaDAO.php';
require_once '../dto/ocorrenciaDTO.php';

$tipo=$_POST["tipo"];
$localizacao=$_POST["localizacao"];
$referencia=$_POST["referencia"];
$dt_registro=$_POST["dt_registro"];
$hr_registro=$_POST["hr_registro"];
$titulo_registro=$_POST["titulo_registro"];
$marca=$_POST["marca"];
$modelo=$_POST["modelo"];
$codOcorrencia=$_POST["cod"];

$ocorrenciaDTO = new ocorrenciaDTO();
$ocorrenciaDTO->setTipo($tipo);
$ocorrenciaDTO->setLocalizacao($localizacao);
$ocorrenciaDTO->setReferencia($referencia);
$ocorrenciaDTO->setDt_registro($dt_registro);
$ocorrenciaDTO->setHr_registro($hr_registro);
$ocorrenciaDTO->setTitulo_registro($titulo_registro);
$ocorrenciaDTO->setMarca($marca);
$ocorrenciaDTO->setModelo($modelo);
$ocorrenciaDTO->setCod($codOcorrencia);

$ocorrenciaDAO = new ocorrenciaDAO();
$retorno=$ocorrenciaDAO->alterarOcorrencia($ocorrenciaDTO);

if($retorno){
    $msg1="ocorrencia alterada!";
    echo"
        <script src='../js/sweetalert2.all.min.js' type='text/javascript'></script>
    <body>
        <script type='text/javascript'>
            
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Ocorrência Alterada!',
              text: 'A sua ocorrência foi alterada com sucesso ;)',
              showConfirmButton: false,
              timer: 1500
            })
                var variavel = setInterval(function() {
                    window.location.href = '../view/listarOcorrencia.php?msg={$msg1}';
                }, 1500);
            </script>
    </body>";
}else{
    $msg2="ocorrencia não foi alterada!";
    echo"
        <body>
        <script type='text/javascript'>
            
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Ocorrência não alterado!',
                text: 'Ocorrência não foi alterada :(',
                showConfirmButton: false,
                timer: 1500
            })
                var variavel = setInterval(function() {
                    window.location.href = '../view/listarOcorrencia.php?msg={$msg2}';
                }, 1500);
            </script>
    </body>";
}
