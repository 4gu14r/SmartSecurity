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
        <style>
            *{
                padding: 0;
                margin: 10;
            }


            table {
                border-collapse: collapse;
                border-spacing: 0;
                width: 100%;
                border: 1px solid #ddd;
            }

            th, td {
                text-align: left;
                padding: 16px;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2;
            }
            .btn {
                border: 2px solid black;
                background-color: white;
                color: black;
                padding: 14px 28px;
                font-size: 16px;
                cursor: pointer;
            }
            .alterar {
                border-color: #ff9800;
                color: orange;
            }

            .alterar:hover {
                background: #ff9800;
                color: white;
            }
            .excluir {
                border-color: #f44336;
                color: red;
            }

            .excluir:hover {
                background: #f44336;
                color: white;
            }
            .default {
                border-color: #e7e7e7;
                color: black;
            }
            .default:hover {
                background: #e7e7e7;
            }
            div.logo{
                text-align: right;
            }
            span{
                font-family: serif;
                font-size: 45pt;
            }
            div.titulo{
                width: 100vw;
                text-align: center;
                position: absolute;
                top: 25px;

            }
            svg{
                width: 50px;
                height: 50px;
                position: absolute;
            }
        </style>
    </head>
    <body>

        <?php
        session_start();
        require_once '../dao/comentarioDAO.php';
        require_once '../dao/usuarioDAO.php';

        $comentarioDAO = new comentarioDAO();
        $listaComentarios = $comentarioDAO->listarComentario();

        $id = $_SESSION['id'];
        echo "<a href='../view/principal.php'>";
        ?>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M280.37 148.26L96 300.11V464a16 16 0 0 0 16 16l112.06-.29a16 16 0 0 0 15.92-16V368a16 16 0 0 1 16-16h64a16 16 0 0 1 16 16v95.64a16 16 0 0 0 16 16.05L464 480a16 16 0 0 0 16-16V300L295.67 148.26a12.19 12.19 0 0 0-15.3 0zM571.6 251.47L488 182.56V44.05a12 12 0 0 0-12-12h-56a12 12 0 0 0-12 12v72.61L318.47 43a48 48 0 0 0-61 0L4.34 251.47a12 12 0 0 0-1.6 16.9l25.5 31A12 12 0 0 0 45.15 301l235.22-193.74a12.19 12.19 0 0 1 15.3 0L530.9 301a12 12 0 0 0 16.9-1.6l25.5-31a12 12 0 0 0-1.7-16.93z"/></svg>
        <?php
        echo "</a>";
        echo "<div class='logo'>";
        echo "<a href='../view/principal.php'>";
        echo "<img src='../img/logo.png' style='width: 150px; height: 150px;'>";
        echo"</a>";
        echo "</div>";
        echo "<br>";
        echo "<div class='titulo'>";
        echo "<h1>";
        echo "<span>S</span>mart <span>S</span>ecurity";
        echo "</h1>";
        echo "</div>";
        echo "<div>";
        echo "<a href='formComentario.php'>";
        echo "<button class='btn default'>";
        echo "Comentar";
        echo "</button>";
        echo "</a>";
        echo "</div>";
        echo"<table border='1' align='center'>";
        echo"<br>";
        echo"<tr>";
        echo"<th>COD</th>";
        echo"<th>Comentários</th>";
        echo"<th>ID do Usuário</th>";
        echo"<th>";
        echo"Ação";
        echo"</th>";
        echo "</tr>";
        foreach ($listaComentarios as $comentario) {
            echo "<tr>";
            echo "<td>{$comentario['cod']}</td>";
            echo "<td>{$comentario['comentario']}</td>";
            echo "<td>{$comentario['usuario_id']}</td>";
            echo "<td>";
            echo "<a href='../view/formEditarComentario.php?cod={$comentario['cod']}'>";
            echo "<button class='btn alterar'>";
            echo"Alterar";
            echo "</button>";
            echo"</a>";
            echo"<a href='../controller/excluirComentarioByCodController.php?cod={$comentario['cod']}'>";
            ?>
            <button class="btn excluir" onclick="confirm('Deseja excluir esse comentário?')">Excluir</button>
            <?php
            echo"</a>";
            echo"</td>";
            echo "</tr>";
        }
        echo "</table>";
        ?>
    </body>
</html>
