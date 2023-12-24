<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Smart Security</title>
        <link href="css/cssIndex.css" rel="stylesheet" type="text/css"/>
        <link href="./css/cssForm.css" rel="stylesheet" type="text/css"/>
        <link href="./css/cssSlideIndex.css" rel="stylesheet" type="text/css"/>
        <script src="./js/jsSlideApresetacaoSozinho.js" type="text/javascript" ></script>
        <style>
            
        </style>
    </head>
    <body>
        <header>
            <nav class="inicialMenu">
            <label for="rd_home">Home</label>
            <label for="rd_entre">Entrar</label>
            <label for="rd_sobre">Sobre-Nós</label>
        </nav>
        </header>
        
        <div class="scroll">
            <input type="radio" name="grupo" id="rd_home" checked="true" hidden>
            <input type="radio" name="grupo" id="rd_entre"hidden>
            <input type="radio" name="grupo" id="rd_sobre"hidden>
            
            <section class="sections">
<!-- ----------------------------------------------------------------------- -->              
                <section class="bloco" id="home">
                    <div class="slideshow-container" style=" width: 100vw; height: 100vh; position: relative; margin-bottom: 0; overflow: hidden;">

                        <div class="mySlides fade">
                          <img src="img/slide1.jpg" >
                          <div class="text">
                              <h1>Listamento</h1>
                              <p>Monitore seus locais favoritos e acompanhe todas as ocorrências enviadas pelos usuários.</p>
                          </div>
                        </div>

                        <div class="mySlides fade">
                          <img src="./img/slide3.jpg" >
                          <div class="text">
                              <h1>Ocorrências</h1>
                              <p>A cada ocorrência compartilhada, várias pessoas podem se precaver para aquela região.</p>
                          </div>
                        </div>

                        <div class="mySlides fade">
                          <img src="./img/slide2.jpg" >
                          <div class="text">
                              <h1>Criminalidade</h1>
                              <p>Quanto mais engajamento da população, maiores serão as ações de segurança.</p>
                              <p><br></p>
                          </div>
                        </div>

                        </div>
                        <br>

                        <div style="text-align:center">
                            <span class="dot" style="display:none;"></span> 
                          <span class="dot" style="display:none;"></span> 
                          <span class="dot" style="display:none;"></span> 
                        </div>
                    <script>
                        var slideIndex = 0;
                        showSlides();

                        function showSlides() {
                          var i;
                          var slides = document.getElementsByClassName("mySlides");
                          var dots = document.getElementsByClassName("dot");
                          for (i = 0; i < slides.length; i++) {
                            slides[i].style.display = "none";  
                          }
                          slideIndex++;
                          if (slideIndex > slides.length) {slideIndex = 1}    
                          for (i = 0; i < dots.length; i++) {
                            dots[i].className = dots[i].className.replace(" active", "");
                          }
                          slides[slideIndex-1].style.display = "block";  
                          dots[slideIndex-1].className += " active";
                          setTimeout(showSlides, 5000); // Change image every 2 seconds
                        }
                    </script>
                </section>
<!-- ----------------------------------------------------------------------- -->                
                <section class="bloco" id="entre">
                    <form action="./controller/loginController.php" method="post">
                        <h1>Entre</h1>
                        <label for="email">Email:</label><br>
                        <input id="email" name="email" type="email" placeholder="seuemail@email.com" required><br>
                        <label for="senha">Senha:</label><br>
                        <input id="senha" name="senha" type="password" placeholder="Digite sua senha" required><br>
                        <input id="botao" type="submit" name="enviar" value="Enviar">
                        <div class="centralizada"><a href="./view/formCadastroUsuario.php" style="color: white;">Você ainda não possui uma conta? <strong>Cadastre-se</strong></a><br><br>  
                        <a href="./view/menuVisitante.php" style="color: white;">Entre como visitante<a></div>
                    </form>
                </section>
<!-- ----------------------------------------------------------------------- -->              
                <section class="bloco" id="sobre" style="">
                    
                    <div><p>Os Cidadãos Ceilândenses agora tem uma nova arma contra o crime que possa usar contra assaltantes, que tem como objetivo listar os bairros de Ceilândia, onde ocorrem assaltos e outros incidentes como perda de seu celular.</p></div>
                    <div><p>Nossa iniciativa partiu de varias ideias que tem relação com a segurança pública. "É uma forma de protestar e de divulgar essa informação, para evitar que outras pessoas sejam vítimas nos mesmos locais", que hoje conta com quatro membros ativos e não tem fins lucrativos.</p></div>
                    <div><p>O Site permite que o usuário seleciona o local onde foi vítima. Cada seleção vira uma listagem sobre os bairros e se torna visível para todos. É possível clicar na opção da listagem e ver mais detalhes informados pela vítima.</p></div>
                    
                </section>
            </section>
        </div>     
    </body>
</html>
