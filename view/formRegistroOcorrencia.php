<?php 

session_start();
    include 'validaLogin.php';
    
    if(!empty($_POST['email']) && !empty($_POST['senha'])){
             header('location:../index.php#entre');
             exit();
    } 

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Boletim de Ocorrência</title>
        <link href="../css/cssForm.css" rel="stylesheet" type="text/css"/>
        <link href="../css/formStyle.css" rel="stylesheet" type="text/css"/>
        <style>
            body{
                background: url('../img/espiral.jpg');
                color: white;
                font-size: 1.1rem;
            }
        </style>
        <script>	
        function HabilDesab(){  
           if(document.getElementById('cor').checked == true){ 	 
              document.getElementById('outra').disabled = ""  }  
           if(document.getElementById('cor').checked == false){ 	
              document.getElementById('outra').disabled = "disabled" }	
       }
       
       function HabilDesabOutrasMarcas(){  
                if(document.getElementById('marcasoutras').checked == true){ 	 
                   document.getElementById('outrasmarcas').disabled = "", document.getElementById('marca').disabled = "disabled"}  
                if(document.getElementById('marcasoutras').checked == false){ 	
                   document.getElementById('outrasmarcas').disabled = "disabled", document.getElementById('marca').disabled = ""}
           }
   </script>
    </head>
    <body>
        <a href="../view/principal.php"><svg style="width: 50px;height: 50px;position: absolute; color: white;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M280.37 148.26L96 300.11V464a16 16 0 0 0 16 16l112.06-.29a16 16 0 0 0 15.92-16V368a16 16 0 0 1 16-16h64a16 16 0 0 1 16 16v95.64a16 16 0 0 0 16 16.05L464 480a16 16 0 0 0 16-16V300L295.67 148.26a12.19 12.19 0 0 0-15.3 0zM571.6 251.47L488 182.56V44.05a12 12 0 0 0-12-12h-56a12 12 0 0 0-12 12v72.61L318.47 43a48 48 0 0 0-61 0L4.34 251.47a12 12 0 0 0-1.6 16.9l25.5 31A12 12 0 0 0 45.15 301l235.22-193.74a12.19 12.19 0 0 1 15.3 0L530.9 301a12 12 0 0 0 16.9-1.6l25.5-31a12 12 0 0 0-1.7-16.93z" style="color: white;"/></svg></a>
        <h1>Registrar Ocorrência</h1>
        <form method="post" action="../controller/registrarOcorrenciaController.php"style="margin-top: 0;">
            <fieldset>
                <label for="perda"> Perda </label><input class="inpOc" type="radio" name="tipo" id="perda" value="Perda">
                <label for="assalto"> Assalto </label><input class="inpOc" type="radio" name="tipo" id="assalto" value="Assalto" checked="">
            </fieldset>
            <fieldset class="fieldOc">
            <ol>
                <li>
                    <p><h3>Localização</h3></p>
                    <select name="localizacao" required="">
                        <option selected="" disabled=""></option>
                        <optgroup label="C">
                        <option>Ceilândia Centro</option>
                        <option>Ceilândia Norte</option>
                        <option>Ceilândia Sul</option>
                        </optgroup>
                        <optgroup label="E">
                        <option>Expansão do Setor O</option>
                        </optgroup>
                        <optgroup label="G">
                        <option>Guariroba</option>
                        </optgroup>
                        <optgroup label="I">
                        <option>Incra(Ceilândia)</option>
                        </optgroup>
                        <optgroup label="P">
                        <option>Por do Sol</option>
                        <option>P Norte</option>
                        <option>P Sul</option>
                        </optgroup>
                        <optgroup label="Q">
                        <option>QNQ</option>
                        <option>QNR</option>
                        </optgroup>
                        <optgroup label="S">
                        <option>Setor Habitacional Sol Nascente</option>
                        <option>Setor O</option>
                        <option>Setor Privê</option>
                        <option>Setores de Indústria e de Materiais de Construção</option>
                        </optgroup>
                    </select>
                    <p><label>Referência</label></p>
                    <p><input type="text" name="referencia" placeholder="Ex.: Perto do 'VALMIR PIPAS'" style="width: 180px"></p>
                </li>
                <li>
                    <p><h3>Dados do Assalto</h3></p>
                    <p><label>Data do Ocorrido</label></p>
                    <p><input type="date" name="dt_registro" required=""</p>
                    <p><label>Horário do Ocorrido</label></p>
                    <p><input type="time" name="hr_registro" required=""</p>
                    <p><label><h4>Dê um Título para o Ocorrido</h4></label></p>
                    <p><input type="text" name="titulo_registro" placeholder="Ex.: Fui assaltado Voltando do Trabalho" required="" style="width: 250px;"></p>
                </li>
                <li>
                    <p><h3>Celular</h3></p>
                    <p><label>Marca:</label></p>
                    <select required="" name="marca" id="marca"> 
                            <option selected="" disabled=""></option>
                            <optgroup label="Mais Populares">
                            <option>APPLE</option>
                            <option>ASUS</option>
                            <option>LG</option>
                            <option>MOTOROLA</option>
                            <option>SAMSUNG</option>
                            <option>XIAOMI</option>
                            </optgroup>
                            <optgroup label="Demais">
                            <option>ALCATEL</option>
                            <option>BLACKBERRY</option>
                            <option>CCE</option>
                            <option>DELL</option>
                            <option>HP</option>
                            <option>HTC</option>
                            <option>HUAWEI</option>
                            <option>INTELBRAS</option>
                            <option>MICROSOFT</option>
                            <option>NOKIA</option>
                            <option>PANASONIC</option>
                            <option>PHILIPS</option>
                            <option>SEMP TOSHIBA</option>
                            <option>SONY</option>
                            </optgroup>
                    </select><br><br>
                    <label for="marcasoutras" style="text-align: left">Outra Marca?</label><input class="inpOc" type="checkbox" name="marcasoutras" id="marcasoutras" onClick="HabilDesabOutrasMarcas()" style="text-align: right;"><br><input type="text" name="marcasoutras" id="outrasmarcas" disabled="" placeholder="Qual Marca?">
                        <br>
                        <p><label>Modelo:</label></p>
                        <p><input type="text" name="modelo" id="modelo" maxlength="50" placeholder="Ex.: IPHONE 8"></p>
                        <p><label>Cor:</label></p>
                        <div class="cores">
                        <p><label for="preto" class="labOc">Preto</label><input class="inpOc" type="radio" name="cor" id="preto" value="Preto" checked=""onClick="HabilDesab()"><label class="labOc" for="branco">Branco</label><input class="inpOc" type="radio" name="cor" id="branco" value="Branco"onClick="HabilDesab()"><label class="labOc" for="prata">Prata</label><input class="inpOc" type="radio" name="cor" id="prata" value="Prata"onClick="HabilDesab()"><label class="labOc" for="dourado">Dourado</label><input class="inpOc" type="radio" name="cor" id="dourado" value="Dourado" onClick="HabilDesab()"><label for="outra">Outras</label><input class="inpOc" type="radio" name="cor" id="cor" onClick="HabilDesab()" value="<?php $outra ?>"><input type="text" name="outra" id="outra" disabled="" placeholder="Qual cor?"></p>
                        </div>
                        <label>IMEI </label><input type="number" name="imei" minlength="20" maxlength="20" placeholder="Digita o seu IMEI                                 *opcional*">
                </li>
                <li>
                    <p><h3>Informações Adicionais</h3></p>
                    <p><textarea name="descricao" id="descricao" cols="42" rows="10" placeholder="Descreva como aconteceu" maxlength="500"></textarea></p>
                </li>
            </ol>
            </fieldset>
            <br><br>
            <input type="submit" value="Registrar" onclick="confirm('Deseja registrar a Ocorrência? Você não poderá excluí-la!')">
        </form>
    </body>
</html>
