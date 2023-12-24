<!DOCTYPE html>
<html >
    <head>
        <meta charset="UTF-8">
        <title>Cadastra-se já</title>
        <link href="../css/cssForm.css" rel="stylesheet" type="text/css"/>
        <script src="../js/jquery-3.4.1.min.js" type="text/javascript"></script>
        <script src="../js/jquery.cpfcnpj.min.js" type="text/javascript"></script>
        <script src="../js/jquery.mask.js" type="text/javascript"></script>
        <script src="../js/sweetalert2.all.min.js" type="text/javascript"></script>
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
        <style>
            .error {  border-color: #F70202 }
            .escondido{display: none;}
            body{
                background: url('../img/xadrez.jpg');
            }
            input{
                background-color: rgb(255,255,255);
            }
            form{
                text-align: center;
            }
            input#masc, input#femi{
                width: 20px;
                background-color: rgba(255,255,255,0);
            }
        </style>
    </head>
    <body>
        <div>
            <?php
            
            ?>
            <form name="formuser" method="post" action="../controller/cadastrarUsuarioController.php" style="margin-top: 0px">
                <input type="radio" class="escondido" name="perfil" id="perfil" value="2" checked=""><label for="perfil" class="escondido">Usuário</label>
                <fieldset><legend>Pessoal</legend>
                <label for="nome">Nome</label><br>
                <input type="text" name="nome" id="nome" required=""><br><br>
                <label for="sobre">Sobrenome</label><br>
                <input type="text" name="sobre" id="sobre" required=""><br><br>
                <label>Data de Nacimento</label><br>
                <input type="date" name="dt_nascimento" id="dt_nascimento" maxlength="10"required="" OnKeyPress="formatar('##-##-####', this)" placeholder="00-00-0000"><br><br>
                <label for="cpf">CPF</label><br>
                <input type="text" name="cpf" class="cpf" placeholder="Ex: 123.456.789-12" mask="___.___.___-__" data-form="signup" OnKeyPress="formatar('###.###.###-##', this)" data-page="signup" autocomplete="on" maxlength="11" required><br><br>
                <fieldset><legend>Sexo</legend>
                    <input type="radio" name="sexo" id="masc" value="Masculino" checked="" class="btn" onfocus="return validarCPF()"><label for="masc">Masculino</label>
                    <input type="radio" name="sexo" id="femi" value="Feminino" class="btn"><label for="femi" onclick="return validarCPF()" >Feminino</label>
                </fieldset>
                </fieldset><br>
                <fieldset><legend>Contato</legend>
                    <label for="email">E-mail</label><br>
                    <input type="email" name="email" id="email" required="" class="btn" onfocus="return validarCPF()"><br><br>
                    <label for="Cemail">Confimar E-mail</label><br>
                    <input type="email" name="Cemail" id="Cemail" class="btn" required=""><br><br>
                    <label for="senha">Senha</label><br>
                    <input type="password" name="senha" id="senha" required="" onfocus="return validarEmail()" minlength="6"><br><br>
                    <label for="Csenha">Confimar Senha</label><br>
                    <input type="password" name="Csenha" id="Csenha" required="" minlength="6"><br><br>
                </fieldset>
                <fieldset><legend>Endereço</legend>
                    <label for="bairro">Bairro</label>
                    <select name="endereco" required="" onfocus="return validarSenha()">
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
                        <option>Setor Habitacional Sol Nacente</option>
                        <option>Setor O</option>
                        <option>Setor Privê</option>
                        <option>Setores de Indústria e de Materiais de Construção</option>
                        </optgroup>
                    </select>
                </fieldset><br><br>
                
                <input type="submit" value="Cadastrar" onfocus="return validarCPF()" class="btn" onclick="msg()">
                
            </form>
        </div>
        <script type="text/javascript">
        $(document).ready(function validarCPF() {
            $('.cpf').cpfcnpj({
                mask: true,
                validate: 'cpf',
                event: 'focus',
                handler: '.btn',
                ifValid: function (input) { input.removeClass("sucess"); },
                ifInvalid: function (input) { 
                    alert("CPF Inválido");
                formuser.cpf.focus();
                return false; }
                
            });
        });
    
        </script>
        <SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
            function msg(){
                decisao = confirm("Deseja cadastra-se? \n"+
                        "Depois você não Poderá Excluir a conta!");
                if (decisao){
                    return true;
                } else {
                    document.formuser.focus();
                    return false;
                }
            }
        </SCRIPT>
    </body>
</html>