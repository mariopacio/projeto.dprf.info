<?php

/**
 * DPRF.info
 * Página responsável pela exibição das pesquisas por datas com o resumo completo 
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
                        <li id="info-tab" class="active"><a href="#Info" data-toggle="tab"><i class="aweso-icon-tasks"></i>Informações</a></li>
                        <li id="escolher-tab" class="hidden-phone"><a href="#tperiodo" data-toggle="tab"><i class="aweso-icon-refresh"></i>Alterar período</a></li>
                    </ul>
                    <ul class="nav nav-dropdown pull-left visible-phone">
                        <li class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle" href="#">Mais <span class="hide-x4small">ações</span> <i class="fontello-icon-down-open"></i></a>
                            <ul class="dropdown-menu nav">
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
                                    <div class="row-fluid">
                                        <div class="span6 grider">
                                            
                                            <h3><i class="fontello-icon-chart-bar-3"></i><?php echo (($infoDPRF->Tipo_Periodo == 'Anual') ? 'Relatório anual de ' . $infoDPRF->Legenda_Periodo : $infoDPRF->Legenda_Periodo); ?> <small class="hidden-phone"><?php echo $infoDPRF->Legenda_Periodo_Complemento; ?></small></h3>
                                            
                                            <p class="pagedesc">O gráfico abaixo representa o comparativo mensal de ocorrências neste período.</p>
                                            
                                            <hr class="margin-mx" />
                                            
                                            <div id="dashChartVisitors" style="width:100%; height:170px" class="margin-bottom32"> </div>

                                            <hr class="mm" />
                                            
                                            <!-- Tipos de acidente --> 
                                            <div class="row-fluid">
                                                <div class="span12">
                                                
                                                <h3><i class="fontello-icon-down-open-1"></i>Tipos de acidente </h3>
                                                <p class="pagedesc">Conheça os principais tipos de acidentes nas rodovias federais.</p>
                                                
                                                <div class="tabbable tabbable-bordered tabs-top <?php echo $infoDPRF->theme['tabbable']; ?>">
                                                    <ul class="nav nav-tabs">
                                                        <li class="active"><a href="#tipos_comuns" data-toggle="tab">Tipos mais comuns</a></li>
                                                        <li class="hide-x4small"><a href="#todos_tipos" data-toggle="tab">Lista completa</a></li>
                                                    </ul>
                                                    <div class="tab-content">
                                                        <div class="tab-pane active" id="tipos_comuns">
                                                        
                                                        <table class="table table-condensed">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Tipo</th>
                                                                    <th scope="col" width="90" class="text-right">Ocorrências</th>
                                                                    <th scope="col" width="60" class="hidden-phone text-center"></th>
                                                                    <th scope="col" width="100"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                    $contador_tipo_acidente = 0;
                                                                    
                                                                    $Periodo_Array = $infoDPRF->Tipo_Periodo;
                                                                    if($Periodo_Array == 'Diario') $Periodo_Array = 'Horario';
                                                                    if($Periodo_Array == 'Mensal') $Periodo_Array = 'Diario';
                                                                    if($Periodo_Array == 'Anual') $Periodo_Array = 'Mensal';
                                                                        
                                                                    foreach($infoDPRF->resultados['TIPO_ACIDENTE'] as $id_tipo_acidente => $Total_Atual){
                                                                        
                                                                        if(!is_numeric($id_tipo_acidente) || $id_tipo_acidente == 'ND') continue;
                                                                        
                                                                        $contador_tipo_acidente++;
                                                                        
                                                                        $DSPLine = array();
                                                                        ksort($infoDPRF->resultados[$Periodo_Array]['TIPO_ACIDENTE']);
                                                                        foreach($infoDPRF->resultados[$Periodo_Array]['TIPO_ACIDENTE'] as $mes_tipo_acidente => $tipo_acidente){
                                                                            $DSPLine[$mes_tipo_acidente] = $tipo_acidente[$id_tipo_acidente];
                                                                        }
                                                                        ksort($DSPLine);
                                                                        $DSPLine = implode(',', $DSPLine);
            
                                                                        // Total deste tipo de acidente no periodo anterior 
                                                                        $Total_Anterior = intval($infoDPRF_Anterior->resultados['TIPO_ACIDENTE'][$id_tipo_acidente]);
                                                                        // Porcentagem de diferença entre os dois períodos comparados
                                                                        $Porcentagem = $infoDPRF->Porcentagem($Total_Atual, $Total_Anterior);
                                                                        // Formata os números com milhar
                                                                        $Total_Atual = number_format($Total_Atual, 0, '', '.');
                                                                        $Total_Anterior = number_format($Total_Anterior, 0, '', '.');
                                                                        // Verifica se houve aumento ou diminuição de ocorrências
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
                                                                        
                                                                        $Titulo_TAC = $infoDPRF->getTipoAcidente($id_tipo_acidente);
                                                                        
                                                                        echo '
                                                                            <tr>
                                                                                <td>
                                                                                    <span class="">
                                                                                        <a href="'. $Url_Base . $infoDPRF->URL.'/Tipos/'.$id_tipo_acidente.'" class="Ttip" title="Veja as causas de acidente mais comuns para: '.$Titulo_TAC.'">'.$Titulo_TAC.'</a>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="text-right bold">'.$Total_Atual.'</td>
                                                                                <td class="hidden-phone text-right '.$class_pct.' bold"> 
                                                                                    <span class="Ttip" title="'.$legenda.'">'.$Porcentagem.'</span> 
                                                                                    <i class="indicator '.$icone_pct.'"></i> 
                                                                                </td>
                                                                                <td><div class="section-chart"> <span class="DSPLine" values="'.$DSPLine.'"></span> </div></td>
                                                                            </tr>
                                                                        ';
                                                                        if($contador_tipo_acidente == 5) break;
                                                                    }
                                                                
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                        
                                                        </div>
                                                        
                                                        <div id="todos_tipos" class="tab-pane">
                                                        
                                                        <table class="table table-condensed">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Tipo</th>
                                                                    <th scope="col" width="90" class="text-right">Ocorrências</th>
                                                                    <th scope="col" width="60" class="hidden-phone text-center"></th>
                                                                    <th scope="col" width="100"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                    
                                                                    foreach($infoDPRF->resultados['TIPO_ACIDENTE'] as $id_tipo_acidente => $Total_Atual){

                                                                        if(!is_numeric($id_tipo_acidente) || $id_tipo_acidente == 'ND') continue;
                                                                        
                                                                        $DSPLine = array();
                                                                        foreach($infoDPRF->resultados[$Periodo_Array]['TIPO_ACIDENTE'] as $mes_tipo_acidente => $tipo_acidente){
                                                                            $DSPLine[] = $tipo_acidente[$id_tipo_acidente];
                                                                        }
                                                                        $DSPLine = implode(',', $DSPLine);
            
                                                                        // Total deste tipo de acidente no periodo anterior 
                                                                        $Total_Anterior = intval($infoDPRF_Anterior->resultados['TIPO_ACIDENTE'][$id_tipo_acidente]);
                                                                        // Porcentagem de diferença entre os dois períodos comparados
                                                                        $Porcentagem = $infoDPRF->Porcentagem($Total_Atual, $Total_Anterior);
                                                                        // Formata os números com milhar
                                                                        $Total_Atual = number_format($Total_Atual, 0, '', '.');
                                                                        $Total_Anterior = number_format($Total_Anterior, 0, '', '.');
                                                                        // Verifica se houve aumento ou diminuição de ocorrências
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
                                                                        
                                                                        $Titulo_TAC = $infoDPRF->getTipoAcidente($id_tipo_acidente);
                                                                        
                                                                        echo '
                                                                            <tr>
                                                                                <td>
                                                                                    <span class="">
                                                                                        <a href="'. $Url_Base . $infoDPRF->URL.'/Tipos/'.$id_tipo_acidente.'" class="Ttip" title="Veja as causas de acidente mais comuns para: '.$Titulo_TAC.'">'.$Titulo_TAC.'</a>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="text-right bold">'.$Total_Atual.'</td>
                                                                                <td class="hidden-phone text-right '.$class_pct.' bold"> 
                                                                                    <span class="Ttip" title="'.$legenda.'">'.$Porcentagem.'</span> 
                                                                                    <i class="indicator '.$icone_pct.'"></i> 
                                                                                </td>
                                                                                <td><div class="section-chart"> <span class="DSPLine" values="'.$DSPLine.'"></span> </div></td>
                                                                            </tr>
                                                                        ';
                                                                    }
                                                                
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                        
                                                        </div>
                                                        </div>
                                                        </div>
                                                        
                                                </div>
                                            </div>
                                            <!-- // tipos de acidente --> 
                                            
                                            
                                            <?php echo ($_GET['theme_name'] == 'dark') ? '<hr class="mm top5" />' : '<hr class="mm" />'; ?>
                                                                                        
                                            
                                            <!-- Causas de acidente --> 
                                            <div class="row-fluid">
                                                <div class="span12">
                                                
                                                <h3><i class="fontello-icon-down-open-1"></i>Causas de acidente </h3>
                                                <p class="pagedesc">Todo acidente tem um motivo, saiba quais os mais comuns.</p>
                                                
                                                <div class="tabbable tabbable-bordered tabs-top <?php echo $infoDPRF->theme['tabbable']; ?>">
                                                    <ul class="nav nav-tabs">
                                                        <li class="active"><a href="#causas_comuns" data-toggle="tab">Causas mais comuns</a></li>
                                                        <li class="hide-x4small"><a href="#todas_causas" data-toggle="tab">Lista completa</a></li>
                                                    </ul>
                                                    <div class="tab-content">
                                                        <div class="tab-pane active" id="causas_comuns">
                                                
                                                        <table class="table table-condensed">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Causa</th>
                                                                    <th scope="col" width="90" class="text-right">Ocorrências</th>
                                                                    <th scope="col" width="60" class="hidden-phone text-center"></th>
                                                                    <th scope="col" width="100"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                    $contador_causa_acidente = 0;
                                                                    foreach($infoDPRF->resultados['CAUSA_ACIDENTE'] as $id_causa_acidente => $Total_Atual){
                                                                        
                                                                        if(!is_numeric($id_causa_acidente) || $id_causa_acidente == 'ND') continue;
                                                                        
                                                                        $contador_causa_acidente++;
                                                                        
                                                                        $DSPLine = array();
                                                                        ksort($infoDPRF->resultados[$Periodo_Array]['CAUSA_ACIDENTE']);
                                                                        foreach($infoDPRF->resultados[$Periodo_Array]['CAUSA_ACIDENTE'] as $mes_causa_acidente => $causa_acidente){
                                                                            $DSPLine[] = $causa_acidente[$id_causa_acidente];
                                                                        }
                                                                        $DSPLine = implode(',', $DSPLine);
            
                                                                        // Total desta causa de acidente no periodo anterior 
                                                                        $Total_Anterior = intval($infoDPRF_Anterior->resultados['CAUSA_ACIDENTE'][$id_causa_acidente]);
                                                                        // Porcentagem de diferença entre os dois períodos comparados
                                                                        $Porcentagem = $infoDPRF->Porcentagem($Total_Atual, $Total_Anterior);
                                                                        // Formata os números com milhar
                                                                        $Total_Atual = number_format($Total_Atual, 0, '', '.');
                                                                        $Total_Anterior = number_format($Total_Anterior, 0, '', '.');
                                                                        // Verifica se houve aumento ou diminuição de ocorrências
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
                                                                        
                                                                        $Titulo_TCA = $infoDPRF->getCausaAcidente($id_causa_acidente);
                                                                        
                                                                        echo '
                                                                            <tr>
                                                                                <td>
                                                                                    <span class="">
                                                                                        <a href="'. $Url_Base . $infoDPRF->URL.'/Causas/'.$id_causa_acidente.'" class="Ttip" title="Veja os tipos de acidente mais comuns para: '.$Titulo_TCA.'">'.$Titulo_TCA.'</a>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="text-right bold">'.$Total_Atual.'</td>
                                                                                <td class="hidden-phone text-right '.$class_pct.' bold"> 
                                                                                    <span class="Ttip" title="'.$legenda.'">'.$Porcentagem.'</span> 
                                                                                    <i class="indicator '.$icone_pct.'"></i> 
                                                                                </td>
                                                                                <td><div class="section-chart"> <span class="DSPLine" values="'.$DSPLine.'"></span> </div></td>
                                                                            </tr>
                                                                        ';
                                                                        if($contador_causa_acidente == 5) break;
                                                                    }
                                                                
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    
                                                        </div>
                                                        
                                                        <div id="todas_causas" class="tab-pane">
                                                        
                                                        <table class="table table-condensed">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Causa</th>
                                                                    <th scope="col" width="90" class="text-right">Ocorrências</th>
                                                                    <th scope="col" width="60" class="hidden-phone text-center"></th>
                                                                    <th scope="col" width="100"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php

                                                                    foreach($infoDPRF->resultados['CAUSA_ACIDENTE'] as $id_causa_acidente => $Total_Atual){
                                                                        
                                                                        if(!is_numeric($id_causa_acidente) || $id_causa_acidente == 'ND') continue;
                                                                        
                                                                        $DSPLine = array();
                                                                        foreach($infoDPRF->resultados[$Periodo_Array]['CAUSA_ACIDENTE'] as $mes_causa_acidente => $causa_acidente){
                                                                            $DSPLine[] = $causa_acidente[$id_causa_acidente];
                                                                        }
                                                                        $DSPLine = implode(',', $DSPLine);
            
                                                                        // Total desta causa de acidente no periodo anterior 
                                                                        $Total_Anterior = intval($infoDPRF_Anterior->resultados['CAUSA_ACIDENTE'][$id_causa_acidente]);
                                                                        // Porcentagem de diferença entre os dois períodos comparados
                                                                        $Porcentagem = $infoDPRF->Porcentagem($Total_Atual, $Total_Anterior);
                                                                        // Formata os números com milhar
                                                                        $Total_Atual = number_format($Total_Atual, 0, '', '.');
                                                                        $Total_Anterior = number_format($Total_Anterior, 0, '', '.');
                                                                        // Verifica se houve aumento ou diminuição de ocorrências
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
                                                                        
                                                                        $Titulo_TCA = $infoDPRF->getCausaAcidente($id_causa_acidente);
                                                                        
                                                                        echo '
                                                                            <tr>
                                                                                <td>
                                                                                    <span class="">
                                                                                        <a href="'. $Url_Base . $infoDPRF->URL.'/Causas/'.$id_causa_acidente.'" class="Ttip" title="Veja os tipos de acidente mais comuns para: '.$Titulo_TCA.'">'.$Titulo_TCA.'</a>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="text-right bold">'.$Total_Atual.'</td>
                                                                                <td class="hidden-phone text-right '.$class_pct.' bold"> 
                                                                                    <span class="Ttip" title="'.$legenda.'">'.$Porcentagem.'</span> 
                                                                                    <i class="indicator '.$icone_pct.'"></i> 
                                                                                </td>
                                                                                <td><div class="section-chart"> <span class="DSPLine" values="'.$DSPLine.'"></span> </div></td>
                                                                            </tr>
                                                                        ';

                                                                    }
                                                                
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                        
                                                        </div>
                                                        </div>
                                                        </div>                                                        
                                                        
                                                </div>
                                            </div>
                                            <!-- Fim causas de acidente --> 
                                            
                                            
                                        </div>
                                        <!-- fim da coluna de estatíticas/esquerda -->
                                        
                                        <!-- 2 colunas/direita -->
                                        <div class="span6 grider">

                                            <div class="row-fluid">

                                                <!-- // coluna 6 (2/3) -->
                                                <div class="span6 grider-item">

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
                                                                        <span class="<?php echo $class_pct; ?>"><i class="indicator fontello-icon-<?php echo $icone_pct; ?>-dir"></i><sub><?php echo $Porcentagem; ?></sub></span>
                                                                    </h2>
                                                                    <?php if($Total_Ocorrencias_Anterior > 0): ?>
                                                                    <span class="info-block f11"><?php echo ucfirst($infoDPRF->Legenda_Periodo_Display); ?> anterior: <?php echo $Total_Ocorrencias_Anterior; ?> ocorrências</span>
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
                                                                    <h2 class="statistic-values Ttip" title="Veja o perfil completo dos acidentes neste trecho.">
                                                                        <?php echo $Trecho_Atual; ?> 
                                                                        <span class="<?php echo $class_pct; ?>"><i class="indicator fontello-icon-<?php echo $icone_pct; ?>-dir"></i><sup><?php echo $Porcentagem; ?></sup></span>
                                                                    </h2>
                                                                    <h5 class="statistic-values">KM <?php echo $Trecho_KM; ?> &nbsp; <?php echo $Total_Trecho; ?> ocorrências</h5>
                                                                    <?php if($Total_Trecho_Anterior > 0): ?>
                                                                    <span class="info-block f11"><?php echo ucfirst($infoDPRF->Legenda_Periodo_Display); ?> anterior: <?php echo $Total_Trecho_Anterior; ?> ocorrências</span>
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
                                                    
                                                    <!-- // modelos de veiculos -->
                                                    <div class="row-fluid">
                                                        <div class="span12 grider-item">
                                                            <div class="statistic-box well <?php echo $infoDPRF->theme['well']; ?> well-impressed">
                                                                <div class="section-title">
                                                                    <h5><i class="fontello-icon-target-2"></i> Modelos mais comuns</h5><!-- aweso-icon-truck -->
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
                                                                <div class="section-content veiculos">
                                                                <ul class="nav nav-well veiculos">
                                                                <?php
                                                                    $contador_veiculos = 0;
                                                                    foreach($infoDPRF->resultados['TOTAL_MODELOS'] as $Marca_Modelo => $Total){
                                                                        
                                                                        $contador_veiculos++;
                                                                        $Total_Veiculo = number_format($Total, 0, '', '.');
                                                                        $Marca_Modelo = explode('/', $Marca_Modelo);
                                                                        
                                                                        $Marca = $Marca_Modelo[0];
                                                                        $Modelo = $Marca_Modelo[1];
                                                                        
                                                                    ?>
                                                                    <li>
                                                                        <a class="well <?php echo $infoDPRF->theme['well']; ?>" href="<?php echo $Url_Base; ?><?php echo $infoDPRF->URL; ?>/Modelos/<?php echo $Marca; ?>/<?php echo $Modelo; ?>">
                                                                            <img src="<?php echo $Url_Base; ?>assets/img/marcas/90x90/<?php echo $infoDPRF->getIcone($Marca, $Modelo); ?>.jpg" width="34" class="fleft" />
                                                                            <h4 class="statistic-values pull-right"><?php echo $Total_Veiculo; ?></h4>
                                                                            <span class="modelo_veiculo"><?php echo $Modelo; ?></span>
                                                                            <span class="marca_veiculo"><?php echo $infoDPRF->getMarca($Marca); ?></span>
                                                                        </a>
                                                                    </li>
                                                                    <?php
                                                                        if($contador_veiculos == 5) break;
                                                                    }
                                                                
                                                                    ?>    
                                                                    <li class="mais">
                                                                        <a class="well <?php echo $infoDPRF->theme['well']; ?> f12" href="<?php echo $Url_Base; ?><?php echo $infoDPRF->URL; ?>/Modelos">
                                                                            <span class="pull-right">Veja mais modelos <i class="fontello-icon-right-dir-1"></i></span>
                                                                        </a>
                                                                    </li>                                                
                                                                </ul>
                                                                </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- // modelos de veiculos -->
                                                    
                                                    
                                                </div>
                                                <!-- // fim coluna 6 (2/3) -->
                                                
                                                <!-- // fim coluna 6 (3/3) -->
                                                <div class="span6 grider-item">
                                                
                                                
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
                                                                        <span class="<?php echo $class_pct; ?>"><i class="indicator fontello-icon-<?php echo $icone_pct; ?>-dir"></i><sub><?php echo $Porcentagem; ?></sub></span>
                                                                    </h2>
                                                                    <?php if($Total_Pessoas_Anterior > 0): ?>
                                                                    <span class="info-block f11"><?php echo ucfirst($infoDPRF->Legenda_Periodo_Display); ?> anterior: <?php echo $Total_Pessoas_Anterior; ?> pessoas</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- // pessoas -->

                                                

                                                    <!-- // sexo -->
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
                                                    <!-- // sexo -->
                                                    
                                                    
                                                    
                
                                                    

                                                    <!-- // idade dos condutores -->
                                                    <div class="row-fluid">
                                                        <div class="span12 grider-item">
                                                            <div class="statistic-box well <?php echo $infoDPRF->theme['well']; ?> well-impressed">
                                                                <div class="section-title">
                                                                    <h5><i class="fontello-icon-chart"></i> Idade dos condutores</h5>
                                                                </div>
                                                                
                                                                <div class="section-content idade">
                                                                
                                                                <ul class="nav nav-well idade">
                                                                <?php 
                                                                                  
                                                                    ksort($infoDPRF->resultados['CONDUTORES']['IDADE']);
                                                                    
                                                                    $total_condutores = $infoDPRF->resultados['CONDUTORES']['TOTAL'];
                                                                    
                                                                    foreach($infoDPRF->resultados['CONDUTORES']['IDADE'] as $Faixa_Idade => $Total){
                                                                        if($Faixa_Idade != 'ND'){
                                                                            
                                                                            $pct = $Total/$total_condutores;
                                                                            $pct_barra = (number_format( $pct * 100, 2 ) * 3) . '%';
                                                                            
                                                                            $Total_Idade = number_format($Total, 0, '', '.');
                                                                            
                                                                            echo '
                                                                            <li>
                                                                                <span class="well '.$infoDPRF->theme['well'].' dblock">
                                                                                    <a href="'. $Url_Base . $infoDPRF->URL.'/Idade/'.$Faixa_Idade.'" class="idade_pessoa Ttip" title="Trace o perfil dos acidentes para condutores '.(($Faixa_Idade == '0-17') ? 'com até 17 anos' : (($Faixa_Idade == '65+') ? 'com mais de 65 anos' : ' com faixa de idade entre ' . $Faixa_Idade . ' anos')).'">
                                                                                        <h4 class="statistic-values pull-right">'. $Total_Idade .'</h4>
                                                                                        <span>'. $Faixa_Idade .' anos</span>
                                                                                    </a>
                                                                                </span>
                                                                                <div class="progress '.$infoDPRF->theme['progress'].' progress-mini" style="margin:0 10px 2px; ">
                                                                                    <div class="filler">
                                                                                        <div class="bar" style="width:'.$pct_barra.'"></div>
                                                                                    </div>
                                                                                </div>
                                                                            </li>';
                                                                            
                                                                        } else {
                                                                            $Dados_Indisponiveis = number_format($Total, 0, '', '.');
                                                                        }
                                                            
                                                                    }
                                                                    echo '<li><div class="info-block pad10 f11 l14"><i class="fontello-icon-info-circle"></i> A idade de aproximadamente '.$Dados_Indisponiveis.' condutores não foi registrada ou identificada.</div></li>';
                                                                    echo '</ul>';
                                                                ?>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                    <!-- // idade dos condutores -->
                                                    


                                                
                                                
                                            </div><!-- // row --> 
                                        </div><!-- // column --> 
                                        
                                    </div>
                                </div><!-- // column --> 
                                
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