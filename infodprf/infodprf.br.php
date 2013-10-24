<?php

/**
 * DPRF.info
 * Página com o resumo da rodovia escolhida
 * 
 * @author Mário Pácio <mario.pacio@gmail.com>
 * @copyright 2013
 * @version 1.0
 * @package DPRF.info
 * @license AGPLv3 - http://www.gnu.org/licenses/agpl-3.0.html
 * 
 */
 
?>
            <!-- cabeçalho -->
            <div class="row-fluid page-head">
                <div class="qrcode"><a href="#QRCode" data-toggle="modal" class="Ltip" title="Não sabe o que é? Clique e veja."><img src="<?php echo $infoDPRF->QRCode('1'); ?>" /></a></div>
                <h2 class="page-title"><i class="fontello-icon-monitor"></i> Bem-vindo(a) <small class="hide-x2small">ao aplicativo DPRF.info</small></h2>
                <p class="pagedesc visible-desktop visible-tablet">Estatísticas de ocorrências em rodovias federais a partir de 2007. <a href="<?php echo $Url_Base; ?>About">Mais..</a></p>
                <div class="page-bar">
                    <ul class="nav nav-tabs pull-left">
                        <li id="info-tab" class="active"><a href="#Info" data-toggle="tab"><i class="aweso-icon-tasks"></i> Informações</a></li>
                        <li id="escolher-tab" class="hidden-phone"><a href="#tperiodo" data-toggle="tab"><i class="aweso-icon-refresh"></i> Alterar período</a></li>
                    </ul>
                    <ul class="nav nav-dropdown pull-left visible-phone">
                        <li class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle" href="#">Mais <span class="hide-x4small">ações</span> <i class="fontello-icon-down-open"></i></a>
                            <ul class="dropdown-menu nav">
                                <li><a href="#tperiodo" data-toggle="tab">Alterar período</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- fim cabeçalho -->
            
            <div id="page-content" class="page-content tab-content">
            
                    <div class="tab-pane active" id="Info">
                        <section>
                            <div class="row-fluid margin-top20">
                                <div class="span12 well <?php echo $infoDPRF->theme['well']; ?>">
                                
                                <h3>
                                    <i class="fontello-icon-road"></i>BR-<?php echo $infoDPRF->BR; ?> <small><?php echo (($infoDPRF->Tipo_Periodo == 'Anual') ? 'Relatório anual de ' . $infoDPRF->Legenda_Periodo : $infoDPRF->Legenda_Periodo); ?></small>
                                </h3>
                                <?php
                                    $Resumo_BR = $infoDPRF->getBRDescription($infoDPRF->BR);
                                    if($Resumo_BR):
                                ?>
                                <p class="pagedesc">
                                    <?php echo $Resumo_BR; ?> 
                                    <a href="http://pt.wikipedia.org/wiki/BR-<?php echo $Rodovia; ?>" target="_blank">Wikipedia<i class="fontello-icon-right-open"></i></a> 
                                    
                                </p>
                                <?php endif; ?>
                                
                                <div class="tabbable tabbable-bordered tabs-top <?php echo $infoDPRF->theme['tabbable']; ?>">
                                
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#com_ocorrencias" data-toggle="tab"><?php echo $infoDPRF->Legenda_Periodo; ?></a></li>
                                </ul>
                                                    
                                <div class="tab-content">
                                
                                <div class="tab-pane active" id="com_ocorrencias">
                                                        
                                <table class="table table-condensed rodovias">
                                
                                <?php

                                
                                    $tipo_rodovia = '';
                                    $rodovia_com_ocorrencias = '';
                                    $rodovia_sem_ocorrencias = '';
                                    
                                    $sql_rodovias = mysql_query("select * from infodprf_rodovias order by num_rodovia asc");
                                    
                                    foreach($infoDPRF->resultados['LOCALBR']['BR_UF'] as $BR_UF => $Total){
                                        
                                          $BR_UF = explode('-', $BR_UF);
                         
                                          if(substr($BR_UF[1], 0, 3) == $infoDPRF->BR){

                                              $conteudo =
                                                     '<tr>
                                                        <td>
                                                            <strong class="f16">
                                                                <a href="'. $Url_Base .'BR-'.$infoDPRF->BR.'/'.substr($BR_UF[1], -2).'">
                                                                    BR-'.$infoDPRF->BR.' / <span class="destaque">'.substr($BR_UF[1], -2).'</span>
                                                                </a>
                                                            </strong>';
                                                            
                                                            $conteudo .= ' <i class="fontello-icon-right-open"></i> 
                                                            <a href="'. $Url_Base .'BR-'.$infoDPRF->BR.'/'.substr($BR_UF[1], -2).'"><em>'. number_format($Total, 0, '', '.') . (($Total > 1) ? ' ocorrências' : 'ocorrência').'</em></a>';
    
                                              $conteudo .= '</td></tr>';
    
                                              $rodovia_com_ocorrencias .= $conteudo;
                                          
                                          }

                                    }

                                    echo $rodovia_com_ocorrencias;

                                    echo '</tbody>
                                          </table>';
                                                                
                                ?>
                                
                                </div>

                                </div>
                                </div>
                                </div>
                                
                            </div>
                            
                        </section>

                </div>
                
                <?php require_once('infodprf/infodprf.include.periodo.php'); ?>
                <div class="tab-pane" id="tperiodo">
                        <section>
                            <!-- row -->
                            <div class="row-fluid margin-top20">
                                <!-- span12 well -->
                                <div class="span12 well <?php echo $infoDPRF->theme['well']; ?>">
                                        <!-- row -->
                                        <div class="row-fluid">
                                            <div class="span12">
                                                <h3><i class="aweso-icon-refresh"></i> &nbsp;Alterar período</h3>
                                                <p class="pagedesc">Selecione abaixo o período que você deseja filtrar as rodovias com ocorrências.</p>
                                            </div>
                                        </div>
                                        <!-- //row -->
                                        <!-- row -->
                                        <div class="row-fluid">
                                            <div class="span6 grider"><?php echo $coluna_1; ?></div>
                                            <div class="span6 grider"><?php echo $coluna_2; ?></div>
                                        </div>
                                        <!-- //row -->
                                </div>
                                <!-- //span12 well -->
                            </div>
                            <!-- //row -->
                        </section>
                </div>

             </div>
