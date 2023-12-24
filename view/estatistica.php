<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style>
            h1{
                text-align: center;
            }
            table {
                border-collapse: collapse;
                border-spacing: 0;
                width: 100%;
                border: 1px solid #ddd;
            }

            th, td {
                text-align: left;
                padding: 16px;
                border: 1px solid #ddd;
                
            }

            tr:nth-child(even) {
                background-color: #f2f2f2;
            }
            div.nada{
                width: 50px;
                height: 50px;
                position: absolute;
            }
            div.grafico{
                display: block;
                float: left;
                width: 98vw;
                margin: 0;
                padding: 0;
            }
            div#piechart{
                padding: 0;
                
            }
            div#piechartHora{
                margin: 0;
                padding: 0;
                width: 50%;
                height: auto;
                display: block;
                float: left;
            }
            div#piechartTipo{
                margin: 0;
                padding: 0;
                width: 50%;
                height: auto;
                display: block;
                float: right;
            }
        </style>
    </head>
    <body>
        <div class="nada">
        <a href="../view/principal.php">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M280.37 148.26L96 300.11V464a16 16 0 0 0 16 16l112.06-.29a16 16 0 0 0 15.92-16V368a16 16 0 0 1 16-16h64a16 16 0 0 1 16 16v95.64a16 16 0 0 0 16 16.05L464 480a16 16 0 0 0 16-16V300L295.67 148.26a12.19 12.19 0 0 0-15.3 0zM571.6 251.47L488 182.56V44.05a12 12 0 0 0-12-12h-56a12 12 0 0 0-12 12v72.61L318.47 43a48 48 0 0 0-61 0L4.34 251.47a12 12 0 0 0-1.6 16.9l25.5 31A12 12 0 0 0 45.15 301l235.22-193.74a12.19 12.19 0 0 1 15.3 0L530.9 301a12 12 0 0 0 16.9-1.6l25.5-31a12 12 0 0 0-1.7-16.93z"/></svg>
        </a>
        </div>
        <h1>Estatísticas</h1>
        <table>
            <thead>
            <th>Onde</th>
            <th>horario</th>
            <th>tipo</th>
            </thead>
            <tbody>
                <?php
                $cont_ceicentro=0;
                $cont_ceinorte=0;
                $cont_ceisul=0;
                $cont_expanSetorO=0;
                $cont_guariroba=0;
                $cont_incra=0;
                $cont_porsol=0;
                $cont_pnorte=0;
                $cont_psul=0;
                $cont_QNQ=0;
                $cont_QNR=0;
                $cont_SolNascente=0;
                $cont_setorO=0;
                $cont_setorPrive=0;
                $cont_SIMC=0;
                
                $cont_Madrugada=0;
                $cont_Dia=0;
                $cont_Tarde=0;
                $cont_Noite=0;
                
                $cont_Perda=0;
                $cont_Assalto=0;
                
                require_once '../dao/ocorrenciaDAO.php';
                $ocorrenciaDAO = new ocorrenciaDAO();
                $listaOcorrencias = $ocorrenciaDAO->listarOcorrencia();
                foreach ($listaOcorrencias as $ocorrencia) {
                    echo "<tr>";
                    echo "<td>{$ocorrencia['localizacao']}</td>";
                    echo "<td>{$ocorrencia['hr_registro']}</td>";
                    echo "<td>{$ocorrencia['tipo']}</td>";
                    echo "</tr>";
                    
                    if($ocorrencia["localizacao"] == "Ceilândia Centro"){
                        $cont_ceisul++;
                    }
                    if($ocorrencia["localizacao"] == "Ceilândia Norte"){
                        $cont_ceinorte++;
                    }
                    if($ocorrencia["localizacao"] == "Ceilândia Sul"){
                        $cont_ceisul++;
                    }
                    if($ocorrencia["localizacao"] == "Expansão do Setor O"){
                        $cont_expanSetorO++;
                    }
                    if($ocorrencia["localizacao"] == "Guariroba"){
                        $cont_guariroba++;
                    }
                    if($ocorrencia["localizacao"] == "Incra(Ceilândia)"){
                        $cont_incra++;
                    }
                    if($ocorrencia["localizacao"] == "Por do Sol"){
                        $cont_porsol++;
                    }
                    if($ocorrencia["localizacao"] == "P Norte"){
                        $cont_pnorte++;
                    }
                    if($ocorrencia["localizacao"] == "P Sul"){
                        $cont_psul++;
                    }
                    if($ocorrencia["localizacao"] == "QNQ"){
                        $cont_QNQ++;
                    }
                    if($ocorrencia["localizacao"] == "QNR"){
                        $cont_QNR++;
                    }
                    if($ocorrencia["localizacao"] == "Setor Habitacional Sol Nascente"){
                        $cont_SolNascente++;
                    }
                    if($ocorrencia["localizacao"] == "Setor O"){
                        $cont_setorO++;
                    }
                    if($ocorrencia["localizacao"] == "Setor Privê"){
                        $cont_setorPrive++;
                    }
                    if($ocorrencia["localizacao"] == "Setores de Indústria e de Materiais de Construção"){
                        $cont_SIMC++;
                    }
                    
                    
                    
                    
                    $calc=0;
                    
                    list($horas,$minutos,$segundos) = explode(':', $ocorrencia['hr_registro']);
                    
                    $calc=$horas*3600+$minutos*60+$segundos;
                    
                    if( 0 <= $calc && $calc <= 21599){
                        $cont_Madrugada++;
                    }
                    if(21600 <= $calc && $calc <= 43199){
                        $cont_Dia++;
                    }
                    if(43200 <= $calc && $calc <= 64799){
                        $cont_Tarde++;
                    }
                    if(64800 <= $calc && $calc <= 86399){
                        $cont_Noite++;
                    }
                    
                    
                    
                    
                    
                    if($ocorrencia["tipo"] == "Perda"){
                        $cont_Perda++;
                    }else{
                        $cont_Assalto++;
                    }
                }
                ?>
            </tbody>
        </table>
        <br>
        <div class="grafico" style="">
            <center><div id="piechart" style="height: 450px; width: 100%;"></div> </center>       
            <left><div id="piechartHora" style=""></div></left>
            <right><div id="piechartTipo" style=""></div></right>
        </div>
    </body>
   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
          google.charts.load('current', {'packages':['corechart']});
          google.charts.setOnLoadCallback(drawChart);

          function drawChart() {

            var data = google.visualization.arrayToDataTable([
              ['localizacao', 'quatidade'],
              ['Ceilândia Centro',     <?php echo $cont_ceicentro; ?>],
              ['Ceilândia Norte',      <?php echo $cont_ceinorte; ?>],
              ['Ceilândia Sul',      <?php echo $cont_ceisul; ?>],
              ['Expansão do Setor O',      <?php echo $cont_expanSetorO; ?>],
              ['Guariroba',      <?php echo $cont_guariroba; ?>],
              ['Incra(Ceilândia)',  <?php echo $cont_incra; ?>],
              ['Por do Sol', <?php echo $cont_porsol; ?>],
              ['P Norte', <?php echo $cont_pnorte; ?>],
              ['P Sul', <?php echo $cont_psul; ?>],
              ['QNQ', <?php echo $cont_QNQ; ?>],
              ['QNR', <?php echo $cont_QNR; ?>],
              ['Setor Habitacional Sol Nascente', <?php echo $cont_SolNascente; ?>],
              ['Setor O', <?php echo $cont_setorO; ?>],
              ['Setor Privê', <?php echo $cont_setorPrive; ?>],
              ['Setores de Indústria e de Materiais de Construção',    <?php echo $cont_SIMC; ?>]
            ]);

            var options = {
              title: 'Porcentagem das regiões mais perigosas'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
          }
    </script>
   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
          google.charts.load('current', {'packages':['corechart']});
          google.charts.setOnLoadCallback(HORA);

          function HORA() {

            var hora = google.visualization.arrayToDataTable([
              ['hr_registro', 'quatidade'],
              ['Madrugada', <?php echo $cont_Madrugada ?>],
              ['Dia', <?php echo $cont_Dia ?>],
              ['Tarde', <?php echo $cont_Tarde ?>],
              ['Noite', <?php echo $cont_Noite ?>]
            ]);

            var options = {
              title: 'Horário'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechartHora'));

            chart.draw(hora, options);
          }
    </script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
          google.charts.load('current', {'packages':['corechart']});
          google.charts.setOnLoadCallback(tipo);

          function tipo() {

            var hora = google.visualization.arrayToDataTable([
              ['tipo', 'quatidade'],
              ['Perda', <?php echo $cont_Perda ?>],
              ['Assalto', <?php echo $cont_Assalto ?>]
            ]);

            var options = {
              title: 'Tipo'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechartTipo'));

            chart.draw(hora, options);
          }
    </script>
</html>
