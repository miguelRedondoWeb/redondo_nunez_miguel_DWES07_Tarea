<?php
require 'Voto.php';
require_once 'xajax_core/xajax.inc.php';

$xjax=new xajax();
$xjax->register(XAJAX_FUNCTION, 'miVoto');
function miVoto($cantidad, $idPr, $idUs){
    $resp=new xajaxResponse();
    $voto = new Voto();

    if (!$voto->isValido($idPr, $idUs)) {
        $resp->setReturnValue(false);
    } else {
        $voto->insertarVoto($cantidad, $idPr, $idUs);
        $resp->setReturnValue($voto->mediaProducto($idPr));
    }
    return $resp;
}


$xjax->register(XAJAX_FUNCTION, 'pintarEstrellas');
function pintarEstrellas(){
    $resp=new xajaxResponse();
    $voto = new Voto();
    $resultado = $voto->pintarEstrellas();

    foreach ($resultado as $value) {
        $id = $value['id'];
        $mediaVotos = (float) $value['mediaVotos'];
        $numVotos = (int) $value['numVotos'];
        $innerHTML = '';

        if($numVotos === 0){
            $innerHTML = 'Sin valoración';
        }else{
            $etiqueta = ($numVotos === 1) ? 'valoración' : 'valoraciones';
            $innerHTML .= '<p>' . $numVotos . ' ' . $etiqueta . ': ';

            $estrellasCompletas = (int) floor($mediaVotos);
            $media = ($mediaVotos - $estrellasCompletas) >= 0.5;

            for ($i = 0; $i < $estrellasCompletas; $i++) {
                $innerHTML .= '<i class="fas fa-star"></i>';
            }

            if ($media) {
                $innerHTML .= '<i class="fas fa-star-half-alt"></i>';
            }

            $innerHTML .= '</p>';
        }
        $resp->assign('votos_' . $id, 'innerHTML', $innerHTML);
    }

    $resp->setReturnValue(true);
    $voto = null;
    return $resp;

}

$xjax->processRequest();
