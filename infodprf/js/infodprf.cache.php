<?php

/**
 * DPRF.info
 * Javascript responsável pela chamada de criação do cache
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
    
    header("content-type: application/javascript; charset=iso-8859-1");

    require_once '../../infodprf.class.php';

    $infoDPRF = new infoDPRF;  
    
    // Configura a classe para o período atual
    $infoDPRF->configure();


?>
$(document).ready(function () {

		$('.progress .bar.text-label-top').progressbar({
            update: function (current_percentage) {
                $('#label-update1').text(current_percentage +'%');
                if(current_percentage > 25){
                    $('.help-block').text('Agrupando as informações...');
                }
            },
            done: function (current_percentage) {
                $('.help-block').text('Salvando resultados...');
            }
        });
        
        $('.help-block').text('Conectando ao banco de dados...');
  
        $.ajax({
            url: "/infodprf.cache.create.php?tp_periodo=<?php echo $infoDPRF->Tipo_Periodo; ?>&periodo=<?php echo $infoDPRF->Periodo; ?>&ano=<?php echo $infoDPRF->Ano; ?>&mes=<?php echo $infoDPRF->Mes; ?>&dia=<?php echo $infoDPRF->Dia; ?>",
            type: "GET",
            timeout: 190000,
            success: function(response) { 
                $('.help-block').text('Concluído.');
                if(response == 'ok'){
                    location.reload();
                } else if(response == 'nenhum_resultado'){
                    document.location = '/NotFound';
                }
            },
            error: function(x, t, m) {
                if(t==="timeout") {
                    location.reload();
                } else {
                    alert(x);
                    alert(t);
                    alert(m);
                }
            }
        });
        
});