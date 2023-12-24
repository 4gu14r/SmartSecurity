<?php 
session_start();

require_once '../dao/usuarioDAO.php';

$id=$_SESSION["id"];
$usuarioDAO = new usuarioDAO();
$usuario = $usuarioDAO->getUsuarioById($id);

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
    <form method="post" action="../controller/postarComentarioUsuarioController.php">
    <div class="row">
      <div class="col-25">
        <label for="nome">Nome</label>
      </div>
      <div class="col-75">
          <input type="text" id="nome" name="nome" placeholder="Seu nome ..." value="<?php echo $usuario["nome"]?>">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="sobre">Sobrenome</label>
      </div>
      <div class="col-75">
        <input type="text" id="sobre" name="sobre" placeholder="Seu Sobrenome ..." value="<?php echo $usuario["sobrenome"] ?>">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="comentario">Comentário</label>
      </div>
      <div class="col-75">
        <textarea id="comentario" name="comentario" placeholder="Escreva" style="height:200px"></textarea>
      </div>
        <br><br>
    </div>
    <div class="row">
      <input type="submit" value="Postar" onclick="confirm('Você deseja postar esse comentário?')">
    </div>
  </form>
</div>

</body>
</html>

