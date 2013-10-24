<?php

/**
 * DPRF.info
 * Página responsável pelo mapeamento das informações por trecho
 * 
 * @author Mário Pácio <mario.pacio@gmail.com>
 * @copyright 2013
 * @version 1.0
 * @package DPRF.info
 * @license AGPLv3 - http://www.gnu.org/licenses/agpl-3.0.html
 * 
 */

    $ObjTrecho = $infoDPRF->resultados['LOCALBR']['BR-'.$infoDPRF->BR][$infoDPRF->UF][$infoDPRF->Trecho];
    $ObjTrecho_Anterior = $infoDPRF_Anterior->resultados['LOCALBR']['BR-'.$infoDPRF->BR][$infoDPRF->UF][$infoDPRF->Trecho];

    ?>
            
            <div class="row-fluid page-head">
                <div class="qrcode"><a href="#QRCode" data-toggle="modal" class="Ltip" title="Não sabe o que é? Clique e veja."><img src="<?php echo $infoDPRF->QRCode('1'); ?>" /></a></div>
                <h2 class="page-title"><i class="fontello-icon-monitor"></i> Bem-vindo(a) <small class="hide-x2small">ao aplicativo DPRF.info</small></h2>
                <p class="pagedesc visible-desktop visible-tablet">Estatísticas de ocorrências em rodovias federais a partir de 2007. <a href="<?php echo $Url_Base; ?>About">Mais..</a></p>
                <div class="page-bar">
                    <ul class="nav nav-tabs pull-left">
                        <li id="info-tab" class="active"><a href="#Info" data-toggle="tab"><i class="aweso-icon-tasks"></i> Informações</a></li>
                        <li id="trecho-tab" class="hidden-phone"><a href="#ttrecho" data-toggle="tab"><i class="aweso-icon-refresh"></i> Alterar trecho</a></li>
                        <li id="periodo-tab" class="hidden-phone"><a href="#tperiodo" data-toggle="tab"><i class="aweso-icon-refresh"></i> Alterar período</a></li>
                    </ul>
                    <ul class="nav nav-dropdown pull-left visible-phone">
                        <li class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle" href="#">Mais <span class="hide-x4small">ações</span> <i class="fontello-icon-down-open"></i></a>
                            <ul class="dropdown-menu nav">
                                <li><a href="#ttrecho" data-toggle="tab">Alterar trecho</a></li>
                                <li><a href="#tperiodo" data-toggle="tab">Alterar período</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- // page head -->
            
            <div id="page-content" class="page-content tab-content">
            
                    <div class="tab-pane active" id="Info">
                    
                        <section>
                                                    
                            <div class="row-fluid margin-top20">
                                <div class="span12 well <?php echo $infoDPRF->theme['well']; ?>">
                                    <div class="row-fluid">
                                        <div class="span6 grider">
                                            <span class="h3_modelo f14">Período de pesquisa: <?php echo $infoDPRF->Legenda_Periodo; ?></span>
                                            <h3 class="l22">
                                                <i class="fontello-icon-road"></i>
                                                <a href="javascript:void(0);" class="RodoviaModal Ttip" data-toggle="modal" data-rodovia="<?php echo $infoDPRF->BR; ?>" title="Saiba um pouco mais sobre a rodovia BR-<?php echo $infoDPRF->BR; ?>">
                                                    BR-<?php echo $infoDPRF->BR; ?>/<?php echo $infoDPRF->UF; ?>
                                                </a> 
                                                <small>Km <?php echo $infoDPRF->Trecho; ?></small>
                                            </h3>

                                            <p class="pagedesc">O gráfico abaixo representa o comparativo de ocorrências neste trecho.</p>
                                            
                                            <hr class="margin-mx" />
                                            
                                            <div id="dashChartVisitors" style="width:100%; height:170px" class="margin-bottom32"></div>
                                            
                                            <hr class="margin-mx" />
                                            
                                            <div class="row-fluid margin-top20">
                                            
                                                <div class="span12">

                                                    <div class="row-fluid">
                                                    
                                                        <!-- // Ocorrencias -->
                                                        <div class="span6 grider-item">
                                                            <div class="statistic-box well <?php echo $infoDPRF->theme['well']; ?> well-impressed">
                                                                <div class="section-title">
                                                                    <h5><i class="fontello-icon-chart"></i> Total de ocorrências</h5>
                                                                </div>
                                                                <?php 
                                                                    // Total de ocorrências do periodo pesquisado
                                                                    $Total_Atual = $infoDPRF->resultados['LOCALBR']['TRECHOS']['BR-'.$infoDPRF->BR.'/'.$infoDPRF->UF.'/'.$infoDPRF->Trecho];
                                                                    // Total de ocorrências do periodo anterior ao pesquisado
                                                                    $Total_Anterior = $infoDPRF_Anterior->resultados['LOCALBR']['TRECHOS']['BR-'.$infoDPRF->BR.'/'.$infoDPRF->UF.'/'.$infoDPRF->Trecho];
                                                                    // Porcentagem de diferença entre os dois períodos comparados
                                                                    $Porcentagem = $infoDPRF->Porcentagem($Total_Atual, $Total_Anterior);
                                                                    // Formata os números com milhar
                                                                    $Total_Ocorrencias = number_format($Total_Atual, 0, '', '.');
                                                                    $Total_Ocorrencias_Anterior = number_format($Total_Anterior, 0, '', '.');
                                                                    // Verifica se houve aumento ou diminuição de ocorrências
                                                                    if($Porcentagem > 0){
                                                                        // Aumento
                                                                        $class_pct = "positive";
                                                                        $icone_pct = "up";
                                                                    } else {
                                                                        // Diminuição
                                                                        $class_pct = "negative";
                                                                        $icone_pct = "down";
                                                                    }
                                                                ?>
                                                                <div class="section-content">
                                                                    <h2 class="statistic-values">
                                                                        <?php echo $Total_Ocorrencias; ?> 
                                                                        <span class="<?php echo $class_pct; ?>">
                                                                            <i class="indicator fontello-icon-<?php echo $icone_pct; ?>-dir"></i>
                                                                            <sub><?php echo $Porcentagem; ?></sub>
                                                                        </span>
                                                                    </h2>
                                                                    <?php if($Total_Ocorrencias_Anterior > 0): ?>
                                                                    <span class="info-block"><?php echo ucfirst($infoDPRF->Legenda_Periodo_Display); ?> anterior: <?php echo $Total_Ocorrencias_Anterior; ?> ocorrências</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                            <!-- // statistic-box -->
                                                        </div> 
                                                        <!-- // span6 -->
                                                        <!-- // ocorrencias -->
                                                        
                                                        
                                                        <!-- // pessoas -->                                                        
                                                        <div class="span6 grider-item">
                                                            <div class="statistic-box well <?php echo $infoDPRF->theme['well']; ?> well-impressed">
                                                                <div class="section-title">
                                                                    <h5><i class="fontello-icon-users"></i> Total de pessoas envolvidas</h5>
                                                                </div>
                                                                <?php 
                                                                    // Total de ocorrências do periodo pesquisado
                                                                    $TotalPessoas_Atual = $ObjTrecho['PESSOAS']['TOTAL'];
                                                                    // Total de ocorrências do periodo anterior ao pesquisado
                                                                    $TotalPessoas_Anterior = intval($ObjTrecho_Anterior['PESSOAS']['TOTAL']);
                                                                    // Porcentagem de diferença entre os dois períodos comparados
                                                                    $Porcentagem = $infoDPRF->Porcentagem($TotalPessoas_Atual, $TotalPessoas_Anterior);
                                                                    // Formata os números com milhar
                                                                    $Total_Pessoas = number_format($TotalPessoas_Atual, 0, '', '.');
                                                                    $Total_Pessoas_Anterior = number_format($TotalPessoas_Anterior, 0, '', '.');
                                                                    // Verifica se houve aumento ou diminuição de ocorrências
                                                                    if($Porcentagem > 0){
                                                                        // Aumento
                                                                        $class_pct = "positive";
                                                                        $icone_pct = "up";
                                                                    } else {
                                                                        // Diminuição
                                                                        $class_pct = "negative";
                                                                        $icone_pct = "down";
                                                                    }
                                                                ?>
                                                                <div class="section-content">
                                                                    <h2 class="statistic-values">
                                                                        <?php echo $Total_Pessoas; ?> 
                                                                        <span class="<?php echo $class_pct; ?>">
                                                                            <i class="indicator fontello-icon-<?php echo $icone_pct; ?>-dir"></i>
                                                                            <sub><?php echo $Porcentagem; ?></sub>
                                                                        </span>
                                                                    </h2>
                                                                    <?php if($Total_Pessoas_Anterior > 0): ?>
                                                                    <span class="info-block"><?php echo ucfirst($infoDPRF->Legenda_Periodo_Display); ?> anterior: <?php echo $Total_Pessoas_Anterior; ?> pessoas</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                            <!-- // statistic-box -->
                                                        </div>
                                                        <!-- // span6 -->
                                                        <!-- // pessoas -->
                                                        
                                                    </div>
                                                    <!-- // row -->
                                                    
                                                    
                                                    <div class="row-fluid">
                                                            
                                                                <!-- // mortes/feridos -->
                                                                <div class="span6 grider-item">
                                                                    <ul class="nav nav-well stats_mortes_feridos">
                                                                    
                                                                        <li class="Ttip" title="Números que representam um total de <?php echo number_format($ObjTrecho['ESTADO_FISICO'][2], 0, '', '.'); ?> ferimentos leves, seguidos de <?php echo number_format($ObjTrecho['ESTADO_FISICO'][3], 0, '', '.'); ?> ferimentos com maior gravidade.">
                                                                            <span class="well <?php echo $infoDPRF->theme['well']; ?> stat-yellow dblock">
                                                                                <i class="fontello-icon-lifebuoy"></i>
                                                                                <h4 class="statistic-values pull-right"><?php echo number_format($ObjTrecho['ESTADO_FISICO'][2] + $ObjTrecho['ESTADO_FISICO'][3], 0, '', '.'); ?></h4>
                                                                                Pessoas feridas
                                                                            </span>
                                                                        </li>
        
                                                                        <li class="Ttip" title="As mortes não são registradas em casos onde as pessoas feridas venham a falecer posteriormente.">
                                                                            <span class="well <?php echo $infoDPRF->theme['well']; ?> negative dblock">
                                                                                <i class="fontello-icon-lifebuoy"></i>
                                                                                <h4 class="statistic-values pull-right"><?php echo number_format($ObjTrecho['ESTADO_FISICO'][4], 0, '', '.'); ?></h4>
                                                                                Pessoas mortas
                                                                            </span>
                                                                        </li>
                                                                        
                                                                        <?php 
                                                                            // Dia da semana mais crítico
                                                                            arsort($ObjTrecho['DIASEMANA']);
                                                                            // Buscamos todos os dias
                                                                            $contador_dia_semana = 0;
                                                                            // Legenda tooltip
                                                                            $Legenda_Dia1 = '';
                                                                            $Legenda_Dia2 = '';
                                                                            foreach($ObjTrecho['DIASEMANA'] as $diasemana => $valor){
                                                                                if(is_numeric($diasemana)){
                                                                                    // Define o primeiro item na ordem do array(ordenado com maior numero de ocorrencias)
                                                                                    if($contador_dia_semana == 0){
                                                                                        $DiaSemana = $infoDPRF->getDiaSemana($diasemana);
                                                                                        $Legenda_Dia1 = $infoDPRF->getDiaSemana($diasemana, 1). ' lidera com '.number_format($valor, 0, '', '.');
                                                                                        $contador_dia_semana++;
                                                                                    } else
                                                                                    if($contador_dia_semana == 1){
                                                                                         $Legenda_Dia2 = $infoDPRF->getDiaSemana($diasemana, 1). ' com um total de '.number_format($valor, 0, '', '.');
                                                                                         break;
                                                                                    }                                                                   
                                                                                }
                                                                            } 
                                                                        ?>                                                                
                                                                        <li class="Ttip" title="<?php echo $Legenda_Dia1; ?> ocorrências, seguido de <?php echo $Legenda_Dia2; ?> registros.">
                                                                            <span class="well <?php echo $infoDPRF->theme['well']; ?> dblock">
                                                                                <i class="fontello-icon-calendar"></i>
                                                                                <h4 class="statistic-values pull-right"><?php echo $DiaSemana; ?></h4>
                                                                                Dia mais crítico
                                                                            </span>
                                                                        </li>
                                                                        
                                                                        <li class="Ttip" title="">
                                                                            <span class="well <?php echo $infoDPRF->theme['well']; ?> dblock">
                                                                                <i class="fontello-icon-clock"></i>
                                                                                <h4 class="statistic-values pull-right"><?php 
                                                                                    arsort($ObjTrecho['HORA']);
                                                                                    foreach($ObjTrecho['HORA'] as $horario => $valor){
                                                                                        if(is_numeric($horario)){
                                                                                            echo '<small>~</small>'.$horario.':00';
                                                                                            //echo $horario.'<sup>:00~</sup>'.$horario.'<sup>:59</sup>';
                                                                                            break;
                                                                                        }
                                                                                    } 
                                                                                ?></h4>
                                                                                Hora mais crítica
                                                                            </span>
                                                                        </li>
                                                                        
                                                                    </ul>
                                                                </div>
                                                                <!-- // span6 -->
                                                                <!-- // mortes/feridos --> 
                                                        
                                                            
                                                                <!-- Sexo dos condutores -->
                                                                <div class="span6 grider-item">
                                                                    <div class="statistic-box well <?php echo $infoDPRF->theme['well']; ?> well-impressed">
                                                                        <div class="section-title">
                                                                            <h5><i class="fontello-icon-target-2"></i> Sexo dos condutores</h5><!-- aweso-icon-truck -->
                                                                        </div>
                                                                        <div class="section-content">
                                                                            <div id="SexoCondutores"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- // span6 -->
                                                                <!-- // Sexo dos condutores --> 

                                                        </div>
                                             </div>
                                             </div>
                                                    
                                            
                                            <div class="row-fluid">
                                                <div class="span12">
                                                
                                                <hr class="mm top0" />
                                                
                                                <h3><i class="fontello-icon-down-open-1"></i>Tipos de acidente </h3>
                                                <p class="pagedesc">Conheça os principais tipos de acidentes nas rodovias federais.</p>
                                                
                                                <div class="tabbable tabbable-bordered tabs-top <?php echo $infoDPRF->theme['tabbable']; ?>">
                                                    <ul class="nav nav-tabs">
                                                        <li class="active"><a href="#tipos_comuns" data-toggle="tab">Tipos mais comuns</a></li>
                                                        <?php if(count($ObjTrecho['TIPO_ACIDENTE']) > 5): ?>
                                                        <li class="hidden-phone"><a href="#todos_tipos" data-toggle="tab">Lista completa</a></li>
                                                        <?php endif; ?>
                                                    </ul>
                                                    <div class="tab-content">
                                                        <div class="tab-pane active" id="tipos_comuns">
                                                        
                                                            <table class="table table-condensed">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col"> Tipo</th>
                                                                        <th scope="col" width="90" class="text-right">Ocorrências</th>
                                                                        <th scope="col" width="60" class="hidden-phone text-center"></th>
                                                                        <th scope="col" width="100"></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    
                                                                        $contador_tipo_acidente = 0;
                                                                        
                                                                        arsort($ObjTrecho['TIPO_ACIDENTE']);
                                                                        //ksort($ObjTrecho['TIPO_ACIDENTE'][$infoDPRF->Tipo_Periodo]);
                                                                        
                                                                        $Periodo_Array = $infoDPRF->Tipo_Periodo;
                                                                        if($Periodo_Array == 'Diario') $Periodo_Array = 'Horario';
                                                                        
                                                                        foreach($ObjTrecho['TIPO_ACIDENTE'] as $id_tipo_acidente => $Total_Atual){
                                                                            
                                                                            if(is_numeric($Total_Atual)){
        
                                                                                $contador_tipo_acidente++;
            
                                                                                $DSPLine = array();
                                                                                $sparkline = array();
                                                                                ksort($ObjTrecho['TIPO_ACIDENTE'][$Periodo_Array]);
                                                                                foreach($ObjTrecho['TIPO_ACIDENTE'][$Periodo_Array] as $mes_tipo_acidente => $tipo_acidente){
                                                                                    $DSPLine[] = $tipo_acidente[$id_tipo_acidente];
                                                                                    // Legendas dos gráficos
                                                                                    // Sparklines
                                                                                    $ano_sparkline = substr($mes_tipo_acidente, 0, 4);
                                                                                    $mes_sparkline = substr($mes_tipo_acidente, 4, 2);
                                                                                    $dia_sparkline = substr($mes_tipo_acidente, 6, 2);
                                                                                    if($infoDPRF->Tipo_Periodo == 'Semestre' || $infoDPRF->Tipo_Periodo == 'Trimestre'){
                                                                                        $sparkline[$mes_tipo_acidente] = $infoDPRF->getMesFull($mes_sparkline).' de '.$ano_sparkline;
                                                                                    } else
                                                                                    if($infoDPRF->Tipo_Periodo == 'Mensal'){
                                                                                        $sparkline[$mes_tipo_acidente] = $dia_sparkline . ' de ' . $infoDPRF->getMesFull($mes_sparkline).' de '.$ano_sparkline;
                                                                                    } else 
                                                                                    if($infoDPRF->Tipo_Periodo == 'Diario'){
                                                                                        $sparkline[$mes_tipo_acidente] = '~' . $mes_tipo_acidente.':00h';
                                                                                    }
                                                                                    // Fim Sparklines
                                                                                }
                                                                                $DSPLine = implode(',', $DSPLine);
            
                                                                                // Total deste tipo de acidente no periodo anterior 
                                                                                $Total_Anterior = intval($ObjTrecho_Anterior['TIPO_ACIDENTE'][$id_tipo_acidente]);                                                                        
                                                                                // Porcentagem de diferença entre os dois períodos comparados
                                                                                $Porcentagem = $infoDPRF->Porcentagem($Total_Atual, $Total_Anterior);
                                                                                // Formata os números com milhar
                                                                                $Total_Atual = number_format($Total_Atual, 0, '', '.');
                                                                                $Total_Anterior = number_format($Total_Anterior, 0, '', '.');
                                                                                // Verifica se houve aumento ou diminuição de ocorrências
                                                                                if($Porcentagem > 0){
                                                                                    // Aumento
                                                                                    $class_pct = "positive";
                                                                                    $icone_pct = "up";
                                                                                    $legenda = "Aumento de {$Porcentagem} em relação ao {$infoDPRF->Tipo_Periodo} anterior";
                                                                                } else {
                                                                                    // Diminuição
                                                                                    $class_pct = "negative";
                                                                                    $icone_pct = "down";
                                                                                    $legenda = "Diminuição de ".substr($Porcentagem, 1)." em relação ao {$infoDPRF->Tipo_Periodo} anterior";
                                                                                }
                                                                                
                                                                                echo '
                                                                                    <tr>
                                                                                        <td><span class="">'.$infoDPRF->getTipoAcidente($id_tipo_acidente).'</span></td>
                                                                                        <td class="text-right bold">'.$Total_Atual.'</td>
                                                                                        <td class="hidden-phone text-right '.$class_pct.' bold"> 
                                                                                            <span class="Ttip" title="'.$legenda.'">'.$Porcentagem.'</span> 
                                                                                            <i class="indicator fontello-icon-'.$icone_pct.'-dir"></i> 
                                                                                        </td>
                                                                                        <!--td class="text-right">600</td-->
                                                                                        <td><div class="section-chart"> <span class="DSPLine" values="'.$DSPLine.'"></span> </div></td>
                                                                                    </tr>
                                                                                ';
                                                                                if($contador_tipo_acidente == 5) break;
        
                                                                            }
                                                                            
                                                                        }
                                                                    
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        
                                                        </div>
                                                        
                                                        <?php if(count($ObjTrecho['TIPO_ACIDENTE']) > 5): ?>
                                                        
                                                        <div id="todos_tipos" class="tab-pane">
                                                        
                                                            <table class="table table-condensed">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col"> Tipo</th>
                                                                        <th scope="col" width="90" class="text-right">Ocorrências</th>
                                                                        <th scope="col" width="60" class="hidden-phone text-center"></th>
                                                                        <th scope="col" width="100"></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                        
                                                                        arsort($ObjTrecho['TIPO_ACIDENTE']);
                                                                        //ksort($ObjTrecho['TIPO_ACIDENTE'][$infoDPRF->Tipo_Periodo]);
                                                                        
                                                                        foreach($ObjTrecho['TIPO_ACIDENTE'] as $id_tipo_acidente => $Total_Atual){
                                                                            
                                                                            if($id_tipo_acidente == 'ND') continue;
                                                                            
                                                                            if(is_numeric($Total_Atual)){
            
                                                                                $DSPLine = array();
                                                                                foreach($ObjTrecho['TIPO_ACIDENTE'][$Periodo_Array] as $mes_tipo_acidente => $tipo_acidente){
                                                                                    $DSPLine[] = $tipo_acidente[$id_tipo_acidente];
                                                                                }
                                                                                $DSPLine = implode(',', $DSPLine);
            
                                                                                // Total deste tipo de acidente no periodo anterior 
                                                                                $Total_Anterior = intval($ObjTrecho_Anterior['TIPO_ACIDENTE'][$id_tipo_acidente]);                                                                        
                                                                                // Porcentagem de diferença entre os dois períodos comparados
                                                                                $Porcentagem = $infoDPRF->Porcentagem($Total_Atual, $Total_Anterior);
                                                                                // Formata os números com milhar
                                                                                $Total_Atual = number_format($Total_Atual, 0, '', '.');
                                                                                $Total_Anterior = number_format($Total_Anterior, 0, '', '.');
                                                                                // Verifica se houve aumento ou diminuição de ocorrências
                                                                                if($Porcentagem > 0){
                                                                                    // Aumento
                                                                                    $class_pct = "positive";
                                                                                    $icone_pct = "up";
                                                                                    $legenda = "Aumento de {$Porcentagem} em relação ao {$infoDPRF->Tipo_Periodo} anterior";
                                                                                } else {
                                                                                    // Diminuição
                                                                                    $class_pct = "negative";
                                                                                    $icone_pct = "down";
                                                                                    $legenda = "Diminuição de ".substr($Porcentagem, 1)." em relação ao {$infoDPRF->Tipo_Periodo} anterior";
                                                                                }
                                                                                
                                                                                echo '
                                                                                    <tr>
                                                                                        <td><span class="">'.$infoDPRF->getTipoAcidente($id_tipo_acidente).'</span></td>
                                                                                        <td class="text-right bold">'.$Total_Atual.'</td>
                                                                                        <td class="hidden-phone text-right '.$class_pct.' bold"> 
                                                                                            <span class="Ttip" title="'.$legenda.'">'.$Porcentagem.'</span> 
                                                                                            <i class="indicator fontello-icon-'.$icone_pct.'-dir"></i> 
                                                                                        </td>
                                                                                        <!--td class="text-right">600</td-->
                                                                                        <td><div class="section-chart"> <span class="DSPLine" values="'.$DSPLine.'"></span> </div></td>
                                                                                    </tr>
                                                                                ';
        
                                                                            }
                                                                            
                                                                        }
                                                                    
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                            
                                                        </div>
                                                        
                                                        <?php endif; ?>
                                                        
                                                        </div>
                                                        </div>
                                                        
                                                        
                                                </div>
                                            </div>
                                            <!-- // Tipos de acidentes --> 
                                            

                                            
                                            
                                            
                                        </div>
                                        <!-- // coluna -->
                                        
                                        
                                        <!-- coluna direita (1/2) -->
                                        <div class="span6 grider">
                                            
                                            <div class="row-fluid">
                                                <div class="span12 grider-item">
                                                
                                                    <h3>
                                                        <i class="fontello-icon-location"></i>Mapeamento <!--small>localização</small-->
                                                    </h3>

                                                    <?php if($infoDPRF->resultados['LOCALBR']['BR-'.$infoDPRF->BR][$infoDPRF->UF][$infoDPRF->Trecho]['LAT_LONG']): ?>
                                                    <p class="pagedesc">Veja no mapa os trechos onde as ocorrências são registradas.</p>
                                                    <?php else: ?>
                                                    <p class="pagedesc">Nenhuma latitude/longitude foi registrada.</p>
                                                    <?php endif; ?>
                                                
                                                    <hr class="mm top10" />
                                                
                                                    <div class="row-fluid">
                                                        <div class="span12">
                                                        <?php $showMaps = true; ?>                                  
                                                        <div id="map" class="trechos" <?php if(!$infoDPRF->resultados['LOCALBR']['BR-'.$infoDPRF->BR][$infoDPRF->UF][$infoDPRF->Trecho]['LAT_LONG']): ?>style="height: 300px;"<?php endif; ?>></div>
                                                        </div>
                                                    </div>
                                                
                                                </div>
                                            </div>
                                            
                                            
                                            
                                                
                                            
                                            <!-- Causas de acidente -->                                          
                                            <div class="row-fluid top10">
                                                <div class="span12 grider-item">
                                                
                                                <hr class="mm top10" />
                                                
                                                <h3><i class="fontello-icon-down-open-1"></i>Causas de acidente </h3>
                                                <p class="pagedesc">Todo acidente tem um motivo, saiba quais os mais comuns.</p>
                                                
                                                <div class="tabbable tabbable-bordered tabs-top <?php echo $infoDPRF->theme['tabbable']; ?>">
                                                    <ul class="nav nav-tabs">
                                                        <li class="active"><a href="#causas_comuns" data-toggle="tab">Causas mais comuns</a></li>
                                                        <?php if(count($ObjTrecho['CAUSA_ACIDENTE']) > 5): ?>
                                                        <li class="hidden-phone"><a href="#todas_causas" data-toggle="tab">Lista completa</a></li>
                                                        <?php endif; ?>
                                                    </ul>
                                                    <div class="tab-content">
                                                        <div class="tab-pane active" id="causas_comuns">

                                                
                                                        <table class="table table-condensed">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col"> Causa</th>
                                                                    <th scope="col" width="90" class="text-right">Ocorrências</th>
                                                                    <th scope="col" width="60" class="hidden-phone text-center"></th>
                                                                    <th scope="col" width="100"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                
                                                                    $contador_causa_acidente = 0;
                                                                    
                                                                    arsort($ObjTrecho['CAUSA_ACIDENTE']);
                                                                    ksort($ObjTrecho['CAUSA_ACIDENTE'][$Periodo_Array]);
                                                                    
                                                                    foreach($ObjTrecho['CAUSA_ACIDENTE'] as $id_causa_acidente => $Total_Atual){
                                                                        
                                                                        if(is_numeric($Total_Atual)){
                                                                        
                                                                            $contador_causa_acidente++;
                                                                            
                                                                            $DSPLine = array();
                                                                            foreach($ObjTrecho['CAUSA_ACIDENTE'][$Periodo_Array] as $mes_causa_acidente => $causa_acidente){
                                                                                $DSPLine[] = $causa_acidente[$id_causa_acidente];
                                                                            }
                                                                            $DSPLine = implode(',', $DSPLine);
                
                                                                            // Total desta causa de acidente no periodo anterior 
                                                                            $Total_Anterior = intval($ObjTrecho_Anterior['CAUSA_ACIDENTE'][$id_causa_acidente]);
                                                                            // Porcentagem de diferença entre os dois períodos comparados
                                                                            $Porcentagem = $infoDPRF->Porcentagem($Total_Atual, $Total_Anterior);
                                                                            // Formata os números com milhar
                                                                            $Total_Atual = number_format($Total_Atual, 0, '', '.');
                                                                            $Total_Anterior = number_format($Total_Anterior, 0, '', '.');
                                                                            // Verifica se houve aumento ou diminuição de ocorrências
                                                                            if($Porcentagem > 0){
                                                                                // Aumento
                                                                                $class_pct = "positive";
                                                                                $icone_pct = "up";
                                                                                $legenda = "Aumento de {$Porcentagem} em relação ao {$infoDPRF->Tipo_Periodo} anterior";
                                                                            } else {
                                                                                // Diminuição
                                                                                $class_pct = "negative";
                                                                                $icone_pct = "down";
                                                                                $legenda = "Diminuição de ".substr($Porcentagem, 1)." em relação ao {$infoDPRF->Tipo_Periodo} anterior";
                                                                            }
                                                                            
                                                                            echo '
                                                                                <tr>
                                                                                    <td><span class="">'.$infoDPRF->getCausaAcidente($id_causa_acidente).'</span></td>
                                                                                    <td class="text-right bold">'.$Total_Atual.'</td>
                                                                                    <td class="hidden-phone text-right '.$class_pct.' bold"> 
                                                                                        <span class="Ttip" title="'.$legenda.'">'.$Porcentagem.'</span> 
                                                                                        <i class="indicator fontello-icon-'.$icone_pct.'-dir"></i> 
                                                                                    </td>
                                                                                    <!--td class="text-right">600</td-->
                                                                                    <td><div class="section-chart"> <span class="DSPLine" values="'.$DSPLine.'"></span> </div></td>
                                                                                </tr>
                                                                            ';
                                                                            if($contador_causa_acidente == 5) break;
                                                                            
                                                                        }
                                                                        
                                                                    }
                                                                
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                        
                                                        </div>
                                                        
                                                        <?php if(count($ObjTrecho['TIPO_ACIDENTE']) > 5): ?>
                                                        
                                                        <div id="todas_causas" class="tab-pane">
                                                        
                                                        <table class="table table-condensed">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col"> Causa</th>
                                                                    <th scope="col" width="90" class="text-right">Ocorrências</th>
                                                                    <th scope="col" width="60" class="hidden-phone text-center"></th>
                                                                    <th scope="col" width="100"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                    
                                                                    foreach($ObjTrecho['CAUSA_ACIDENTE'] as $id_causa_acidente => $Total_Atual){
                                                                        
                                                                        if($id_causa_acidente == 'ND') continue;
                                                                        
                                                                        if(is_numeric($Total_Atual)){
                                                                            
                                                                            $DSPLine = array();
                                                                            foreach($ObjTrecho['CAUSA_ACIDENTE'][$Periodo_Array] as $mes_causa_acidente => $causa_acidente){
                                                                                $DSPLine[] = $causa_acidente[$id_causa_acidente];
                                                                            }
                                                                            $DSPLine = implode(',', $DSPLine);
                
                                                                            // Total desta causa de acidente no periodo anterior 
                                                                            $Total_Anterior = intval($ObjTrecho_Anterior['CAUSA_ACIDENTE'][$id_causa_acidente]);
                                                                            // Porcentagem de diferença entre os dois períodos comparados
                                                                            $Porcentagem = $infoDPRF->Porcentagem($Total_Atual, $Total_Anterior);
                                                                            // Formata os números com milhar
                                                                            $Total_Atual = number_format($Total_Atual, 0, '', '.');
                                                                            $Total_Anterior = number_format($Total_Anterior, 0, '', '.');
                                                                            // Verifica se houve aumento ou diminuição de ocorrências
                                                                            if($Porcentagem > 0){
                                                                                // Aumento
                                                                                $class_pct = "positive";
                                                                                $icone_pct = "up";
                                                                                $legenda = "Aumento de {$Porcentagem} em relação ao {$infoDPRF->Tipo_Periodo} anterior";
                                                                            } else {
                                                                                // Diminuição
                                                                                $class_pct = "negative";
                                                                                $icone_pct = "down";
                                                                                $legenda = "Diminuição de ".substr($Porcentagem, 1)." em relação ao {$infoDPRF->Tipo_Periodo} anterior";
                                                                            }
                                                                            
                                                                            echo '
                                                                                <tr>
                                                                                    <td><span class="">'.$infoDPRF->getCausaAcidente($id_causa_acidente).'</span></td>
                                                                                    <td class="text-right bold">'.$Total_Atual.'</td>
                                                                                    <td class="hidden-phone text-right '.$class_pct.' bold"> 
                                                                                        <span class="Ttip" title="'.$legenda.'">'.$Porcentagem.'</span> 
                                                                                        <i class="indicator fontello-icon-'.$icone_pct.'-dir"></i> 
                                                                                    </td>
                                                                                    <td><div class="section-chart"> <span class="DSPLine" values="'.$DSPLine.'"></span> </div></td>
                                                                                </tr>
                                                                            ';
                                                                            
                                                                        }
                                                                        
                                                                    }
                                                                
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                        
                                                        </div>
                                                        
                                                        <?php endif; ?>
                                                        
                                                        </div>
                                                        </div>
                                                        
                                                </div>
                                            </div>
                                            <!-- // causas de acidente --> 
                                            
                                            
                                        </div>
                                        <!-- // coluna direita (1/2) --> 
                                        
                                        
                                    </div>
                                </div>
                                <!-- // coluna --> 
                                
                                                    <ul class="nav nav-well veiculos">
                                                        <li>
                                                            <div class="info-block f11 l14">
                                                                <i class="fontello-icon-info-circle"></i> 
                                                                O sexo de aproximadamente <?php echo number_format($ObjTrecho['SEXO']['ND'], 0, '', '.'); ?> condutores não foi registrado no sistema.
                                                            </div>
                                                        </li>
                                                    </ul>
                                

                            </div>
                            <!-- // row --> 
                            
                        </section>

                </div>

                <?php
              
                    $array_trechos = array();
                    foreach($infoDPRF->resultados['LOCALBR']['TRECHOS'] as $trecho_range => $total){
                        $trechos = explode('/', $trecho_range);
                        if($trechos[0].$trechos[1] == 'BR-' . $infoDPRF->BR . $infoDPRF->UF)
                        $array_trechos[$trechos[2]] = $total;
                    }
                    arsort($array_trechos);
                
                ?>                

                <div class="tab-pane" id="ttrecho">
                        <section>
                            <div class="row-fluid margin-top20">
                            
                                <div class="span12 well <?php echo $infoDPRF->theme['well']; ?>">
                                    <div class="row-fluid">
                                    
                                        <div class="span12">
                                            <h3><i class="fontello-icon-shuffle"></i> Escolher outro trecho </h3>
                                            <p class="pagedesc">Selecione abaixo outros trechos com ocorrências no <?php echo $infoDPRF->Legenda_Periodo; ?> pela rodovia BR-<?php echo $infoDPRF->BR; ?>/<?php echo $infoDPRF->UF; ?>.</p>
                                        </div>
                                    </div>
                                                                        
                                    <div class="row-fluid">

                                        <div class="span5 grider">
                                        
                                            <ul class="nav nav-well">
                                                
                                                <?php
                                                
                                                $Url_Periodo = '/'.$infoDPRF->Tipo_Periodo.
                                                    (($infoDPRF->Periodo) ? '/'.$infoDPRF->Periodo : '').
                                                    (($infoDPRF->Dia) ? '/'.$infoDPRF->Dia : '').
                                                    (($infoDPRF->Mes) ? '/'.$infoDPRF->Mes : '').
                                                    (($infoDPRF->Ano) ? '/'.$infoDPRF->Ano : '');
                                                
                                                foreach($array_trechos as $trecho => $total){
                                                    
                                                    $active = (($infoDPRF->Trecho == $trecho) ? 'active' : '');
                                                    
                                                    echo '
                                                    <li class="'.$active.'"><a class="well '.$infoDPRF->theme['well'].' '.$active.'" href="'. $Url_Base .'BR-'.$infoDPRF->BR.'/'.$infoDPRF->UF.'/'.$trecho.$Url_Periodo.'">
                                                        <i class="fontello-icon-road"></i> <i class="chevron fontello-icon-right-dir-1"></i>
                                                        KM '.$trecho.'
                                                        <h5 class="statistic-values pull-right">'.$total.' ocorrências</h5>
                                                        </a>
                                                    </li>';
                                                    
                                                }
                                                ?>
                                                
                                            </ul>
                                        
                                        </div>
                                        
                                        <div class="span7 grider">

                                        
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
                                                <p class="pagedesc">Selecione abaixo o período que você deseja visualizar as estatísticas.</p>
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
           
<script>
var SPARKLINE_DYNAMIC = {
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
</script>