<?php

/**
 * DPRF.info
 * Classe principal do aplicativo DPRF.info
 * 
 * @author Mário Pácio <mario.pacio@gmail.com>
 * @copyright 2013
 * @version 1.0
 * @package infoDPRF
 * @license AGPLv3 - http://www.gnu.org/licenses/agpl-3.0.html
 * 
 */


class infoDPRF {
    
    var $Title,
        $Description,
        $Keywords;
    
    var $Periodo;
    var $Tipo_Periodo;
    
    var $Legenda_Periodo;
    var $Legenda_Periodo_Complemento;
    var $Legenda_Abangencia;
    var $Legenda_Periodo_Display;
    
    var $Ano,
        $Semestre,
        $Trimestre,
        $Mes,
        $Dia;
    
    var $BR,
        $UF,
        $Trecho;
    
    var $Dia_Inicial = '01';
    var $Dia_Final = '31';
    
    var $Mes_Inicial = '01';
    var $Mes_Final = '12';
    
    var $Ano_Anterior,
        $Mes_Anterior,
        $Periodo_Anterior;
    
    var $Modelo,
        $Marca;
    
    var $Idade;
    
    var $TipoAcidente;
    var $CausaAcidente;
    
    var $cache_file;

    var $Grupo_Atual;
    
    var $URL_QRCode_Small = 'http://chart.apis.google.com/chart?cht=qr&chs=75x75&chld=L|2&choe=UTF-8&chl=http%3A%2F%2Fdprf.info';
    var $URL_QRCode_Medium = 'http://chart.apis.google.com/chart?cht=qr&chs=90x90&chld=L|2&choe=UTF-8&chl=http%3A%2F%2Fdprf.info';
    var $QRCode = '';
    
    var $URL;
    
    /**
     * O índice de gravidade é baseado em estudo do Instituto de Pesquisa Econômica Aplicada (Ipea). 
     * O índice define pesos para os acidentes:
     * - acidente sem vítima: 1 ponto
     * - acidente com vítima: 5 pontos
     * - acidente com óbito: 25 pontos
     * Para o cálculo, multiplica-se o número de acidentes registrados no trecho pela pontuação de cada tipo. 
     * O somatório final é o índice de gravidade. 
     */
    var $Indice_SemVitima = 1;
    var $Indice_ComVitima = 5;
    var $Indice_ComObito  = 25;
    
    var $db;
    var $where = array();
    
    var $theme_name;
    var $theme = array();
    
    var $resultados;
    
    var $TOTAL_OCORRENCIAS = 0;
    
    var $uf_estados = array(
        'AC' => 'Acre',
        'AL' => 'Alagoas',
        'AM' => 'Amazonas',
        'AP' => 'Amapá',
        'BA' => 'Bahia',
        'CE' => 'Ceará',
        'DF' => 'Distrito Federal',
        'ES' => 'Espírito Santo',
        'GO' => 'Goiás',
        'MA' => 'Maranhão',
        'MG' => 'Minas Gerais',
        'MS' => 'Mato Grosso do Sul',
        'MT' => 'Mato Grosso',
        'PA' => 'Pará',
        'PB' => 'Paraíba',
        'PE' => 'Pernambuco',
        'PI' => 'Piaui',
        'PR' => 'Paraná',
        'RJ' => 'Rio de Janeiro',
        'RN' => 'Rio Grande do Norte',
        'RO' => 'Rondônia',
        'RR' => 'Roraima',
        'RS' => 'Rio Grande do Sul',
        'SC' => 'Santa Catarina',
        'SE' => 'Sergipe',
        'SP' => 'São Paulo',
        'TO' => 'Tocantins'
    );
    
    public function __construct(){
        // Conecta no banco de dados
        mysql_connect('localhost', 'root', '');
        mysql_select_db('dprf');
        // Inicia o tema
        $this->setTheme();
    }

    public function setTheme($tema = ''){
        
        if($tema == 'clean')
            // Tema clean
            // Define as configurações padrões
            $this->theme = array(
                'tabbable' => '',
                'widget' => '',
                'well' => 'well-nice',
                'progress' => 'progress-info'
            );
        else
            // Tema dark
            // Define as configurações padrões
            $this->theme = array(
                'tabbable' => 'tabbable-inverse',
                'widget' => 'widget-inverse',
                'well' => 'well-black',
                'progress' => 'progress-warning'
            );
            
        $this->theme_name = ($tema) ? $tema : 'dark';
            
    }
    
    public function getDataSQL($atual = 1){
        
        $data_inicial = "{$this->Ano}-{$this->Mes_Inicial}-{$this->Dia_Inicial}";
        $data_final = "{$this->Ano}-{$this->Mes_Final}-{$this->Dia_Final}";
        
        if($atual == 0 && $this->Tipo_Periodo == 'Diario') {
            
            $date = "{$this->Mes_Inicial}-{$this->Dia_Inicial}-{$this->Ano}";
            $date1 = str_replace('-', '/', $date);
            $new_date = date('m-d-Y',strtotime($date1 . "-1 days"));
            
            $data = explode('-', $new_date);
            
            $this->Ano = $data[2];
            $this->Mes = $this->Mes_Inicial = $this->Mes_Final = $data[0];
            $this->Dia = $this->Dia_Inicial = $this->Dia_Final = $data[1];
            
            $data_inicial = "{$data[2]}-{$data[0]}-{$data[1]}";
            $data_final = "{$data[2]}-{$data[0]}-{$data[1]}";
            
        } else 
        if($atual == 0 && $this->Tipo_Periodo == 'Mensal') {
            
            $date = "{$this->Mes_Inicial}-{$this->Dia_Inicial}-{$this->Ano}";
            $date1 = str_replace('-', '/', $date);
            $new_date = date('m-Y', strtotime($date1 . "-1 month"));
            
            $data = explode('-', $new_date);
            
            $this->Ano = $data[1];
            $this->Mes = $this->Mes_Inicial = $this->Mes_Final = $data[0];
            
            $data_inicial = "{$data[1]}-{$data[0]}-01";
            $data_final = "{$data[1]}-{$data[0]}-31";
            
        } 
        
        $sql = "select ".
            	/* Informações da ocorrência */ "
                ocorrencia.ocoid as OCORRENCIA_ID,
            	ocorrencia.ocolocal as LOCALBR_ID," .
                /* Informações dos veículos */ "
                veiculo.veiid as VEICULO_ID,
            	veiculo.veitcecodigo as VEICULO_COR_ID,
            	veiculo.veitvvcodigo as VEICULO_TIPO_ID,
                veiculo.veiano as VEICULO_ANO," .
                /* Informações da marca/modelo dos veículos */ "
            	marcadeveiculo.tmvmarca as VEICULO_MARCA_ID,
            	marcadeveiculo.tmvcodigo as VEICULO_MODELO_ID,
                marcadeveiculo.tmvmodelo as VEICULO_MODELO, 
                infodprf_veiculo_marca.marcadescricao as VEICULO_MARCA," .
                /* Informações das pessoas envolvidas */"
            	pessoa.pesid as PESSOA_ID,
            	pessoa.pesestadofisico as PESSOA_ESTADO_FISICO_ID,
                pessoa.pesidade as PESSOA_IDADE,
            	pessoa.pessexo as PESSOA_SEXO,
                ocorrenciapessoa.opettecodigo as TIPO_ENVOLVIDO_ID," .
                /* Informações da ocorrência */"
                ocorrenciaacidente.oacttacodigo as TIPO_ACIDENTE_ID,
                ocorrenciaacidente.oactcacodigo as CAUSA_ACIDENTE_ID,
                ocorrenciaacidente.oacmodelopista as MODELO_PISTA," .
                /* Variáveis para agrupamento por período */"
                date_format(ocorrencia.ocodataocorrencia, '%Y') as GrupoAno,
                date_format(ocorrencia.ocodataocorrencia, '%Y%m') as GrupoSemestre,
                date_format(ocorrencia.ocodataocorrencia, '%Y%m') as GrupoTrimestre,
                date_format(ocorrencia.ocodataocorrencia, '%Y%m') as GrupoMes,
                date_format(ocorrencia.ocodataocorrencia, '%Y%m%d') as GrupoDia,
                date_format(ocorrencia.ocodataocorrencia, '%H') as GrupoHora,
                DAYOFWEEK(ocorrencia.ocodataocorrencia) as GrupoDiaSemana," .
                /* Informações da BR */"
            	localbr.lbruf as LOCALBR_UF,
            	localbr.lbrbr as LOCALBR_BR,
                localbr.lbrlatitude as LATITUDE,
                localbr.lbrlongitude as LONGITUDE," .
                /* Segundo informações no grupo, a última casa de campo não corresponde a km e sim a metros, então pego apenas as 4 primeiras casas */ 
                /* O ideal é que a PRF reestruture este campo, separando a ultima casa com ponto. Atual: 00507 - Para float: 50.7 (50 km e 700 metros) */"
            	LEFT(localbr.lbrkm, 4) as LOCALBR_KM," .
                /* Pegamos o KM e fazemos uma faixa de resultados a cada 10 KM para estatísticas aproximada de cada trecho */ "
            	CONCAT((FLOOR(LEFT(localbr.lbrkm, 4)/10))*10,'-',((FLOOR(LEFT(localbr.lbrkm, 4)/10))*10)+10) as LOCALBR_RANGE
                
            from ocorrencia
            	left join ocorrenciaveiculo on ocorrenciaveiculo.ocvocoid = ocorrencia.ocoid
            	left join ocorrenciaacidente on ocorrenciaacidente.oacocoid = ocorrencia.ocoid
            	left join veiculo on veiculo.veiid = ocorrenciaveiculo.ocvveiid
            	left join marcadeveiculo on marcadeveiculo.tmvcodigo = veiculo.veitmvcodigo
                left join infodprf_veiculo_marca on infodprf_veiculo_marca.idmarca = marcadeveiculo.tmvmarca
            	left join pessoa on pessoa.pesveiid = veiculo.veiid
            	left join ocorrenciapessoa on ocorrenciapessoa.opepesid = pessoa.pesid
            	left join localbr on localbr.lbrid = ocorrencia.ocolocal
            where 
            	ocorrencia.ocodataocorrencia between '$data_inicial 00:00:00' and '$data_final 23:59:59'
            order by 
            	ocorrencia.ocoid desc";
             
            // Executa o comando SQL na classe principal 
            $this->query($sql);
        
            // Cria o caminho do arquivo de cache da consulta 
            $this->cache_file = 'cache/'.$this->Tipo_Periodo.'/'.(($this->Periodo) ? $this->Periodo.'-' : '').$this->Tipo_Periodo.(($this->Ano) ? '-'.$this->Ano : '').(($this->Mes) ? '-'.$this->Mes : '').(($this->Dia) ? '-'.$this->Dia : '').'.json';
    
            // Verifica se o arquivo não existe
            if(!file_exists($this->cache_file) && $this->resultados){
                // Cria o arquivo
                $json = fopen($this->cache_file, 'w+');
                // Codifica os resultados para json
                $json_content = json_encode($this->resultados);
                // Escreve no arquivo
                fwrite($json, $json_content);
                // Fecha o arquivo
                fclose($json);
            }

    }
        
    public function configure(){

            $this->Tipo_Periodo = ucfirst($_GET['tp_periodo']);
            $this->Periodo = ($_GET['periodo']) ? intval($_GET['periodo']) : '';
            
            $this->Ano = $_GET['ano'];
            $this->Mes = $_GET['mes'];
            $this->Dia = $_GET['dia'];
            
            $this->BR = $_GET['br'];
            $this->UF = $_GET['uf'];
            $this->Trecho = $_GET['trecho'];
            
            $this->Marca = $_GET['marca'];
            $this->Modelo = $_GET['modelo'];
            
            $this->Idade = ((trim($_GET['idade']) == '65') ? '65+' : $_GET['idade']);
            $this->TipoAcidente = $_GET['tipo_id'] ? intval(trim($_GET['tipo_id'])) : '';
            $this->CausaAcidente = $_GET['causa_id'] ? intval(trim($_GET['causa_id'])) : '';
            
            // Código temporário que torna o último semestre padrão caso não tenha sido informado nenhum período
            // Tornando-se a partir daqui a página inicial
            // Pode ser alterado ou re-adaptado da maneira que quiser
            if(!$this->Tipo_Periodo && !$this->Ano){
                
                $this->Periodo = 1;
                $this->Ano = 2013;
                $this->Tipo_Periodo = 'Semestre';
                $this->Legenda_Periodo = '1° Semestre de '.$this->Ano;
                $this->Legenda_Abangencia = '6 meses';
                $this->Legenda_Periodo_Complemento = 'Janeiro a Junho';
                $this->Legenda_Periodo_Display = 'semestre';
            
            // Caso tenha selecionado no menu o período mas ainda não tenha especificado qual o ano, semestre, trimestre, mes ou dia.
            } else {
                if($this->Tipo_Periodo && !$this->Ano){
                    $this->Ano = 2013;
                    // Em caso de busca anual, definimos 2013 como padrão
                    if($this->Tipo_Periodo == 'Anual'){
                        $this->Legenda_Periodo = $this->Ano;
                        $this->Legenda_Abangencia = '12 meses';
                        $this->Legenda_Periodo_Complemento = 'Janeiro a Dezembro';
                        $this->Legenda_Periodo_Display = 'ano';
                    } else
                    // Em caso de busca semestral, definimos 1° semestre de 2013 como padrão
                    if($this->Tipo_Periodo == 'Semestre'){
                        $this->Periodo = 1;
                        $this->Legenda_Periodo = $this->Periodo.'° Semestre de '.$this->Ano;
                        $this->Legenda_Abangencia = '6 meses';
                        $this->Legenda_Periodo_Complemento = 'Janeiro a Junho';
                        $this->Legenda_Periodo_Display = 'semestre';
                    } else
                    // Em caso de busca trimestral, definimos 1° semestre de 2013 como padrão
                    if($this->Tipo_Periodo == 'Trimestre'){
                        $this->Periodo = 1;
                        $this->Legenda_Periodo = $this->Periodo.'° Trimestre de '.$this->Ano;
                        $this->Legenda_Abangencia = '3 meses';
                        $this->Legenda_Periodo_Complemento = 'Janeiro a Março';
                        $this->Legenda_Periodo_Display = 'trimestre';
                    } else
                    if($this->Tipo_Periodo == 'Mensal'){
                        $this->Mes = '01';
                        $this->Legenda_Periodo = $this->getMesFull($this->Mes).' de '.$this->Ano;
                        $this->Legenda_Abangencia = date('j', mktime(0, 0, 0, $this->Mes, 0, $this->Ano)).' dias';
                        $this->Legenda_Periodo_Complemento = 'Dia 01 a ' . date('j', mktime(0, 0, 0, $this->Mes, 0, $this->Ano));
                        $this->Legenda_Periodo_Display = 'mês';
                    } else
                    if($this->Tipo_Periodo == 'Diario'){
                        $this->Dia = '01';
                        $this->Mes = '01';
                        $this->Legenda_Periodo = $this->Dia . ' de ' . $this->getMesFull($this->Mes).' de '.$this->Ano;
                        $this->Legenda_Abangencia = date('j', mktime(0, 0, 0, $this->Mes, $this->Dia, $this->Ano)).' dia';
                        $this->Legenda_Periodo_Complemento = '00:00 às 23:59';
                        $this->Legenda_Periodo_Display = 'dia';
                    }
                }
            }
            
            // Montamos a lógica do período caso seja anual
            if($this->Tipo_Periodo == 'Anual'){
                
                $this->Legenda_Periodo = !$this->Legenda_Periodo ? $this->Ano : $this->Legenda_Periodo;
                $this->Legenda_Periodo_Complemento = !$this->Legenda_Periodo_Complemento ? 'Janeiro a Dezembro' : $this->Legenda_Periodo_Complemento;
                $this->Legenda_Periodo_Display = 'ano';
                $this->Legenda_Abangencia = '12 meses';
                $this->Ano_Anterior = $this->Ano - 1;
                
                $this->Title = 'DPRF.info - Acidentes em Rodovias Federais - Ano '.$this->Ano.'';
                $this->Description = 'Estatísticas de acidentes em rodovias federais no ano de '.$this->Legenda_Periodo.'. Números de vítimas, total de ocorrências, marcas e modelos de veículos mais envolvidos, faixa etária dos condutores, trechos mais perigosos, índice de rodovias, tipos e causas de acidentes.';
                
            } else
            // Montamos a lógica dos períodos caso seja semestre
            if($this->Tipo_Periodo == 'Semestre'){
                $this->Legenda_Abangencia = '6 meses';
                $this->Legenda_Periodo_Display = 'semestre';
                switch($this->Periodo){
                    // Primeiro semestre
                    case '1':
                        // Definimos os primeiros 6 meses
                        $this->Mes_Inicial = '01';
                        $this->Mes_Final = '06';
                        // Legenda frontend de identificação do semestre
                        $this->Legenda_Periodo = !$this->Legenda_Periodo ? $this->Periodo.'° Semestre de '.$this->Ano : $this->Legenda_Periodo;
                        $this->Legenda_Periodo_Complemento = !$this->Legenda_Periodo_Complemento ? 'Janeiro a Junho' : $this->Legenda_Periodo_Complemento;
                        // Agora vamos definir qual é o período anterior para comparações de aumentos/diminuições
                        // Como estamos no primeiro semestre o semestre anterior é o segundo semestre do ano passado
                        // Voltamos ao ano anterior
                        $this->Ano_Anterior = $this->Ano - 1;
                        // Definimos como segundo semestre 
                        $this->Periodo_Anterior = 2;
                        break;
                    // Segundo semestre
                    case '2':
                        // Definimos os últimos 6 meses
                        $this->Mes_Inicial = '07';
                        $this->Mes_Final = '12';
                        // Legenda frontend de identificação do semestre
                        $this->Legenda_Periodo = !$this->Legenda_Periodo ? $this->Periodo.'° Semestre de '.$this->Ano : $this->Legenda_Periodo;
                        $this->Legenda_Periodo_Complemento = !$this->Legenda_Periodo_Complemento ? 'Julho a Dezembro' : $this->Legenda_Periodo_Complemento;
                        // Agora vamos definir qual é o período anterior para comparações de aumentos/diminuições
                        // Já que estamos no segundo semestre, o semestre anterior é o primeiro semestre deste mesmo ano
                        $this->Ano_Anterior = $this->Ano;
                        // Definimos como primeiro semestre 
                        $this->Periodo_Anterior = 1;
                        break;
                }
                
                $this->Title = 'DPRF.info - Acidentes em Rodovias Federais - '.$this->Legenda_Periodo.'';
                $this->Description = 'Estatísticas de acidentes em rodovias federais no '.$this->Legenda_Periodo.'. Números de vítimas, total de ocorrências, marcas e modelos de veículos mais envolvidos, faixa etária dos condutores, trechos mais perigosos, índice de rodovias, tipos e causas de acidentes.';
                
            } else
            // Montamos a lógica dos períodos caso seja trimestre
            if($this->Tipo_Periodo == 'Trimestre'){
                $this->Legenda_Abangencia = '3 meses';
                $this->Legenda_Periodo_Display = 'trimestre';
                switch($this->Periodo){
                    // Primeiro trimestre
                    case '1':
                        // Definimos os primeiros 3 meses
                        $this->Mes_Inicial = '01';
                        $this->Mes_Final = '03';
                        // Legenda frontend de identificação do trimestre
                        $this->Legenda_Periodo = !$this->Legenda_Periodo ? $this->Periodo.'° Trimestre de '.$this->Ano : $this->Legenda_Periodo;
                        $this->Legenda_Periodo_Complemento = !$this->Legenda_Periodo_Complemento ? 'Janeiro a Março' : $this->Legenda_Periodo_Complemento;
                        // Agora vamos definir qual é o período anterior para comparações de aumentos/diminuições
                        // Como estamos no primeiro trimestre o trimestre anterior é o quarto trimestre do ano passado
                        // Voltamos ao ano anterior
                        $this->Ano_Anterior = $this->Ano - 1;
                        // Definimos como segundo semestre 
                        $this->Periodo_Anterior = 4;
                        break;
                    // Segundo trimestre
                    case '2':
                        // Definimos o segundo trimestre
                        $this->Mes_Inicial = '04';
                        $this->Mes_Final = '06';
                        // Legenda frontend de identificação do semestre
                        $this->Legenda_Periodo = !$this->Legenda_Periodo ? $this->Periodo.'° Trimestre de '.$this->Ano : $this->Legenda_Periodo;
                        $this->Legenda_Periodo_Complemento = !$this->Legenda_Periodo_Complemento ? 'Abril a Junho' : $this->Legenda_Periodo_Complemento;
                        // Agora vamos definir qual é o período anterior para comparações de aumentos/diminuições
                        // Não estamos no primeiro trimestre, então o trimestre anterior é deste mesmo ano
                        $this->Ano_Anterior = $this->Ano;
                        $this->Periodo_Anterior = $this->Periodo - 1;
                        break;
                    // Terceiro trimestre
                    case '3':
                        // Definimos o segundo trimestre
                        $this->Mes_Inicial = '07';
                        $this->Mes_Final = '09';
                        // Legenda frontend de identificação do semestre
                        $this->Legenda_Periodo = !$this->Legenda_Periodo ? $this->Periodo.'° Trimestre de '.$this->Ano : $this->Legenda_Periodo;
                        $this->Legenda_Periodo_Complemento = !$this->Legenda_Periodo_Complemento ? 'Julho a Setembro' : $this->Legenda_Periodo_Complemento;
                        // Agora vamos definir qual é o período anterior para comparações de aumentos/diminuições
                        // Não estamos no primeiro trimestre, então o trimestre anterior é deste mesmo ano
                        $this->Ano_Anterior = $this->Ano;
                        $this->Periodo_Anterior = $this->Periodo - 1;
                        break;
                    // Quarto trimestre
                    case '4':
                        // Definimos o quarto trimestre
                        $this->Mes_Inicial = '10';
                        $this->Mes_Final = '12';
                        // Legenda frontend de identificação do semestre
                        $this->Legenda_Periodo = !$this->Legenda_Periodo ? $this->Periodo.'° Trimestre de '.$this->Ano : $this->Legenda_Periodo;
                        $this->Legenda_Periodo_Complemento = !$this->Legenda_Periodo_Complemento ? 'Outubro a Dezembro' : $this->Legenda_Periodo_Complemento;
                        // Agora vamos definir qual é o período anterior para comparações de aumentos/diminuições
                        // Não estamos no primeiro trimestre, então o trimestre anterior é deste mesmo ano
                        $this->Ano_Anterior = $this->Ano;
                        $this->Periodo_Anterior = $this->Periodo - 1;
                        break;
                }
                
                $this->Title = 'DPRF.info - Acidentes em Rodovias Federais - '.$this->Legenda_Periodo.'';
                $this->Description = 'Estatísticas de acidentes em rodovias federais no '.$this->Legenda_Periodo.'. Números de vítimas, total de ocorrências, marcas e modelos de veículos mais envolvidos, faixa etária dos condutores, trechos mais perigosos, índice de rodovias, tipos e causas de acidentes.';
                
            } else
            // Montamos a lógica do período caso seja mensal
            if($this->Tipo_Periodo == 'Mensal'){
                
                $this->Mes_Inicial = str_pad(($this->Mes), 2, "0", STR_PAD_LEFT);
                $this->Mes_Final = str_pad(($this->Mes), 2, "0", STR_PAD_LEFT);
                
                $this->Legenda_Abangencia = cal_days_in_month(CAL_GREGORIAN, $this->Mes, $this->Ano).' dias';
                $this->Legenda_Periodo = !$this->Legenda_Periodo ? $this->getMesFull($this->Mes).' de '.$this->Ano : $this->Legenda_Periodo;
                $this->Legenda_Periodo_Complemento = !$this->Legenda_Periodo_Complemento ? '01 a '.cal_days_in_month(CAL_GREGORIAN, $this->Mes, $this->Ano) : $this->Legenda_Periodo_Complemento;
                $this->Legenda_Periodo_Display = 'mês';
                if($this->Mes == '01'){
                    $this->Ano_Anterior = $this->Ano - 1;
                    $this->Mes_Anterior = '12';      
                } else {
                    $this->Ano_Anterior = $this->Ano;
                    $this->Mes_Anterior =  str_pad(($this->Mes - 1), 2, "0", STR_PAD_LEFT);
                }
                
                $this->Title = 'DPRF.info - Acidentes em Rodovias Federais - '.$this->Legenda_Periodo.'';
                $this->Description = 'Estatísticas de acidentes em rodovias federais em '.$this->Legenda_Periodo.'. Números de vítimas, total de ocorrências, marcas e modelos de veículos mais envolvidos, faixa etária dos condutores, trechos mais perigosos, índice de rodovias, tipos e causas de acidentes.';
                
            } else
            // Montamos a lógica do período caso seja diário
            if($this->Tipo_Periodo == 'Diario'){
                
                $this->Dia_Inicial = $this->Dia;
                $this->Dia_Final = $this->Dia;
                $this->Mes_Inicial = $this->Mes;
                $this->Mes_Final = $this->Mes;
                $this->Legenda_Abangencia = '';
                $this->Legenda_Periodo = !$this->Legenda_Periodo ? $this->Dia.' de '.$this->getMesFull($this->Mes).' de '.$this->Ano : $this->Legenda_Periodo;
                $this->Legenda_Periodo_Complemento = !$this->Legenda_Periodo_Complemento ? $this->getDiaSemana(date('w', mktime(0, 0, 0, $this->Mes, 0, $this->Ano)) + 1, 1) : $this->Legenda_Periodo_Complemento;
                $this->Legenda_Periodo_Display = 'dia';
                $this->Ano_Anterior = $this->Ano - 1;
                
                $date = "{$this->Mes_Inicial}-{$this->Dia_Inicial}-{$this->Ano}";
                $date1 = str_replace('-', '/', $date);
                $new_date = date('m-d-Y',strtotime($date1 . "-1 days"));
                
                $data = explode('-', $new_date);
                
                $this->Ano_Anterior = $data[2];
                $this->Mes_Anterior = $data[0];
                $this->Dia_Anterior = $data[1];
                
                $this->Title = 'DPRF.info - Acidentes em Rodovias Federais - '.$this->Legenda_Periodo.'';
                $this->Description = 'Estatísticas de acidentes em rodovias federais no dia '.$this->Legenda_Periodo.'. Números de vítimas, total de ocorrências, marcas e modelos de veículos mais envolvidos, faixa etária dos condutores, trechos mais perigosos, índice de rodovias, tipos e causas de acidentes.';
                
            }

            $this->cache_file = 'cache/'.$this->Tipo_Periodo.'/'.(($this->Periodo) ? $this->Periodo.'-' : '').$this->Tipo_Periodo.(($this->Ano) ? '-'.$this->Ano : '').(($this->Mes) ? '-'.$this->Mes : '').(($this->Dia) ? '-'.$this->Dia : '').'.json';
            
            $this->URL = $this->Tipo_Periodo.
                         (($this->Periodo) ? '/'.$this->Periodo : '').
                         (($this->Dia) ? '/'.$this->Dia : '').
                         (($this->Mes) ? '/'.$this->Mes : '').
                         (($this->Ano) ? '/'.$this->Ano : '');

    }

    public function QRCode($tamanho = '1'){

      $this->QRCode = (($tamanho == '1') ? $this->URL_QRCode_Small : $this->URL_QRCode_Medium) . 
                      (($this->BR) ? '/BR-'.$this->BR : '').
                      (($this->UF) ? '/'.$this->UF : '').
                      (($this->Trecho) ? '/'.$this->Trecho : '').
                      '/'.$this->Tipo_Periodo.
                      (($this->Periodo) ? '/'.$this->Periodo : '').
                      (($this->Dia) ? '/'.$this->Dia : '').
                      (($this->Mes) ? '/'.$this->Mes : '').
                      (($this->Ano) ? '/'.$this->Ano : '').
                      (($_GET['veiculo']) ? '/'.$_GET['veiculo'] : '');
                      
                      return $this->QRCode;
                    
    }

    public function getTipoAcidente($Id){
        $sql = mysql_query("select * from tipoacidente where ttacodigo = '$Id'");
        $tipo_acidente = mysql_fetch_object($sql);
        return $tipo_acidente->ttadescricao;
    }


    public function getCausaAcidente($Id){
        $sql = mysql_query("select * from causaacidente where tcacodigo = '$Id'");
        $causa_acidente = mysql_fetch_object($sql);
        return $causa_acidente->tcadescricao;
    }
    
    public function getBRDescription($BR){
        $sql = mysql_query("select * from infodprf_rodovias where num_rodovia = '$BR'");
        $rodovia = mysql_fetch_object($sql);
        return $rodovia->descricao;
    }

    /**
     * Calcula as diferenças entre períodos
     */
    public function Porcentagem($val1, $val2, $precisao = 1) 
    {
    	if($val1 > $val2)
            $porcentagem = (((intval($val1) - intval($val2)) / intval($val1)) * 100);
        else
            $porcentagem = (((intval($val1) - intval($val2)) / intval($val2)) * 100);
        $porcentagem = round($porcentagem, $precisao);
        $porcentagem = ((strlen($porcentagem) >= 5) ? round($porcentagem, 1) : $porcentagem);
    	return $porcentagem.'%';
    }


    public function query($comando_sql){
        
        $sql = mysql_query($comando_sql);
        $total = mysql_num_rows($sql);
        
        // Se não encontrar nada na tabela retorna como false
        if(!$total) return false;
        
        // Percorre os resultados encontrados
        while($resultado = mysql_fetch_object($sql)){
            
           /**
            * TRECHO DO CÓDIGO PARA CONDUTOR (ID 2)
            * Este trecho do código é para estatísticas caso o envolvido seja o condutor pois na consulta é gerada uma 
            * duplicidade de informações de acordo com a quantia de pessoas envolvidas no acidente
            */
            if($resultado->TIPO_ENVOLVIDO_ID == 2){
                
                /**
                 * Totaliza as estatísticas de marcas/modelos
                 */ 
                // Caso tenha a marca e modelo definido
                if($resultado->VEICULO_MARCA && $resultado->VEICULO_MODELO){
                    
                    // Soma a quantidade de veículos desta marca ao total
                    $this->resultados['VEICULOS'][$resultado->VEICULO_MARCA]['TOTAL']++;
                    // Adiciona o modelo na marca, para estatísticas individuais dos modelos desta marca 
                    $this->resultados['VEICULOS'][$resultado->VEICULO_MARCA]['MODELOS'][$resultado->VEICULO_MODELO]['TOTAL']++;
                    // Separa o ano dos veículos
                    if($resultado->VEICULO_ANO)
                        $this->resultados['VEICULOS'][$resultado->VEICULO_MARCA]['MODELOS'][$resultado->VEICULO_MODELO][$resultado->VEICULO_ANO]++;
                    else 
                        $this->resultados['VEICULOS'][$resultado->VEICULO_MARCA]['MODELOS'][$resultado->VEICULO_MODELO]['ND']++;
                    // Soma o total de veículos
                    $this->resultados['VEICULOS']['TOTAL']++;
                    
                // Caso apenas a marca seja identificada(sem modelo definido)
                } else if($resultado->VEICULO_MARCA){
                    
                    // Soma a quantidade de veículos desta marca ao total
                    $this->resultados['VEICULOS'][$resultado->VEICULO_MARCA]['TOTAL']++;
                    // Soma a quantidade de modelos não identificados ao total
                    $this->resultados['VEICULOS'][$resultado->VEICULO_MARCA]['MODELOS']['NAODISPONIVEL']++;
                    // Soma o total de veículos
                    $this->resultados['VEICULOS']['TOTAL']++;
                    
                // Caso a marca não seja identificada
                } else if(!$resultado->VEICULO_MARCA){
                    
                    // Soma a quantidade de marcas não identificadas ao total
                    $this->resultados['VEICULOS']['NAODISPONIVEL']++;
                    $this->resultados['VEICULOS']['TOTAL']++;
                    
                }
            
                /**
                 * Totaliza as estatísticas por sexo dos condutores
                 */
                 // Verifica se o sexo da pessoa foi informado
                 if($resultado->PESSOA_SEXO){
                    if($resultado->PESSOA_SEXO == 'M'){
                        // Sexo Masculino
                        $this->resultados['CONDUTORES']['SEXO']['M']++;
                    } else 
                    if($resultado->PESSOA_SEXO == 'F'){
                        // Sexo Feminino
                        $this->resultados['CONDUTORES']['SEXO']['F']++;
                    } else {
                        // Não informado/identificado
                        $this->resultados['CONDUTORES']['SEXO']['ND']++;
                    }
                    // Total de condutores envolvidos
                    $this->resultados['CONDUTORES']['TOTAL']++;
                 } else {
                    // Não informado
                    $this->resultados['CONDUTORES']['SEXO']['ND']++;
                    // Total de condutores envolvidos
                    $this->resultados['CONDUTORES']['TOTAL']++;
                 }
                 
                 
                /**
                 * Totaliza as estatísticas por idade dos condutores
                 */
                 // Verifica se a idade dos condutores foi informada
                 if($resultado->PESSOA_IDADE > 0){
                    
                    /**
                     * Jovens menores de idade ao volante
                     */
                    if($resultado->PESSOA_IDADE <= 17){
                        //
                        $this->resultados['CONDUTORES']['IDADE']['0-17']++;
                        // Define o tipo do acidente para idades até 17 anos 
                        if($resultado->TIPO_ACIDENTE_ID > 0)
                        $this->resultados['IDADE']['TIPO_ACIDENTE']['0-17'][$resultado->TIPO_ACIDENTE_ID]++;
                        // Define a causa do acidente para idades até 17 anos 
                        if($resultado->CAUSA_ACIDENTE_ID > 0)
                        $this->resultados['IDADE']['CAUSA_ACIDENTE']['0-17'][$resultado->CAUSA_ACIDENTE_ID]++;
                        //
                    /**
                     * Jovens* de 18 a 25 anos
                     */
                    } else if($resultado->PESSOA_IDADE >= 18 && $resultado->PESSOA_IDADE <= 25){
                        //
                        $this->resultados['CONDUTORES']['IDADE']['18-25']++;
                        // Define o tipo do acidente para idades de 18 até 25 anos 
                        if($resultado->TIPO_ACIDENTE_ID > 0)
                        $this->resultados['IDADE']['TIPO_ACIDENTE']['18-25'][$resultado->TIPO_ACIDENTE_ID]++;
                        // Define a causa do acidente para idades de 18 até 25 anos  
                        if($resultado->CAUSA_ACIDENTE_ID > 0)
                        $this->resultados['IDADE']['CAUSA_ACIDENTE']['18-25'][$resultado->CAUSA_ACIDENTE_ID]++;
                        //
                    /**
                     * Adultos de 25 a 35 anos
                     */
                    } else if($resultado->PESSOA_IDADE >= 26 && $resultado->PESSOA_IDADE <= 35){
                        //
                        $this->resultados['CONDUTORES']['IDADE']['26-35']++;
                        // Define o tipo do acidente para idades de 26 até 35 anos
                        if($resultado->TIPO_ACIDENTE_ID > 0)
                        $this->resultados['IDADE']['TIPO_ACIDENTE']['26-35'][$resultado->TIPO_ACIDENTE_ID]++;
                        // Define a causa do acidente para idades de 26 até 35 anos  
                        if($resultado->CAUSA_ACIDENTE_ID > 0)
                        $this->resultados['IDADE']['CAUSA_ACIDENTE']['26-35'][$resultado->CAUSA_ACIDENTE_ID]++;
                        //
                    /**
                     * Adultos de 35 a 45 anos
                     */
                    } else if($resultado->PESSOA_IDADE >= 36 && $resultado->PESSOA_IDADE <= 45){
                        //
                        $this->resultados['CONDUTORES']['IDADE']['36-45']++;
                        // Define o tipo do acidente para idades de 36 até 45 anos
                        if($resultado->TIPO_ACIDENTE_ID > 0)
                        $this->resultados['IDADE']['TIPO_ACIDENTE']['36-45'][$resultado->TIPO_ACIDENTE_ID]++;
                        // Define a causa do acidente para idades de 36 até 45 anos  
                        if($resultado->CAUSA_ACIDENTE_ID > 0)
                        $this->resultados['IDADE']['CAUSA_ACIDENTE']['36-45'][$resultado->CAUSA_ACIDENTE_ID]++;
                        //
                    /**
                     * Adultos de 45 a 55 anos
                     */
                    } else if($resultado->PESSOA_IDADE >= 46 && $resultado->PESSOA_IDADE <= 55){
                        //
                        $this->resultados['CONDUTORES']['IDADE']['46-55']++;
                        // Define o tipo do acidente para idades de 46 até 55 anos
                        if($resultado->TIPO_ACIDENTE_ID > 0)
                        $this->resultados['IDADE']['TIPO_ACIDENTE']['46-55'][$resultado->TIPO_ACIDENTE_ID]++;
                        // Define a causa do acidente para idades de 46 até 55 anos  
                        if($resultado->CAUSA_ACIDENTE_ID > 0)
                        $this->resultados['IDADE']['CAUSA_ACIDENTE']['46-55'][$resultado->CAUSA_ACIDENTE_ID]++;
                        //
                    /**
                     * Adultos/Idosos de 55 a 65 anos
                     */
                    } else if($resultado->PESSOA_IDADE >= 56 && $resultado->PESSOA_IDADE <= 65){
                        //
                        $this->resultados['CONDUTORES']['IDADE']['56-65']++;
                        // Define o tipo do acidente para idades de 56 até 65 anos
                        if($resultado->TIPO_ACIDENTE_ID > 0)
                        $this->resultados['IDADE']['TIPO_ACIDENTE']['56-65'][$resultado->TIPO_ACIDENTE_ID]++;
                        // Define a causa do acidente para idades de 56 até 65 anos  
                        if($resultado->CAUSA_ACIDENTE_ID > 0)
                        $this->resultados['IDADE']['CAUSA_ACIDENTE']['56-65'][$resultado->CAUSA_ACIDENTE_ID]++;
                        //
                    /**
                     * Idosos com mais de 65 anos
                     */
                    } else if($resultado->PESSOA_IDADE > 65){
                        //
                        $this->resultados['CONDUTORES']['IDADE']['65+']++;
                        // Define o tipo do acidente para idades acima de 65 anos
                        if($resultado->TIPO_ACIDENTE_ID > 0)
                        $this->resultados['IDADE']['TIPO_ACIDENTE']['65+'][$resultado->TIPO_ACIDENTE_ID]++;
                        // Define a causa do acidente para idades acima de 65 anos
                        if($resultado->CAUSA_ACIDENTE_ID > 0)
                        $this->resultados['IDADE']['CAUSA_ACIDENTE']['65+'][$resultado->CAUSA_ACIDENTE_ID]++;
                        //
                    }
                 } else {
                    // Caso não tenha sido informada define como não disponível
                    $this->resultados['CONDUTORES']['IDADE']['ND']++;
                 }
                 
                 /**
                  * SEXO DOS CONDUTORES POR TRECHO DA BR
                  */
                  if($resultado->LOCALBR_BR && $resultado->LOCALBR_UF && $resultado->LOCALBR_RANGE){
                         // Verifica se o sexo da pessoa foi informado
                         if($resultado->PESSOA_SEXO){
                            if($resultado->PESSOA_SEXO == 'M'){
                                // Sexo Masculino para a BR
                                $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR]['SEXO']['M']++;
                                // Sexo Masculino para a BR/UF
                                $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF]['SEXO']['M']++;
                                // Sexo Masculino para a BR/UF/RANGE
                                $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$resultado->LOCALBR_RANGE]['SEXO']['M']++;
                            } else 
                            if($resultado->PESSOA_SEXO == 'F'){
                                // Sexo Feminino para a BR
                                $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR]['SEXO']['F']++;
                                // Sexo Feminino para a BR/UF
                                $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF]['SEXO']['F']++;
                                // Sexo Feminino para a BR/UF/RANGE
                                $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$resultado->LOCALBR_RANGE]['SEXO']['F']++;
                            } else {
                                // Sexo indefinido para a BR
                                $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR]['SEXO']['ND']++;
                                // Sexo indefinido para a BR/UF
                                $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF]['SEXO']['ND']++;
                                // Sexo indefinido para a BR/UF/RANGE
                                $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$resultado->LOCALBR_RANGE]['SEXO']['ND']++;
                            }
                         }
                   } 
                 
                /**
                 * Estatísticas por local da BR onde a ocorrência aconteceu
                 */
                 if($resultado->PESSOA_ALCOOLIZADA == 'S'){
                    $this->resultados['PESSOA_ALCOOLIZADA']++;
                 }
                 
                /**
                 * Estatísticas por tipo de veículo
                 */
                 if($resultado->VEICULO_TIPO_ID){
                    $this->resultados['VEICULOS']['VEICULO_TIPO'][$resultado->VEICULO_TIPO_ID]++;
                 }
                 

             
             } // Fim do IF Condutor
             
             // Total de pessoas no período
             $this->resultados['PESSOAS']['TOTAL']++;
             
             // Total de pessoas na BR
             if($resultado->LOCALBR_BR)
             $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR]['PESSOAS']['TOTAL']++;
             
             // Total de pessoas na BR/UF
             if($resultado->LOCALBR_BR && $resultado->LOCALBR_UF)
             $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF]['PESSOAS']['TOTAL']++;
             
             // Total de pessoas no trecho
             if($resultado->LOCALBR_BR && $resultado->LOCALBR_UF && $resultado->LOCALBR_RANGE)
             $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$resultado->LOCALBR_RANGE]['PESSOAS']['TOTAL']++;
             
             
            /**
             * Organiza as estatísticas por tipo de envolvido
             */
             // Totaliza os tipos de envolvidos 
             if($resultado->TIPO_ENVOLVIDO_ID){
                $this->resultados['PESSOAS']['TIPO_ENVOLVIDO'][$resultado->TIPO_ENVOLVIDO_ID]++;
             } else {
                $this->resultados['PESSOAS']['TIPO_ENVOLVIDO']['ND']++;
             }
             
             
            /**
             * Organiza as estatísticas por estado físico das pessoas envolvidas
             */
             // Totaliza os tipos de envolvidos 
             if($resultado->PESSOA_ESTADO_FISICO_ID){
                 $this->resultados['PESSOAS']['ESTADO_FISICO'][$resultado->PESSOA_ESTADO_FISICO_ID]++;
                 if($resultado->LOCALBR_BR && $resultado->LOCALBR_UF){
                     // Divide o estado fisico das pessoas envolvidas pela BR
                     $this->resultados['LOCALBR']["BR-".$resultado->LOCALBR_BR]['ESTADO_FISICO'][$resultado->PESSOA_ESTADO_FISICO_ID]++;
                     // Divide o estado fisico das pessoas envolvidas pelo trecho da BR/UF
                     $this->resultados['LOCALBR']["BR-".$resultado->LOCALBR_BR][$resultado->LOCALBR_UF]['ESTADO_FISICO'][$resultado->PESSOA_ESTADO_FISICO_ID]++;
                     // Divide o estado fisico das pessoas envolvidas pelo trecho da BR/UF/RANGE a cada 10 KM de distancia
                     $this->resultados['LOCALBR']["BR-".$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$resultado->LOCALBR_RANGE]['ESTADO_FISICO'][$resultado->PESSOA_ESTADO_FISICO_ID]++;
                 }
             } else {
                 $this->resultados['PESSOAS']['ESTADO_FISICO']['ND']++;
             }
             
             
             // Totaliza os itens apenas uma vez por ocorrência pois na consulta
             // é gerado duplicidade das informações de acordo com a quantia de envolvidos
             if($ID_OCORRENCIA != $resultado->OCORRENCIA_ID){
        
                 // Soma a quantidade de ocorrências para o período pesquisado
                 $this->resultados['TOTAL_OCORRENCIAS']++;

                 /**
                  * Organiza as estatísticas de locais da br
                  */
                  if($resultado->LOCALBR_UF && $resultado->LOCALBR_BR){

                     if($resultado->PESSOA_ESTADO_FISICO_ID == 1) $Indice = 1;  else
                     if($resultado->PESSOA_ESTADO_FISICO_ID == 2) $Indice = 5;  else
                     if($resultado->PESSOA_ESTADO_FISICO_ID == 3) $Indice = 5;  else
                     if($resultado->PESSOA_ESTADO_FISICO_ID == 4) $Indice = 25; else
                                                                  $Indice = 1;
                     
                     // Soma os trechos mais perigosos
                     $this->resultados['LOCALBR']['TRECHOS']['BR-'.$resultado->LOCALBR_BR."/".$resultado->LOCALBR_UF."/".$resultado->LOCALBR_RANGE]++;

                     // Soma o total da BR
                     $this->resultados['LOCALBR']['BR']['BR-'.$resultado->LOCALBR_BR]++;

                     // Soma o total da BR/UF
                     $this->resultados['LOCALBR']['BR_UF']['BR-'.$resultado->LOCALBR_BR.'/'.$resultado->LOCALBR_UF]++;

                     // Soma o indice da BR/UF
                     $this->resultados['LOCALBR']['BR_UF_IDC']['BR-'.$resultado->LOCALBR_BR.'/'.$resultado->LOCALBR_UF] += $Indice;

                     if($resultado->LATITUDE && $resultado->LONGITUDE){
                        // Organiza as coordenadas de localização da ocorrencia para a BR
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR]['LAT_LONG'][$resultado->LATITUDE.",".$resultado->LONGITUDE]['TOTAL']++;
                        // Organiza as coordenadas de localização da ocorrencia para a BR/UF
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF]['LAT_LONG'][$resultado->LATITUDE.",".$resultado->LONGITUDE]['TOTAL']++;
                        // Organiza as coordenadas de localização da ocorrencia para a BR/UF/TRECHO
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$resultado->LOCALBR_RANGE]['LAT_LONG'][$resultado->LATITUDE.",".$resultado->LONGITUDE]['TOTAL']++;
                        /**
                         * Salva as latitudes/longitudes por BR
                         */
                        // Salva um array com as ocorrencias em cada local da BR/UF/Trecho
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR]['LAT_LONG'][$resultado->LATITUDE.",".$resultado->LONGITUDE]['OCOID'][$resultado->OCORRENCIA_ID] = $resultado->LOCALBR_KM;
                        // Organiza o estado físico das pessoas para deste trecho
                        if($resultado->PESSOA_ESTADO_FISICO_ID)
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR]['LAT_LONG'][$resultado->LATITUDE.",".$resultado->LONGITUDE]['ESTADO_FISICO'][$resultado->PESSOA_ESTADO_FISICO_ID]++;
                        /**
                         * Salva as latitudes/longitudes por BR/UF
                         */
                        // Salva um array com as ocorrencias em cada local da BR/UF/Trecho
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF]['LAT_LONG'][$resultado->LATITUDE.",".$resultado->LONGITUDE]['OCOID'][$resultado->OCORRENCIA_ID] = $resultado->LOCALBR_KM;
                        // Organiza o estado físico das pessoas para deste trecho
                        if($resultado->PESSOA_ESTADO_FISICO_ID)
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF]['LAT_LONG'][$resultado->LATITUDE.",".$resultado->LONGITUDE]['ESTADO_FISICO'][$resultado->PESSOA_ESTADO_FISICO_ID]++;
                        /**
                         * Salva as latitudes/longitudes por BR/UF/Trecho
                         */
                        // Salva um array com as ocorrencias em cada local da BR/UF/Trecho
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$resultado->LOCALBR_RANGE]['LAT_LONG'][$resultado->LATITUDE.",".$resultado->LONGITUDE]['OCOID'][$resultado->OCORRENCIA_ID] = $resultado->LOCALBR_KM;
                        // Organiza o estado físico das pessoas para deste trecho
                        if($resultado->PESSOA_ESTADO_FISICO_ID)
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$resultado->LOCALBR_RANGE]['LAT_LONG'][$resultado->LATITUDE.",".$resultado->LONGITUDE]['ESTADO_FISICO'][$resultado->PESSOA_ESTADO_FISICO_ID]++;
                     }

                    /**
                     * HORÁRIOS
                     */
                     // Divide os horários mais críticos da BR
                     $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR]['HORA'][$resultado->GrupoHora]++;
                     // Divide os horários mais críticos da BR/UF
                     $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF]['HORA'][$resultado->GrupoHora]++;
                     // Divide os horários mais críticos do trecho
                     $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$resultado->LOCALBR_RANGE]['HORA'][$resultado->GrupoHora]++;

                    /**
                     * DIA DA SEMANA
                     */
                     // Divide os dias da semana mais críticos da BR
                     $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR]['DIASEMANA'][$resultado->GrupoDiaSemana]++;
                     // Divide os dias da semana mais críticos da BR/UF
                     $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF]['DIASEMANA'][$resultado->GrupoDiaSemana]++;
                     // Divide os dias da semana mais críticos da BR/UG/RANGE
                     $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$resultado->LOCALBR_RANGE]['DIASEMANA'][$resultado->GrupoDiaSemana]++;

                }
                
                $this->resultados['MODELO_PISTA'][$resultado->MODELO_PISTA]++;

                /**
                 * Organiza as estatísticas por tipo de acidente
                 */
                 if($resultado->TIPO_ACIDENTE_ID){
                    $this->resultados['TIPO_ACIDENTE'][$resultado->TIPO_ACIDENTE_ID]++;
                    // Agrupa as causas de acidente mais comuns para este tipo
                    if($resultado->CAUSA_ACIDENTE_ID)
                    $this->resultados['TIPO_ACIDENTE']['TIPO_x_CAUSA'][$resultado->TIPO_ACIDENTE_ID][$resultado->CAUSA_ACIDENTE_ID]++; 
                    //
                    if($resultado->LOCALBR_UF && $resultado->LOCALBR_BR){
                         // Divide o estado fisico das pessoas envolvidas pelo trecho da BR
                         $this->resultados['LOCALBR']["BR-".$resultado->LOCALBR_BR]['TIPO_ACIDENTE'][$resultado->TIPO_ACIDENTE_ID]++;
                         // Divide o estado fisico das pessoas envolvidas pelo trecho da BR/UF
                         $this->resultados['LOCALBR']["BR-".$resultado->LOCALBR_BR][$resultado->LOCALBR_UF]['TIPO_ACIDENTE'][$resultado->TIPO_ACIDENTE_ID]++;
                         // Divide o estado fisico das pessoas envolvidas pelo trecho da BR/UF/RANGE a cada 10 KM de distancia
                         $this->resultados['LOCALBR']["BR-".$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$resultado->LOCALBR_RANGE]['TIPO_ACIDENTE'][$resultado->TIPO_ACIDENTE_ID]++;
                    }
                 } else {
                    $this->resultados['TIPO_ACIDENTE']['ND']++;
                 }

                /**
                 * Organiza as estatísticas por causas de acidente
                 */
                 if($resultado->CAUSA_ACIDENTE_ID){
                    $this->resultados['CAUSA_ACIDENTE'][$resultado->CAUSA_ACIDENTE_ID]++;
                    // Agrupa as causas de acidente mais comuns para este tipo
                    if($resultado->TIPO_ACIDENTE_ID)
                    $this->resultados['CAUSA_ACIDENTE']['CAUSA_x_TIPO'][$resultado->CAUSA_ACIDENTE_ID][$resultado->TIPO_ACIDENTE_ID]++; 
                    //
                    if($resultado->LOCALBR_UF && $resultado->LOCALBR_BR){
                         // Divide o estado fisico das pessoas envolvidas pelo trecho da BR/UF
                         $this->resultados['LOCALBR']["BR-".$resultado->LOCALBR_BR]['CAUSA_ACIDENTE'][$resultado->CAUSA_ACIDENTE_ID]++;
                         // Divide o estado fisico das pessoas envolvidas pelo trecho da BR/UF
                         $this->resultados['LOCALBR']["BR-".$resultado->LOCALBR_BR][$resultado->LOCALBR_UF]['CAUSA_ACIDENTE'][$resultado->CAUSA_ACIDENTE_ID]++;
                         // Divide o estado fisico das pessoas envolvidas pelo trecho da BR/UF/RANGE a cada 10 KM de distancia
                         $this->resultados['LOCALBR']["BR-".$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$resultado->LOCALBR_RANGE]['CAUSA_ACIDENTE'][$resultado->CAUSA_ACIDENTE_ID]++;
                    }
                 } else {
                    $this->resultados['CAUSA_ACIDENTE']['ND']++;
                 }

                /**
                 * Organiza as estatísticas por período anual
                 */                 
                 if($this->Tipo_Periodo == 'Anual'){
                    $this->resultados[$this->Tipo_Periodo][$resultado->GrupoAno]++;
                    // Tipo de acidente
                    if($resultado->TIPO_ACIDENTE_ID){
                        $this->resultados[$this->Tipo_Periodo]['TIPO_ACIDENTE'][$resultado->GrupoAno][$resultado->TIPO_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR]['TIPO_ACIDENTE'][$this->Tipo_Periodo][$resultado->GrupoTrimestre][$resultado->TIPO_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF]['TIPO_ACIDENTE'][$this->Tipo_Periodo][$resultado->GrupoTrimestre][$resultado->TIPO_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$resultado->LOCALBR_RANGE]['TIPO_ACIDENTE'][$this->Tipo_Periodo][$resultado->GrupoTrimestre][$resultado->TIPO_ACIDENTE_ID]++;
                    }
                    // Causa do acidente 
                    if($resultado->CAUSA_ACIDENTE_ID){
                        $this->resultados[$this->Tipo_Periodo]['CAUSA_ACIDENTE'][$resultado->GrupoAno][$resultado->CAUSA_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR]['CAUSA_ACIDENTE'][$this->Tipo_Periodo][$resultado->GrupoTrimestre][$resultado->CAUSA_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF]['CAUSA_ACIDENTE'][$this->Tipo_Periodo][$resultado->GrupoTrimestre][$resultado->CAUSA_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$resultado->LOCALBR_RANGE]['CAUSA_ACIDENTE'][$this->Tipo_Periodo][$resultado->GrupoTrimestre][$resultado->CAUSA_ACIDENTE_ID]++;
                    }
                    // Trecho da BR
                    $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$this->Tipo_Periodo][$resultado->GrupoAno]++;
                    $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF]['Anual_Mensal'][$resultado->GrupoMes]++;                    
                    $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$this->Tipo_Periodo][$resultado->GrupoAno]++;
                    $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$resultado->LOCALBR_RANGE]['Anual_Mensal'][$resultado->GrupoMes]++;
                    $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$resultado->LOCALBR_RANGE][$this->Tipo_Periodo][$resultado->GrupoAno]++; 
                 }
                 
                /**
                 * Organiza as estatísticas por período semestral
                 */  
                 if($this->Tipo_Periodo == 'Semestre'){
                    $this->resultados[$this->Tipo_Periodo][$resultado->GrupoSemestre]++;
                    // Tipo de acidente
                    if($resultado->TIPO_ACIDENTE_ID){
                        $this->resultados[$this->Tipo_Periodo]['TIPO_ACIDENTE'][$resultado->GrupoSemestre][$resultado->TIPO_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR]['TIPO_ACIDENTE'][$this->Tipo_Periodo][$resultado->GrupoSemestre][$resultado->TIPO_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF]['TIPO_ACIDENTE'][$this->Tipo_Periodo][$resultado->GrupoSemestre][$resultado->TIPO_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$resultado->LOCALBR_RANGE]['TIPO_ACIDENTE'][$this->Tipo_Periodo][$resultado->GrupoSemestre][$resultado->TIPO_ACIDENTE_ID]++;
                    }
                    // Causa do acidente 
                    if($resultado->CAUSA_ACIDENTE_ID){
                        $this->resultados[$this->Tipo_Periodo]['CAUSA_ACIDENTE'][$resultado->GrupoSemestre][$resultado->CAUSA_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR]['CAUSA_ACIDENTE'][$this->Tipo_Periodo][$resultado->GrupoSemestre][$resultado->CAUSA_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF]['CAUSA_ACIDENTE'][$this->Tipo_Periodo][$resultado->GrupoSemestre][$resultado->CAUSA_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$resultado->LOCALBR_RANGE]['CAUSA_ACIDENTE'][$this->Tipo_Periodo][$resultado->GrupoSemestre][$resultado->CAUSA_ACIDENTE_ID]++;
                    }
                    // Trecho da BR
                    $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$this->Tipo_Periodo][$resultado->GrupoSemestre]++;
                    $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$this->Tipo_Periodo][$resultado->GrupoSemestre]++;
                    $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$resultado->LOCALBR_RANGE][$this->Tipo_Periodo][$resultado->GrupoSemestre]++;
                 }

                /**
                 * Organiza as estatísticas por período trimestral
                 */  
                 if($this->Tipo_Periodo == 'Trimestre'){
                    $this->resultados[$this->Tipo_Periodo][$resultado->GrupoTrimestre]++;
                    // Tipo de acidente
                    if($resultado->TIPO_ACIDENTE_ID){
                        $this->resultados[$this->Tipo_Periodo]['TIPO_ACIDENTE'][$resultado->GrupoTrimestre][$resultado->TIPO_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR]['TIPO_ACIDENTE'][$this->Tipo_Periodo][$resultado->GrupoTrimestre][$resultado->TIPO_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF]['TIPO_ACIDENTE'][$this->Tipo_Periodo][$resultado->GrupoTrimestre][$resultado->TIPO_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$resultado->LOCALBR_RANGE]['TIPO_ACIDENTE'][$this->Tipo_Periodo][$resultado->GrupoTrimestre][$resultado->TIPO_ACIDENTE_ID]++;
                    }
                    // Causa do acidente 
                    if($resultado->CAUSA_ACIDENTE_ID){
                        $this->resultados[$this->Tipo_Periodo]['CAUSA_ACIDENTE'][$resultado->GrupoTrimestre][$resultado->CAUSA_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR]['CAUSA_ACIDENTE'][$this->Tipo_Periodo][$resultado->GrupoTrimestre][$resultado->CAUSA_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF]['CAUSA_ACIDENTE'][$this->Tipo_Periodo][$resultado->GrupoTrimestre][$resultado->CAUSA_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$resultado->LOCALBR_RANGE]['CAUSA_ACIDENTE'][$this->Tipo_Periodo][$resultado->GrupoTrimestre][$resultado->CAUSA_ACIDENTE_ID]++;
                    }
                    // Trecho da BR
                    $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$this->Tipo_Periodo][$resultado->GrupoTrimestre]++;
                    $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$this->Tipo_Periodo][$resultado->GrupoTrimestre]++;
                    $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$resultado->LOCALBR_RANGE][$this->Tipo_Periodo][$resultado->GrupoTrimestre]++;
                 }

                /**
                 * Organiza as estatísticas por período mensal
                 */
                 if($this->Tipo_Periodo == 'Mensal' || $this->Tipo_Periodo == 'Anual'){
                    $this->resultados['Mensal'][$resultado->GrupoMes]++;                
                    // Tipo de acidente
                    if($resultado->TIPO_ACIDENTE_ID){
                        $this->resultados['Mensal']['TIPO_ACIDENTE'][$resultado->GrupoMes][$resultado->TIPO_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR]['TIPO_ACIDENTE']['Mensal'][$resultado->GrupoDia][$resultado->TIPO_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF]['TIPO_ACIDENTE']['Mensal'][$resultado->GrupoDia][$resultado->TIPO_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$resultado->LOCALBR_RANGE]['TIPO_ACIDENTE']['Mensal'][$resultado->GrupoDia][$resultado->TIPO_ACIDENTE_ID]++;
                    }
                    // Causa do acidente 
                    if($resultado->CAUSA_ACIDENTE_ID){
                        $this->resultados['Mensal']['CAUSA_ACIDENTE'][$resultado->GrupoMes][$resultado->CAUSA_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR]['CAUSA_ACIDENTE']['Mensal'][$resultado->GrupoDia][$resultado->CAUSA_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF]['CAUSA_ACIDENTE']['Mensal'][$resultado->GrupoDia][$resultado->CAUSA_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$resultado->LOCALBR_RANGE]['CAUSA_ACIDENTE']['Mensal'][$resultado->GrupoDia][$resultado->CAUSA_ACIDENTE_ID]++;
                    }
                    // Trecho da BR
                    $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR]['Mensal'][$resultado->GrupoDia]++;
                    $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF]['Mensal'][$resultado->GrupoDia]++;
                    $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$resultado->LOCALBR_RANGE]['Mensal'][$resultado->GrupoDia]++;
                 }

                /**
                 * Organiza as estatísticas por período diário
                 */
                 if($this->Tipo_Periodo == 'Diario' || $this->Tipo_Periodo == 'Mensal'){
                    $this->resultados['Diario'][$resultado->GrupoDia]++;
                    // Tipo de acidente
                    if($resultado->TIPO_ACIDENTE_ID){
                        $this->resultados['Diario']['TIPO_ACIDENTE'][$resultado->GrupoDia][$resultado->TIPO_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR]['TIPO_ACIDENTE']['Diario'][$resultado->GrupoDia][$resultado->TIPO_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF]['TIPO_ACIDENTE']['Diario'][$resultado->GrupoDia][$resultado->TIPO_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$resultado->LOCALBR_RANGE]['TIPO_ACIDENTE']['Diario'][$resultado->GrupoDia][$resultado->TIPO_ACIDENTE_ID]++;
                    }
                    // Causa do acidente 
                    if($resultado->CAUSA_ACIDENTE_ID){
                        $this->resultados['Diario']['CAUSA_ACIDENTE'][$resultado->GrupoDia][$resultado->CAUSA_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR]['CAUSA_ACIDENTE']['Diario'][$resultado->GrupoDia][$resultado->CAUSA_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF]['CAUSA_ACIDENTE']['Diario'][$resultado->GrupoDia][$resultado->CAUSA_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$resultado->LOCALBR_RANGE]['CAUSA_ACIDENTE']['Diario'][$resultado->GrupoDia][$resultado->CAUSA_ACIDENTE_ID]++;
                    }
                    // Trecho da BR
                    $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR]['Diario'][$resultado->GrupoDia]++;
                    $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF]['Diario'][$resultado->GrupoDia]++;
                    $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$resultado->LOCALBR_RANGE]['Diario'][$resultado->GrupoDia]++;
                 }
                 
                /**
                 * Organiza as estatísticas por período diário (por hora)
                 */
                 if($this->Tipo_Periodo == 'Diario'){
                    $this->resultados['Horario'][$resultado->GrupoHora]++;
                    // Tipo de acidente
                    if($resultado->TIPO_ACIDENTE_ID){
                        $this->resultados['Horario']['TIPO_ACIDENTE'][$resultado->GrupoHora][$resultado->TIPO_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR]['TIPO_ACIDENTE']['Horario'][$resultado->GrupoHora][$resultado->TIPO_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF]['TIPO_ACIDENTE']['Horario'][$resultado->GrupoHora][$resultado->TIPO_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$resultado->LOCALBR_RANGE]['TIPO_ACIDENTE']['Horario'][$resultado->GrupoHora][$resultado->TIPO_ACIDENTE_ID]++;
                    }
                    // Causa do acidente 
                    if($resultado->CAUSA_ACIDENTE_ID){
                        $this->resultados['Horario']['CAUSA_ACIDENTE'][$resultado->GrupoHora][$resultado->CAUSA_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR]['CAUSA_ACIDENTE']['Horario'][$resultado->GrupoHora][$resultado->CAUSA_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF]['CAUSA_ACIDENTE']['Horario'][$resultado->GrupoHora][$resultado->CAUSA_ACIDENTE_ID]++;
                        $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$resultado->LOCALBR_RANGE]['CAUSA_ACIDENTE']['Horario'][$resultado->GrupoHora][$resultado->CAUSA_ACIDENTE_ID]++;
                    }
                    // Trecho da BR
                    $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR]['Horario'][$resultado->GrupoHora]++;
                    $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF]['Horario'][$resultado->GrupoHora]++;
                    $this->resultados['LOCALBR']['BR-'.$resultado->LOCALBR_BR][$resultado->LOCALBR_UF][$resultado->LOCALBR_RANGE]['Horario'][$resultado->GrupoHora]++;
                 }

                 // Agrupa pelos horários
                 if($resultado->GrupoHora){
                    $this->resultados['HORARIO'][$resultado->GrupoHora]++;
                    // Tipo de acidente
                    if($resultado->TIPO_ACIDENTE_ID) 
                    $this->resultados['HORARIO']['TIPO_ACIDENTE'][$resultado->GrupoHora][$resultado->TIPO_ACIDENTE_ID]++;
                    // Causa do acidente 
                    if($resultado->CAUSA_ACIDENTE_ID)
                    $this->resultados['HORARIO']['CAUSA_ACIDENTE'][$resultado->GrupoHora][$resultado->CAUSA_ACIDENTE_ID]++;
                 }

                 // Agrupa pelos dias da semana
                 if($resultado->GrupoDiaSemana){
                    $this->resultados['DIASEMANA'][$resultado->GrupoDiaSemana]++;
                    // Tipo de acidente
                    if($resultado->TIPO_ACIDENTE_ID)
                    $this->resultados['DIASEMANA']['TIPO_ACIDENTE'][$resultado->GrupoDiaSemana][$resultado->TIPO_ACIDENTE_ID]++;
                    // Causa do acidente 
                    if($resultado->CAUSA_ACIDENTE_ID)
                    $this->resultados['DIASEMANA']['CAUSA_ACIDENTE'][$resultado->GrupoDiaSemana][$resultado->CAUSA_ACIDENTE_ID]++;
                 }

            }

            // Define o código da última ocorrência calculada 
            $ID_OCORRENCIA = $resultado->OCORRENCIA_ID;

        } // Fim do while

        // Cria a array com o total de veículos/marca para estatística
        $total_marcas = array();
        // Percorre o array da consulta e adiciona as marcas como key e as quantidades como valor
        foreach($this->resultados['VEICULOS'] as $marca => $veiculos){
            if($veiculos['TOTAL'] >= 0)
            $total_marcas[$marca] = $veiculos['TOTAL'];
        }
        arsort($total_marcas);
        $this->resultados['TOTAL_MARCAS'] = $total_marcas;

        // Cria a array com o total de veículos/marcas para estatística
        $total_modelos = array();
        // Percorre o array da consulta e adiciona as marcas como key e as quantidades como valor
        foreach($this->resultados['VEICULOS'] as $marca => $array_marcas){
            if(is_array($array_marcas['MODELOS'])){
                foreach($array_marcas['MODELOS'] as $modelo => $array_modelos){
                    if(is_array($array_modelos)){
                        $total_modelos["{$marca}/{$modelo}"] = $array_modelos['TOTAL'];
                    }
                }
            }
        }

        arsort($total_modelos);   
        $this->resultados['TOTAL_MODELOS'] = $total_modelos;

        arsort($this->resultados['TIPO_ACIDENTE']);
        arsort($this->resultados['CAUSA_ACIDENTE']);
        arsort($this->resultados['PESSOAS']['TIPO_ENVOLVIDO']);
        arsort($this->resultados['PESSOAS']['ESTADO_FISICO']);
        arsort($this->resultados['CONDUTORES']['IDADE']);
        arsort($this->resultados['LOCALBR']['TRECHOS']);
        arsort($this->resultados['LOCALBR']['BR']);
        arsort($this->resultados['LOCALBR']['BR_UF']);
        arsort($this->resultados['LOCALBR']['BR_UF_IDC']);
        arsort($this->resultados['VEICULOS']['VEICULO_TIPO']);
        
        if($this->resultados['ANUAL'])         ksort($this->resultados['ANUAL']);       
        if($this->resultados['SEMESTRE'])      ksort($this->resultados['SEMESTRE']);
        if($this->resultados['TRIMESTRE'])     ksort($this->resultados['TRIMESTRE']);
        if($this->resultados['MENSAL'])        ksort($this->resultados['MENSAL']);
        if($this->resultados['DIARIO'])        ksort($this->resultados['DIARIO']);
        if($this->resultados['HORARIO'])       ksort($this->resultados['HORARIO']);
        if($this->resultados['DIASEMANA'])     ksort($this->resultados['DIASEMANA']);

    }
    
    public function getData($atual = 1){
        
        if(!$atual){
            $cache_file = 'cache/'.$this->Tipo_Periodo.'/'.(($this->Periodo_Anterior) ? $this->Periodo_Anterior.'-' : '').$this->Tipo_Periodo.(($this->Ano_Anterior) ? '-'.$this->Ano_Anterior : '').(($this->Mes_Anterior) ? '-'.$this->Mes_Anterior : '').(($this->Dia_Anterior) ? '-'.$this->Dia_Anterior : '').'.json';
        } else {
            $cache_file = $this->cache_file;
        }
        
        $this->cache_file = $cache_file;
        
        // Fiz esse IF pois o servidor estava dando problema de memory limit para periodo anual
        // Vamos juntar os 2 semestres no resultado
        if($this->Tipo_Periodo == 'Anual'){
            
            $cache_file_1 = 'cache/Semestre/1-Semestre-'.$this->Ano.'.json';
            $cache_file_2 = 'cache/Semestre/2-Semestre-'.$this->Ano.'.json';
            // Primeiro semestre
            if(file_exists($cache_file_1)){
                $json = file_get_contents($cache_file_1);
                $json_decode = json_decode($json, true);
                $retorno_1 = $json_decode;
            }
            // Segundo semestre
            if(file_exists($cache_file_2)){
                $json = file_get_contents($cache_file_2);
                $json_decode = json_decode($json, true);
                $retorno_2 = $json_decode;
            }
            // Se encontrarmos os 2 períodos
            if(is_array($retorno_1) && is_array($retorno_2)){
                // Agrupamos os 2 períodos
                $final = array_merge($retorno_1, $retorno_2);
            // Se for encontrado apenas 1 período
            } else if(is_array($retorno_1)){
                $final = $retorno_1;
            }
            // Se foram encontrados resultados
            if($final){
                $this->resultados = $final;
                return $cache_file_1;
            }
            
        } else {
        
            if(file_exists($cache_file)){
                $json = file_get_contents($cache_file);
                $json_decode = json_decode($json, true);
                $this->resultados = $json_decode;
                return $cache_file;
            } else {
                return false;
            }
        
        }
        
    }
    
    public function getDataFile($cache_file = ''){
        
        if($cache_file) 
             $cache_file = $cache_file;
        else $cache_file = $this->cache_file;
        
        if( file_exists($cache_file)){
            $json = file_get_contents($cache_file);
            $json_decode = json_decode($json, true);
            $this->resultados = $json_decode;
            return $cache_file;
        } else {
            return false;
        }
        
    }
    
    public function getIcone($Marca, $Modelo = ''){
         if($Marca == 'HONDA'){
            if(preg_match('/CG/', $Modelo)){
                $Marca = $Marca.'MOTOS';
            } else {
                $Marca = $Marca.'CARROS';
            }
         }
         $Marca = preg_replace('/\s+/', '', $Marca);
         return $Marca;
    }
    
    public function getMarca($Marca){
         if($Marca == 'VW') $Marca = 'VOLKSWAGEN';
         if($Marca == 'GM') $Marca = 'CHEVROLET';
         if($Marca == 'KIA') $Marca = 'KIA MOTORS';
         return $Marca;
    }
    
    public function getMes($Mes){
         if($Mes == '01') return 'Jan';
         if($Mes == '02') return 'Fev';
         if($Mes == '03') return 'Mar';
         if($Mes == '04') return 'Abr';
         if($Mes == '05') return 'Mai';
         if($Mes == '06') return 'Jun';
         if($Mes == '07') return 'Jul';
         if($Mes == '08') return 'Ago';
         if($Mes == '09') return 'Set';
         if($Mes == '10') return 'Out';
         if($Mes == '11') return 'Nov';
         if($Mes == '12') return 'Dez';
         return $Mes;
    }
    
    public function getMesFull($Mes){
         if($Mes == '01' || $Mes == 1) return 'Janeiro';
         if($Mes == '02' || $Mes == 2) return 'Fevereiro';
         if($Mes == '03' || $Mes == 3) return 'Março';
         if($Mes == '04' || $Mes == 4) return 'Abril';
         if($Mes == '05' || $Mes == 5) return 'Maio';
         if($Mes == '06' || $Mes == 6) return 'Junho';
         if($Mes == '07' || $Mes == 7) return 'Julho';
         if($Mes == '08' || $Mes == 8) return 'Agosto';
         if($Mes == '09' || $Mes == 9) return 'Setembro';
         if($Mes == '10' || $Mes == 10) return 'Outubro';
         if($Mes == '11' || $Mes == 11) return 'Novembro';
         if($Mes == '12' || $Mes == 12) return 'Dezembro';
         return $Marca;
    }
    
    public function getDiaSemana($Dia, $complete = 0){
         if($Dia == 1) return 'Domingo';
         if($Dia == 2) return ($complete == 1) ? 'Segunda-feira' : 'Segunda';
         if($Dia == 3) return ($complete == 1) ? 'Terça-feira'   : 'Terça';
         if($Dia == 4) return ($complete == 1) ? 'Quarta-feira'  : 'Quarta';
         if($Dia == 5) return ($complete == 1) ? 'Quinta-feira'  : 'Quinta';
         if($Dia == 6) return ($complete == 1) ? 'Sexta-feira'   : 'Sexta';
         if($Dia == 7) return 'Sábado';
         return $Marca;
    }
    
    public function getTipoRodovia($tipo){
         if($tipo == 0) return 'Rodovias radiais';
         if($tipo == 1) return 'Rodovias longitudinais';
         if($tipo == 2) return 'Rodovias transversais';
         if($tipo == 3) return 'Rodovias diagonais';
         if($tipo == 4) return 'Rodovias de ligação';
         if($tipo == 6) return 'Rodovias de ligação de pouca extensão';     
         return $Marca;
    }
    


}


?>