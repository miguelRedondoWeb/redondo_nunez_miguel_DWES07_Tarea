function envForm() {
    var usu = document.getElementById("usu").value;
    var pass = document.getElementById('pass').value;
    var res = xajax.request({xjxfun: 'vUsuario'}, {mode: 'synchronous', parameters: [usu, pass]});
    if(res==false) alert("Credenciales erróneas");
    return res;
}

function envFormVoto(form){
    var res = xajax.request({xjxfun: 'miVoto'}, {mode: 'synchronous', parameters: [form['cantidad'], form['idPr']]});
    if(res==false){
        alert("Ya has votado este producto");
    }else{
        xajax.request({xjxfun: 'pintarEstrellas'}, {mode: 'synchronous', parameters: []});
    } 
    return res;
}
