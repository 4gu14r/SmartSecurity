<?php 
session_start();

require_once '../dao/usuarioDAO.php';
require_once '../dao/comentarioDAO.php';

$id=$_SESSION["id"];
$usuarioDAO = new usuarioDAO();
$usuario = $usuarioDAO->getUsuarioById($id);
$cod=$_GET["cod"];
$comentarioDAO=new comentarioDAO();
$comentario = $comentarioDAO->getComentarioByCod($cod);

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../css/cssFormComentario.css" rel="stylesheet" type="text/css"/>
</head>

<body>

<h2>Formulário Comentativo</h2>

<div class="container">
    <form method="post" action="../controller/alterarComentarioController.php">
        <input type="hidden" name="cod" value="<?php echo $comentario["cod"]; ?>">
    <div class="row">
      <div class="col-25">
        <label for="nome">Nome</label>
      </div>
      <div class="col-75">
          <input disabled="" type="text" id="nome" name="nome" placeholder="Seu nome ..." value="<?php echo $usuario["nome"]?>" style="background-color: white">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="sobre">Sobrenome</label>
      </div>
      <div class="col-75">
          <input disabled="" type="text" id="sobre" name="sobre" placeholder="Seu Sobrenome ..." value="<?php echo $usuario["sobrenome"] ?>" style="background-color: white">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="comentario">Comentário</label>
      </div>
      <div class="col-75">
          <input type="text" id="comentario" name="comentario" placeholder="Escreva" style="height:200px" value="<?php echo $comentario["comentario"] ?>">
      </div>
        <br><br>
    </div>
    <div class="row">
      <input type="submit" value="Comentar" onclick="confirm('Deseja realmente editar esse comentário?')">
    </div>
  </form>
</div>

</body>
</html>

