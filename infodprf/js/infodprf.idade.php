<?php

/**
 * DPRF.info
 * Javascript responsável pela criação dos gráficos de estatística por faixa etária do condutor
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

?>

$(document).ready(function () {
        dashboard_A_chart.SexoCondutores();
});

dashboard_A_chart = {
        
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




