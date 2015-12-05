function getDataHash(datos, KEY, timestamp) {

	var PK = "mierda";
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

	var data = KEY + keysImpares.join("") + impares.join("") + PK + keysPares.join("")
			+ pares.join("") + timestamp;
	console.log(data);
	return CryptoJS.SHA256(data).toString();
}

function sortObject(obj) {
    return Object.keys(obj).sort().reduce(function (result, key) {
        result[key] = obj[key];
        return result;
    }, {});
}
