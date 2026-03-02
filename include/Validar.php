<?php
require 'Usuario.php';
require_once 'xajax_core/xajax.inc.php';

$xjax=new xajax();
$xjax->register(XAJAX_FUNCTION, 'vUsuario');
$xjax->processRequest();
function vUsuario($u, $p){

        $resp=new xajaxResponse();
        if(strlen($u)==0 || strlen($p)==0){
            $resp->assign('msgLogin', 'innerHTML', '<div class="alert alert-danger mb-3">Debes indicar usuario y contraseña.</div>');
            $resp->setReturnValue(false);
        }
        else {
            $usuario = new Usuario();
            if (!$usuario->isValido($u, $p)) {
                $resp->assign('msgLogin', 'innerHTML', '<div class="alert alert-danger mb-3">Credenciales incorrectas.</div>');
                $resp->setReturnValue(false);
            } else {
                $resp->assign('msgLogin', 'innerHTML', '');
                session_start();
                $_SESSION['usu'] = $u;
                $resp->setReturnValue(true);
            }
            $usuario = null;
        }
        return $resp;
    }

