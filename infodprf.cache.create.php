<?php

/**
 * infoDPRF
 * Arquivo responsбvel pela chamada e criaзгo de cache das consultas sql.
 * 
 * @author Mбrio Pбcio <mario.pacio@gmail.com>
 * @copyright 2013
 * @version 1.0
 * @package infoDPRF
 * @license AGPLv3 - http://www.gnu.org/licenses/agpl-3.0.html
 * 
 */

    ob_start();
    
    ini_set('memory_limit', '-1');
    set_time_limit(0);
    
    mysql_connect('localhost', 'root', '');
    mysql_select_db('dprf');
    
    require_once 'infodprf.class.php';
    
    // Inicia a classe principal do projeto
    $infoDPRF = new infoDPRF;
    
    // Configura a classe para o perнodo atual
    $infoDPRF->configure();
    
    // Faz a verificaзгo da existкncia do cache para agilizar no carregamento da pбgina
    $Dados = $infoDPRF->getData();
    
    // Se o cache ainda nгo existir, faz a conexгo com a tabela 
    if(!$Dados){
        // Executa o comando sql
        $infoDPRF->getDataSQL();
    }
    
    if(!$infoDPRF->resultados){

        die('nenhum_resultado');

    }
    
    die('ok');
    

?>