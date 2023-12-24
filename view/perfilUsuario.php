
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Altere a Conta</title>
        <link href="../css/formStyle.css" rel="stylesheet" type="text/css"/>
        <link href="../css/cssForm.css" rel="stylesheet" type="text/css"/>
        <script src="../js/jquery-3.4.1.min.js" type="text/javascript"></script>
        <script src="../js/jquery.cpfcnpj.min.js" type="text/javascript"></script>
        <script src="../js/jquery.mask.js" type="text/javascript"></script>
        <script type="text/javascript">
        
            
            function formatar(mascara, documento){
                var i = documento.value.length;
                var saida = mascara.substring(0,1);
                var texto = mascara.substring(i)
                if (texto.substring(0,1) != saida){
                    documento.value += texto.substring(0,1);
                }
            }
            function validarEmail(){
                var email = formuser.email.value;
                var Cemail = formuser.Cemail.value;
                if (email !== Cemail) {
                    alert('E-mails Distintos');
                    formuser.email.focus();
                    return false;
                }
            }
            function validarSenha(){
                var senha = formuser.senha.value;
                var Csenha = formuser.Csenha.value;
                if (senha !== Csenha) {
                    alert('Senhas Distintas');
                    formuser.senha.focus();
                    return false;
                }
            }
            
            
        </script>
    </head>
    <?php
    require_once '../dao/usuarioDAO.php';
    require_once '../js/funcaoData.php';
    
    $id = $_GET["id"];
    $usuarioDAO = new usuarioDAO();
    $usuario = $usuarioDAO->getUsuarioById($id);
   
    ?>
    <body>
        <div>
            <form name="formuser" method="post" action="../controller/alterarPerfilUsuarioController.php" style="margin-top: 0px">
                <input type="hidden" name="id" value="<?php echo $usuario["id"]?>"/>
                <fieldset><legend>Pessoal</legend>
                <label for="nome">Nome</label><br>
                <input type="text" name="nome" id="nome" value="<?php echo $usuario["nome"] ?>" required=""><br><br>
                <label for="sobre">Sobrenome</label><br>
                <input type="text" name="sobre" id="sobre" required="" value="<?php echo $usuario["sobrenome"] ?>"><br><br>
                <label>Data de Nacimento</label><br>
                <input type="date" name="dt_nascimento" id="dt_nascimento" maxlength="10"required="" OnKeyPress="formatar('##-##-####', this)" placeholder="00-00-0000" value="<?php echo $usuario["dt_nascimento"]?>"><br><br>
                <fieldset><legend>Sexo</legend>
                    <?php
                    if("sexo"=="masc"){
                        echo "<input type='radio' name='sexo' id='masc' value='Masculino' checked='' class='inpOc'"
                        . "><label for='masc' >Masculino</label>"
                        . "<input type='radio' name='sexo' id='femi' value='Feminino' class='inpOc'><label for='femi'><label>Feminino</label>";
                    }else{
                        echo "<input type='radio' name='sexo' id='masc' value='Masculino' checked='' class='inpOc' <label for='masc' >Masculino</label>"
                        . "<input type='radio' name='sexo' id='femi' value='Feminino' class='inpOc'><label for='femi'><label>Feminino</label>";
                    }
                    ?>
                </fieldset>
                </fieldset><br>
                <fieldset><legend>Contato</legend>
                    <label for="email">E-mail</label><br>
                    <input type="email" name="email" id="email" required="" class="btn" value="<?php echo $usuario["email"]?>"><br><br>
                    <label for="Cemail">Confimar E-mail</label><br>
                    <input type="email" name="Cemail" id="Cemail" class="btn" required=""><br><br>
                    <label for="senha">Senha</label><br>
                    <input type="password" name="senha" id="senha" required="" onfocus="return validarEmail()" minlength="6" value="<?php echo $usuario["senha"]?>"><br><br>
                    <label for="Csenha">Confimar Senha</label><br>
                    <input type="password" name="Csenha" id="Csenha" required="" minlength="6"><br><br>
                </fieldset>
                <fieldset><legend>Endereço</legend>
                    <label for="bairro">Bairro</label>
                    <select name="endereco" required="">
                        <option selected="" disabled=""></option>
                        <optgroup label="C">
                        <option <?php if($usuario["endereco"]=="Ceilândia Centro") echo " selected " ?>  >Ceilândia Centro</option>
                        <option  <?php if($usuario["endereco"]=="Ceilândia Norte") echo " selected " ?> >Ceilândia Norte</option>
                        <option  <?php if($usuario["endereco"]=="Ceilândia Sul") echo " selected " ?> >Ceilândia Sul</option>
                        </optgroup>
                        <optgroup label="E">
                        <option  <?php if($usuario["endereco"]=="Expansão do Setor O") echo " selected " ?> >Expansão do Setor O</option>
                        </optgroup>
                        <optgroup label="G">
                        <option  <?php if($usuario["endereco"]=="Guariroba") echo " selected " ?> >Guariroba</option>
                        </optgroup>
                        <optgroup label="I">
                        <option  <?php if($usuario["endereco"]=="Incra(Ceilândia)") echo " selected " ?> >Incra(Ceilândia)</option>
                        </optgroup>
                        <optgroup label="P">
                        <option  <?php if($usuario["endereco"]=="Por do Sol") echo " selected " ?> >Por do Sol</option>
                        <option <?php if($usuario["endereco"]=="P Norte") echo " selected " ?> >P Norte</option>
                        <option  <?php if($usuario["endereco"]=="P Sul") echo " selected " ?> >P Sul</option>
                        </optgroup>
                        <optgroup label="Q">
                        <option  <?php if($usuario["endereco"]=="QNQ") echo " selected " ?> >QNQ</option>
                        <option  <?php if($usuario["endereco"]=="QNR") echo " selected " ?> >QNR</option>
                        </optgroup>
                        <optgroup label="S">
                        <option <?php if($usuario["endereco"]=="Setor Habitacional Sol Nascente") echo " selected " ?> >Setor Habitacional Sol Nascente</option>
                        <option <?php if($usuario["endereco"]=="Setor O") echo " selected " ?> >Setor O</option>
                        <option <?php if($usuario["endereco"]=="Setor Privê") echo " selected " ?> >Setor Privê</option>
                        <option <?php if($usuario["endereco"]=="Setores de Indústria e de Materiais de Construção") echo " selected " ?> >Setores de Indústria e de Materiais de Construção</option>
                        </optgroup>
                    </select><br>
                
                <input type="submit" value="Atualizar" onfocus="return validarCPF()" class="btn" onclick="confirm('Deseja realmente editar os dados?')">
                
                
            </form>
        </div>
         <script type="text/javascript">
        $(document).ready(function validarCPF() {
            $('.cpf').cpfcnpj({
                mask: true,
                validate: 'cpf',
                event: 'focus',
                handler: '.btn',
                ifValid: function (input) { input.removeClass("error"); },
                ifInvalid: function (input) { window.alert("CPF INVÁLIDO");
                formuser.cpf.focus();
                return false; }
                
            });
        });
        </script>
    </body>
</html>
