<?php

/**
 * DPRF.info
 * Include dos menus visíveis na aba "Alterar período"
 * 
 * @author Mário Pácio <mario.pacio@gmail.com>
 * @copyright 2013
 * @version 1.0
 * @package DPRF.info
 * @license AGPLv3 - http://www.gnu.org/licenses/agpl-3.0.html
 * 
 */
                                    
                    $coluna_1 = '';
                    $coluna_2 = '';
                    
                    // Anos disponíveis 
                    $anos = array(2013, 2012, 2011, 2010, 2009, 2008, 2007);
                    // Contador de anos exibidos
                    $contador_anos = 0;
                    // Divide o total de anos pelas duas colunas
                    $contador_anos_divisao = round((count($anos) / 2)); 
                    
                    $Parte_Url_1 = (($infoDPRF->BR) ? '/BR-'.$infoDPRF->BR : '').
                                   (($infoDPRF->UF) ? '/'.$infoDPRF->UF : '').
                                   (($infoDPRF->Trecho) ? '/'.$infoDPRF->Trecho : '');
                    
                    $Parte_Url_2 = (($_GET['tipo_exibicao'] == 'Tipos') ? '/Tipos' : '').
                                   (($_GET['tipo_exibicao'] == 'Causas') ? '/Causas' : '').
                                   (($_GET['tipo'] == 'idade') ? '/Idade' : '').
                                   (($infoDPRF->TipoAcidente) ? '/'.$infoDPRF->TipoAcidente : '').
                                   (($infoDPRF->CausaAcidente) ? '/'.$infoDPRF->CausaAcidente : '').
                                   (($infoDPRF->Marca) ? '/'.$infoDPRF->Marca : '').
                                   (($infoDPRF->Modelo) ? '/'.$infoDPRF->Modelo : '').
                                   (($infoDPRF->Idade) ? '/'.$infoDPRF->Idade : '');
                    
                    // Percorre os anos disponíveis
                    foreach($anos as $ano){
                                            
                        if($contador_anos < $contador_anos_divisao){ 
                                                
                            $coluna_1 .= '
                                <div class="widget '.$infoDPRF->theme['widget'].' widget-collapsible widget-sel-periodo">
                                
                                    <div class="widget-header header-small clickable collapsed" data-toggle="collapse" data-target="#ano_'.$ano.'">
                                        <h5><i class="fontello-icon-plus-circle"></i> '.$ano.' </h5>
                                        <div class="widget-tool"><span class="btn btn-glyph btn-link widget-toggle-btn fontello-icon-arrow-combo"></span></div>
                                    </div>
                                    
                                    <div id="ano_'.$ano.'" class="widget-content collapse">
                                        <div class="widget-body">
                                        
                                            <!--ul class="nav nav-well">';
                                                $coluna_1 .= '<li><a class="well '.$infoDPRF->theme['well'].'" href="'.(($Url_Base == '/') ? '' : $Url_Base).$Parte_Url_1.'/Anual/'.$ano.$Parte_Url_2.'"><i class="fontello-icon-calendar"></i> <i class="chevron fontello-icon-right-dir-1"></i> Relatório anual de '.$ano.' <br />&nbsp; &nbsp; &nbsp; <small>Janeiro a Dezembro</small></a></li>';                                                               
                                                $coluna_1 .= '
                                            </ul-->
                                            
                                            <!-- widget semestre -->
                                            <div class="widget '.$infoDPRF->theme['widget'].' widget-collapsible">
                                                <!-- widget-header -->
                                                <div class="widget-header header-small clickable collapsed" data-toggle="collapse" data-target="#semestre_'.$ano.'">
                                                    <h5><i class="fontello-icon-plus-circle"></i> Semestral </h5>
                                                    <div class="widget-tool"><span class="btn btn-glyph btn-link widget-toggle-btn fontello-icon-arrow-combo"></span></div>
                                                </div>
                                                <!-- /widget-header -->
                                                <!-- widget-content -->
                                                <div id="semestre_'.$ano.'" class="widget-content collapse">
                                                    <!-- widget-body -->
                                                    <div class="widget-body">
                                                        <ul class="nav nav-well">';
                                                            $coluna_1 .= '<li><a class="well '.$infoDPRF->theme['well'].'" href="'. (($Url_Base == '/') ? '' : $Url_Base) . $Parte_Url_1.'/Semestre/1/'.$ano.$Parte_Url_2.'"><i class="fontello-icon-calendar"></i> <i class="chevron fontello-icon-right-dir-1"></i> 1° Semestre de '.$ano.' <br />&nbsp; &nbsp; &nbsp; <small>Janeiro a Junho</small></a></li>';
                                                            // Bloqueamos o link para o 2° semestre de 2013 que ainda não tem dados
                                                            if($ano != 2013)
                                                            $coluna_1 .= '<li><a class="well '.$infoDPRF->theme['well'].'" href="'. (($Url_Base == '/') ? '' : $Url_Base) . $Parte_Url_1.'/Semestre/2/'.$ano.$Parte_Url_2.'"><i class="fontello-icon-calendar"></i> <i class="chevron fontello-icon-right-dir-1"></i> 2° Semestre de '.$ano.' <br />&nbsp; &nbsp; &nbsp; <small>Julho a Dezembro</small></a></li>';                                                                
                                                            $coluna_1 .= '
                                                        </ul>
                                                    </div>
                                                    <!-- /widget-body -->
                                                </div>
                                                <!-- /widget-content -->                                                
                                            </div>
                                            <!-- /widget semestre -->
                                            
                                            <!-- widget trimestre -->
                                            <div class="widget '.$infoDPRF->theme['widget'].' widget-collapsible">
                                                <!-- widget-header -->
                                                <div class="widget-header header-small clickable collapsed" data-toggle="collapse" data-target="#trimestre_'.$ano.'">
                                                    <h5><i class="fontello-icon-plus-circle"></i> Trimestral </h5>
                                                    <div class="widget-tool"><span class="btn btn-glyph btn-link widget-toggle-btn fontello-icon-arrow-combo"></span></div>
                                                </div>
                                                <!-- /widget-header -->
                                                <!-- widget-content -->
                                                <div id="trimestre_'.$ano.'" class="widget-content collapse">
                                                    <!-- widget-body -->
                                                    <div class="widget-body">
                                                        <ul class="nav nav-well">';
                                                            $coluna_1 .= '<li><a class="well '.$infoDPRF->theme['well'].'" href="'. (($Url_Base == '/') ? '' : $Url_Base) . $Parte_Url_1.'/Trimestre/1/'.$ano.'"><i class="fontello-icon-calendar"></i> <i class="chevron fontello-icon-right-dir-1"></i> 1° Trimestre de '.$ano.' <br />&nbsp; &nbsp; &nbsp; <small>Janeiro a Março</small></a></li>';
                                                            $coluna_1 .= '<li><a class="well '.$infoDPRF->theme['well'].'" href="'. (($Url_Base == '/') ? '' : $Url_Base) . $Parte_Url_1.'/Trimestre/2/'.$ano.'"><i class="fontello-icon-calendar"></i> <i class="chevron fontello-icon-right-dir-1"></i> 2° Trimestre de '.$ano.' <br />&nbsp; &nbsp; &nbsp; <small>Abril a Junho</small></a></li>';
                                                            // Bloqueamos o link para os trimestres de 2013 que ainda não tem dados
                                                            if($ano != 2013){
                                                                $coluna_1 .= '<li><a class="well '.$infoDPRF->theme['well'].'" href="'. (($Url_Base == '/') ? '' : $Url_Base) . $Parte_Url_1.'/Trimestre/3/'.$ano.'"><i class="fontello-icon-calendar"></i> <i class="chevron fontello-icon-right-dir-1"></i> 3° Trimestre de '.$ano.' <br />&nbsp; &nbsp; &nbsp; <small>Julho a Setembro</small></a></li>';
                                                                $coluna_1 .= '<li><a class="well '.$infoDPRF->theme['well'].'" href="'. (($Url_Base == '/') ? '' : $Url_Base) . $Parte_Url_1.'/Trimestre/4/'.$ano.'"><i class="fontello-icon-calendar"></i> <i class="chevron fontello-icon-right-dir-1"></i> 4° Trimestre de '.$ano.' <br />&nbsp; &nbsp; &nbsp; <small>Outubro a Dezembro</small></a></li>';
                                                            }                                                                
                                                            $coluna_1 .= '
                                                        </ul>
                                                    </div>
                                                    <!-- /widget-body -->
                                                </div>
                                                <!-- /widget-content -->                                                
                                            </div>
                                            <!-- /widget trimestre -->
                                            
                                            <!-- widget mensal -->
                                            <div class="widget '.$infoDPRF->theme['widget'].' widget-collapsible">
                                                <!-- widget-header -->
                                                <div class="widget-header header-small clickable collapsed" data-toggle="collapse" data-target="#mensal_'.$ano.'">
                                                    <h5><i class="fontello-icon-plus-circle"></i> Mensal </h5>
                                                    <div class="widget-tool"><span class="btn btn-glyph btn-link widget-toggle-btn fontello-icon-arrow-combo"></span></div>
                                                </div>
                                                <!-- /widget-header -->
                                                <!-- widget-content -->
                                                <div id="mensal_'.$ano.'" class="widget-content collapse">
                                                    <!-- widget-body -->
                                                    <div class="widget-body">
                                                        <ul class="nav nav-well">';
                                                            for($mes = 1; $mes <= 12; $mes++){
                                                                // Bloqueamos o link para os meses de 2013 que ainda não tem dados
                                                                if($ano != 2013 || ($ano == 2013 && $mes < 7)){
                                                                    $mes_com_zero = (($mes < 10) ? '0'.$mes : $mes);
                                                                    $coluna_1 .= '<li><a class="well '.$infoDPRF->theme['well'].'" href="'. (($Url_Base == '/') ? '' : $Url_Base) . $Parte_Url_1.'/Mensal/'.$mes_com_zero.'/'.$ano.$Parte_Url_2.'"><i class="fontello-icon-calendar"></i> <i class="chevron fontello-icon-right-dir-1"></i> '.$infoDPRF->getMesFull($mes_com_zero).' de '.$ano.' </a></li>';
                                                                } 
                                                            }
                                                            $coluna_1 .= '
                                                        </ul>
                                                    </div>
                                                    <!-- /widget-body -->
                                                </div>
                                                <!-- /widget-content -->                                                
                                            </div>
                                            <!-- /widget trimestre -->
                                            
                                        </div>
                                    </div>
                                    
                                </div>';
                                                
                        } else {

                            $coluna_2 .= '
                                <div class="widget '.$infoDPRF->theme['widget'].' widget-collapsible widget-sel-periodo">
                                
                                    <div class="widget-header header-small clickable collapsed" data-toggle="collapse" data-target="#ano_'.$ano.'">
                                        <h5><i class="fontello-icon-plus-circle"></i> '.$ano.' </h5>
                                        <div class="widget-tool"><span class="btn btn-glyph btn-link widget-toggle-btn fontello-icon-arrow-combo"></span></div>
                                    </div>
                                    
                                    <div id="ano_'.$ano.'" class="widget-content collapse">
                                        <div class="widget-body">
                                        
                                            <!--ul class="nav nav-well">';
                                                $coluna_2 .= '<li><a class="well '.$infoDPRF->theme['well'].'" href="'. (($Url_Base == '/') ? '' : $Url_Base) . $Parte_Url_1.'/Anual/'.$ano.$Parte_Url_2.'"><i class="fontello-icon-calendar"></i> <i class="chevron fontello-icon-right-dir-1"></i> Relatório anual de '.$ano.' <br />&nbsp; &nbsp; &nbsp; <small>Janeiro a Dezembro</small></a></li>';                                                               
                                                $coluna_2 .= '
                                            </ul-->
                                            
                                            <!-- widget semestre -->
                                            <div class="widget '.$infoDPRF->theme['widget'].' widget-collapsible">
                                                <!-- widget-header -->
                                                <div class="widget-header header-small clickable collapsed" data-toggle="collapse" data-target="#semestre_'.$ano.'">
                                                    <h5><i class="fontello-icon-plus-circle"></i> Semestral </h5>
                                                    <div class="widget-tool"><span class="btn btn-glyph btn-link widget-toggle-btn fontello-icon-arrow-combo"></span></div>
                                                </div>
                                                <!-- /widget-header -->
                                                <!-- widget-content -->
                                                <div id="semestre_'.$ano.'" class="widget-content collapse">
                                                    <!-- widget-body -->
                                                    <div class="widget-body">
                                                        <ul class="nav nav-well">';
                                                            $coluna_2 .= '<li><a class="well '.$infoDPRF->theme['well'].'" href="'. (($Url_Base == '/') ? '' : $Url_Base) . $Parte_Url_1.'/Semestre/1/'.$ano.$Parte_Url_2.'"><i class="fontello-icon-calendar"></i> <i class="chevron fontello-icon-right-dir-1"></i> 1° Semestre de '.$ano.' <br />&nbsp; &nbsp; &nbsp; <small>Janeiro a Junho</small></a></li>';
                                                            // Bloqueamos o link para o 2° semestre de 2013 que ainda não tem dados
                                                            if($ano != 2013)
                                                            $coluna_2 .= '<li><a class="well '.$infoDPRF->theme['well'].'" href="'. (($Url_Base == '/') ? '' : $Url_Base) . $Parte_Url_1.'/Semestre/2/'.$ano.$Parte_Url_2.'"><i class="fontello-icon-calendar"></i> <i class="chevron fontello-icon-right-dir-1"></i> 2° Semestre de '.$ano.' <br />&nbsp; &nbsp; &nbsp; <small>Julho a Dezembro</small></a></li>';                                                                
                                                            $coluna_2 .= '
                                                        </ul>
                                                    </div>
                                                    <!-- /widget-body -->
                                                </div>
                                                <!-- /widget-content -->                                                
                                            </div>
                                            <!-- /widget semestre -->
                                            
                                            <!-- widget trimestre -->
                                            <div class="widget '.$infoDPRF->theme['widget'].' widget-collapsible">
                                                <!-- widget-header -->
                                                <div class="widget-header header-small clickable collapsed" data-toggle="collapse" data-target="#trimestre_'.$ano.'">
                                                    <h5><i class="fontello-icon-plus-circle"></i> Trimestral </h5>
                                                    <div class="widget-tool"><span class="btn btn-glyph btn-link widget-toggle-btn fontello-icon-arrow-combo"></span></div>
                                                </div>
                                                <!-- /widget-header -->
                                                <!-- widget-content -->
                                                <div id="trimestre_'.$ano.'" class="widget-content collapse">
                                                    <!-- widget-body -->
                                                    <div class="widget-body">
                                                        <ul class="nav nav-well">';
                                                            $coluna_2 .= '<li><a class="well '.$infoDPRF->theme['well'].'" href="'. (($Url_Base == '/') ? '' : $Url_Base) . $Parte_Url_1.'/Trimestre/1/'.$ano.$Parte_Url_2.'"><i class="fontello-icon-calendar"></i> <i class="chevron fontello-icon-right-dir-1"></i> 1° Trimestre de '.$ano.' <br />&nbsp; &nbsp; &nbsp; <small>Janeiro a Março</small></a></li>';
                                                            $coluna_2 .= '<li><a class="well '.$infoDPRF->theme['well'].'" href="'. (($Url_Base == '/') ? '' : $Url_Base) . $Parte_Url_1.'/Trimestre/2/'.$ano.$Parte_Url_2.'"><i class="fontello-icon-calendar"></i> <i class="chevron fontello-icon-right-dir-1"></i> 2° Trimestre de '.$ano.' <br />&nbsp; &nbsp; &nbsp; <small>Abril a Junho</small></a></li>';
                                                            // Bloqueamos o link para os trimestres de 2013 que ainda não tem dados
                                                            if($ano != 2013){
                                                                $coluna_2 .= '<li><a class="well '.$infoDPRF->theme['well'].'" href="'. (($Url_Base == '/') ? '' : $Url_Base) . $Parte_Url_1.'/Trimestre/3/'.$ano.$Parte_Url_2.'"><i class="fontello-icon-calendar"></i> <i class="chevron fontello-icon-right-dir-1"></i> 3° Trimestre de '.$ano.' <br />&nbsp; &nbsp; &nbsp; <small>Julho a Setembro</small></a></li>';
                                                                $coluna_2 .= '<li><a class="well '.$infoDPRF->theme['well'].'" href="'. (($Url_Base == '/') ? '' : $Url_Base) . $Parte_Url_1.'/Trimestre/4/'.$ano.$Parte_Url_2.'"><i class="fontello-icon-calendar"></i> <i class="chevron fontello-icon-right-dir-1"></i> 4° Trimestre de '.$ano.' <br />&nbsp; &nbsp; &nbsp; <small>Outubro a Dezembro</small></a></li>';
                                                            }                                                                
                                                            $coluna_2 .= '
                                                        </ul>
                                                    </div>
                                                    <!-- /widget-body -->
                                                </div>
                                                <!-- /widget-content -->                                                
                                            </div>
                                            <!-- /widget trimestre -->
                                            
                                            <!-- widget mensal -->
                                            <div class="widget '.$infoDPRF->theme['widget'].' widget-collapsible">
                                                <!-- widget-header -->
                                                <div class="widget-header header-small clickable collapsed" data-toggle="collapse" data-target="#mensal_'.$ano.'">
                                                    <h5><i class="fontello-icon-plus-circle"></i> Mensal </h5>
                                                    <div class="widget-tool"><span class="btn btn-glyph btn-link widget-toggle-btn fontello-icon-arrow-combo"></span></div>
                                                </div>
                                                <!-- /widget-header -->
                                                <!-- widget-content -->
                                                <div id="mensal_'.$ano.'" class="widget-content collapse">
                                                    <!-- widget-body -->
                                                    <div class="widget-body">
                                                        <ul class="nav nav-well">';
                                                            for($mes = 1; $mes <= 12; $mes++){
                                                                // Bloqueamos o link para os meses de 2013 que ainda não tem dados
                                                                if($ano != 2013 || ($ano == 2013 && $mes < 7)){
                                                                    $mes_com_zero = (($mes < 10) ? '0'.$mes : $mes);
                                                                    $coluna_2 .= '<li><a class="well '.$infoDPRF->theme['well'].'" href="'. (($Url_Base == '/') ? '' : $Url_Base) . $Parte_Url_1.'/Mensal/'.$mes_com_zero.'/'.$ano.$Parte_Url_2.'"><i class="fontello-icon-calendar"></i> <i class="chevron fontello-icon-right-dir-1"></i> '.$infoDPRF->getMesFull($mes_com_zero).' de '.$ano.' </a></li>';
                                                                } 
                                                            }
                                                            $coluna_2 .= '
                                                        </ul>
                                                    </div>
                                                    <!-- /widget-body -->
                                                </div>
                                                <!-- /widget-content -->                                                
                                            </div>
                                            <!-- /widget trimestre -->
                                            
                                        </div>
                                    </div>
                                    
                                </div>';
                                                
                        }
                        
                        $contador_anos++;

                    }
                                        
?>