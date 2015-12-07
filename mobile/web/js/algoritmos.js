var PRIVATE_KEY = "GRUPO3PHPPRIVADO";
var PUBLIC_KEY = "GRUPO3PHP";

function getDataHash(datos, timestamp) {
	var pares = [];
	var keysPares = [];
	var impares = [];
	var keysImpares = [];

	datosOrd = sortObject(datos);

	var i = 1;
	for(var key in datos ) {
		if(  i%2 ) {
			pares.push(datos[key]);
			keysPares.push(key);
		} else {
			impares.push(datos[key]);
			keysImpares.push(key);
		}
		i++;
	}

	var data = PUBLIC_KEY + keysImpares.join("") + impares.join("") + PRIVATE_KEY + keysPares.join("")
			+ pares.join("") + timestamp;

	return CryptoJS.SHA256(data).toString();
}

function sortObject(obj) {
    return Object.keys(obj).sort().reduce(function (result, key) {
        result[key] = obj[key];
        return result;
    }, {});
}

function obtenerDatosDeForm(form_id) {
    var datos = {};
    $("#" + form_id + " input").each(function(){
      if( $(this).attr("name") != undefined )
        datos[$(this).attr("name")] = $(this).val();
    });
     $("#" + form_id + " select").each(function(){
      if( $(this).attr("name") != undefined )
        datos[$(this).attr("name")] = $(this).val();
    });

    var timestamp = Math.round(+new Date()/1000);
    var hash = getDataHash(datos, timestamp);

    var request = {
    	"datos" : datos,
    	"timestamp" : timestamp,
    	"hash" : hash,
    	"key" : PUBLIC_KEY
    };

    var token = cargarDeLocalStorage("token");
    if( token !=  "NOT_FOUND" )
    	request.token =  token;

    return request;
}

function cargarDeLocalStorage(id) {
	if(typeof(Storage) !== "undefined") {
    	if( localStorage[id] != undefined ) {
    		return localStorage[id];
    	} else {
    		return "NOT_FOUND";
    	}
	} else {
	    alert("ERROR!! Este sition necesita la soporte de localStorage para funcionar!!")
	}
}

function guardarEnLocalStorage(id, valor) {
	if(typeof(Storage) !== "undefined") {
    	localStorage.setItem(id, valor);
	} else {
	    alert("ERROR!! Este sition necesita la soporte de localStorage para funcionar!!")
	}
}

function destruirEnLocalStorage(id) {
	if(typeof(Storage) !== "undefined") {
    	localStorage.removeItem(id);
	} else {
	    alert("ERROR!! Este sition necesita la soporte de localStorage para funcionar!!")
	}
}

function enviarFormularioPOST(form_id, response, action) {

	if( action == undefined ) {
		action = $("#" + form_id).attr('action');
	}
	console.log("accion:");
	console.log(action);
	request = obtenerDatosDeForm(form_id);
	console.log("REQUEST:");
	console.log(request);

	$.ajax({
		url: action,
		type: 'post',
		data: request,
		success: response,
		error: response
	});

}

function agregarErrores(form, errors) {
    limpiarErrores(form);
    errors.forEach(function(error){
        if( error[1] != form ) {
            $("<div class='help-block'>"+error[0]+"</div>").insertAfter(error[1]);
            $(error[1]).parent().addClass("has-error");
        } else {
            $(error[1]).prepend($("<div class='help-block'>"+error[0]+"</div>"));
            $(error[1]).addClass("has-error");
        }
    });
}

function limpiarErrores(form) {
    $(form).removeClass("has-error");
    $(form).find(".has-error").each(function(){
        $(this).removeClass("has-error");
    });
    $(form).find(".help-block").each(function(){
        $(this).remove();
    });
}
