<?php

/**
 * DPRF.info
 * P�gina com os modelos de ve�culos mais envolvidos em ocorr�ncias
 * 
 * @author M�rio P�cio <mario.pacio@gmail.com>
 * @copyright 2013
 * @version 1.0
 * @package DPRF.info
 * @license AGPLv3 - http://www.gnu.org/licenses/agpl-3.0.html
 * 
 */
 
    // Total de modelos que ser�o exibidos na listagem
    $Limit_Modelos = 50;

    $Array_Marcas = array();
    foreach($infoDPRF->resultados['VEICULOS'] as $Marca => $Array){
        if($Marca != 'VEICULO_TIPO' && $Marca != 'TOTAL' && $Marca != 'NAODISPONIVEL'){
            $Array_Marcas[$Marca] = $Array['TOTAL'];
        }
    }
    arsort($Array_Marcas);
    
?>
            
            <div class="row-fluid page-head">
                <div class="qrcode"><a href="#QRCode" data-toggle="modal" class="Ltip" title="N�o sabe o que �? Clique e veja."><img src="<?php echo $infoDPRF->QRCode('1'); ?>" /></a></div>
                <h2 class="page-title"><i class="fontello-icon-monitor"></i> Bem-vindo(a) <small class="hide-x2small">ao aplicativo DPRF.info</small></h2>
                <p class="pagedesc visible-desktop visible-tablet">Estat�sticas de ocorr�ncias em rodovias federais a partir de 2007. <a href="<?php echo $Url_Base; ?>About">Mais..</a></p>
                <div class="page-bar">
                    <ul class="nav nav-tabs pull-left">
                        <li id="info-tab" class="active"><a href="#Info" data-toggle="tab"><i class="aweso-icon-tasks"></i> Informa��es</a></li>
                        <li class="hidden-phone"><a href="<?php echo $Url_Base; ?><?php echo $infoDPRF->URL; ?>"><i class="aweso-icon-circle-arrow-left"></i><?php echo $infoDPRF->Legenda_Periodo; ?></a></li>
                        <li id="escolher-tab" class="hidden-phone"><a href="#tperiodo" data-toggle="tab"><i class="aweso-icon-refresh"></i>Alterar per�odo</a></li>
                    </ul>
                    <ul class="nav nav-dropdown pull-left visible-phone">
                        <li class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle" href="#">Mais <span class="hide-x4small">a��es</span> <i class="fontello-icon-down-open"></i></a>
                            <ul class="dropdown-menu nav">
                                <li><a href="<?php echo $Url_Base; ?><?php echo $infoDPRF->URL; ?>"><i class="aweso-icon-circle-arrow-left"></i><?php echo $infoDPRF->Legenda_Periodo; ?></a></li>
                                <li><a href="#tperiodo" data-toggle="tab"><i class="aweso-icon-refresh"></i>Alterar per�odo</a></li>
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
                                        
                                            <?php if($infoDPRF->Marca && $infoDPRF->Modelo): ?>
                                            
                                                <div class="row-fluid">
                                                    <div class="span12 well <?php echo $infoDPRF->theme['well']; ?>">
    
                                                        <h3 class="l22">
                                                            <img src="<?php echo $Url_Base; ?>assets/img/marcas/90x90/<?php echo $infoDPRF->getIcone($infoDPRF->Marca, $infoDPRF->Modelo); ?>.jpg" width="50" class="fleft bimg" />
                                                            <small class="h3_modelo"><?php echo $infoDPRF->getMarca($infoDPRF->Marca); ?></small>
                                                            <br />
                                                            <?php echo $infoDPRF->Modelo; ?>
                                                            <small class="hidden-phone"><?php echo $infoDPRF->Legenda_Periodo; ?></small>
                                                        </h3>
                                                        
                                                        <hr class="mm" />
                                                            
                                                        <table class="table table-condensed table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col" width="40">Ano</th>
                                                                        <th scope="col" width="90" class="text-right">Ocorr�ncias</th>
                                                                        <th scope="col" width="75" class="text-center"></th>
                                                                        <th scope="col"></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php 
                                                                    
                                                                    $Total_Modelo = 0;
                                                                    $contador = 0;
                                                                
                                                                    $Objeto = $infoDPRF->resultados['VEICULOS'][$infoDPRF->Marca]['MODELOS'][$infoDPRF->Modelo];
                                                                    if(is_array($Objeto)): 
                                                                        // Ordena pelo mais novo
                                                                        krsort($Objeto);
                                                                        $total_top = intval($infoDPRF->resultados['TOTAL_MODELOS'][$infoDPRF->Marca.'/'.$infoDPRF->Modelo]);
                                                                        // Percorre os anos
                                                                        foreach($Objeto as $Ano => $Total){
                                                                            if(is_numeric($Ano)):
                                                                                $Total = intval($Total);
                                                                                $Total_Modelo += $Total;
                                                                                // Total atual formatado 
                                                                                $Total_Ocorrencias = number_format($Total, 0, '', '.');
                                                                                // Total anterior para comparativo
                                                                                $Total_Anterior = intval($infoDPRF_Anterior->resultados['VEICULOS'][$infoDPRF->Marca]['MODELOS'][$infoDPRF->Modelo][$Ano]);
                                                                                // Porcentagem de diferen�a entre os dois periodos
                                                                                $Porcentagem = $infoDPRF->Porcentagem($Total, $Total_Anterior);   
                                                                                // Verifica se houve aumento ou diminui��o para o ano/modelo
                                                                                if($Porcentagem > 0){
                                                                                    // Aumento
                                                                                    $class_pct = "positive";
                                                                                    $icone_pct = "fontello-icon-up-dir";
                                                                                    $legenda = "Aumento de {$Porcentagem} em rela��o ao {$infoDPRF->Legenda_Periodo_Display} anterior";
                                                                                } else if($Porcentagem < 0){
                                                                                    // Diminui��o
                                                                                    $class_pct = "negative";
                                                                                    $icone_pct = "fontello-icon-down-dir";
                                                                                    $legenda = "Diminui��o de ".substr($Porcentagem, 1)." em rela��o ao {$infoDPRF->Legenda_Periodo_Display} anterior";
                                                                                } else {
                                                                                    // Diminui��o
                                                                                    $class_pct = "c777";
                                                                                    $icone_pct = "fontello-icon-arrow-combo";
                                                                                    $legenda = "Nenhuma diferen�a em rela��o ao {$infoDPRF->Legenda_Periodo_Display} anterior";
                                                                                }
                                                                                
                                                                                $pct = $Total/$total_top;
                                                                                
                                                                                if($contador == 0){
                                                                                    $pct_atual = number_format( $pct * 100, 1 );
                                                                                    if($pct_atual > 70) $fator_multiplicacao = 1.2; else
                                                                                    if($pct_atual > 40) $fator_multiplicacao = 2;   else
                                                                                    if($pct_atual > 30) $fator_multiplicacao = 2.5; else
                                                                                    if($pct_atual > 20) $fator_multiplicacao = 4;   else
                                                                                    if($pct_atual > 15) $fator_multiplicacao = 5;   else
                                                                                    if($pct_atual > 10) $fator_multiplicacao = 6;   else
                                                                                                        $fator_multiplicacao = 9;
                                                                                    $contador++;
                                                                                }
                                                                    
                                                                                $pct_barra = (number_format( $pct * 100, 2 ) * $fator_multiplicacao) . '%';
                                                                    ?>
                                                                    <tr>
                                                                        <td class="text-center"><?php echo $Ano; ?></td>
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
                                            
                                            <?php else: ?>
                                            
                                            <div class="alert alert-<?php echo (($infoDPRF->theme_name == 'dark') ? 'warning' : 'info'); ?> f13">
                                                <button type="button" class="close" data-dismiss="alert">�</button>
                                                <i class="fontello-icon-info-circle"></i>
                                                <span class="bold">Dica.</span> Selecione o modelo abaixo para um mapeamento detalhado do ano/modelo.
                                            </div>
                                                            
                                            <?php endif; ?>
                                        
                                            <h3><i class="aweso-icon-tasks"></i> Modelos de ve�culos <small class="hidden-phone"><?php echo $infoDPRF->Legenda_Periodo; ?></small></h3>
                                            
                                            <div class="row-fluid">
                                                <div class="span12">
                                                <p class="pagedesc">Confira a lista dos <?php echo $Limit_Modelos; ?> modelos mais envolvidos em ocorr�ncias no <?php echo $infoDPRF->Legenda_Periodo_Display; ?>.</p>
                                                
                                                <div class="tabbable tabs-top <?php echo $infoDPRF->theme['tabbable']; ?>">
                                                    <!--ul class="nav nav-tabs">
                                                        <li class="active"><a href="#tipos_comuns" data-toggle="tab">TOP <?php echo $Limit_Modelos; ?></a></li>
                                                    </ul-->
                                                    <div class="tab-content">
                                                    
                                                        <div class="tab-pane active" id="modelos">

                                                        <table class="table table-condensed noborder">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Modelos</th>
                                                                    <th scope="col" width="90" class="text-right">Ocorr�ncias</th>
                                                                    <th scope="col" width="60" class="hidden-phone text-center"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                
                                                                    $total_top = 0;
                                                                    $contador_veiculos = 0;
                                                                    foreach($infoDPRF->resultados['TOTAL_MODELOS'] as $Marca_Modelo => $Total){
                                                                        $total_top += $Total;
                                                                        $contador_veiculos++;
                                                                        if($contador_veiculos == $Limit_Modelos) break;
                                                                    }
                                                                    
                                                                    $contador_veiculos = 0;
                                                                    foreach($infoDPRF->resultados['TOTAL_MODELOS'] as $Marca_Modelo => $Total){
                                                                        
                                                                        $contador_veiculos++;
                                                                        $Total_Veiculo = number_format($Total, 0, '', '.');
                                                                        $Marca_Modelo_Array = explode('/', $Marca_Modelo);
                                                                        
                                                                        $Marca = $Marca_Modelo_Array[0];
                                                                        $Modelo = $Marca_Modelo_Array[1];
                                                                    
                                                                        // Total deste modelo no periodo anterior 
                                                                        $Total_Anterior = intval($infoDPRF_Anterior->resultados['TOTAL_MODELOS'][$Marca_Modelo]);
                                                                        // Porcentagem de diferen�a entre os dois per�odos comparados
                                                                        $Porcentagem = $infoDPRF->Porcentagem($Total, $Total_Anterior);                                                                        
                                                                        // Formata os n�meros com milhar
                                                                        $Total_Atual = number_format($Total, 0, '', '.');
                                                                        $Total_Anterior = number_format($Total_Anterior, 0, '', '.');
                                                                        // Verifica se houve aumento ou diminui��o para o modelo
                                                                        if($Porcentagem > 0){
                                                                            // Aumento
                                                                            $class_pct = "positive";
                                                                            $icone_pct = "up";
                                                                            $legenda = "Aumento de {$Porcentagem} em rela��o ao {$infoDPRF->Legenda_Periodo_Display} anterior";
                                                                        } else {
                                                                            // Diminui��o
                                                                            $class_pct = "negative";
                                                                            $icone_pct = "down";
                                                                            $legenda = "Diminui��o de -".substr($Porcentagem, 1)." em rela��o ao semestre anterior";
                                                                        }
                                                                        
                                                                        $pct = $Total/$total_top;
                                                                        
                                                                        if($contador_veiculos == 1){
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
                                                                                    <a href="'. $Url_Base . $infoDPRF->URL .'/Modelos/'.$Marca.'/'.$Modelo.'">
                                                                                        <img src="'. $Url_Base .'assets/img/marcas/90x90/'.$infoDPRF->getIcone($Marca, $Modelo).'.jpg" width="34" class="fleft" />
                                                                                    </a>
                                                                                    <small>'.$Marca.'</small>
                                                                                    <h4><a href="'. $Url_Base . $infoDPRF->URL.'/Modelos/'.$Marca.'/'.$Modelo.'">'.$Modelo.'</a></h4>
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
                                                                        if($contador_veiculos == $Limit_Modelos) break;
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
                                                <h3><i class="aweso-icon-refresh"></i> &nbsp;Alterar per�odo</h3>
                                                <p class="pagedesc">Selecione abaixo o per�odo que voc� deseja visualizar as estat�sticas.</p>
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