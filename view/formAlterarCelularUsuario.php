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
        <link href="../css/cssForm.css" rel="stylesheet" type="text/css"/>
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
        <style>
            body{
                background: url('../img/vvv.jpg');
                text-align: center;
            }
        </style>
    </head>
        <?php
        require_once '../dao/celularDAO.php';
        
        $cod = $_GET["cod"];
        $celularDAO=new celularDAO();
        $celular=$celularDAO->getCelularByCod($cod);
        ?>
    <body>
        <form method="post" action="../controller/alterarCelularUsuarioController.php">
            <input type="hidden" name="cod" value="<?php echo $celular["cod"]?>">
                <p><label>Marca:</label></p>
                    <select required="" name="marca" id="marca"> 
                            <option selected="" disabled=""></option>
                            <optgroup label="Mais Populares">
                            <option <?php if($celular["marca"]=="APPLE") echo " selected " ?>  >APPLE</option>
                            <option <?php if($celular["marca"]=="ASUS") echo " selected " ?>  >ASUS</option>
                            <option <?php if($celular["marca"]=="LG") echo " selected " ?> >LG</option>
                            <option <?php if($celular["marca"]=="MOTOROLA") echo " selected " ?> >MOTOROLA</option>
                            <option <?php if($celular["marca"]=="SAMSUNG") echo " selected " ?> >SAMSUNG</option>
                            <option <?php if($celular["marca"]=="XIAOMI") echo " selected " ?> >XIAOMI</option>
                            </optgroup>
                            <optgroup label="Demais">
                            <option <?php if($celular["marca"]=="ALCATEL") echo " selected " ?> >ALCATEL</option>
                            <option <?php if($celular["marca"]=="BLACKBERRY") echo " selected " ?> >BLACKBERRY</option>
                            <option <?php if($celular["marca"]=="CCE") echo " selected " ?> >CCE</option>
                            <option <?php if($celular["marca"]=="DELL") echo " selected " ?> >DELL</option>
                            <option <?php if($celular["marca"]=="HP") echo " selected " ?> >HP</option>
                            <option <?php if($celular["marca"]=="HTC") echo " selected " ?> >HTC</option>
                            <option <?php if($celular["marca"]=="HUAWEI") echo " selected " ?> >HUAWEI</option>
                            <option <?php if($celular["marca"]=="INTELBRAS") echo " selected " ?> >INTELBRAS</option>
                            <option <?php if($celular["marca"]=="MICROSOFT") echo " selected " ?> >MICROSOFT</option>
                            <option <?php if($celular["marca"]=="NOKIA") echo " selected " ?> >NOKIA</option>
                            <option <?php if($celular["marca"]=="PANASONIC") echo " selected " ?> >PANASONIC</option>
                            <option <?php if($celular["marca"]=="PHILIPS") echo " selected " ?> >PHILIPS</option>
                            <option <?php if($celular["marca"]=="SEMP TOSHIBA") echo " selected " ?> >SEMP TOSHIBA</option>
                            <option <?php if($celular["marca"]=="SONY") echo " selected " ?> >SONY</option>
                            </optgroup>
                        </select><br>
                        <label for="marcasoutras">Outra Marca?</label><input class="inpOc" type="checkbox" name="marcasoutras" id="marcasoutras" onClick="HabilDesabOutrasMarcas()"><input type="text" name="marcasoutras" id="outrasmarcas" disabled="" placeholder="Qual Marca?" value="<?php echo $celular["marca"]?>">
                        <br>
                        <p><label>Modelo:</label></p>
                        <p><input type="text" name="modelo" id="modelo" maxlength="50" placeholder="Ex.: IPHONE 8" value="<?php echo $celular["modelo"]?>"></p>
                        
                        
                         
                         
                        <p>
                            <input type="radio" name="cor" id="preto" value="Preto" <?=$celular["cor"]=="Preto"?"checked":"" ?> checked=""onClick="HabilDesab()">
                            <label for="preto">Preto</label>
    <!-- -------------------------------------------------------------------------------------------------------------------------------------   -->                             <input type="radio" name="cor" id="branco" value="Branco" <?=$celular["cor"]=="Branco"?"checked":"" ?> onClick="HabilDesab()">
                            <label for="branco">Branco</label>
    <!-- --------------------------------------------------------------------------------------------------------------------------------------   -->                            <input type="radio" name="cor" id="prata" value="Prata" <?=$celular["cor"]=="Prata"?"checked":"" ?> onClick="HabilDesab()">
                            <label for="prata">Prata</label>
    <!-- --------------------------------------------------------------------------------------------------------------------------------------   -->                        
                            <input type="radio" name="cor" id="douraudo" value="Douraudo" <?=$celular["cor"]=="Dourado"?"checked":"" ?> onClick="HabilDesab()">
                            <label for="douraudo">Douraudo</label>
    <!-- --------------------------------------------------------------------------------------------------------------------------------------   -->                           <input class="inpOc" type="radio" name="cor" id="cor" onClick="HabilDesab()" value="<?php $outra ?>">
                           <label for="outra">Outras</label>
                           <input type="text" name="outra" id="outra" disabled="" placeholder="Qual cor?" value="<?=$celular["cor"]?>">
                        
                        
                        
                        <label>IMEI </label><input type="number" name="imei" maxlength="20" placeholder="Digita o seu IMEI" value="<?php echo $celular["imei"]?>">
                         
                         
                        
                        
                        <input type="submit" value="Atualizar" onclick="confirm('Deseja editar o aparelho')">
        </form>
    </body>
</html>
