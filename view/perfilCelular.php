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
    </head>
        <?php
        require_once '../dao/celularDAO.php';
        
        $cod = $_GET["cod"];
        $celularDAO=new celularDAO();
        $celular=$celularDAO->getCelularByCod($cod);
        ?>
    <body>
        <form method="post" action="../controller/alterarCelularController.php">
            <input type="hidden" name="cod" value="<?php echo $celular["cod"]?>">
                        <br>
                        <p><label>Modelo:</label></p>
                        <p><input type="text" name="modelo" id="modelo" maxlength="50" placeholder="Ex.: IPHONE 8" value="<?php echo $celular["modelo"]?>"></p>
                        
                        
                        <!-- 
                        <p><input type="radio" name="cor" id="preto" value="Preto" checked=""onClick="HabilDesab()"><label for="preto">Preto</label><input type="radio" name="cor" id="branco" value="Branco"onClick="HabilDesab()"><label for="branco">Branco</label><input type="radio" name="cor" id="prata" value="Prata"onClick="HabilDesab()"><label for="prata">Prata</label><input type="radio" name="cor" id="douraudo" value="Douraudo" onClick="HabilDesab()"><label for="douraudo">Douraudo</label><input type="radio" name="cor" id="cor" onClick="HabilDesab()" value="<?/*php $outra ?>"><label for="outra">Outras</label><input type="text" name="outra" id="outra" disabled="" placeholder="Qual cor?"><?/*php $outra=$_POST['outra']?></p>
                        -->
                        
                        
                        <input type="submit" value="Atualizar" onclick="confirm('Deseja editar o aparelho')">
        </form>
    </body>
</html>
