<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="../css/menuUsuario.css" rel="stylesheet" type="text/css"/>
        <link href="../css/cssBotaoMenu.css" rel="stylesheet" type="text/css"/>
        <link href="../css/principalEstilo.css" rel="stylesheet" type="text/css"/>
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
                width: 93%;
                border: 0.01px solid #ddd;
                margin-top: 50px;
                background-color: white;
            }

            th, td {
                text-align: left;
                padding: 16px;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2;
            }


            a#logo{
                margin: 0px;
                padding: -50px;
                color: rgba(255,255,255,0);
                background-color: rgba(255,255,255,0);
            }
            a#logo:hover{
                color: rgba(255,255,255,0);
                background-color: rgba(255,255,255,0);
            }

            li a{
                text-decoration: none;
            }
            li a:hover{
                text-decoration: none;
                color: black;
            }
            h4{
                text-align: center;
            }
        </style>
    </head>
    <body>
        <header id="cabecalho">
            <div class="menu">
                <input type="checkbox" id="chec">
                <nav>
                <ul id="principal">
                    <p style="color: white; position: absolute; top: 40px; left: 200px;">Perfil: Usuário</p>
                    <li id="sair"><a href="../controller/logoffController.php">Sair</a></li>
                    <li><a href="minhasOcorrenciasUsuario.php">Minha Ocorrências</a></li>
                    <li><a href="estatistica.php">Estatísticas</a></li>
                    <li><a href="termoServico.php">Termos de Serviços</a></li>
                    <li><a href="politicaPrivacidade.php">Politica de Privacidade</a></li>
                    <li><a style="cursor: pointer; color: whitesmoke;">Configuração</a>
                            <ul id="submenu">
                                <li><a href="listarPerfilUsuario.php">Alterar Perfil</a></li>
                                <li><a href="meusCelulares.php">Celular</a></li>
                                <li><a href="comentariosUsuario.php">Comentário</a></li>
                            </ul>
                    </li>
                    <br><br><br><br>
                    <li id="botao"><a href="formRegistroOcorrencia.php">Registrar Ocorrência</a></li>
                </ul>
            </nav>
                <div class="imagem-menu">
                    <label for="chec">
                        <div class="container" onclick="myFunction(this)">
                            <div class="bar1"></div>
                            <div class="bar2"></div>
                            <div class="bar3"></div>
                        </div>
                    </label>
                </div>
            </div>
            <div class="logo">
                <a id="logo" href="principal.php"><img src="../img/logo.png"/></a>
            </div>
            <div class="titulo">
                <h1>
                    <span>S</span>mart <span>S</span>ecurity
                </h1>
            </div>
            <form name="searchform"  method="post" action="../view/principal.php">
                <div class="campo-de-busca">
                    <h3 style="margin-left: 10px;">Buscar</h3>
                    <input type="search" name="ocorrencia" align="left" size="50" maxlength="60" placeholder="Digite o Bairro">
                </div>
            </form>

        </header>
        <div class="container1">
            <section id="busca">
                <?php
                require_once '../dao/ocorrenciaDAO.php';


                if (isset($_POST["ocorrencia"])) {
                    echo "<table border='1' align='center''>";
                    $ocorrencia = $_POST["ocorrencia"];
                    $ocorrenciaDAO = new ocorrenciaDAO();
                    $listaOcorrencias = $ocorrenciaDAO->getAllOcorrenciaByOcorrencia($ocorrencia);
                    echo "<tr style='background-color: rgba(0,0,0,0.7); color: white;'>";
                    echo "<th>Título</th>";
                    echo "<th>Localização</th>";
                    echo "<th style='text-align: center;'>Vizualização</th>";
                    echo "</tr>";
                    foreach ($listaOcorrencias as $ocorrencia) {
                        
                        echo "<tr>";
                        echo "<td style='width: 50%'>{$ocorrencia['titulo_registro']}";
                        echo "<td style='width: 30%'>{$ocorrencia['localizacao']} </td>";
                        echo "<td style='width: 20%'>";
                        echo "<button style='margin: 0; width: 100%;' type='button' class='btn btn-primary' data-toggle='modal' data-target='#myModal{$ocorrencia['cod']}'> ";
                        echo "Visualizar";
                        echo " </button>";
                        echo "</td>";
                        echo "</tr>";
                    }
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
                                        <?php echo "<p>Data: {$ocorrencia['dt_registro']}</p>"?>
                                        <?php echo "<p>Hora: {$ocorrencia['hr_registro']}</p>" ?>
                                        <?php echo "</fieldset>"?>
                                        <hr>
                                        <?php echo "<fieldset>"?>
                                        <?php echo "<p>Marca: {$ocorrencia['marca']}</p>"?>
                                        <?php echo "<p>Modelo: {$ocorrencia['modelo']}</p>"?>
                                        <?php echo "<p>Cor: {$ocorrencia['cor']}</p>"?>
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
                }
                ?>



            </section>
        </div>
    </body>
</html>
