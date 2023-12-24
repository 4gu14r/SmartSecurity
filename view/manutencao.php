<!DOCTYPE html>
<html>
<style>
body, html {
  height: 100%;
  margin: 0;
}

.bgimg {
  background-image: url('../img/manutencao.png');
  height: 100%;
  background-position: center;
  background-size: cover;
  position: relative;
  font-family: "Courier New", Courier, monospace;
  font-size: 25px;
}

.topleft {
  position: absolute;
  top: 0;
  left: 16px;
}

.bottomleft {
  position: absolute;
  bottom: 0;
  left: 16px;
}

.middle {
  position: absolute;
  top: 50%;
  left: 90%;
  transform: translate(-50%, -50%);
  text-align: center;
}

hr {
  margin: auto;
  width: 40%;
}
</style>
<body>

<div class="bgimg">
  <div class="topleft">
      <p><a href="../view/principal.php"><img src="../img/logo.png" style="width: 250px; height: 250px;"></a></p>
    
  </div>
  <div class="middle">
    <h1>Em Breve</h1>
    <hr>
    <p>30 dias restantes</p>
  </div>
  <div class="bottomleft">
    <p>Em manutenção</p>
  </div>
</div>

</body>
</html>