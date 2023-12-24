<!DOCTYPE html>
<?php
//session_start();
include_once '../class/face.php"';
?>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Login</title>
		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/signin.css" rel="stylesheet">
	</head>
	<body>
		<div class="">
			<div class="">
				<h2 class="">Entre</h2>
				<?php
					if(isset($_SESSION['msg'])){
						echo $_SESSION['msg'];
						unset($_SESSION['msg']);
					}
					if(isset($_SESSION['msgcad'])){
						echo $_SESSION['msgcad'];
						unset($_SESSION['msgcad']);
					}
				?>
                                <form method="post" action="principal.php">
					<!--<label>Usuário</label>-->
                                        <input type="text" name="usuario" placeholder="Digite o seu usuário" class="form-control" required=""><br>
					
					<!--<label>Senha</label>-->
                                        <input type="password" name="senha" placeholder="Digite a sua senha" class="form-control" required=""><br>
					
					<br><input type="submit" name="login" value="Logar" class="">
					
					<div class="" style="margin-top: 20px;"> 
						<h4>Você ainda não possui uma conta?</h4>
                                                <a href="formCadastroUsuario.php">Cadastra-se</a>
					</div>
					<div class="" style="margin-top: 20px;">
                                            Entre com o Facebook
						<a href="<?php echo $loginUrl; ?>">
							<button type="button" class="">Facebook</button>
						</a>
					</div>
					
					
					
				</form>
			</div>
		</div>			
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>
