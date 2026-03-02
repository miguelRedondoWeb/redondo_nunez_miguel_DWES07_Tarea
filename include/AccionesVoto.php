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


$xajax->register(XAJAX_FUNCTION, 'pintarEstrellas');
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

            $decimal = $mediaVotos - $estrellasCompletas;
            if($decimal >= 0.5){
                $innerHTML .= '<i class="fas fa-star-half-alt"></i>';
                $estrellasCompletas++;
            }

            for ($i = $estrellasCompletas; $i < 5; $i++) {
                $innerHTML .= '<i class="far fa-star"></i>';
            }


            $innerHTML .= '</p>';
        }
        $resp->assign("votos_" . $id, "innerHTML", $innerHTML);
    }

    $resp->setReturnValue(true);
    $voto = null;
    return $resp;

}

$xajax->processRequest();
