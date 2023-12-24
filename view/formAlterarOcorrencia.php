<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Boletim de Ocorrência</title>
        <link href="../css/cssForm.css" rel="stylesheet" type="text/css"/>
        <link href="../css/formStyle.css" rel="stylesheet" type="text/css"/>
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
    require_once '../dao/ocorrenciaDAO.php';
    
    $cod = $_GET["cod"];
    $ocorrenciaDAO = new ocorrenciaDAO();
    $ocorrencia = $ocorrenciaDAO->getOcorrenciaByCod($cod);
    
    ?>
    <body>
        <h1>Registrar Ocorrência</h1>
        <form method="post" action="../controller/alterarOcorrenciaController.php"style="margin-top: 0;">
            <input type="hidden" name="cod" value="<?php echo $ocorrencia["cod"]?>">
            <fieldset>
                
                <?php
                    if("tipo"=="Perda"){
                        echo "<label for='perda' >Perda</label><input type='radio' name='tipo' id='perda' value='Perda'  class='inpOc' >"
                        . "<label for='assalto'><label>Assalto</label><input type='radio' name='tipo' id='assalto' value='Assalto' class='inpOc'>";
                    }else{
                        echo "<label for='perda' >Perda</label><input type='radio' name='tipo' id='perda' value='Perda'  class='inpOc'>";
                       echo "<label for='assalto'><label>Assalto</label><input type='radio' name='tipo' id='assalto' value='Assalto' class='inpOc' >";
                    }
                    ?>
                
                
            </fieldset>
            
            <p><h3>Localização</h3></p>
                    <select name="localizacao" required="">
                        <option selected="" disabled=""></option>
                        <optgroup label="C">
                        <option <?php if($ocorrencia["localizacao"]=="Ceilândia Centro") echo " selected " ?>  >Ceilândia Centro</option>
                        <option  <?php if($ocorrencia["localizacao"]=="Ceilândia Norte") echo " selected " ?> >Ceilândia Norte</option>
                        <option  <?php if($ocorrencia["localizacao"]=="Ceilândia Sul") echo " selected " ?> >Ceilândia Sul</option>
                        </optgroup>
                        <optgroup label="E">
                        <option  <?php if($ocorrencia["localizacao"]=="Expansão do Setor O") echo " selected " ?> >Expansão do Setor O</option>
                        </optgroup>
                        <optgroup label="G">
                        <option  <?php if($ocorrencia["localizacao"]=="Guariroba") echo " selected " ?> >Guariroba</option>
                        </optgroup>
                        <optgroup label="I">
                        <option  <?php if($ocorrencia["localizacao"]=="Incra(Ceilândia)") echo " selected " ?> >Incra(Ceilândia)</option>
                        </optgroup>
                        <optgroup label="P">
                        <option  <?php if($ocorrencia["localizacao"]=="Por do Sol") echo " selected " ?> >Por do Sol</option>
                        <option <?php if($ocorrencia["localizacao"]=="P Norte") echo " selected " ?> >P Norte</option>
                        <option  <?php if($ocorrencia["localizacao"]=="P Sul") echo " selected " ?> >P Sul</option>
                        </optgroup>
                        <optgroup label="Q">
                        <option  <?php if($ocorrencia["localizacao"]=="QNQ") echo " selected " ?> >QNQ</option>
                        <option  <?php if($ocorrencia["localizacao"]=="QNR") echo " selected " ?> >QNR</option>
                        </optgroup>
                        <optgroup label="S">
                        <option <?php if($ocorrencia["localizacao"]=="Setor Habitacional Sol Nascente") echo " selected " ?> >Setor Habitacional Sol Nascente</option>
                        <option <?php if($ocorrencia["localizacao"]=="Setor O") echo " selected " ?> >Setor O</option>
                        <option <?php if($ocorrencia["localizacao"]=="Setor Privê") echo " selected " ?> >Setor Privê</option>
                        <option <?php if($ocorrencia["localizacao"]=="Setores de Indústria e de Materiais de Construção") echo " selected " ?> >Setores de Indústria e de Materiais de Construção</option>
                        </optgroup>
                    </select>
            
                    <p><label>Referência</label></p>
                    <p><input type="text" name="referencia" placeholder="Ex.: Perto do 'VALMIR PIPAS'" style="width: 180px" value="<?php echo $ocorrencia["referencia"]?>"></p>
                
                    <p><h3>Dados do Assalto</h3></p>
                    <p><label>Data do Ocorrido</label></p>
                    <p><input type="date" name="dt_registro" required="" value="<?php echo $ocorrencia["dt_registro"]?>" ></p>
                    <p><label>Horário do Ocorrido</label></p>
                    <p><input type="time" name="hr_registro" required="" value="<?php echo $ocorrencia["hr_registro"]?>"></p>
                    <p><label><h4>Dê um Título para o Ocorrido</h4></label></p>
                    <p><input type="text" name="titulo_registro" placeholder="Ex.: Fui assaltado Voltando do Trabalho" required="" style="width: 250px;" value="<?php echo $ocorrencia["titulo_registro"]?>"></p>
            <br><br>
                    <p><label>Marca:</label></p>
                    <select required="" name="marca" id="marca"> 
                            <option selected="" disabled=""></option>
                            <optgroup label="Mais Populares">
                            <option <?php if($ocorrencia["marca"]=="APPLE") echo " selected " ?>  >APPLE</option>
                            <option <?php if($ocorrencia["marca"]=="ASUS") echo " selected " ?>  >ASUS</option>
                            <option <?php if($ocorrencia["marca"]=="LG") echo " selected " ?> >LG</option>
                            <option <?php if($ocorrencia["marca"]=="MOTOROLA") echo " selected " ?> >MOTOROLA</option>
                            <option <?php if($ocorrencia["marca"]=="SAMSUNG") echo " selected " ?> >SAMSUNG</option>
                            <option <?php if($ocorrencia["marca"]=="XIAOMI") echo " selected " ?> >XIAOMI</option>
                            </optgroup>
                            <optgroup label="Demais">
                            <option <?php if($ocorrencia["marca"]=="ALCATEL") echo " selected " ?> >ALCATEL</option>
                            <option <?php if($ocorrencia["marca"]=="BLACKBERRY") echo " selected " ?> >BLACKBERRY</option>
                            <option <?php if($ocorrencia["marca"]=="CCE") echo " selected " ?> >CCE</option>
                            <option <?php if($ocorrencia["marca"]=="DELL") echo " selected " ?> >DELL</option>
                            <option <?php if($ocorrencia["marca"]=="HP") echo " selected " ?> >HP</option>
                            <option <?php if($ocorrencia["marca"]=="HTC") echo " selected " ?> >HTC</option>
                            <option <?php if($ocorrencia["marca"]=="HUAWEI") echo " selected " ?> >HUAWEI</option>
                            <option <?php if($ocorrencia["marca"]=="INTELBRAS") echo " selected " ?> >INTELBRAS</option>
                            <option <?php if($ocorrencia["marca"]=="MICROSOFT") echo " selected " ?> >MICROSOFT</option>
                            <option <?php if($ocorrencia["marca"]=="NOKIA") echo " selected " ?> >NOKIA</option>
                            <option <?php if($ocorrencia["marca"]=="PANASONIC") echo " selected " ?> >PANASONIC</option>
                            <option <?php if($ocorrencia["marca"]=="PHILIPS") echo " selected " ?> >PHILIPS</option>
                            <option <?php if($ocorrencia["marca"]=="SEMP TOSHIBA") echo " selected " ?> >SEMP TOSHIBA</option>
                            <option <?php if($ocorrencia["marca"]=="SONY") echo " selected " ?> >SONY</option>
                            </optgroup>
                        </select><br>
                        <label for="marcasoutras">Outra Marca?</label><input class="inpOc" type="checkbox" name="marcasoutras" id="marcasoutras" onClick="HabilDesabOutrasMarcas()" ><input type="text" name="marcasoutras" id="outrasmarcas" disabled="" placeholder="Qual Marca?" value="<?php echo $ocorrencia["marca"]?>">
                        <br>
                        <p><label>Modelo:</label></p>
                        <p><input type="text" name="modelo" id="modelo" maxlength="50" placeholder="Ex.: IPHONE 8" value="<?php echo $ocorrencia["modelo"]?>"></p>
            <input type="submit" value="Atualizar o Registro" onclick="confirm('Deseja alterar a ocorrência?')">
        </form>
    </body>
</html>
