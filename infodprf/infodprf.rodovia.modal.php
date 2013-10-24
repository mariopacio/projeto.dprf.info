<?php

/**
 * DPRF.info
 * Arquivo responsável pela exibição do resumo da rodovia  
 * 
 * @author Mário Pácio <mario.pacio@gmail.com>
 * @copyright 2013
 * @version 1.0
 * @package DPRF.info
 * @license AGPLv3 - http://www.gnu.org/licenses/agpl-3.0.html
 * 
 */
 
    require_once('../infodprf.class.php');
    
    $infoDPRF = new infoDPRF;
    
    $Rodovia = $_GET['rodovia'];
    
    if(!is_numeric($Rodovia)) die;
    
    $Resumo = $infoDPRF->getBRDescription($Rodovia);

?>
<div class="modal modal-shadow" style="position: relative; top: auto; left: auto; margin: 0; z-index: 1; max-width: 100%;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4>Rodovia BR-<?php echo $Rodovia; ?></h4>
    </div>
    <div class="modal-body">
        <p><?php echo utf8_encode($Resumo); ?></p>
    </div>
    <div class="modal-footer"> 
        <a href="http://pt.wikipedia.org/wiki/BR-<?php echo $Rodovia; ?>" target="_blank" class="btn btn-blue">Ver na Wikipedia<i class="fontello-icon-right-open"></i></a>
        <a href="#" class="btn" data-dismiss="modal">Fechar janela</a>
    </div>
</div>