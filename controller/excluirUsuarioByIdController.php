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

    $usuarioDAO = new usuarioDAO();
    $id = $_GET["id"];

    $retorno = $usuarioDAO->excluirUsuario($id);

    if ($retorno) {
        $msg1 = "Usuário Deletado!";
        echo"
        <script src='../js/sweetalert2.all.min.js' type='text/javascript'></script>
    <body>
        <script type='text/javascript'>
            
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Usuário Deletado',
                text: 'Usuário excluido com Sucesso',
                showConfirmButton: false,
                timer: 1580
            })
            
            var variavel = setInterval(function sweetAlert() {
                window.location.href = '../view/listarUsuario.php?msg={$msg1}';
            },1580);
            
            </script>     
    </body>";
    } else {
        $msg2 = "Remoção não realizada!";
        echo"
    <body>
        <script type='text/javascript'>
            
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Usuário não foi Deletado!',
                text: 'Exclusão não foi Realizado',
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

