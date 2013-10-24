<?php

/**
 * DPRF.info
 * Página responsável pela exibição e mapeamento de causas x tipos de acidentes
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
                                        <div class="span8 grider ">
                                        
                                            <?php 
                                            
                                                if($infoDPRF->TipoAcidente || $infoDPRF->CausaAcidente): 
                                                
                                                    $ID_Tipo_Causa_Atual = ($infoDPRF->TipoAcidente) ? $infoDPRF->TipoAcidente : $infoDPRF->CausaAcidente;
                                                    
                                                    if($infoDPRF->TipoAcidente){
                                                        $Tipo_Causa_Legenda = $infoDPRF->getTipoAcidente($ID_Tipo_Causa_Atual);
                                                        $Subtitulo = 'Veja abaixo as principais causas de acidente para ocorrências com: <strong>'.$Tipo_Causa_Legenda.'</strong>';
                                                        $Obj_Array_1 = 'TIPO_ACIDENTE';
                                                        $Obj_Array_2 = 'TIPO_x_CAUSA';
                                                    } else {
                                                        $Tipo_Causa_Legenda = $infoDPRF->getCausaAcidente($ID_Tipo_Causa_Atual);
                                                        $Subtitulo = 'Veja abaixo os principais tipos de acidente para ocorrências com: <strong>'.$Tipo_Causa_Legenda.'</strong>';
                                                        $Obj_Array_1 = 'CAUSA_ACIDENTE';
                                                        $Obj_Array_2 = 'CAUSA_x_TIPO';
                                                    }
                                                
                                                    ?>
                                                    
                                                    <div class="row-fluid">
                                                    <div class="span12 well <?php echo $infoDPRF->theme['well']; ?>">

                                                    <h3 class="l22">
                                                        <i class="fontello-icon-chart"></i><?php echo $Tipo_Causa_Legenda; ?>
                                                        <small class="hidden-phone"><?php echo $infoDPRF->Legenda_Periodo; ?></small>
                                                    </h3>
                                                    
                                                    <?php echo $Subtitulo; ?>
                                                    
                                                    <hr class="mm top5" />
                                                        
                                                    <table class="table table-condensed table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col"><?php echo ($infoDPRF->TipoAcidente) ? 'Causas dos acidentes' : 'Tipos de acidentes'; ?></th>
                                                                    <th scope="col" width="90" class="text-right">Ocorrências</th>
                                                                    <th scope="col" width="75" class="text-center"></th>
                                                                    <th scope="col" width="120"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php 
                                                            
                                                                $total_top = 0;
                                                            
                                                                arsort($infoDPRF->resultados[$Obj_Array_1][$Obj_Array_2][$ID_Tipo_Causa_Atual]);
                                                                
                                                                foreach($infoDPRF->resultados[$Obj_Array_1][$Obj_Array_2][$ID_Tipo_Causa_Atual] as $ID_Tipo_Causa => $Total){
                                                                    $total_top += $Total;
                                                                }
                                                                
                                                                $contador = 0;
                                                                
                                                                foreach($infoDPRF->resultados[$Obj_Array_1][$Obj_Array_2][$ID_Tipo_Causa_Atual] as $ID_Tipo_Causa => $Total){
                                                                    
                                                                    // Total atual formatado 
                                                                    $Total_Atual = number_format($Total, 0, '', '.');
                                                                    // Total anterior para comparativo
                                                                    $Total_Anterior = intval($infoDPRF_Anterior->resultados[$Obj_Array_1][$Obj_Array_2][$ID_Tipo_Causa_Atual][$ID_Tipo_Causa]);
                                                                            
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
                                                                    
                                                                    if($contador == 0){
                                                                        $pct_atual = number_format( $pct * 100, 1 );
                                                                        if($pct_atual > 70) $fator_multiplicacao = 1.2; else
                                                                        if($pct_atual > 40) $fator_multiplicacao = 2;   else
                                                                        if($pct_atual > 30) $fator_multiplicacao = 2.6; else
                                                                        if($pct_atual > 20) $fator_multiplicacao = 4;   else
                                                                        if($pct_atual > 10) $fator_multiplicacao = 8;   else
                                                                                            $fator_multiplicacao = 10;
                                                                        $contador++;
                                                                    }
                                                                    
                                                                    $pct_barra = (number_format( $pct * 100, 2 ) * $fator_multiplicacao) . '%';
                                                                    
                                                                    if($infoDPRF->TipoAcidente){
                                                                        // Busca o titulo da causa de acidente
                                                                        $Titulo_Display = $infoDPRF->getCausaAcidente($ID_Tipo_Causa);
                                                                        $Url = 'Causas';
                                                                    } else {
                                                                        // Busca o titulo dos tipos de acidente
                                                                        $Titulo_Display = $infoDPRF->getTipoAcidente($ID_Tipo_Causa); 
                                                                        $Url = 'Tipos';
                                                                    }                                                                                                                               
                                                                                                                                        
                                                                ?>
                                                                                                                                
                                                                <tr>
                                                                    <td class="text-left">
                                                                        <a href="<?php echo $Url_Base; ?><?php echo $infoDPRF->URL; ?>/<?php echo $Url; ?>/<?php echo $ID_Tipo_Causa; ?>"><?php echo $Titulo_Display; ?></a>
                                                                    </td>
                                                                    <td class="text-right"><?php echo $Total_Atual; ?></td>
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
                                                                    } // foreach
                                                            ?>                                                                
                                                            </tbody>
                                                        </table>
                                                        
                                                        </div>
                                                        </div>
                                                        
                                                        <hr class="mm top5" />
                                                        
                                            <?php endif; ?>
                                            
                                            
                                        
                                            <h3><i class="aweso-icon-tasks"></i> <?php echo (($_GET['tipo_exibicao'] == 'Tipos') ? 'Tipos de acidente' : 'Causas de acidente'); ?> <small class="hidden-phone"><?php echo $infoDPRF->Legenda_Periodo; ?></small></h3>
                                            
                                            <div class="row-fluid">
                                                <div class="span12">
                                                <p class="pagedesc">Confira a lista <?php echo (($_GET['tipo_exibicao'] == 'Tipos') ? 'dos tipos de acidentes' : 'das causas de acidente '); ?> que foram registradas nas rodovias federais.</p>
                                                
                                                <div class="tabbable  tabs-top <?php echo $infoDPRF->theme['tabbable']; ?>">

                                                    <div class="tab-content">
                                                    
                                                        <div class="tab-pane active" id="modelos">

                                                            <table class="table table-condensed noborder">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">Tipos</th>
                                                                        <th scope="col" width="90" class="text-right">Ocorrências</th>
                                                                        <th scope="col" width="60" class="text-center"></th>
                                                                        <th scope="col" width="100" class="hidden-phone"></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    
                                                                        $contador_tipo_acidente = 0;
                                                                        
                                                                        $Total_Ocorrencias = $infoDPRF->resultados['TOTAL_OCORRENCIAS'];
                                                                
                                                                        
                                                                        $Periodo_Array = $infoDPRF->Tipo_Periodo;     
                                                                        if($Periodo_Array == 'Diario') $Periodo_Array = 'Horario';
                                                                        if($Periodo_Array == 'Mensal') $Periodo_Array = 'Diario';
                                                                        if($Periodo_Array == 'Anual')  $Periodo_Array = 'Mensal';
                                                                        
                                                                        if($_GET['tipo_exibicao'] == 'Tipos')  $Obj_Array = 'TIPO_ACIDENTE';
                                                                        if($_GET['tipo_exibicao'] == 'Causas') $Obj_Array = 'CAUSA_ACIDENTE';
                                                                            
                                                                        foreach($infoDPRF->resultados[$Obj_Array] as $id_tipo_causa_acidente => $Total){
                                                                            
                                                                            if(!is_numeric($id_tipo_causa_acidente) || $id_tipo_causa_acidente == 'ND') continue;
                                                                            
                                                                            $contador_tipo_acidente++;
                                                                            
                                                                            $DSPLine = array();
                                                                            $sparkline = array();
                                                                            ksort($infoDPRF->resultados[$Periodo_Array][$Obj_Array]);
                                                                            foreach($infoDPRF->resultados[$Periodo_Array][$Obj_Array] as $mes_tipo_acidente => $tipo_acidente){
                                                                                $DSPLine[] = $tipo_acidente[$id_tipo_causa_acidente];
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
                                                                            $Total_Anterior = intval($infoDPRF_Anterior->resultados[$Obj_Array][$id_tipo_causa_acidente]);
                                                                            
                                                                            // Porcentagem de diferença entre os dois períodos comparados
                                                                            $Porcentagem = $infoDPRF->Porcentagem($Total, $Total_Anterior);
                                                                            
                                                                            // Formata os números com milhar
                                                                            $Total_Atual = number_format($Total, 0, '', '.');
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
                                                                            
                                                                            $pct = $Total/$Total_Ocorrencias;
                                                                            $pct_barra = (number_format( $pct * 100, 2 ) * 3) . '%';
                                                                            
                                                                            if($_GET['tipo_exibicao'] == 'Tipos')
                                                                                $Titulo_Display = $infoDPRF->getTipoAcidente($id_tipo_causa_acidente);
                                                                            else
                                                                                $Titulo_Display = $infoDPRF->getCausaAcidente($id_tipo_causa_acidente);
    
                                                                            echo '
                                                                                <tr>
                                                                                    <th>
                                                                                        <a href="'. $Url_Base . $infoDPRF->URL .'/'.$_GET['tipo_exibicao'].'/'.$id_tipo_causa_acidente.'" class="f14 Ttip" title="Veja '.(($_GET['tipo_exibicao'] == 'Causas') ? 'os principais tipos' : 'as principais causas').' de acidentes para: '.$Titulo_Display.'">'.$Titulo_Display.'</a>
                                                                                    </th>
                                                                                    <td class="text-right bold">'.$Total_Atual.'</td>
                                                                                    <td class="text-right '.$class_pct.' bold"> 
                                                                                        <span class="Ttip" title="'.$legenda.'">'.$Porcentagem.'</span> 
                                                                                        <i class="indicator '.$icone_pct.'"></i> 
                                                                                    </td>
                                                                                    <td class="hidden-phone"><div class="section-chart"><span class="DSPLine" values="'.$DSPLine.'"></span></div></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td colspan="4" class="no-hover">
                                                                                        <div class="progress '.$infoDPRF->theme['progress'].' progress-mini">
                                                                                            <div class="filler">
                                                                                                <div class="bar" style="width:'.$pct_barra.'"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
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