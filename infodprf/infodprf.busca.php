<?php

/**
 * DPRF.info
 * Página responsável pelo tratamento da busca (busca do topo e pelo menu "Filtrar por período") 
 * 
 * @author Mário Pácio <mario.pacio@gmail.com>
 * @copyright 2013
 * @version 1.0
 * @package DPRF.info
 * @license AGPLv3 - http://www.gnu.org/licenses/agpl-3.0.html
 * 
 */
 

    // Dados enviados pela busca
    $dados_busca = mysql_real_escape_string($_POST['input_busca_topo']);
    
    $_SESSION['input_busca_topo'] = $dados_busca;

    // Busca por BR sem UF
    $preg_br = '/^BR-([0-9]{3})$/';
    if(preg_match($preg_br, $dados_busca)){
        header('location: '. $Url_Base . $dados_busca);
        die;
    }
    
    // Busca por BR sem UF (sem traço)
    $preg_br = '/^BR([0-9]{3})$/';
    if(preg_match($preg_br, $dados_busca)){
        header('location: '. $Url_Base . substr($dados_busca, 0, 2).'-'.substr($dados_busca, 2, 3));
        die;
    }

    // Busca por BR com UF
    $preg_br_uf = '/^BR-([0-9]{3})\/([A-Z]{2})$/';
    if(preg_match($preg_br_uf, $dados_busca)){
        header('location: '. $Url_Base . $dados_busca);
        die;
    }
    
    // Busca por ano
    $preg_ano = '/^([0-9]{4})$/';
    /*
    if(preg_match($preg_ano, $dados_busca)){
        header('location: '. $Url_Base .'Anual/'.$dados_busca);
        die;
    }
    */
    
    // Busca por mês
    $preg_mes = '/^([0-9]{2})\/([0-9]{4})$/';
    if(preg_match($preg_mes, $dados_busca)){
        header('location: '. $Url_Base .'Mensal/'.$dados_busca);
        die;
    }
    
    // Busca por dia
    $preg_dia = '/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/';
    if(preg_match($preg_dia, $dados_busca)){
        header('location: '. $Url_Base .'Diario/'.$dados_busca);
        die;
    }

   
    if($_POST){
        
        $tp_periodo = $_POST['sel_tp_periodo'];
        $ano = $_POST['sel_ano'];
        $semestre = $_POST['sel_semestre'];
        $trimestre = $_POST['sel_trimestre'];
        $mes = $_POST['sel_mes'];
        $dia = $_POST['sel_dia'];

        switch($tp_periodo){
            /*
            case 'Anual':
                if(preg_match($preg_ano, $ano)){
                    header('location: '. $Url_Base .'Anual/'.$ano);
                    die;
                }
            break;
            */
            case 'Semestral':
                if(preg_match('/^(1|2)$/', $semestre) && preg_match($preg_ano, $ano)){
                    header('location: '. $Url_Base .'Semestre/'.$semestre.'/'.$ano);
                    die;
                }
            break;
            case 'Trimestral':
                if(preg_match('/^(1|2|3|4)$/', $trimestre) && preg_match($preg_ano, $ano)){
                    header('location: '. $Url_Base .'Trimestre/'.$trimestre.'/'.$ano);
                    die;
                }
            break;
            case 'Mensal':
                if(preg_match($preg_mes, $mes.'/'.$ano)){
                    header('location: '. $Url_Base .'Mensal/'.$mes.'/'.$ano);
                    die;
                }
            break;
            case 'Diario':
                if(preg_match($preg_dia, $dia.'/'.$mes.'/'.$ano)){
                    header('location: '. $Url_Base .'Diario/'.$dia.'/'.$mes.'/'.$ano);
                    die;
                }
            break;
        }
    }
    
    
?>

       
            <!-- page head -->
            <div class="row-fluid page-head">
                <br />
                <h2 class="page-title"><i class="fontello-icon-cancel-circle-4"></i> Busca por: <small><?php echo $dados_busca; ?></small></h2>
                <p class="pagedesc">Não conseguimos identificar o que você procura.</p>
            </div>
            <!-- /page head -->
            
            <!-- page-content -->
            <div id="page-content" class="page-content tab-content">
                    <!-- tab-pane -->
                    <div class="tab-pane active" id="Info">
                        <!-- section -->
                        <section>
                            <!-- row-fluid -->
                            <div class="row-fluid margin-top20">
                                <!-- span12 -->
                                <div class="span12">
                                    <!-- row-fluid -->
                                    <div class="row-fluid">
                                        <!-- span12 -->
                                        <div class="span12">
                                            <h3><i class="fontello-icon-down-circle2"></i> Algumas dicas de pesquisa</h3>
                                            <hr class="mm" />
                                            <p class="pagedesc">
                                            
                        Algumas dicas que podem ajudá-lo(a) a pesquisar rapidamente informações no aplicativo:
                        <br /><br />
                        <strong>Procure pelo nome da BR.</strong><br />
                        <em>Exemplo:</em> BR-101/SC
                        <br /><br />
                        <strong>Procure por períodos.</strong><br /> 
                        <em>Exemplos:</em> <br />
                        <strong>02/2012</strong> (buscar por Fevereiro de 2012)<br />
                        <strong>01/01/2012</strong> (buscar pelo dia 01 de Janeiro de 2012)
                        
                                            </p>
                                            <hr class="mm" />
                                        </div>
                                        <!-- /span12 -->
                                    </div>
                                    <!-- /row-fluid -->
                                </div>
                                <!-- /span12 -->
                            </div>
                            <!-- /row-fluid -->
                        </section>
                        <!-- /section -->
                </div>
                <!-- /tab-pane -->
             </div>
             <!-- /page-content -->
             
