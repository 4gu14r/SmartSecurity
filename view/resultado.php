<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require_once '../dao/usuarioDAO.php';
        $usuarioDAO = new usuarioDAO();
        $listaUsuarios = $usuarioDAO->getAllUsuario();
        
        echo "<table border='1' align='center'>";
        echo "<br>";
        echo "<tr>";
        echo"<th>id</th>";
        echo"<th>nome</th>";
        echo"<th>cpf</th>";
        echo"<th>";
        echo"Ação";
        echo"</th>";
        echo "</tr>";
        foreach ($listaUsuarios as $usuario) {
            echo "<tr>";
            echo "<td>{$usuario['id']}</td>";
            echo "<td>{$usuario['nome']}</td>";
            echo "<td>{$usuario['cpf']}</td>";
            echo "<td>";
            echo"<a href='../controller/excluirUsuarioByController.php?id={$usuario['idusuario']}'>";
            echo"excluir";
            echo"</a>";
            echo "|";
            echo "<a href='../view/formAlterarUsuario.php?id={$usuario['idusuario']}'>";
            echo"Alterar";
            echo"</a>";
            echo"</td>";
            echo "</tr>";

            }
            echo "</table>";
            ?>
    </body>
</html>
