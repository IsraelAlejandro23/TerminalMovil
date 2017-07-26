<?php namespace App\Http\Controllers\Pagos_Openpay;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class MsgErrorController extends Controller {

	var $codigo = '';

	/**
	 * Retornar le mensaje de error de OpenPay
	 *
	 */
	public function msgErrorOpenPay()
	{

		if( empty($this->codigo) ) return 'Tarjeta declinada, contacta al administrador.';

		$msg = '';
		// ### Generales ### //
		if( 1000 == $this->codigo){
			$msg.='Ocurrió un error interno en el servidor de Openpay';
		}
		elseif( 1001 == $this->codigo ){
			$msg.='El formato de la petición no es JSON, los campos no tienen el formato correcto, o la petición no tiene campos que son requeridos.';
		}
		elseif( 1002 == $this->codigo ){
			$msg.='La llamada no está autenticada o la autenticación es incorrecta.';
		}
		elseif( 1003 == $this->codigo ){
			$msg.='La operación no se pudo completar por que el valor de uno o más de los parametros no es correcto.';
		}
		elseif( 1004 == $this->codigo ){
			$msg.='Un servicio necesario para el procesamiento de la transacción no se encuentra disponible.';
		}
		elseif( 1005 == $this->codigo ){
			$msg.='Uno de los recursos requeridos no existe.';
		}
		elseif( 1006 == $this->codigo ){
			$msg.='Ya existe una transacción con el mismo ID de orden.';
		}
		elseif( 1007 == $this->codigo ){
			$msg.='La transferencia de fondos entre una cuenta de banco o tarjeta y la cuenta de Openpay no fue aceptada.';
		}
		elseif( 1008 == $this->codigo ){
			$msg.='Una de las cuentas requeridas en la petición se encuentra desactivada.';
		}
		elseif( 1009 == $this->codigo ){
			$msg.='El cuerpo de la petición es demasiado grande.';
		}
		elseif( 1010 == $this->codigo ){
			$msg.='Se está utilizando la llave pública para hacer una llamada que requiere la llave privada, o bien, se está usando la llave privada desde JavaScript.';
		}
		elseif( 1011 == $this->codigo ){
			$msg.='Se solicita un recurso que está marcado como eliminado.';
		}
		elseif( 1012 == $this->codigo ){
			$msg.='El monto de transacción está fuera de los límites permitidos.';
		}
		elseif( 1013 == $this->codigo ){
			$msg.='La operación no está permitida para el recurso.';
		}
		elseif( 1014 == $this->codigo ){
			$msg.='La cuenta está inactiva.';
		}
		elseif( 1015 == $this->codigo ){
			$msg.='No se ha obtenido respuesta de la solicitud realizada al servicio.';
		}
		elseif( 1016 == $this->codigo ){
			$msg.='El mail del comercio ya ha sido procesado.';
		}
		elseif( 1017 == $this->codigo ){
			$msg.='El gateway no se encuentra disponible en ese momento.';
		}
		elseif( 1018 == $this->codigo ){
			$msg.='El número de intentos de cargo es mayor al permitido.';
		}
		// ### Almacenamiento ### //
		elseif( 2001 == $this->codigo ){
			$msg.='La cuenta de banco con esta CLABE ya se encuentra registrada en el cliente.';
		}
		elseif( 2002 == $this->codigo ){
			$msg.='La tarjeta con este número ya se encuentra registrada en el cliente.';
		}
		elseif( 2003 == $this->codigo ){
			$msg.='El cliente con este identificador externo (External ID) ya existe.';
		}
		elseif( 2004 == $this->codigo ){
			$msg.='El dígito verificador del número de tarjeta es inválido de acuerdo al algoritmo Luhn.';
		}
		elseif( 2005 == $this->codigo ){
			$msg.='La fecha de expiración de la tarjeta es anterior a la fecha actual.';
		}
		elseif( 2006 == $this->codigo ){
			$msg.='El código de seguridad de la tarjeta (CVV2) no fue proporcionado.';
		}
		elseif( 2007 == $this->codigo ){
			$msg.='El número de tarjeta es de prueba, solamente puede usarse en Sandbox (Entorno de pruebas).';
		}
		elseif( 2008 == $this->codigo ){
			$msg.='La tarjeta no es válida para puntos Santander.';
		}
		// ### Tarjetas ### //
		elseif( 3001 == $this->codigo ){
			$msg.='La tarjeta fue declinada.';
		}
		elseif( 3002 == $this->codigo ){
			$msg.='La tarjeta ha expirado.';
		}
		elseif( 3003 == $this->codigo ){
			$msg.='La tarjeta no tiene fondos suficientes.';
		}
		elseif( 3004 == $this->codigo ){
			$msg.='La tarjeta ha sido identificada como una tarjeta robada.';
		}
		elseif( 3005 == $this->codigo ){
			$msg.='La tarjeta ha sido identificada como una tarjeta fraudulenta.';
		}
		elseif( 3006 == $this->codigo ){
			$msg.='La operación no está permitida para este cliente o esta transacción.';
		}
		elseif( 3007 == $this->codigo){
			$msg.='La tarjeta fue declinada.';
		}
		elseif( 3008 == $this->codigo ){
			$msg.='La tarjeta no es soportada en transacciones en línea.';
		}
		elseif( 3009 == $this->codigo ){
			$msg.='La tarjeta fue reportada como perdida.';
		}
		elseif( 3010 == $this->codigo ){
			$msg.='El banco ha restringido la tarjeta.';
		}
		elseif( 3011 == $this->codigo ){
			$msg.='El banco ha solicitado que la tarjeta sea retenida. Contacte al banco.';
		}
		elseif( 3012 == $this->codigo ){
			$msg.='Se requiere solicitar al banco autorización para realizar este pago.';
		}
		// ### Cuentas ### //
		elseif( 4001 == $this->codigo ){
			$msg.='La cuenta de Openpay no tiene fondos suficientes.';
		}
		elseif( 4002 == $this->codigo ){
			$msg.='La operación no puede ser completada hasta que sean pagadas las comisiones pendientes.';
		}
		// ### Órdenes ###//
		elseif( 5001 == $this->codigo ){
			$msg.='La orden con este identificador externo ya existe.';
		}
		// ### Webhooks ###//
		elseif( 6001 == $this->codigo ){
			$msg.='El webhook ya ha sido procesado.';
		}
		elseif( 6002 == $this->codigo ){
			$msg.='No se ha podido conectar con el servicio de webhook.';
		}
		elseif( 6003 == $this->codigo ){
			$msg.='El servicio respondió con errores.';
		}
		// OTROS
		else{
			$msg.='Mensaje no especificado código: '.$this->codigo;
		}

		return $msg;
	}

}
