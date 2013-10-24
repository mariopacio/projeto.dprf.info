<?php

/**
 * DPRF.info
 * Include responsável pelo resumo do período na lateral das páginas
 * 
 * @author Mário Pácio <mario.pacio@gmail.com>
 * @copyright 2013
 * @version 1.0
 * @package DPRF.info
 * @license AGPLv3 - http://www.gnu.org/licenses/agpl-3.0.html
 * 
 */
 
?>

                                        <div class="span12 grider-item"><!-- 1 coluna --> 
                                                    
                                        <div class="statistic-box well <?php echo $infoDPRF->theme['well']; ?> well-impressed lateral">
                                        
                                            <div class="section-title">
                                                <h5><i class="fontello-icon-down-circle2"></i> Resumo: <?php echo $infoDPRF->Legenda_Periodo; ?></h5>
                                            </div>
                                            
                                            <div class="section-content">

                                                    <div class="row-fluid">
        
                                                        <!-- 1 coluna -->
                                                        <div class="span12 grider-item">
                                                        
                                                            <!-- // ocorrencias -->
                                                            <div class="row-fluid">
                                                                <div class="span12 grider-item">
                                                                    <div class="statistic-box well <?php echo $infoDPRF->theme['well']; ?> well-impressed">
                                                                        <div class="section-title">
                                                                            <h5><i class="fontello-icon-chart"></i> Total de ocorrências</h5>
                                                                        </div>
                                                                        <?php 
                                                                            // Total de ocorrências do periodo pesquisado
                                                                            $Total_Atual = $infoDPRF->resultados['TOTAL_OCORRENCIAS'];
                                                                            // Total de ocorrências do periodo anterior ao pesquisado
                                                                            $Total_Anterior = $infoDPRF_Anterior->resultados['TOTAL_OCORRENCIAS'];
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
                                                                </div> 
                                                            </div>
                                                            <!-- // ocorrencias -->
                                                            
                                                            <!-- // trechos -->
                                                            <div class="row-fluid">
                                                                <div class="span12 grider-item">
                                                                    <div class="statistic-box well <?php echo $infoDPRF->theme['well']; ?> well-impressed">
                                                                        <div class="section-title">
                                                                            <h5><i class="fontello-icon-road"></i> Trecho mais perigoso</h5>
                                                                        </div>
                                                                        <?php
                                                                        foreach($infoDPRF->resultados['LOCALBR']['TRECHOS'] as $LocalBR => $Total_Trecho){
        
                                                                            $Url_Periodo = '/'.$infoDPRF->Tipo_Periodo.
                                                                                (($infoDPRF->Periodo) ? '/'.$infoDPRF->Periodo : '').
                                                                                (($infoDPRF->Dia) ? '/'.$infoDPRF->Dia : '').
                                                                                (($infoDPRF->Mes) ? '/'.$infoDPRF->Mes : '').
                                                                                (($infoDPRF->Ano) ? '/'.$infoDPRF->Ano : '');
                                                            
                                                                            $Trecho_Atual_Array = explode('/', $LocalBR);
                                                                            $Trecho_Atual = '<a href="'. $Url_Base . $Trecho_Atual_Array[0].'/'.$Trecho_Atual_Array[1].'/'.$Trecho_Atual_Array[2].$Url_Periodo.'">'.$Trecho_Atual_Array[0].'/'.$Trecho_Atual_Array[1].'</a>';
                                                                            $Trecho_KM = $Trecho_Atual_Array[2];
                                                                            // Pega o total desse trecho no periodo anterior
                                                                            $Total_Trecho_Anterior = $infoDPRF_Anterior->resultados['LOCALBR']['TRECHOS'][$LocalBR];
                                                                            // Verifica se houve aumento ou diminuição de ocorrências neste trecho
                                                                            $Porcentagem = $infoDPRF->Porcentagem($Total_Trecho, $Total_Trecho_Anterior);
                                                                            // Formata os números com milhar
                                                                            $Total_Trecho = number_format($Total_Trecho, 0, '', '.');
                                                                            $Total_Trecho_Anterior = number_format($Total_Trecho_Anterior, 0, '', '.');
                                                                            // Verifica se houve aumento ou diminuição
                                                                            if($Porcentagem > 0){
                                                                                // Aumento
                                                                                $class_pct = "positive";
                                                                                $icone_pct = "up";
                                                                            } else {
                                                                                // Diminuição
                                                                                $class_pct = "negative";
                                                                                $icone_pct = "down";
                                                                            }
                                                                            break;
                                                                        }
                                                                        ?>
                                                                        <div class="section-content">
                                                                            <h2 class="statistic-values"><?php echo $Trecho_Atual; ?> 
                                                                                <span class="<?php echo $class_pct; ?>">
                                                                                    <i class="indicator fontello-icon-<?php echo $icone_pct; ?>-dir"></i>
                                                                                    <sup><?php echo $Porcentagem; ?></sup>
                                                                                </span>
                                                                            </h2>
                                                                            <h5 class="statistic-values">KM <?php echo $Trecho_KM; ?> &nbsp; <?php echo $Total_Trecho; ?> ocorrências</h5>
                                                                            <?php if($Total_Trecho_Anterior > 0): ?>
                                                                            <span class="info-block"><?php echo ucfirst($infoDPRF->Legenda_Periodo_Display); ?> anterior: <?php echo $Total_Trecho_Anterior; ?> ocorrências</span>
                                                                            <?php endif; ?>
                                                                            </div>
                                                                            <ul class="nav nav-well trechos">
                                                                                <li class="mais">
                                                                                    <a class="well <?php echo $infoDPRF->theme['well']; ?> f12" href="<?php echo $Url_Base; ?>BR/Perigosas/<?php echo $infoDPRF->URL; ?>">
                                                                                        <span class="pull-right">Veja outros trechos <i class="fontello-icon-right-dir-1"></i></span>
                                                                                    </a>
                                                                                </li> 
                                                                            </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- // trechos -->
                                                            
                                                            <!-- // pessoas -->
                                                            <div class="row-fluid">
                                                                <div class="span12 grider-item">
                                                                    <div class="statistic-box well <?php echo $infoDPRF->theme['well']; ?> well-impressed">
                                                                        <div class="section-title">
                                                                            <h5><i class="fontello-icon-users"></i> Total de pessoas envolvidas</h5>
                                                                        </div>
                                                                        <?php 
                                                                            // Total de ocorrências do periodo pesquisado
                                                                            $TotalPessoas_Atual = $infoDPRF->resultados['PESSOAS']['TOTAL'];
                                                                            // Total de ocorrências do periodo anterior ao pesquisado
                                                                            $TotalPessoas_Anterior = $infoDPRF_Anterior->resultados['PESSOAS']['TOTAL'];
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
                                                                </div>
                                                            </div>
                                                            <!-- // pessoas -->
                                                            
                                                            <div class="row-fluid">
                                                                <div class="span12 grider-item">
                                                                    <div class="statistic-box well <?php echo $infoDPRF->theme['well']; ?> well-impressed">
                                                                        <div class="section-title">
                                                                            <h5><i class="fontello-icon-target-2"></i> Sexo dos condutores</h5><!-- aweso-icon-truck -->
                                                                        </div>
                                                                        <div class="section-content">
                                                                            <div id="SexoCondutores"></div>
                                                                            <ul class="nav nav-well veiculos">
                                                                                <li>
                                                                                    <div class="info-block f11 l14">
                                                                                        <i class="fontello-icon-info-circle"></i> 
                                                                                        O sexo de aproximadamente <?php echo number_format($infoDPRF->resultados['CONDUTORES']['SEXO']['ND'], 0, '', '.'); ?> condutores não foi registrado no sistema.
                                                                                    </div>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- // mortes/feridos -->                                
                                                            <div class="row-fluid">
                                                                <div class="span12 grider-item">
                                                                    <ul class="nav nav-well stats_mortes_feridos">

                                                                        <li class="Ttip" title="Números que representam um total de <?php echo number_format($infoDPRF->resultados['PESSOAS']['ESTADO_FISICO'][2], 0, '', '.'); ?> ferimentos leves, seguidos de <?php echo number_format($infoDPRF->resultados['PESSOAS']['ESTADO_FISICO'][3], 0, '', '.'); ?> ferimentos com maior gravidade.">
                                                                            <span class="well <?php echo $infoDPRF->theme['well']; ?> stat-yellow dblock">
                                                                                <i class="fontello-icon-lifebuoy"></i>
                                                                                <h4 class="statistic-values pull-right"><?php echo number_format($infoDPRF->resultados['PESSOAS']['ESTADO_FISICO'][2] + $infoDPRF->resultados['PESSOAS']['ESTADO_FISICO'][3], 0, '', '.'); ?></h4>
                                                                                Pessoas feridas
                                                                            </span>
                                                                        </li>

                                                                        <li class="Ttip" title="As mortes não são registradas em casos onde as pessoas feridas venham a falecer posteriormente.">
                                                                            <span class="well <?php echo $infoDPRF->theme['well']; ?> negative dblock">
                                                                                <i class="fontello-icon-lifebuoy"></i>
                                                                                <h4 class="statistic-values pull-right"><?php echo number_format($infoDPRF->resultados['PESSOAS']['ESTADO_FISICO'][4], 0, '', '.'); ?></h4>
                                                                                Pessoas mortas
                                                                            </span>
                                                                        </li>
                                                                        
                                                                        <?php 
                                                                            // Dia da semana mais crítico
                                                                            arsort($infoDPRF->resultados['DIASEMANA']);
                                                                            // Buscamos todos os dias
                                                                            $contador_dia_semana = 0;
                                                                            // Legenda tooltip
                                                                            $Legenda_Dia1 = '';
                                                                            $Legenda_Dia2 = '';
                                                                            foreach($infoDPRF->resultados['DIASEMANA'] as $diasemana => $valor){
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
                                                                                    arsort($infoDPRF->resultados['HORARIO']);
                                                                                    foreach($infoDPRF->resultados['HORARIO'] as $horario => $valor){
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
                                                            </div>
                                                            <!-- // mortes/feridos -->  
                                                    
                                                </div>
                                                <!-- /1 coluna -->
                                                
                                                </div>
                                                </div>
                                                </div>
                                                </div>
                                                
                                                <!-- resumo completo -->
                                                <div class="row-fluid">
                                                    <div class="span12 grider-item">
                                                        <ul class="nav nav-well">
                                                            <li>
                                                                <a class="well <?php echo $infoDPRF->theme['well']; ?>" href="<?php echo $Url_Base; ?><?php echo $infoDPRF->URL; ?>">
                                                                    <i class="fontello-icon-reply-1"></i> 
                                                                    <i class="chevron fontello-icon-plus-4"></i> 
                                                                    Relatório completo: <?php echo $infoDPRF->Legenda_Periodo; ?>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <!-- // resumo completo -->