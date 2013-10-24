<?php

/**
 * DPRF.info
 * Página amigável responsável pela chamada de criação do cache
 * 
 * @author Mário Pácio <mario.pacio@gmail.com>
 * @copyright 2013
 * @version 1.0
 * @package DPRF.info
 * @license AGPLv3 - http://www.gnu.org/licenses/agpl-3.0.html
 * 
 */


    if($infoDPRF->Tipo_Periodo == 'Anual')      $css_tempo = '90';
    if($infoDPRF->Tipo_Periodo == 'Semestre')   $css_tempo = '30';
    if($infoDPRF->Tipo_Periodo == 'Trimestre')  $css_tempo = '15';
    if($infoDPRF->Tipo_Periodo == 'Mensal')     $css_tempo = '8';

?>

            <!-- cabeçalho -->
            <div class="row-fluid page-head">
                <!--div class="qrcode"><a href="#QRCode" data-toggle="modal" class="Ltip" title="Não sabe o que é? Clique e veja."><img src="<?php echo $infoDPRF->QRCode('1'); ?>" /></a></div-->
                <h2 class="page-title"><i class="fontello-icon-monitor"></i> Bem-vindo(a) <small class="hide-x2small">ao aplicativo DPRF.info</small></h2>
                <p class="pagedesc visible-desktop visible-tablet">Estatísticas de ocorrências em rodovias federais a partir de 2007. <a href="<?php echo $Url_Base; ?>About">Mais..</a></p>
                <div class="page-bar">
                    <ul class="nav nav-tabs pull-left">
                        <li id="info-tab" class="active"><a href="#Info" data-toggle="tab"><i class="aweso-icon-tasks"></i> Informações</a></li>
                    </ul>
                </div>
            </div>
            <!-- fim cabeçalho -->
            
            <div id="page-content" class="page-content">

                        <section>
                            <div class="row-fluid margin-top20">
                                <div class="span12 well <?php echo $infoDPRF->theme['well']; ?>" id="conteudo_cache">
                                            
                                            <h3>
                                                <i class="fontello-icon-chart-bar-3"></i>
                                                <span>Buscando informações...</span>
                                            </h3>
                                            
                                            <div class="progress-group">
                                            
                                                <div class="progress progress-striped active filled4">
                                                    <div class="filler">
                                                        <div class="bar text-label-top s<?php echo $css_tempo; ?>-ease-in-out" data-percentage="95"></div>
                                                    </div>
                                                </div>

                                                <div class="label-field">
                                                    <span id="label-update1"></span>
                                                    <span id="label-done1" class="blueboo"></span>
                                                    <span class="help-block pull-right"></span>
                                                </div>
                                                
                                            </div>

                                </div>
                                
                            </div>
                            
                        </section>

             </div>