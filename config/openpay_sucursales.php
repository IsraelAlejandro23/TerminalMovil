<?php
/**
 * Cada arreglo de sucursales indica el ID de la sucursal, escepto 'default'
 * que se usa si no se encuentra el id de la sucursal en el arreglo
 *
 * Cada elemento contiene:
 * name 	    : nombre de la sucursal
 * email 	    : email de la sucursal, a este email se enviará correo de venta
 * id           : ID provisto por OpenPay desde el panel de control
 * private_key  : Llave privada proporcionada por OpenPay desde el panel de control
 *  			  Para llamadas entre servidores y con acceso total a todas las operaciones de la API
 *  			  (nunca debe ser compartida).
 * public_key   : Llave pública proporcionada por OpenPay desde el panel de control
 * 				  Sólo se debe utilizar en llamadas desde JavaScript.
 *				  Esta llave sólo tiene permitido realizar crear tarjetas o crear tokens
 *				  Para hacer llamadas con tu llave pública utiliza la librería Openpay.js
 * mode_sandbox : Con el modo sanbox en true, estaremos en ambiente de pruebas
 *				  Si está en false estaremos en modo de Producción
 * str_orden_id : Esta variable se le contacte el ID obtenido de la base de datos;
 *				  si se utiliza el sandbox en true entonces concatena esta variable
 *				  con la variable infix y luego concatena el ID obtenido de la base de datos
 * infix 		: La variable infix se utiliza para el sandbox y el testing,
 * 				  con esto concateno el valor de la variable
 *				  str_orden_id y el resultado es que OpenPay tiene un orden_id diferente para el testing
 */
return [

	'sucursales' => [
		'default' => [
			'name'         =>  'Israel Alejandro',
			'email'        =>  'i.loera@unexpect.mx',
			'id'           => 'mckh9vzhik2zuqipmpsa',
			'private_key'  => 'sk_01727c7a92f6420391446f2ec0f01ce1',
			'public_key'   => 'pk_54a7365a4c864a3bb15b760cc3ca2de5',
			'mode_sandbox' => true,
			'str_orden_id' => 'gral-ia-',
			'infix'        => 'sandboxGral-israel',
		],
		//ID de la sucursal
		2  => [
			'name'  => 'López Mateos',
			'email' => 'suc1@fake.com.mx',
			'id'           => 'miIDdeOpenpay1',
			'private_key'  => 'sk_numeroOpenpay1',
			'public_key'   => 'pk_numeroOpenpay1',
			'mode_sandbox' => true,
			'str_orden_id' => '',
			'infix'        => 'sandbox-israel',
		],
		4  => [
			'name'  => 'GALERIA DEL CALZADO',
			'email' => 'suc2@fake.com.mx',
			'id'           => 'miIDdeOpenpay2',
			'private_key'  => 'sk_numeroOpenpay2',
			'public_key'   => 'pk_numeroOpenpay2',
			'mode_sandbox' => true,
			'str_orden_id' => '4-gv-',
			'infix'        => 'sandbox4-cuau',
		],
    ],

];
