<html>
    <head>
        <meta charset="UTF-8">
        <title>Cadastro do Usuário</title>
        <script src="js/sweetalert2.all.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            var intervalo = window.setTimeout(function sweetAlert() {
                clearInterval(intervalo);
            }, 5000);
        </script>
    </head>
    <?php
    require_once '../dao/usuarioDAO.php';
    require_once '../dto/usuarioDTO.php';

    $nome = $_POST["nome"];
    $sobre = $_POST["sobre"];
    $dt_nascimento = $_POST["dt_nascimento"];
    $sexo = $_POST["sexo"];
    $email = $_POST["email"];
    $senha = md5($_POST["senha"]);
    $endereco = $_POST["endereco"];
    $perfil_cod = $_POST["perfil"];
    $id = $_POST["id"];

    $usuarioDTO = new usuarioDTO();

    $usuarioDTO->setNome($nome);
    $usuarioDTO->setSobre($sobre);
    $usuarioDTO->setDt_nascimento($dt_nascimento);
    $usuarioDTO->setSexo($sexo);
    $usuarioDTO->setEmail($email);
    $usuarioDTO->setSenha($senha);
    $usuarioDTO->setEndereco($endereco);
    $usuarioDTO->setPerfil_cod($perfil_cod);
    $usuarioDTO->setId($id);

    $usuarioDAO = new usuarioDAO();
    $retorno = $usuarioDAO->alterarUsuario($usuarioDTO);

    if ($retorno) {
        $msg1 = "Usuário Alterado!";
        echo"
        <script src='../js/sweetalert2.all.min.js' type='text/javascript'></script>
    <body>
        <script type='text/javascript'>
            
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Usuário Alterado',
                text: 'Alteração Realizada com Sucesso',
                showConfirmButton: false,
                timer: 1580
            })
            
            var variavel = setInterval(function sweetAlert() {
                window.location.href = '../view/listarUsuario.php?msg={$msg1}';
            },1580);
            
            </script>     
    </body>";
    } else {
        $msg2 = "Alteração não realizada!";
        echo"
    <body>
        <script type='text/javascript'>
            
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Usuário não Alterado!',
                text: 'Alteração não foi Realizado',
                showConfirmButton: false,
                timer: 1580
            })
            
            var variavel = setInterval(function sweetAlert() {
                window.location.href = '../view/listarUsuario.php?msg={$msg2}';
            },1580);
            
            </script>     
    </body>";
    }
    ?>
</html>