<?php
    
/**
 * DPRF.info
 * Javascript responsável pela criação dos gráficos de estatística com mapa de localização da rodovia/estado
 * 
 * @author Mário Pácio <mario.pacio@gmail.com>
 * @copyright 2013
 * @version 1.0
 * @package DPRF.info
 * @license AGPLv3 - http://www.gnu.org/licenses/agpl-3.0.html
 * 
 */
    
    ob_start();
    
    ini_set('memory_limit', '-1');
    set_time_limit(0);
    
    header("content-type: application/javascript");

    require_once '../../infodprf.class.php';

    $infoDPRF = new infoDPRF;  
    
    // Configura a classe para o período atual
    $infoDPRF->configure();

    $Dados = $infoDPRF->getDataFile('../../'.$_GET['cache']);

    if(!$Dados) die('Arquivo não encontrado.');
    
    $ObjTrecho = $infoDPRF->resultados['LOCALBR']['BR-'.$infoDPRF->BR][$infoDPRF->UF];

    $ocorrencias = array();
    
    if($infoDPRF->Tipo_Periodo == 'Anual'){

        $mode = 'categories';
        for($mes_atual = 1; $mes_atual <= 12; $mes_atual++){
            // Adiciona o zero ao mes menor que 10
            $mes_atual_zeros = (($mes_atual < 10) ? '0'.$mes_atual : $mes_atual);
            // Total 
            $total = intval($ObjTrecho['Anual_Mensal'][$infoDPRF->Ano.$mes_atual_zeros]);
            $ocorrencias[$infoDPRF->Ano.$mes_atual_zeros] = '["'.$infoDPRF->getMes($mes_atual_zeros).'", '.$total.']';

        }

    } else    
    if($infoDPRF->Tipo_Periodo == 'Semestre'){
        
        $mode = 'categories';
        
        $contador_1 = $contador_2 = $contador_3 = $contador_4 = $contador_5 = $contador_6 = $contador_7 = $contador_8 = $contador_9 = $contador_10 = $contador_11 = $contador_12 = false; 
        
        foreach($ObjTrecho[$infoDPRF->Tipo_Periodo] as $data => $total){
            
            $ano = substr($data, 2, 2);
            $mes = substr($data, 4, 2);
            
            if($mes == '01' || $mes == '07') $contador_1  = true;
            if($mes == '02' || $mes == '08') $contador_2  = true;
            if($mes == '03' || $mes == '09') $contador_3  = true;
            if($mes == '04' || $mes == '10') $contador_4  = true;
            if($mes == '05' || $mes == '11') $contador_5  = true;
            if($mes == '06' || $mes == '12') $contador_6  = true;

            $ocorrencias[$ano.$mes] = '["'.$infoDPRF->getMes($mes).'", '.$total.']';
        }
        
        if(!$contador_1){
            switch($infoDPRF->Periodo){
                case 1: $ocorrencias[$ano.'01'] = '["'.$infoDPRF->getMes('01').'", 0]'; break;
                case 2: $ocorrencias[$ano.'07'] = '["'.$infoDPRF->getMes('07').'", 0]'; break;
            }
        }
        if(!$contador_2){
            switch($infoDPRF->Periodo){
                case 1: $ocorrencias[$ano.'02'] = '["'.$infoDPRF->getMes('02').'", 0]'; break;
                case 2: $ocorrencias[$ano.'08'] = '["'.$infoDPRF->getMes('08').'", 0]'; break;
            }
        }
        if(!$contador_3){
            switch($infoDPRF->Periodo){
                case 1: $ocorrencias[$ano.'03'] = '["'.$infoDPRF->getMes('03').'", 0]'; break;
                case 2: $ocorrencias[$ano.'09'] = '["'.$infoDPRF->getMes('09').'", 0]'; break;
            }
        }
        if(!$contador_4){
            switch($infoDPRF->Periodo){
                case 1: $ocorrencias[$ano.'04'] = '["'.$infoDPRF->getMes('04').'", 0]'; break;
                case 2: $ocorrencias[$ano.'10'] = '["'.$infoDPRF->getMes('10').'", 0]'; break;
            }
        }
        if(!$contador_5){
            switch($infoDPRF->Periodo){
                case 1: $ocorrencias[$ano.'05'] = '["'.$infoDPRF->getMes('05').'", 0]'; break;
                case 2: $ocorrencias[$ano.'11'] = '["'.$infoDPRF->getMes('11').'", 0]'; break;
            }
        }
        if(!$contador_6){
            switch($infoDPRF->Periodo){
                case 1: $ocorrencias[$ano.'06'] = '["'.$infoDPRF->getMes('06').'", 0]'; break;
                case 2: $ocorrencias[$ano.'12'] = '["'.$infoDPRF->getMes('12').'", 0]'; break;
            }
        }
        
    } else 
    if($infoDPRF->Tipo_Periodo == 'Trimestre'){
        
        $mode = 'categories';
        
        $contador_1 = $contador_2 = $contador_3 = false; 
        
        foreach($ObjTrecho[$infoDPRF->Tipo_Periodo] as $data => $total){
            
            $ano = substr($data, 2, 2);
            $mes = substr($data, 4, 2);
            
            if($mes == '01' || $mes == '04' || $mes == '07' || $mes == '10') $contador_1 = true;
            if($mes == '02' || $mes == '05' || $mes == '08' || $mes == '11') $contador_2 = true;
            if($mes == '03' || $mes == '06' || $mes == '09' || $mes == '12') $contador_3 = true;
            
            $ocorrencias[$ano.$mes] = '["'.$infoDPRF->getMes($mes).'", '.$total.']';
            
        }
        if(!$contador_1){
            switch($infoDPRF->Periodo){
                case 1: $ocorrencias[$ano.'01'] = '["'.$infoDPRF->getMes('01').'", 0]'; break;
                case 2: $ocorrencias[$ano.'04'] = '["'.$infoDPRF->getMes('04').'", 0]'; break;
                case 3: $ocorrencias[$ano.'07'] = '["'.$infoDPRF->getMes('07').'", 0]'; break;
                case 4: $ocorrencias[$ano.'10'] = '["'.$infoDPRF->getMes('10').'", 0]'; break;
            }
        }
        if(!$contador_2){
            switch($infoDPRF->Periodo){
                case 1: $ocorrencias[$ano.'02'] = '["'.$infoDPRF->getMes('02').'", 0]'; break;
                case 2: $ocorrencias[$ano.'05'] = '["'.$infoDPRF->getMes('05').'", 0]'; break;
                case 3: $ocorrencias[$ano.'08'] = '["'.$infoDPRF->getMes('08').'", 0]'; break;
                case 4: $ocorrencias[$ano.'11'] = '["'.$infoDPRF->getMes('11').'", 0]'; break;
            }
        }
        if(!$contador_3){
            switch($infoDPRF->Periodo){
                case 1: $ocorrencias[$ano.'03'] = '["'.$infoDPRF->getMes('03').'", 0]'; break;
                case 2: $ocorrencias[$ano.'06'] = '["'.$infoDPRF->getMes('06').'", 0]'; break;
                case 3: $ocorrencias[$ano.'09'] = '["'.$infoDPRF->getMes('09').'", 0]'; break;
                case 4: $ocorrencias[$ano.'12'] = '["'.$infoDPRF->getMes('12').'", 0]'; break;
            }
        }
        
    } else 
    if($infoDPRF->Tipo_Periodo == 'Mensal'){
        
        $mode = 'time';
        $contador = 0;
        // Identifica quantos dias tem no mes atual         
        $dias_mes = cal_days_in_month(CAL_GREGORIAN, $infoDPRF->Mes, $infoDPRF->Ano);
        // Percorre os dias do mês
        for($dia_atual = 1; $dia_atual <= $dias_mes; $dia_atual++){
            // Adiciona o zero ao dia menor que 10
            $dia_atual_zeros = (($dia_atual < 10) ? '0'.$dia_atual : $dia_atual);
            $data_time = strtotime("{$infoDPRF->Ano}-{$infoDPRF->Mes}-{$dia_atual_zeros} 00:00:00 GMT").'000';
            // Se for o primeiro objeto, define esta data como inicial
            if($contador == 0) 
            $Faixa_Inicial = $data_time;
            // Define o ultimo registro como data final
            $Faixa_Final = $data_time;
            // Recupera o total do dia
            $total = intval($ObjTrecho['Diario'][$infoDPRF->Ano.$infoDPRF->Mes.$dia_atual_zeros]);
            // Adiciona a data no array com as ocorrencias
            $ocorrencias[] = '['.$data_time.', '.$total.']';
            $contador++;
        }
        
    } else 
    if($infoDPRF->Tipo_Periodo == 'Diario'){
        
        $mode = 'time';
        // Percorre as 24 horas do dia
        for($hora = 0; $hora <= 23; $hora++){
            $ano = $infoDPRF->Ano;
            $mes = $infoDPRF->Mes;
            $dia = $infoDPRF->Dia;
            $hora = ((strlen($hora) == 1) ? '0'.$hora : $hora);
            // Recupera o total do horario
            $total = intval($ObjTrecho['Horario'][$hora]);
            // Cria a data timestamp
            $data_time = strtotime("$ano-$mes-$dia $hora:00:00 GMT").'000';
            // Se for o primeiro objeto, define esta data como inicial
            if($contador == 0) 
            $Faixa_Inicial = $data_time;
            // Define o ultimo registro como data final
            $Faixa_Final = $data_time;
            // Adiciona a data no array com as ocorrencias
            $ocorrencias[] = '['.$data_time.', '.$total.']';
            // contador de registros
            $contador++;
        }

    }
    
    ksort($ocorrencias);
    $ocorrencias = implode(",", $ocorrencias);

?>
$(document).ready(function () {
        dashboard_A_chart.chartVisit();
		dashboard_A_chart.sparkLine();
        dashboard_A_chart.SexoCondutores();
});

dashboard_A_chart = {

        chartVisit: function () {
				var elem = $('#dashChartVisitors');
			
                var ocorrencias = [<?php echo $ocorrencias; ?>];

                var options = {
                        colors: ["<?php echo ($_GET['theme_name'] == 'dark') ? '#ff8100' : '#5e8fb9'; ?>"],
                        legend: {
                                show: true,
                                noColumns: 6, // number of colums in legend table
                                labelFormatter: null, // fn: string -> string
                                labelBoxBorderColor: false,
                                container: null, // container (as jQuery object) to put legend in, null means default on top of graph
                                margin: 0,
                                backgroundColor: false
                        },
                        plotOffset: { left: 0, right: 0, top: 0, bottom: 0},
                        series: {
                                lines: {
                                        show: true,
                                        lineWidth: 2,
                                        fill: true
                                },
                                points: {
                                        show: true,
                                        fillColor: "#ffffff",
                                        radius: 3.5,
                                        lineWidth: 1.5
                                },
								grow: {
                                        active: true
                                }
                        },
                        xaxis: {
                                mode: "<?php echo $mode; ?>",
                                font: {
                                    weight: "bold"
                                },
                                color: "#D6D8DB",
                                tickColor: "rgba(237,194,64,0.25)",
                                <?php echo (($Faixa_Inicial) ? 'min: "'.$Faixa_Inicial.'",' : ''); ?>
                                <?php echo (($Faixa_Final) ? 'max: "'.$Faixa_Final.'",' : ''); ?>
                                tickLength: 7
                        },
                        grid: {
                                color: "#D6D8DB",
                                tickColor: "<?php echo ($_GET['theme_name'] == 'dark') ? 'rgba(255,255,255,0.10)' : 'rgba(0,0,0,0.10)'; ?>",
                                borderWidth: 0,
                                //markings: weekendAreas,
                                markingsColor: "rgba(255,255,255,0.05)",
                                // interactive stuff
                                clickable: false,
                                hoverable: true
                        }
                };

                var plot = $.plot(elem, [
                {
                        data: ocorrencias,
                        label: "ocorrências"
                }
                /*, {
                        data: mortes,
                        label: "Mortes"
                }*/
                ], options);
 

                // tooltip
                elem.qtip({
                        prerender: true,
                        content: 'Carregando...', // Use a loading message primarily
                        position: {
                                viewport: $(window), // Keep it visible within the window if possible
                                target: 'mouse', // Position it in relation to the mouse
                                adjust: {
                                        x: 7
                                } // ...but adjust it a bit so it doesn't overlap it.
                        },
                        show: false, // We'll show it programatically, so no show event is needed
                        style: {
                                classes: 'ui-tooltip-shadow ui-tooltip-tipsy',
                                tip: false // Remove the default tip.
                        }
                });

                // Bind the plot hover
                elem.bind("plothover", function (event, coords, item) {
                        // Grab the API reference
                        var self = $(this),
                                api = $(this).qtip(),
                                previousPoint, content,

                                // Setup a visually pleasing rounding function
                                round = function (x) {
                                        return Math.round(x * 1000) / 1000;
                                };

                        // If we weren't passed the item object, hide the tooltip and remove cached point data
                        if(!item) {
                                api.cache.point = false;
                                return api.hide(event);
                        }

                        // Proceed only if the data point has changed
                        previousPoint = api.cache.point;
                        if(previousPoint !== item.dataIndex) {
                                // Update the cached point data
                                api.cache.point = item.dataIndex;
                                
                                var num = new NumberFormat();
                                                        
                                num.setInputDecimal('.');
                                num.setNumber(item.datapoint[1]);
                                num.setPlaces('0', false);
                                num.setCurrencyValue('');
                                num.setCurrency(false);
                                num.setCurrencyPosition(num.LEFT_OUTSIDE);
                                num.setNegativeFormat(num.LEFT_DASH);
                                num.setNegativeRed(false);
                                num.setSeparators(true, '.', ',');
                                var total = num.toFormatted();

                                // Setup new content
                                content = round(total) + ' ' + item.series.label;

                                // Update the tooltip content
                                api.set('content.text', content);

                                // Make sure we don't get problems with animations
                                api.elements.tooltip.stop(1, 1);

                                // Show the tooltip, passing the coordinates
                                api.show(coords);
                        }
                });

        },
		
		// Sparkline
        sparkLine: function () {
				$(".well-black .DSPLine").sparkline('html', {
						type: 'line',
						width: '100px',
						height: '20px',
						lineColor: '#ff8100',
						fillColor: '#875725',
						spotColor: false,
						minSpotColor: false,
						maxSpotColor: false,
                        numberDigitGroupSep: '.',
                        numberDecimalMark: '.',
                        tooltipFormat: '<span class="spark_desc"><span style="color: {{color}}">&#9679;</span> {{offset:offset}}</span> <br /> <span class="f16">{{y}}</span> <span class="f11 nobold">Ocorrências</span>',
                        tooltipValueLookups: {
                            'offset': SPARKLINE_DYNAMIC
                        }
				});
				$(".well-nice .DSPLine").sparkline('html', {
						type: 'line',
						width: '100px',
						height: '20px',
						lineColor: '#5e8fb9',
						fillColor: '#c8e1f6',
						spotColor: false,
						minSpotColor: false,
						maxSpotColor: false,
                        numberDigitGroupSep: '.',
                        numberDecimalMark: '.',
                        tooltipFormat: '<span class="spark_desc"><span style="color: {{color}}">&#9679;</span> {{offset:offset}}</span> <br /> <span class="f16">{{y}}</span> <span class="f11 nobold">Ocorrências</span>',
                        tooltipValueLookups: {
                            'offset': SPARKLINE_DYNAMIC
                        }
				})
        },
        
		SexoCondutores: function () {
				var elem = $('#SexoCondutores');
				
				var data = [{
						label: "H",
						data: <?php echo intval($ObjTrecho['SEXO']['M']); ?>
				}, {
						label: "M",
						data: <?php echo intval($ObjTrecho['SEXO']['F']); ?>
				}];
		
				var options = {
						legend: {
								show: false
						},
                        series: {
								pie: {
										show: true,
										radius: 0.8,
										innerRadius: 0.2,
										stroke: {
												color: '<?php echo ($_GET['theme_name'] == 'dark') ? '#323538' : '#f2f2f2'; ?>',
												width: 3
										},
										startAngle: 2,
										label: {
												show: true,
												formatter: function (label, series) {

                                                        var num = new NumberFormat();
                                                        
                                                        num.setInputDecimal('.');
                                                        num.setNumber(series.data[0][1]);
                                                        num.setPlaces('0', false);
                                                        num.setCurrencyValue('');
                                                        num.setCurrency(false);
                                                        num.setCurrencyPosition(num.LEFT_OUTSIDE);
                                                        num.setNegativeFormat(num.LEFT_DASH);
                                                        num.setNegativeRed(false);
                                                        num.setSeparators(true, '.', ',');
                                                        var total = num.toFormatted();
                                                        
                                                        var css = '';
                                                        if(label == 'M') var css = 'text-left';
                                                        if(label == 'F') var css = 'text-right';

                                                        return '<div class="padding5 opaci85 '+css+'">'+
                                                               '<div class="'+css+'" style="font-size: 20px;">' + Math.round(series.percent) + '%</div>' + 
                                                               '<div style="font-size: 12px;" class="text-center">' + total + '</div>' +
                                                               '</div>' ;
												}
										}
								},
								grow: {
										active: false
								},
						},
						grid: {
								hoverable: false,
								clickable: false
						},
						colors: [ "#016ba8", "#842f94"],						
                };
				
				$.plot(elem, data, options);
		}
};
<?php

    $conta_total_pontos = 0;
    $LOCAIS = array();
    
    if(count($ObjTrecho['LAT_LONG']) == 1) 
         $zoom = 12;
    else $zoom = 4;

    if($ObjTrecho['LAT_LONG']):
    
        foreach($ObjTrecho['LAT_LONG'] as $lat_long => $array_lat_long){
    
            $latitude_longitude = explode(',', $lat_long);
            $total = $array_lat_long['TOTAL'];
            
            if($conta_total_pontos == 0) {
                echo 'var lat_long_padrao = \''.$latitude_longitude[0].', '.$latitude_longitude[1].'\';';
                $lat_long_padrao = true;
            } 
            
            $calcular[] = array($latitude_longitude[0], $latitude_longitude[1]);
    
            foreach($array_lat_long['OCOID'] as $ID => $KM){
    
                $LOCAIS[] = array(
                        'lat' => $latitude_longitude[0],
                        'lon' => $latitude_longitude[1]
                );
                $conta_total_pontos++;
    
            }
    
        }
        
    endif;
    
    // $Center = GetCenterFromDegrees($calcular);
    // echo 'var lat_long_padrao = \''.$Center[0].', '.$Center[1].'\';'."\n"; 

    $Retorno = array(
        'count' => $conta_total_pontos,
        'locais' => $LOCAIS
    );
    
    if(!$lat_long_padrao) 
    echo 'var lat_long_padrao = "-18.8897636329999,-48.4375869749999"; ';
    echo 'var data = ' . json_encode($Retorno).'; ';
    echo 'var zoom_mapa = '.$zoom.'; ';

?>
<?php if($_GET['theme_name'] == 'dark'): ?>
var GoogleMapsStyle = 
[
{
    "featureType": "landscape.natural",
    "elementType": "geometry.fill",
    "stylers": [
        { "color": "#373b3e" }
    ]
},
{
"featureType": "water",
    "stylers": [
        { "color": "#666666" },
        { "saturation": 0 }
    ]
},
{
    "featureType": "road.arterial",
    "elementType": "geometry",
    "stylers": [
        { "color": "#333333" }
    ]
},
{
    "featureType": "road.local",
    "stylers": [
        { "color": "#444444" }
    ]
},
{
    "featureType": "transit.station.bus",
    "stylers": [
        { "saturation": -57 }
    ]
},
                  
{
    "featureType": "all",
    "elementType": "labels.text.fill",
    "stylers": [
            { "color": "#ffffff" }
    ]
},
{
    "featureType": "all",
    "elementType": "labels.text.stroke",
    "stylers": [
            { "color": "#222222" }
    ]
},
{
    "featureType": "road.highway",
    "elementType": "geometry",
    "stylers": [
      { "visibility": "on" },
      { "lightness": -21 },
      { "gamma": 4.49 },
      { "color": "#ffaa00" }
    ]
},
{
    "featureType": "administrative",
    "elementType": "labels.text.fill",
    "stylers": [
      { "visibility": "on" },
      { "color": "#ffffff" }
    ]
},{
    "featureType": "administrative",
    "elementType": "labels.text.stroke",
    "stylers": [
      { "visibility": "on" },
      { "color": "#211710" }
    ]
},
{
    "featureType": "poi",
    "stylers": [
        { "visibility": "off" }
    ]
}	
];
<?php else: ?>
var GoogleMapsStyle = 
[
{
    "featureType": "landscape.natural",
    "elementType": "geometry.fill",
    "stylers": [
        { "color": "#edeef5" }
    ]
},
{
"featureType": "water",
    "stylers": [
        { "color": "#d6d8e1" },
        { "saturation": 0 }
    ]
},
{
    "featureType": "road.arterial",
    "elementType": "geometry",
    "stylers": [
        { "color": "#ffffff" }
    ]
},
{
    "featureType": "road.local",
    "stylers": [
        { "color": "#ffffff" }
    ]
},
{
    "featureType": "transit.station.bus",
    "stylers": [
        { "saturation": -57 }
    ]
},
                  
{
    "featureType": "all",
    "elementType": "labels.text.fill",
    "stylers": [
            { "color": "#111111" }
    ]
},
{
    "featureType": "all",
    "elementType": "labels.text.stroke",
    "stylers": [
            { "color": "#ffffff" }
    ]
},
{
    "featureType": "road.highway",
    "elementType": "geometry",
    "stylers": [
      { "visibility": "on" },
      { "lightness": -21 },
      { "gamma": 4.49 },
      { "color": "#5e8fb9" }
    ]
},
{
    "featureType": "poi",
    "stylers": [
        { "visibility": "off" }
    ]
}	
];
<?php endif; ?>