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
            <center>
                     <?php 
                         if (!empty($_GET["msg"])){
                             echo $_GET["msg"]; 
                         }
                     ?>
            </center>
    
    
    <form action="Ocorrencias.php" method="POST">
        Ocorrencia : <input type="text" name="ocorrencia"/><br>
        <input type="submit" value="consultar"/>
    </form>
    
        <?php
            require_once '../dao/ocorrenciaDAO.php';

            
            echo "<table border='1' align='center'>";
            echo "<tr>";
            echo "  <th>Localizações</th>";
            echo "</tr>";
            if(isset($_POST["ocorrencia"])){
                $ocorrencia = $_POST["ocorrencia"];
                $ocorrenciaDAO = new ocorrenciaDAO();
                $listaOcorrencias = $ocorrenciaDAO->getAllOcorrenciaByOcorrencia($ocorrencia);
                        foreach ($listaOcorrencias as $ocorrencia) {
                        echo "<tr>";
                        echo "<td>{$ocorrencia['localizacao']}</td>";
                        echo "<td><a "
                        . " href="
                             ."'../controller/excluirOcorrenciaByIdController.php?id={ocorrencia['idusuario']}'>"
                                . "excluir</a>";
                        echo " | ";
                        echo "<a href='../view/formAlterarOcorrencia.php?id={ocorrencia['idusuario']}'>";
                        echo "Alterar";
                        echo "</a>";
                        echo "</td>";
                        echo "</tr>";
                                    }
            }
            echo "</table>";                    
        ?>
    </body>
</html>
