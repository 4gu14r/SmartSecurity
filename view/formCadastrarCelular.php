<?php declare(strict_types=1) ?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cadastra Celular</title>
        <link href="../css/cssForm.css" rel="stylesheet" type="text/css"/>
        <link href="../css/formStyle.css" rel="stylesheet" type="text/css"/>
        <style>
            body{
                background: url('../img/vvv.jpg');
                text-align: center;
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
        
        <form method="post" action="../controller/cadastrarCelularController.php">
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
                        </select><br>
                        <label for="marcasoutras">Outra Marca?</label><input class="inpOc" type="checkbox" name="marcasoutras" id="marcasoutras" onClick="HabilDesabOutrasMarcas()"><input type="text" name="marcasoutras" id="outrasmarcas" disabled="" placeholder="Qual Marca?">
                        <br>
                        <p><label>Modelo:</label></p>
                        <p><input type="text" name="modelo" id="modelo" maxlength="50" placeholder="Ex.: IPHONE 8"></p>
                        <p><label>Cor:</label></p>
                        <p><label for="preto" class="labOc">Preto</label><input class="inpOc" type="radio" name="cor" id="preto" value="Preto" checked=""onClick="HabilDesab()"><label class="labOc" for="branco">Branco</label><input class="inpOc" type="radio" name="cor" id="branco" value="Branco"onClick="HabilDesab()"><label class="labOc" for="prata">Prata</label><input class="inpOc" type="radio" name="cor" id="prata" value="Prata"onClick="HabilDesab()"><label class="labOc" for="dourado">Dourado</label><input class="inpOc" type="radio" name="cor" id="dourado" value="Dourado" onClick="HabilDesab()"><br><label for="outra">Outras</label><input class="inpOc" type="radio" name="cor" id="cor" onClick="HabilDesab()" value="<?php $outra ?>"><input type="text" name="outra" id="outra" disabled="" placeholder="Qual cor?"></p>
                        <label>IMEI </label><input type="number" name="imei" maxlength="20" placeholder="Digita o seu IMEI">
                        <input type="submit" value="Cadastrar" onclick="confirm('Deseja cadastrar o aparelho? Você não poderar remover depois!')">
        </form>
    </body>
</html>
