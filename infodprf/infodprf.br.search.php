<?php

/**
 * DPRF.info
 * Página com o índice das rodovias
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
                        <li class="hidden-phone"><a href="<?php echo $Url_Base; ?><?php echo $infoDPRF->URL; ?>"><i class="aweso-icon-circle-arrow-left"></i><?php echo $infoDPRF->Legenda_Periodo; ?></a></li>
                        <li id="escolher-tab" class="hidden-phone"><a href="#tperiodo" data-toggle="tab"><i class="aweso-icon-refresh"></i>Alterar período</a></li>
                    </ul>
                    <ul class="nav nav-dropdown pull-left visible-phone">
                        <li class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle" href="#">Mais <span class="hide-x4small">ações</span> <i class="fontello-icon-down-open"></i></a>
                            <ul class="dropdown-menu nav">
                                <li><a href="<?php echo $Url_Base; ?><?php echo $infoDPRF->URL; ?>"><i class="aweso-icon-circle-arrow-left"></i><?php echo $infoDPRF->Legenda_Periodo; ?></a></li>
                                <li><a href="#tperiodo" data-toggle="tab"><i class="aweso-icon-refresh"></i>Alterar período</a></li>
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
                                    <i class="fontello-icon-road"></i>Índice de rodovias <small><?php echo $infoDPRF->Legenda_Periodo; ?></small>
                                </h3>
                                
                                <p class="pagedesc">Conheça todas as rodovias federais com ocorrências.</p>
                                
                                <div class="tabbable tabbable-bordered tabs-top <?php echo $infoDPRF->theme['tabbable']; ?>">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#com_ocorrencias" data-toggle="tab">Com ocorrências</a></li>
                                    <li><a href="#sem_ocorrencias" data-toggle="tab">Sem ocorrências</a></li>
                                </ul>
                                
                                <div class="tab-content">
                                
                                <div class="tab-pane active" id="com_ocorrencias">
                                                        
                                <table class="table table-condensed rodovias">
                                
                                <?php

                                
                                    $tipo_rodovia = '';
                                    $rodovia_com_ocorrencias = '';
                                    $rodovia_sem_ocorrencias = '';
                                    
                                    $sql_rodovias = mysql_query("select * from infodprf_rodovias order by num_rodovia asc");
                                                                        
                                    while($rs = mysql_fetch_object($sql_rodovias)){
                                                                        
                                          if($tipo_rodovia != $rs->tipo_rodovia){
                                            
                                            if($rs->tipo_rodovia == 0){
                                                $title_rodovia = 'Rodovias radiais';
                                                $desc_rodovia = 'As rodovias radiais partem da capital federal em direção aos extremos do país. <a href=\'http://pt.wikipedia.org/wiki/Rodovia_radial\' target=\'_blank\'>Wikipedia<i class=\'fontello-icon-right-open\'></i></a>';
                                            } else
                                            if($rs->tipo_rodovia == 1){
                                                $title_rodovia = 'Rodovias longitudinais';
                                                $desc_rodovia = 'São rodovias que cortam o país na direção norte-sul. <a href=\'http://pt.wikipedia.org/wiki/Rodovia_longitudinal\' target=\'_blank\'>Wikipedia<i class=\'fontello-icon-right-open\'></i></a>';
                                            } else
                                            if($rs->tipo_rodovia == 2){
                                                $title_rodovia = 'Rodovias transversais';
                                                $desc_rodovia = 'São rodovias que cortam o país na direção leste-oeste. <a href=\'http://pt.wikipedia.org/wiki/Rodovia_transversal\' target=\'_blank\'>Wikipedia<i class=\'fontello-icon-right-open\'></i></a>';
                                            } else 
                                            if($rs->tipo_rodovia == 3){
                                                $title_rodovia = 'Rodovias diagonais';
                                                $desc_rodovia = 'São rodovias que podem apresentar dois modos de orientação: noroeste-sudeste ou nordeste-sudoeste. <a href=\'http://pt.wikipedia.org/wiki/Rodovia_diagonal\' target=\'_blank\'>Wikipedia<i class=\'fontello-icon-right-open\'></i></a>';
                                            } else 
                                            if($rs->tipo_rodovia == 4){
                                                $title_rodovia = 'Rodovias de ligação';
                                                $desc_rodovia = 'Rodovias de ligação apresentam-se em qualquer direção. <a href=\'http://pt.wikipedia.org/wiki/Rodovia_de_liga%C3%A7%C3%A3o\' target=\'_blank\'>Wikipedia<i class=\'fontello-icon-right-open\'></i></a>';
                                            } else 
                                            if($rs->tipo_rodovia == 6){
                                                $title_rodovia = 'Rodovias de pouca extensão';
                                                $desc_rodovia = 'Existem algumas rodovias com a nomenclatura BR-6xx, estas são de pouca extensão.';
                                            }
                                          
                                            $cabecalho =
                                                 '<thead>
                                                    <tr>
                                                        <th scope="col">
                                                            '.$title_rodovia.' 
                                                            <span class="help-inline help-icon" rel="popover" data-content="'.$desc_rodovia.'" data-original-title="'.$title_rodovia.'">
                                                                <i class="fontello-icon-help-circle"></i>
                                                            </span>
                                                        </th>
                                                    </tr>
                                                  </thead>
                                                  <tbody>';
                                                  
                                                  
                                          }
                                          //'.(($resumo_br) ? 'rel="popover-hover" data-content="'.$resumo_br.'" data-original-title="BR-'.$rs->num_rodovia.'"' : '').'
                                          $conteudo =
                                                 '<tr>
                                                    <td>
                                                        <a href="javascript:void(0);" class="RodoviaModal" data-toggle="modal" data-rodovia="'.$rs->num_rodovia.'">
                                                            <strong class="f16 destaque"><i class="fontello-icon-info-circle f12"></i> BR-'.$rs->num_rodovia.'</strong>
                                                        </a> ';
                                                        
                                                        $estados = array();
                                                        
                                                        foreach($infoDPRF->uf_estados as $UF => $Estado){
                                                            
                                                            $total_br_uf = $infoDPRF->resultados['LOCALBR']['BR_UF']['BR-'.$rs->num_rodovia.'/'.$UF];
                                                            
                                                            if($total_br_uf > 0){
                                                                array_push($estados, '<a href="'. $Url_Base .'BR-'.$rs->num_rodovia.'/'.$UF.'/'.$infoDPRF->URL.'" class="Ttip" title="'.(($total_br_uf > 1) ? 'Foram registradas ' : 'Foi registrada ').$total_br_uf.(($total_br_uf > 1) ? ' ocorrências ' : ' ocorrência').' na Rodovia BR-'.$rs->num_rodovia.'/'.$Estado.'"><strong>'.$UF.'</strong> <span class="'.(($infoDPRF->theme_name == 'dark') ? 'cCCC' : 'c666').' f11">('.$total_br_uf.')</span></a>');
                                                            }
                                                            
                                                        }
                                                        
                                                        if($estados){
                                                            $conteudo .= ' <i class="fontello-icon-right-open"></i> ';
                                                            $conteudo .= implode(', ', $estados);
                                                        } else {
                                                            $conteudo .= ' <i class="fontello-icon-right-open"></i> <em class="'.(($infoDPRF->theme_name == 'dark') ? 'cAAA' : 'c666').'">Nenhum registro no período.</em>';
                                                        }

                                          $conteudo .= '</td></tr>';
                                                
                                          $rodovia_com_ocorrencias .= $cabecalho;
                                          $rodovia_sem_ocorrencias .= $cabecalho;
                                          
                                          if($estados){
                                             $rodovia_com_ocorrencias .= $conteudo;
                                          } else {
                                            $rodovia_sem_ocorrencias .= $conteudo;
                                          }

                                          $cabecalho = '';
                                          $tipo_rodovia = $rs->tipo_rodovia;

                                    }

                                    echo $rodovia_com_ocorrencias;

                                    echo '</tbody>
                                          </table>';
                                                                
                                ?>
                                
                                </div>

                                <div class="tab-pane" id="sem_ocorrencias">
                                                        
                                    <table class="table table-condensed rodovias">
                                        <?php echo $rodovia_sem_ocorrencias; ?>
                                    </table>

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
