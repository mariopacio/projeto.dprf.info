<?php
    
/**
 * DPRF.info
 * Arquivo responsável pela exibição dos trechos das rodovias mais perigosas
 * 
 * @author Mário Pácio <mario.pacio@gmail.com>
 * @copyright 2013
 * @version 1.0
 * @package DPRF.info
 * @license AGPLv3 - http://www.gnu.org/licenses/agpl-3.0.html
 * 
 */
 
    // Total de trechos que serão exibidos na listagem
    $Limit_Trechos = 50;

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
                                <li class="hidden-phone"><a href="<?php echo $Url_Base; ?><?php echo $infoDPRF->URL; ?>"><i class="aweso-icon-circle-arrow-left"></i><?php echo $infoDPRF->Legenda_Periodo; ?></a></li>
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
                                        
                                            <div class="alert alert-<?php echo (($infoDPRF->theme_name == 'dark') ? 'warning' : 'info'); ?> f13">
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                <i class="fontello-icon-info-circle"></i>
                                                <span class="bold">Dica.</span> Selecione um trecho abaixo para um mapeamento detalhado das ocorrências no local.
                                            </div>
                                        
                                            <h3><i class="aweso-icon-tasks"></i> Trechos mais perigosos <small class="hidden-phone"><?php echo $infoDPRF->Legenda_Periodo; ?></small></h3>
                                            
                                            <div class="row-fluid">
                                                <div class="span12">
                                                <p class="pagedesc">Confira a lista dos <?php echo $Limit_Trechos; ?> trechos mais perigosos neste <?php echo $infoDPRF->Legenda_Periodo_Display; ?>.</p>
                                                
                                                <div class="tabbable tabs-top <?php echo $infoDPRF->theme['tabbable']; ?>">

                                                    <div class="tab-content">
                                                    
                                                        <div class="tab-pane active" id="modelos">

                                                        <table class="table table-condensed noborder">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Trechos</th>
                                                                    <th scope="col" width="90" class="text-right">Ocorrências</th>
                                                                    <th scope="col" width="60" class="hidden-phone text-center"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                    
                                                                    $contador_trechos = 0;
                                                                    
                                                                    $total_top = 0;
                                                                    foreach($infoDPRF->resultados['LOCALBR']['TRECHOS'] as $BR_UF_Trecho => $Total){
                                                                        $total_top += $Total;
                                                                        $contador_trechos++;
                                                                        if($contador_trechos == $Limit_Trechos) break;
                                                                    }
                                                                    
                                                                    $contador_trechos = 0;
                                                                
                                                                    foreach($infoDPRF->resultados['LOCALBR']['TRECHOS'] as $BR_UF_Trecho => $Total){
                                                                        
                                                                        $contador_trechos++;

                                                                        $BR_Array = explode('/', $BR_UF_Trecho);
                                                                        
                                                                        $BR = $BR_Array[0];
                                                                        $UF = $BR_Array[1];
                                                                        $Trecho = $BR_Array[2];
                                                                        
                                                                        // Total deste modelo no periodo anterior 
                                                                        $Total_Anterior = intval($infoDPRF_Anterior->resultados['LOCALBR']['TRECHOS'][$BR_UF_Trecho]);
                                                                        // Porcentagem de diferença entre os dois períodos comparados
                                                                        $Porcentagem = $infoDPRF->Porcentagem($Total, $Total_Anterior);                                                                        
                                                                        // Formata os números com milhar
                                                                        $Total_Atual = number_format($Total, 0, '', '.');
                                                                        $Total_Anterior = number_format($Total_Anterior, 0, '', '.');
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
                                                                        $pct_barra = (number_format( $pct * 100, 2 ) * 18) . '%';

                                                                        echo '
                                                                            <tr>
                                                                                <th>
                                                                                    <h4><a href="'.$Url_Base.''.$BR.'/'.$UF.'/'.$Trecho.'/'.$infoDPRF->URL.'">'.$BR.' / '.$UF.' <small>Km '.$Trecho.'</small></a></h4>
                                                                                </th>
                                                                                <td class="text-right bold">'.$Total_Atual.'</td>
                                                                                <td class="hidden-phone text-right '.$class_pct.' bold"> 
                                                                                    <span class="Ttip" title="'.$legenda.'">'.$Porcentagem.'</span> 
                                                                                    <i class="indicator '.$icone_pct.'"></i> 
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
                                                                        if($contador_trechos == $Limit_Trechos) break;
                                                                            
                                                                    
                                                                    }

                                                                
                                                                
                                                                
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