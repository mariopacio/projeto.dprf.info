<?php

/**
 * DPRF.info
 * Página com a faixa etária dos condutores 
 * 
 * @author Mário Pácio <mario.pacio@gmail.com>
 * @copyright 2013
 * @version 1.0
 * @package DPRF.info
 * @license AGPLv3 - http://www.gnu.org/licenses/agpl-3.0.html
 * 
 */
 
?>

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
            <!-- // page head -->
            
            <div id="page-content" class="page-content tab-content">
            
                    <div class="tab-pane active" id="Info">
                        <section>
                            <div class="row-fluid margin-top20">
                                <div class="span12 well <?php echo $infoDPRF->theme['well']; ?>">
                                    <div class="row-fluid">
                                        <div class="span8 grider">
                                        
                                            <?php 
                                            
                                                if($infoDPRF->Idade): 
                                                
                                                $Esconde_Legenda = true;
                                                
                                                ?>
                                                
                                                <div class="row-fluid">
                                                    <div class="span12 well <?php echo $infoDPRF->theme['well']; ?>">

                                                    <h3 class="l22">
                                                        <small class="h3_modelo">Estatísticas por faixa etária</small>
                                                        <br />
                                                        <i class="fontello-icon-down-circle2"></i><?php 
                                                        
                                                                    echo (($infoDPRF->Idade == '0-17') 
                                                                        ? 'Até 17 anos' : 
                                                                            (($infoDPRF->Idade == '65+') 
                                                                                ? 'Mais de 65 anos' :
                                                                                    'Entre ' . $infoDPRF->Idade . ' anos')); ?>
                                                        <small class="hidden-phone"><?php echo $infoDPRF->Legenda_Periodo; ?></small>
                                                    </h3>
                                                
                                                    <hr class="mm" />
                                                
                                                
                                                <div class="tabbable tabbable-bordered tabs-top <?php echo $infoDPRF->theme['tabbable']; ?>">
                                                
                                                    <ul class="nav nav-tabs">
                                                        <li class="active"><a href="#tipos" data-toggle="tab">Tipos de acidente</a></li>
                                                        <li class=""><a href="#causas" data-toggle="tab">Causas de acidente</a></li>
                                                    </ul>
                                                    
                                                    <div class="tab-content">
                                                    
                                                        <div class="tab-pane active" id="tipos">
                                                        
                                                            <table class="table table-condensed table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">Tipo</th>
                                                                        <th scope="col" width="90" class="text-right">Ocorrências</th>
                                                                        <th scope="col" width="75" class="text-center"></th>
                                                                        <th scope="col"width="100"></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php 
 
                                                                    arsort($infoDPRF->resultados['IDADE']['TIPO_ACIDENTE'][$infoDPRF->Idade]);
                                                                    
                                                                    $Tipo_Acidente_Idade = $infoDPRF->resultados['IDADE']['TIPO_ACIDENTE'][$infoDPRF->Idade];
    
                                                                    if(is_array($Tipo_Acidente_Idade)): 
    
                                                                        $total_top = intval($infoDPRF->resultados['CONDUTORES']['IDADE'][$infoDPRF->Idade]);
                                                                        
                                                                        // Percorre os anos
                                                                        foreach($Tipo_Acidente_Idade as $Tipo_Acidente => $Total){
                                                                            
                                                                            if(is_numeric($Tipo_Acidente)):
                                                                            
                                                                                $Total = intval($Total);
                                                                                // Total atual formatado 
                                                                                $Total_Ocorrencias = number_format($Total, 0, '', '.');
                                                                                // Total anterior para comparativo
                                                                                $Total_Anterior = intval($infoDPRF_Anterior->resultados['IDADE']['TIPO_ACIDENTE'][$infoDPRF->Idade][$Tipo_Acidente]);
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
                                                                                    // Diminuição
                                                                                    $class_pct = "c777";
                                                                                    $icone_pct = "fontello-icon-arrow-combo";
                                                                                    $legenda = "Nenhuma diferença em relação ao {$infoDPRF->Legenda_Periodo_Display} anterior";
                                                                                }
                                                                                
                                                                                $pct = $Total/$total_top;
                                                                                $pct_barra = (number_format( $pct * 100, 2 ) * 4) . '%';
                                                                                
                                                                                $Legenda_Tipo_Acidente = $infoDPRF->getTipoAcidente($Tipo_Acidente);
                                                                    ?>
                                                                    <tr>
                                                                        <td class="text-left">
                                                                            <a href="<?php echo $Url_Base; ?><?php echo $infoDPRF->URL; ?>/Tipos/<?php echo $Tipo_Acidente; ?>" class="Ttip" title="Veja as causas de acidente mais comuns para: <?php echo $Legenda_Tipo_Acidente; ?>">
                                                                                <?php echo $Legenda_Tipo_Acidente; ?>
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
                                                                            endif; 
                                                                        } // foreach
                                                                    endif; 
                                                                ?>
                                                                </tbody>
                                                            </table>
                                                            
                                                        </div>
                                                        
                                                        <div id="causas" class="tab-pane">
                                                        
                                                            <table class="table table-condensed">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">Causa</th>
                                                                        <th scope="col" width="90" class="text-right">Ocorrências</th>
                                                                        <th scope="col" width="75" class="text-center"></th>
                                                                        <th scope="col"width="100"></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php 
                                                                    
                                                                    //echo '<pre>';
                                                                    //print_r($infoDPRF->resultados['IDADE']['TIPO_ACIDENTE']);
                                                                    //die;
                                                                    
                                                                    arsort($infoDPRF->resultados['IDADE']['CAUSA_ACIDENTE'][$infoDPRF->Idade]);
                                                                    
                                                                    $Causa_Acidente_Idade = $infoDPRF->resultados['IDADE']['CAUSA_ACIDENTE'][$infoDPRF->Idade];
    
                                                                    if(is_array($Causa_Acidente_Idade)): 
    
                                                                        $total_top = intval($infoDPRF->resultados['CONDUTORES']['IDADE'][$infoDPRF->Idade]);
                                                                        
                                                                        // Percorre os anos
                                                                        foreach($Causa_Acidente_Idade as $Causa_Acidente => $Total){
                                                                            
                                                                            if(is_numeric($Causa_Acidente)):
                                                                            
                                                                                $Total = intval($Total);
                                                                                // Total atual formatado 
                                                                                $Total_Ocorrencias = number_format($Total, 0, '', '.');
                                                                                // Total anterior para comparativo
                                                                                $Total_Anterior = intval($infoDPRF_Anterior->resultados['IDADE']['CAUSA_ACIDENTE'][$infoDPRF->Idade][$Causa_Acidente]);
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
                                                                                    $legenda = "Diminuição de -".intval(substr($Porcentagem, 1))." em relação ao {$infoDPRF->Legenda_Periodo_Display} anterior";
                                                                                } else {
                                                                                    // Diminuição
                                                                                    $class_pct = "c777";
                                                                                    $icone_pct = "fontello-icon-arrow-combo";
                                                                                    $legenda = "Nenhuma diferença em relação ao {$infoDPRF->Legenda_Periodo_Display} anterior";
                                                                                }
                                                                                
                                                                                $pct = $Total/$total_top;
                                                                                $pct_barra = (number_format( $pct * 100, 2 ) * 2) . '%';
                                                                                
                                                                                $Legenda_Causa_Acidente = $infoDPRF->getCausaAcidente($Causa_Acidente);
                                                                    ?>
                                                                    <tr>
                                                                        <td class="text-left">
                                                                            <a href="<?php echo $Url_Base; ?><?php echo $infoDPRF->URL; ?>/Causas/<?php echo $Causa_Acidente; ?>" class="Ttip" title="Veja os tipos de acidente mais comuns para: <?php echo $Legenda_Causa_Acidente; ?>">
                                                                                <?php echo $Legenda_Causa_Acidente; ?>
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
                                                                            endif; 
                                                                        } // foreach
                                                                    endif; 
                                                                ?>
                                                                </tbody>
                                                            </table>
                                                        
                                                        </div>
                                                        </div>
                                                        </div>
                                                        
                                                        </div>
                                                        </div>
                                                        
                                            <?php endif; ?>
                                            
                                            
                                        
                                            <h3>
                                                <i class="fontello-icon-share-1"></i> Idade dos condutores 
                                                <?php if(!$Esconde_Legenda): ?><small class="hidden-phone"><?php echo $infoDPRF->Legenda_Periodo; ?></small><?php endif; ?>
                                            </h3>
                                            
                                            <div class="row-fluid">
                                                <div class="span12">
                                                <p class="pagedesc">Confira as estatísticas por faixa etária dos condutores envolvidos em ocorrências neste <?php echo $infoDPRF->Legenda_Periodo_Display; ?>.</p>
                                                
                                                <div class="tabbable tabs-top <?php echo $infoDPRF->theme['tabbable']; ?>">

                                                    <div class="tab-content">
                                                    
                                                        <div class="tab-pane active" id="idades">

                                                            <table class="table table-condensed noborder">
                                                                <tbody>
                                                                    <?php
                                                                                                                                        
                                                                        ksort($infoDPRF->resultados['CONDUTORES']['IDADE']);
                                                                        
                                                                        $total_condutores = $infoDPRF->resultados['CONDUTORES']['TOTAL'];
                                                                        
                                                                        $contador_veiculos = 0;
                                                                        foreach($infoDPRF->resultados['CONDUTORES']['IDADE'] as $Faixa_Idade => $Total){
                                                                            
                                                                            if($Faixa_Idade != 'ND'){
                                                                                
                                                                                $pct = $Total/$total_condutores;
                                                                                $pct_barra = (number_format( $pct * 100, 2 ) * 3) . '%';
                                                                                
                                                                                $Total_Idade = number_format($Total, 0, '', '.');
                                                                            
                                                                                // Total desta faixa no periodo anterior 
                                                                                $Total_Anterior = intval($infoDPRF_Anterior->resultados['CONDUTORES']['IDADE'][$Faixa_Idade]);
                                                                                // Porcentagem de diferença entre os dois períodos comparados
                                                                                $Porcentagem = $infoDPRF->Porcentagem($Total, $Total_Anterior);                                                                        
                                                                                // Formata os números com milhar
                                                                                $Total_Atual = number_format($Total, 0, '', '.');
                                                                                $Total_Anterior = number_format($Total_Anterior, 0, '', '.');
                                                                                // Verifica se houve aumento ou diminuição 
                                                                                if($Porcentagem > 0){
                                                                                    // Aumento
                                                                                    $class_pct = "positive";
                                                                                    $icone_pct = "up";
                                                                                    $legenda = "Aumento de {$Porcentagem} em relação ao {$infoDPRF->Legenda_Periodo_Display} anterior";
                                                                                } else {
                                                                                    // Diminuição
                                                                                    $class_pct = "negative";
                                                                                    $icone_pct = "down";
                                                                                    $legenda = "Diminuição de -".substr($Porcentagem, 1)." em relação ao {$infoDPRF->Legenda_Periodo_Display} anterior";
                                                                                }
                                                                                
                                                                                arsort($infoDPRF->resultados['IDADE']['TIPO_ACIDENTE'][$Faixa_Idade]);
                                                                                $Tipo_Acidente_Idade = $infoDPRF->resultados['IDADE']['TIPO_ACIDENTE'][$Faixa_Idade];
                                                                                
                                                                                $Tipo_Acidente_ID = key($Tipo_Acidente_Idade);
                                                                                $Tipo_Acidente_Valor = reset($Tipo_Acidente_Idade);
                                                                                
                                                                                // Causas
                                                                                arsort($infoDPRF->resultados['IDADE']['CAUSA_ACIDENTE'][$Faixa_Idade]);
                                                                                $Causa_Acidente_Idade = $infoDPRF->resultados['IDADE']['CAUSA_ACIDENTE'][$Faixa_Idade];
                                                                                
                                                                                $Causa_Acidente_ID = key($Causa_Acidente_Idade);
                                                                                $Causa_Acidente_Valor = reset($Causa_Acidente_Idade);
                                                                                
                                                                                $Legenda_Tipo_Acidente = $infoDPRF->getTipoAcidente($Tipo_Acidente_ID);
                                                                                $Legenda_Causa_Acidente = $infoDPRF->getCausaAcidente($Causa_Acidente_ID);
                                                                                
                                                                                $Class_Text = (($infoDPRF->theme_name == 'dark') ? 'cAAA' : 'c666');
        
                                                                                echo '
                                                                                    <tr>
                                                                                        <th>
                                                                                           <h4>
                                                                                            <a href="'. $Url_Base . $infoDPRF->URL.'/Idade/'.$Faixa_Idade.'" class="Ttip" title="Veja as ocorrências mais comuns em condutores '.(($Faixa_Idade == '0-17') ? 'com até 17 anos' : (($Faixa_Idade == '65+') ? 'com mais de 65 anos' : ' com idade entre ' . $Faixa_Idade . ' anos')).'">
                                                                                                <i class="aweso-icon-caret-right"></i> '.(($Faixa_Idade == '0-17') ? 'Até 17 anos' : (($Faixa_Idade == '65+') ? 'Mais de 65 anos' : 'Entre ' . $Faixa_Idade . ' anos')).'
                                                                                            </a>
                                                                                           </h4>
                                                                                           <div class="'.$Class_Text.' top5">
                                                                                            &nbsp; &nbsp; <i class="fontello-icon-level-down"></i>
                                                                                            <strong><a href="'. $Url_Base . $infoDPRF->URL.'/Tipos/'.$Tipo_Acidente_ID.'" class="Ttip" title="Veja as causas de acidente mais comuns para: '.$Legenda_Tipo_Acidente.'">'.$Legenda_Tipo_Acidente.'</a></strong> 
                                                                                            é o tipo de acidente mais comum causado(a) por 
                                                                                            <strong><a href="'. $Url_Base . $infoDPRF->URL.'/Causas/'.$Causa_Acidente_ID.'" class="Ttip" title="Veja os tipos de acidente mais comuns para: '.$Legenda_Causa_Acidente.'">'.$Legenda_Causa_Acidente.'</a></strong>.
                                                                                           </div>
                                                                                        </th>
                                                                                        <td width="90" class="text-right bold">'.$Total_Atual.'</td>
                                                                                        <td width="60" class="hidden-phone text-right '.$class_pct.' bold"> 
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
                                                                                    <tr>
                                                                                        <td colspan="3" class="pad0">
    
                                                                                        </td>
                                                                                    </tr>
    
                                                                                    <tr>
                                                                                        <td colspan="3"></td>
                                                                                    </tr>
                                                                                ';
                                                                            
                                                                            }
                                                                            
                                                                        }
                                                                    
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        
                                                        </div>
                                                        

                                                        </div>
                                                        </div>
                                                        
                                                </div>
                                            </div>
                                            <!-- // Example row --> 
                                            
                                                                                    
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