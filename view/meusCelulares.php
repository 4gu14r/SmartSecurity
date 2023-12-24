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
    .default{
        border-color: gray;
        color: gray;
    }
    .default:hover{
        background-color: gray;
        color: white;
    }
    .buscar{
        border-color: #0098ff;
        color: #0098ff;
    }

    .buscar:hover {
        background: #0098ff;
        color: white;
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
        session_start();
        $usuario_id=$_SESSION["id"];
        $celularDAO = new celularDAO();
        $listaCelulares = $celularDAO->listarCelularByUsuario($usuario_id);
        echo "<a href='../view/principal.php'>";
        ?>
        <svg style="width: 50px;height: 50px;position: absolute;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M280.37 148.26L96 300.11V464a16 16 0 0 0 16 16l112.06-.29a16 16 0 0 0 15.92-16V368a16 16 0 0 1 16-16h64a16 16 0 0 1 16 16v95.64a16 16 0 0 0 16 16.05L464 480a16 16 0 0 0 16-16V300L295.67 148.26a12.19 12.19 0 0 0-15.3 0zM571.6 251.47L488 182.56V44.05a12 12 0 0 0-12-12h-56a12 12 0 0 0-12 12v72.61L318.47 43a48 48 0 0 0-61 0L4.34 251.47a12 12 0 0 0-1.6 16.9l25.5 31A12 12 0 0 0 45.15 301l235.22-193.74a12.19 12.19 0 0 1 15.3 0L530.9 301a12 12 0 0 0 16.9-1.6l25.5-31a12 12 0 0 0-1.7-16.93z"/></svg>
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
        echo "<a href='formCadastrarCelularUsuario.php'>";
        echo "<button class='btn default'>";
        echo "Cadatrar Celular";
        echo "</button>";
        echo "</a>";
        echo "</div>";
        echo"<table border='1' align='center'>";
        echo"<br>";
        echo"<tr>";
        echo"<th>Marca</th>";
        echo"<th>Modelo</th>";
        echo"<th>Cor</th>";
        echo"<th>";
        echo"Ação";
        echo"</th>";
        echo "</tr>";
        foreach ($listaCelulares as $celular) {
            echo "<tr>";
            echo "<td>{$celular['marca']}</td>";
            echo "<td>{$celular['modelo']}</td>";
            echo "<td>{$celular['cor']}</td>";
            echo "<td>";
            echo "<a href='../view/formAlterarCelularUsuario.php?cod={$celular['cod']}'>";
            echo "<button class='btn alterar'  style='margin-left: 50px;'>";
            echo"Alterar";
            echo "</button>";
            echo"</a>";
            echo "<a href='../view/buscaCelularUsuario.php?cod={$celular['cod']}'>";
            echo "<button class='btn buscar' style='margin-left: 50px;'>";
            echo"buscar";
            echo "</button>";
            echo"</a>";
            echo"</td>";
            echo "</tr>";

            }
            echo "</table>";
            ?>
    </body>
</html>
