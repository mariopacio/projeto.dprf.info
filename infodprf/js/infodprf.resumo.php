<?php

/**
 * DPRF.info
 * Javascript responsável pela criação dos gráficos de estatística do resumo completo do período selecionado
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
    
    $ocorrencias = array();
    $sparkline = array();
    
    /*
    if($infoDPRF->Tipo_Periodo == 'Anual'){
        $mode = 'categories';
        foreach($infoDPRF->resultados['Mensal'] as $data => $total){
            if(is_numeric($total)){
                $ano = substr($data, 2, 2);
                $mes = substr($data, 4, 2);
                $ocorrencias[$ano.$mes] = '["'.$infoDPRF->getMes($mes).'", '.$total.']';
            }
        }
    } else 
    */
    if($infoDPRF->Tipo_Periodo == 'Semestre'){
        $mode = 'categories';
        $contador = 0;
        foreach($infoDPRF->resultados[$infoDPRF->Tipo_Periodo] as $data => $total){
            if(is_numeric($total)){
                $ano = substr($data, 0, 4);
                $mes = substr($data, 4, 2);
                $sparkline[$ano.$mes] = $infoDPRF->getMesFull($mes) . ' de ' . $infoDPRF->Ano;
                $ocorrencias[$ano.$mes] = '["'.$infoDPRF->getMes($mes).'", '.$total.']';
                $contador++;
            }
        }
    } else 
    if($infoDPRF->Tipo_Periodo == 'Trimestre'){
        $mode = 'categories';
        foreach($infoDPRF->resultados[$infoDPRF->Tipo_Periodo] as $data => $total){
            if(is_numeric($total)){
                $ano = substr($data, 0, 4);
                $mes = substr($data, 4, 2);
                $sparkline[$ano.$mes] = $infoDPRF->getMesFull($mes) . ' de ' . $infoDPRF->Ano;
                $ocorrencias[$ano.$mes] = '["'.$infoDPRF->getMes($mes).'", '.$total.']';
            }
        }
    } else 
    if($infoDPRF->Tipo_Periodo == 'Mensal'){
        $contador = 0;
        $mode = 'time';
        ksort($infoDPRF->resultados['Diario']);
        foreach($infoDPRF->resultados['Diario'] as $data => $total){
            if(is_numeric($total)){
                $ano = substr($data, 2, 2);
                $mes = substr($data, 4, 2);
                $dia = substr($data, 6, 2);
                $data_time = strtotime("$ano-$mes-$dia 00:00:00 GMT").'000';
                if($contador == 0) 
                $Faixa_Inicial = $data_time;
                $Faixa_Final = $data_time;
                $sparkline[$data_time] = $dia . ' de ' . $infoDPRF->getMesFull($mes) . ' de ' . $infoDPRF->Ano;
                $ocorrencias[$data_time] = '['.$data_time.', '.$total.']';
                $contador++;
            }
        }
    } else 
    if($infoDPRF->Tipo_Periodo == 'Diario'){
        $mode = 'time';

        for($hora = 0; $hora <= 23; $hora++){
            
            $ano = $infoDPRF->Ano;
            $mes = $infoDPRF->Mes;
            $dia = $infoDPRF->Dia;
            $hora = ((strlen($hora) == 1) ? '0'.$hora : $hora);
            
            $total = intval($infoDPRF->resultados['Horario'][$hora]);
            
            $data_time = strtotime("$ano-$mes-$dia $hora:00:00 GMT").'000';
            
            if($contador == 0) 
            $Faixa_Inicial = $data_time;
            $Faixa_Final = $data_time;
            
            $sparkline[$data_time] = '~'.$hora.':00 horas';
            $ocorrencias[$data_time] = '['.$data_time.', '.$total.']';
            
            $contador++;
            
        }

    }

    
    /*
    foreach($infoDPRF->resultados[$infoDPRF->Tipo_Periodo] as $data => $total){
        if(is_numeric($total)){
            $ano = substr($data, 2, 2);
            $mes = substr($data, 4, 2);
            $ocorrencias[] = '["'.$infoDPRF->getMes($mes).'", '.$total.']';
        }
    }*/
    
    ksort($sparkline);
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
                //var mortes = [<?php echo $mortes; ?>];

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
                        series: {
                                lines: {
                                        show: true,
                                        lineWidth: 2,
                                        fill: true
                                },
                                points: {
                                        show: true,
                                        fillColor: "<?php echo ($_GET['theme_name'] == 'dark') ? '#ffffff' : '#ffffff'; ?>",
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
                                markingsColor: "<?php echo ($_GET['theme_name'] == 'dark') ? 'rgba(255,255,255,0.08)' : 'rgba(0,0,0,0.08)'; ?>",
                                clickable: false,
                                hoverable: true
                        }
                };

                var plot = $.plot(elem, [
                {
                        data: ocorrencias,
                        label: "Ocorrências"
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
		
		// Dashboard Sparkline
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
                            'offset': {
                                <?php
                                    $contador = 0;
                                    foreach($sparkline as $data => $legenda){
                                        echo $contador.": '{$legenda}'";
                                        if(count($sparkline) != ($contador + 1))
                                        echo ',';
                                        $contador++;
                                    }                                
                                ?>
                            }
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
                        tooltipFormat: '<span class="spark_desc">{{offset:offset}}</span> <br /> <span style="color: {{color}}">&#9679;</span> <span class="f16">{{y}}</span>',
                        tooltipValueLookups: {
                            'offset': {
                                <?php
                                    $contador = 0;
                                    foreach($sparkline as $data => $legenda){
                                        echo $contador.": '{$legenda}'";
                                        if(count($sparkline) != ($contador + 1))
                                        echo ',';
                                        $contador++;
                                    }                                
                                ?>
                            }
                        }
				})
        },
        
		SexoCondutores: function () {
				var elem = $('#SexoCondutores');
				
				var data = [{
						label: "H",
						data: <?php echo $infoDPRF->resultados['CONDUTORES']['SEXO']['M']; ?>
				}, {
						label: "M",
						data: <?php echo $infoDPRF->resultados['CONDUTORES']['SEXO']['F']; ?>
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
                                                               '<div class="'+css+'" style="width: 100%; font-size: 20px;">' + Math.round(series.percent) + '%</div>' + 
                                                               '<div style="width: 100%; font-size: 11px; color: #888" class="'+css+'">' + total + '</div>' +
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




