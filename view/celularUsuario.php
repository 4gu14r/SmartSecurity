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
            div{
                margin: 0;
                padding: 0;
                text-align: left;
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
            div.logo{
                text-align: right;
            }
            .btn {
                border: 2px solid black;
                background-color: white;
                color: black;
                padding: 14px 28px;
                font-size: 16px;
                cursor: pointer;
            }
            div.inicio{
                text-align: left;
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
        require_once '../dao/celularDAO.php';
        $celularDAO = new celularDAO();
        $listaCelulares = $celularDAO->listarCelular();
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
        echo"<br>";
        echo "</div>";
        echo "<br>";
        echo "<div class='titulo'>";
        echo "<h1>";
        echo "<span>S</span>mart <span>S</span>ecurity";
        echo "</h1>";
        echo "</div>";
        echo "<br>";       
        echo "<a href='formCadastrarCelular.php'>";
        echo "<button class='btn default'>";
        echo "Cadastrar Celular";
        echo "</button>";
        echo "</a>";
        echo "<a href='formAlterarCelular.php'>";
        echo "<button class='btn default'>";
        echo "Alterar Celular";
        echo "</button>";
        echo "</a>";
        echo "</div>";
        echo "<br>"; 
        echo "<br>"; 
        echo "<table>";
            echo "<tr>";
                echo "<th>Marca</th>";
                echo "<th>Modelo</th>";
                echo "<th>Cor</th>";
                echo "<th>ID do Usuário</th>";
            echo "</tr>";
            foreach ($listaCelulares as $celular) {
            echo "<tr>";
            echo "<td>{$celular['marca']}</td>";
            echo "<td>{$celular['modelo']}</td>";
            echo "<td>{$celular['cor']}</td>";
            echo "<td>{$celular['usuario_id']}</td>";
            echo "</tr>";

            }
        echo "</table>";
                ?>
    </body>
</html>
