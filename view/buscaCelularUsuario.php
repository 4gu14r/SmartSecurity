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
        <link href="../css/modal.css" rel="stylesheet" type="text/css"/>
        <script src="../js/modal.js" type="text/javascript"></script>


        <!--MODAL-->
        <link rel="stylesheet" href="../js/bootstrap.min.css">
        <script src="../js/jquery.min.js"></script>
        <script src="../js/popper.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <!--MODAL-->
        <style>
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
    input {
	outline: none;
    }
    input[type=search] {
            -webkit-appearance: textfield;
            -webkit-box-sizing: content-box;
            font-family: inherit;
            font-size: 100%;
    }
    input::-webkit-search-decoration,
    input::-webkit-search-cancel-button {
            display: none; 
    }


    input[type=search] {
            background: #ededed url(https://static.tumblr.com/ftv85bp/MIXmud4tx/search-icon.png) no-repeat 9px center;
            border: solid 1px #ccc;
            padding: 9px 10px 9px 32px;
            width: 55px;

            -webkit-border-radius: 10em;
            -moz-border-radius: 10em;
            border-radius: 10em;

            -webkit-transition: all .5s;
            -moz-transition: all .5s;
            transition: all .5s;
    }
    input[type=search]:focus {
            width: 500px;
            background-color: #fff;
            border-color: #66CC75;

            -webkit-box-shadow: 0 0 5px rgba(109,207,246,.5);
            -moz-box-shadow: 0 0 5px rgba(109,207,246,.5);
            box-shadow: 0 0 5px rgba(109,207,246,.5);
    }


    input:-moz-placeholder {
            color: #999;
    }
    input::-webkit-input-placeholder {
            color: #999;
    }
    h3{
        text-align: center;
        margin-top: 10px;
        
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
    img#voltar{
        width: 75px;
        height: 75px;
        position: absolute;
        top: -10px;
        left: -7px;
    }
    h1{
        text-align: center;
    }
        
    
        </style>
    </head>
    <body>
        <header>
            <div class="voltar">
                <a href="../view/meusCelulares.php" id="voltar">
                    <img id="voltar" src="../icons/icones/icons8-esquerda-100.png" alt=""/>
                </a>
            </div>
            <div class="logo">
                <a id="logo" href="principal.php"><img src="../img/logo.png" style="width: 150px; height: 150px;"/></a>
            </div>
            <div class="titulo">
                <h1>
                    <span>S</span>mart <span>S</span>ecurity
                </h1>
            </div>
        </header>
        <?php
        require_once '../dao/ocorrenciaDAO.php';
        require_once '../dao/celularDAO.php';
        $cod=$_GET["cod"];
        $celularDAO=new celularDAO();
        $celular=$celularDAO->getCelularByCod($cod);
        ?>
        <hr>
        <?php    
    echo "<form name='searchform'  method='post' action='../view/buscaCelular.php?cod={$celular['cod']}'>";
        ?>
                <div style="text-align: center;">
                    <!--<input type="search" name="ocorrencia" align="left" size="50" maxlength="60" value="<?php echo $celular["marca"];?>" placeholder="Digite a Marca ou o Modelo do smartphone">-->
                </div>
            </form>
            <br>
            <br>
        <section>
            <?php

            echo "<table border='1' align='center'>";
//            if(isset($_POST["ocorrencia"])){
                $ocorrencia = $celular["marca"];
                $ocorrenciaDAO = new ocorrenciaDAO();
                $listaOcorrencias = $ocorrenciaDAO->getAllOcorrenciaByOcorrencia2($ocorrencia);
                
            if(!empty($listaOcorrencias)){
                echo "<h1>Celulares Assaltados/Perdidos</h1>";
                        foreach ($listaOcorrencias as $ocorrencia) {
                        echo "<tr>";
                        echo "<td style='text-align: left;padding: 16px;'>{$ocorrencia['localizacao']}</td>";
                        echo "<td style='text-align: left;padding: 16px;'>{$ocorrencia['marca']}</td>";
                        echo "<td style='text-align: left;padding: 16px;'>{$ocorrencia['modelo']}</td>";
                        echo "<td style='text-align: left;padding: 16px;'>{$ocorrencia['titulo_registro']}</td>";
                        echo "<td style='text-align: left;padding: 16px;'><button style='margin: 0;' type='button' class='btn btn-primary' data-toggle='modal' data-target='#myModal{$ocorrencia['cod']}'>Vizualizar</button></td>";
                        echo "</tr>";
                   }
//            }
            echo "</table>";
            foreach ($listaOcorrencias as $ocorrencia) {
                        ?>
                        <!-- The Modal -->
                        <div class="modal fade" id="myModal<?= $ocorrencia['cod'] ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title"><?= $ocorrencia['titulo_registro'] ?></h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <?php echo "<fieldset style='color: black'>"?>
                                        <?php echo "<p>Data: {$ocorrencia['dt_registro']}"?>
                                        <?php echo "Hora: {$ocorrencia['hr_registro']}</p>" ?>
                                        <?php echo "</fieldset>"?>
                                        <hr>
                                        <?php echo "<fieldset>"?>
                                        <?php echo "<p>Marca: {$ocorrencia['marca']}"?>
                                        <?php echo "Modelo: {$ocorrencia['modelo']}"?>
                                        <?php echo "Cor: {$ocorrencia['cor']}</p>"?>
                                        <?php echo "</fieldset>"?>
                                        <hr>
                                        <?php echo "<fieldset>"?>
                                       <?php echo "<p>Referência: {$ocorrencia['referencia']}</p>" ?>
                                        <?php echo "</fieldset>"?>
                                        <br>
                                        <br>
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <h4><?php echo $ocorrencia['localizacao'] ?></h4>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <!-- themodal-->                

                        <?php
                    }
            }else{
                echo "<h3>Não existe ocorrência registrada com esse dispotivo</h3>";
            }
        ?>
        </section>
    </body>
</html>
