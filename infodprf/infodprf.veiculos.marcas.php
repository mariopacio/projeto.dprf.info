<?php

/**
 * DPRF.info
 * Página com as marcas de veículos mais envolvidas em ocorrências
 * 
 * @author Mário Pácio <mario.pacio@gmail.com>
 * @copyright 2013
 * @version 1.0
 * @package DPRF.info
 * @license AGPLv3 - http://www.gnu.org/licenses/agpl-3.0.html
 * 
 */
 

    // Total de modelos que serão exibidos na listagem
    $Limit_Marcas = 20;
    
    // Total de modelos que serão exibidos após escolher uma marca
    $Limit_Modelos = 10;
    
?>
            
            <div class="row-fluid page-head">
                <div class="qrcode"><a href="#QRCode" data-toggle="modal" class="Ltip" title="Não sabe o que é? Clique e veja."><img src="<?php echo $infoDPRF->QRCode('1'); ?>" /></a></div>
                <h2 class="page-title"><i class="fontello-icon-monitor"></i> Bem-vindo(a) <small class="hide-x2small">ao aplicativo DPRF.info</small></h2>
                <p class="pagedesc visible-desktop visible-tablet">Estatísticas de ocorrências em rodovias federais a partir de 2007. <a href="<?php echo $Url_Base; ?>About">Mais..</a></p>
                <div class="page-bar">
                    <ul class="nav nav-tabs pull-left">
                        <li id="info-tab" class="active"><a href="#Info" data-toggle="tab"><i class="aweso-icon-tasks"></i> Informações</a></li>
                        <li class="hidden-phone"><a href="<?php echo $Url_Base; ?><?php echo $infoDPRF->URL; ?>"><i class="aweso-icon-circle-arrow-left"></i><?php echo $infoDPRF->Legenda_Periodo; ?></a></li>
                        <li class="hidden-phone" id="escolher-tab"><a href="#tperiodo" data-toggle="tab"><i class="aweso-icon-refresh"></i>Alterar período</a></li>
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
            <!-- // page head -->
            
            <div id="page-content" class="page-content tab-content">
            
                    <div class="tab-pane active" id="Info">
                        <section>
                            <div class="row-fluid margin-top20">
                                <div class="span12 well <?php echo $infoDPRF->theme['well']; ?>">
                                    <div class="row-fluid">
                                        <div class="span8 grider">
                                        
                                            <?php if($infoDPRF->Marca): ?>
                                            
                                                <div class="row-fluid">
                                                    <div class="span12 well <?php echo $infoDPRF->theme['well']; ?>">
    
                                                        <h3 class="l24">
                                                            <img src="<?php echo $Url_Base; ?>assets/img/marcas/90x90/<?php echo $infoDPRF->getIcone($infoDPRF->Marca, $infoDPRF->Modelo); ?>.jpg" width="50" class="fleft bimg" />
                                                            <small class="h3_modelo"><?php echo $infoDPRF->Legenda_Periodo; ?></small>
                                                            <br />
                                                            <?php echo $infoDPRF->getMarca($infoDPRF->Marca); ?>
                                                        </h3>
                                                        
                                                        
                                                        <hr class="mm top15" />
                                                        <p class="pagedesc">Confira a lista dos <?php echo $Limit_Modelos; ?> modelos mais envolvidas em ocorrências da marca <?php echo $infoDPRF->getMarca($infoDPRF->Marca); ?>.</p>

                                                        <table class="table table-hover table-condensed">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">Modelo</th>
                                                                        <th scope="col" width="90" class="text-right">Ocorrências</th>
                                                                        <th scope="col" width="75" class="text-center"></th>
                                                                        <th scope="col" width="100"></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php 
                                                                    
                                                                    $Array_Modelos = array();
                                                                    foreach($infoDPRF->resultados['VEICULOS'][$infoDPRF->Marca]['MODELOS'] as $Modelo => $Array){
                                                                        $Array_Modelos[$Modelo] = $Array['TOTAL'];
                                                                    }
                                                                    arsort($Array_Modelos);
                                                                    
                                                                    $total_top = 0;
                                                                    
                                                                    $contador_modelos = 0;
                                                                    foreach($Array_Modelos as $Modelo => $Total){
                                                                        $total_top += $Total;
                                                                        $contador_modelos++;
                                                                        if($contador_veiculos == $Limit_Modelos) break;
                                                                    }
                                                                    
                                                                    $contador_modelos = 0;
                                                                    
                                                                    foreach($Array_Modelos as $Modelo => $Total){

                                                                        if(is_numeric($Total)): 
                                                                                
                                                                            $Total = intval($Total);
                                                                            $Total_Modelo += $Total;
                                                                            // Total atual formatado 
                                                                            $Total_Ocorrencias = number_format($Total, 0, '', '.');
                                                                            // Total anterior para comparativo
                                                                            $Total_Anterior = intval($infoDPRF_Anterior->resultados['VEICULOS'][$infoDPRF->Marca]['MODELOS'][$Modelo]['TOTAL']);
                                                                            // Porcentagem de diferença entre os dois periodos
                                                                            $Porcentagem = $infoDPRF->Porcentagem($Total, $Total_Anterior);   
                                                                            // Verifica se houve aumento ou diminuição para o ano/modelo
                                                                            if($Porcentagem > 0){
                                                                                    // Aumento
                                                                                    $class_pct = "positive";
                                                                                    $icone_pct = "fontello-icon-up-dir";
                                                                                        $legenda = "Aumento de {$Porcentagem} em relação ao {$infoDPRF->Legenda_Periodo_Display} anterior";
                                                                            } else if($Porcentagem < 0){
                                                                                    // Diminuição
                                                                                    $class_pct = "negative";
                                                                                    $icone_pct = "fontello-icon-down-dir";
                                                                                    $legenda = "Diminuição de ".substr($Porcentagem, 1)." em relação ao {$infoDPRF->Legenda_Periodo_Display} anterior";
                                                                            } else {
                                                                                    $class_pct = "c777";
                                                                                    $icone_pct = "fontello-icon-arrow-combo";
                                                                                    $legenda = "Nenhuma diferença em relação ao {$infoDPRF->Legenda_Periodo_Display} anterior";
                                                                            }
                                                                                    
                                                                            $pct = $Total/$total_top;
                                                                            
                                                                            if($contador_modelos == 0){
                                                                                $pct_atual = number_format( $pct * 100, 1 );
                                                                                if($pct_atual > 70) $fator_multiplicacao = 1.2; else
                                                                                if($pct_atual > 40) $fator_multiplicacao = 2;   else
                                                                                if($pct_atual > 30) $fator_multiplicacao = 2.6; else
                                                                                if($pct_atual > 20) $fator_multiplicacao = 4;   else
                                                                                if($pct_atual > 15) $fator_multiplicacao = 5;   else
                                                                                if($pct_atual > 10) $fator_multiplicacao = 6;   else
                                                                                                    $fator_multiplicacao = 10;
                                                                            }
                                                                                
                                                                            $pct_barra = (number_format( $pct * 100, 2 ) * $fator_multiplicacao) . '%';
                                                                            
                                                                        ?>
                                                                        <tr>
                                                                            <td class="text-left">
                                                                                <a href="<?php echo $Url_Base; ?><?php echo $infoDPRF->URL; ?>/Modelos/<?php echo $infoDPRF->Marca; ?>/<?php echo $Modelo; ?>">
                                                                                    <small><?php echo $infoDPRF->Marca; ?></small> 
                                                                                    <?php echo $Modelo; ?>
                                                                                </a>
                                                                            </td>
                                                                            <td class="text-right"><?php echo $Total_Ocorrencias; ?></td>
                                                                            <td class="text-right <?php echo $class_pct; ?> bold"> 
                                                                                <span class="Ttip" title="<?php echo $legenda; ?>"><?php echo $Porcentagem; ?></span> 
                                                                                <i class="indicator <?php echo $icone_pct; ?>"></i> 
                                                                            </td>
                                                                            <td>
                                                                                <div class="progress <?php echo $infoDPRF->theme['progress']; ?> progress-mini top5">
                                                                                    <div class="filler">
                                                                                        <div class="bar" style="width:<?php echo $pct_barra; ?>"></div>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <?php 
                                                                        
                                                                            $contador_modelos++;
                                                                            
                                                                            if($contador_modelos == $Limit_Modelos) break;
                                                                            
                                                                            endif; 
                                                                        } // foreach

                                                                ?>                                                                
                                                                </tbody>
                                                            </table>
                                                            
                                                            <div class="info-block f11 l14">
                                                                <i class="fontello-icon-info-circle"></i> 
                                                                Selecione o modelo acima para informações detalhadas do modelo/ano.
                                                            </div>

                                                </div>
                                            </div>
                                            
                                            <?php else: ?>
                                            
                                            <div class="alert alert-<?php echo (($infoDPRF->theme_name == 'dark') ? 'warning' : 'info'); ?> f13">
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                <i class="fontello-icon-info-circle"></i>
                                                <span class="bold">Dica.</span> Selecione a marca abaixo para ver os modelos mais envolvidos em acidentes.
                                            </div>
                                                            
                                            <?php endif; ?>
                                        
                                            <h3><i class="aweso-icon-tasks"></i> Marcas <small class="hidden-phone"><?php echo $infoDPRF->Legenda_Periodo; ?></small></h3>
                                            
                                            <div class="row-fluid">
                                                <div class="span12">
                                                <p class="pagedesc">Confira a lista das <?php echo $Limit_Marcas; ?> marcas mais envolvidas em ocorrências.</p>
                                                
                                                <div class="tabbable tabs-top <?php echo $infoDPRF->theme['tabbable']; ?>">

                                                    <div class="tab-content">
                                                    
                                                        <div class="tab-pane active" id="modelos">

                                                        <table class="table table-condensed noborder">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Modelos</th>
                                                                    <th scope="col" width="90" class="text-right">Ocorrências</th>
                                                                    <th scope="col" width="60" class="hidden-phone text-center"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                
                                                                    $total_top = 0;
                                                                    $contador_marcas = 0;
                                                                    foreach($infoDPRF->resultados['TOTAL_MARCAS'] as $Marca => $Total){
                                                                        if(is_numeric($Total)){
                                                                            $total_top += $Total;
                                                                            $contador_marcas++;
                                                                            if($contador_marcas == $Limit_Marcas) break;
                                                                        }
                                                                    }
                                                                    
                                                                    $contador_marcas = 0;
                                                                    foreach($infoDPRF->resultados['TOTAL_MARCAS'] as $Marca => $Total){
                                                                        
                                                                        if($Marca == 'VEICULO_TIPO' || $Marca == 'TOTAL' || $Marca == 'NAODISPONIVEL') continue;
                                                                        
                                                                        $contador_marcas++;
                                                                        $Total_Marca = number_format($Total, 0, '', '.');
                                                                    
                                                                        // Total deste modelo no periodo anterior 
                                                                        $Total_Anterior = intval($infoDPRF_Anterior->resultados['TOTAL_MARCAS'][$Marca]);
                                                                        // Porcentagem de diferença entre os dois períodos comparados
                                                                        $Porcentagem = $infoDPRF->Porcentagem($Total, $Total_Anterior);                                                                        
                                                                        // Formata os números com milhar
                                                                        $Total_Atual = number_format($Total, 0, '', '.');
                                                                        $Total_Anterior = number_format($Total_Anterior, 0, '', '.');
                                                                        // Verifica se houve aumento ou diminuição para o modelo
                                                                        if($Porcentagem > 0){
                                                                            // Aumento
                                                                            $class_pct = "positive";
                                                                            $icone_pct = "up";
                                                                            $legenda = "Aumento de {$Porcentagem} em relação ao {$infoDPRF->Legenda_Periodo_Display} anterior";
                                                                        } else {
                                                                            // Diminuição
                                                                            $class_pct = "negative";
                                                                            $icone_pct = "down";
                                                                            $legenda = "Diminuição de -".substr($Porcentagem, 1)." em relação ao semestre anterior";
                                                                        }
                                                                        
                                                                        $pct = $Total/$total_top;
                                                                        
                                                                        if($contador_marcas == 1){
                                                                            $pct_atual = number_format( $pct * 100, 1 );
                                                                            if($pct_atual > 70) $fator_multiplicacao = 1.2; else
                                                                            if($pct_atual > 40) $fator_multiplicacao = 2;   else
                                                                            if($pct_atual > 30) $fator_multiplicacao = 2.6; else
                                                                            if($pct_atual > 20) $fator_multiplicacao = 4;   else
                                                                            if($pct_atual > 15) $fator_multiplicacao = 5;   else
                                                                            if($pct_atual > 10) $fator_multiplicacao = 6;   else
                                                                                                $fator_multiplicacao = 10;
                                                                        }
                                                                                
                                                                        $pct_barra = (number_format( $pct * 100, 2 ) * $fator_multiplicacao) . '%';

                                                                        echo '
                                                                            <tr>
                                                                                <th>
                                                                                    <a href="'. $Url_Base . $infoDPRF->URL.'/Marcas/'.$Marca.'">
                                                                                        <img src="'. $Url_Base .'assets/img/marcas/90x90/'.$infoDPRF->getIcone($Marca, $Modelo).'.jpg" width="34" class="fleft" />
                                                                                    </a>
                                                                                    <br />
                                                                                    <h4><a href="'. $Url_Base . $infoDPRF->URL.'/Marcas/'.$Marca.'">'.$infoDPRF->getMarca($Marca).'</a></h4>
                                                                                </th>
                                                                                <td class="text-right bold">'.$Total_Atual.'</td>
                                                                                <td class="hidden-phone text-right '.$class_pct.' bold"> 
                                                                                    <span class="Ttip" title="'.$legenda.'">'.$Porcentagem.'</span> 
                                                                                    <i class="indicator fontello-icon-'.$icone_pct.'-dir"></i> 
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="3">
                                                                                    <div class="progress '.$infoDPRF->theme['progress'].' progress-mini">
                                                                                        <div class="filler">
                                                                                            <div class="bar" style="width:'.$pct_barra.'"></div>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        ';
                                                                        if($contador_marcas == $Limit_Marcas) break;
                                                                    }
                                                                
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                        
                                                        </div>
                                                        

                                                        </div>
                                                        </div>
                                                        
                                                </div>
                                            </div>
                                            <!-- // row --> 
                                            
                                                                                    
                                        </div>
                                        <!-- // column -->
                                        
                                        <div class="span4 grider"><!-- 2 colunas -->

                                        <div class="row-fluid">
                                        
                                            <?php require_once('infodprf.lateral.php'); ?>

                                        </div><!-- // coluna --> 
                                        
                                    </div>
                                </div><!-- // coluna --> 
                                
                            </div><!-- // row --> 
                            
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