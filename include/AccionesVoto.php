<?php
require 'Voto.php';
require_once 'xajax_core/xajax.inc.php';

$xjax=new xajax();
$xjax->register(XAJAX_FUNCTION, 'miVoto');
function miVoto($cantidad, $idPr){
    $resp=new xajaxResponse();
    session_start();
    $idUs = $_SESSION['usu'];
    $voto = new Voto();

    if (!$voto->isValido($idPr, $idUs)) {
        $resp->setReturnValue(false);
    } else {
        $voto->insertarVoto($cantidad, $idPr, $idUs);
        $media = $voto->mediaProducto($idPr);
        $resp->setReturnValue($media);
    }
    return $resp;
}


$xjax->register(XAJAX_FUNCTION, 'pintarEstrellas');
function pintarEstrellas(){
    $resp=new xajaxResponse();
    $voto = new Voto();
    $resultado = $voto->pintarEstrellas();
    
    foreach ($resultado as $key => $value) {
        $id = $value['id'];
        $mediaVotos = $value['mediaVotos'];
        $numVotos = $value['numVotos'];
        $innerHTML = '';
        if($numVotos == 0){
            $innerHTML = 'Sin valoración';
        }else{
            $innerHTML .= '<p>' . $numVotos . ' valoraciones: ';
            $enteras = floor($mediaVotos);
            for ($i = 0; $i < $enteras; $i++) {
                $innerHTML .= '<i class="fas fa-star"></i>';
            }
            if (($mediaVotos - $enteras) >= 0.5) {
                $innerHTML .= '<i class="fas fa-star-half"></i>';
            }

            $innerHTML .= '</p>';
        }
        $resp->assign("votos_" . $id, "innerHTML", $innerHTML);
    }

    $resp->setReturnValue(true);
    $voto = null;
    return $resp;

}

$xjax->processRequest();