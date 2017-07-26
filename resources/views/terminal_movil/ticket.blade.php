<!-- TU HTML -->
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title></title>
<style>
  @charset "UTF-8";
  /* CSS Document */

  body {
  margin:0;
  font-family:Helvetica, Arial, sans-serf;
  }
  h3 {
  font-size:25px;
  margin:15px 0 0 0;
  }
  h4 {
  font-size:17px;
  margin:8px 0;
  }
  .whitepaper {
  background-color:#FFF;
  width:812px;
  height: 1020px;
  margin: 0 auto;
  }
  .Header {
  clear:both;
  float:left;
  width:84%;
  margin:4% 8% 4% 8%;
  }
  .Logo_empresa img {
  width:220px;
  float:left;
  }
  .Logo_paynet {
  float:right;
  margin-top:3px;
  }
  .Logo_paynet div {
  font-size:20px;
  font-weight:lighter;
  display:block;
  float:left;
  margin:10px 12px 0 0;
  }
  .Logo_paynet img {
  width:130px;
  float:left;
  }
  .Data {
  width:100%;
  clear:both;
  float:left;
  }
  .DT-margin {
  margin:15px 0;
  display:block;
  float:left;
  width:100%;
  clear:both;
  }
  .Big_Bullet {
  width:40px;
  float:left;
  margin-right:24px;
  }
  .Big_Bullet span, .col2 {
  background-color:#f9b317;
  }
  .Big_Bullet span {
  width:100%;
  height:55px;
  display:block;
  }
  .col1 {
  width:350px;
  float:left;
  }
  .col1 span {
  font-size:14px;
  clear:both;
  display:block;
  margin:5px 0;
  }
  .col1 small {
  font-size:12px;
  width:320px;
  display:block;
  }
  .col2 {
  width:358px;
  float:right;
  color:#FFF;
  padding:40px 0 40px 40px;
  }
  .col2 h1 {
  margin:0;
  padding:0;
  font-size:60px;
  }
  .col2 h1 span {
  font-size:45px;
  }
  .col2 h1 small {
  font-size:20px;
  }
  .col2 h2 {
  margin:0;
  font-size:22px;
  font-weight:lighter;
  }
  .S-margin {
  padding-left:80px;
  }

  .Table-Data {
  margin:20px 0 0 0;
  clear:both;
  width:100%;
  display:block;
  float:left;
  }
  .table-row {
  float:left;
  width:83%;
  padding:0 8.5%;
  }
  .table-row div {
  float:left;
  width:250px;
  padding:15px 0;
  }
  .table-row span {
  float:left;
  border-left:3px solid #FFF;
  padding:15px 0 15px 40px;
  }
  .color1 {
  background-color:#F3F3F3;
  }
  .color2 {
  background-color:#EBEBEB;
  }

  .col1 ol, .Col2 ol {
  font-size:12px;
  width:290px;
  padding-left:20px;
  }
  .col1 li, .Col2 li {
  padding:5px 0;
  line-height:16px;
  }
  .logos-tiendas {
  clear:both;
  float:left;
  width:92%;
  padding:15px 0 0 8%;
  border-top:1px solid #EDEDED;
  border-bottom:1px solid #EDEDED;
  margin:20px 0 0 0;
  }
  .logos-tiendas div {
  float:left;
  margin-right:50px;
  }
  .logos-tiendas small {
  font-size:11px;
  margin-left:20px;
  float:left;
  }
  .margen2 {
  margin-top:10px;
  }
  .mg3 {
  margin-right:0 !important;
  margin-top:10px;
  }
  .Powered {
  text-align:center;
  width:100%;
  float:left;
  margin-top:18px;
  }
</style>
</head>

<body>

<div class="whitepaper">
	<div class="Header">
	<div class="Logo_empresa">
    {{$datos_ticket['msg']}}
    	<!-- <img src="images/logo.png" alt="Logo"> -->
    </div>
    <div class="Logo_paynet">
    	<div>Servicio a pagar: Marisa</div>
    	<!-- <img src="images/paynet_logo.png" alt="Logo Paynet"> -->
    </div>
    </div>
    <div class="Data">
    	<div class="Big_Bullet">
        	<span></span>
        </div>
    	<div class="col1">
        	<h3>Fecha límite de pago</h3>
            <h4>30 de Noviembre 2014, a las 2:30 AM</h4>
            <img width="300" src="images/codigo_barras.gif" alt="Código de Barras">
        	<span>000020TRTJGWX6WVE2NF3R7FOW0260006</span>
            <small>En caso de que el escáner no sea capaz de leer el código de barras, escribir la referencia tal como se muestra.</small>

        </div>
        <div class="col2">
        	<h2>Total a pagar</h2>
            <h1>{{ $datos_ticket['monto_total']}}<span>.00</span><small> MXN</small></h1>
            <!-- <h2 class="S-margin">+8 pesos por comisión</h2> -->
        </div>
    </div>
    <div class="DT-margin"></div>
    <div class="Data">
    	<div class="Big_Bullet">
        	<span></span>
        </div>
    	<div class="col1">
        	<h3>Detalles de la compra</h3>
        </div>
	</div>
    <div class="Table-Data">
    	<div class="table-row color2">
        	<div>Nombre del cliente</div>
            <span>{{ $datos_ticket['nombre_cliente'] }}</span>
        </div>
    	<div class="table-row color1">
        	<div>Correo del cliente</div>
            <span>{{ $datos_ticket['email_cliente'] }}</span>
        </div>
        <div class="table-row color1">
          	<div>Descripción</div>
              <span>{{ $datos_ticket['description'] }}</span>
        </div>
        <div class="table-row color1">
          	<div>Teléfono</div>
              <span>{{ $datos_ticket['telefono'] }}</span>
        </div>
        <div class="table-row color1">
          	<div>Fecha y hora</div>
              <span>{{ $datos_ticket['fecha'] }}</span>
        </div>
        <div class="table-row color1">
            <div>Monto de impuesto</div>
              <span>{{ $datos_ticket['monto_impuesto'] }}</span>
        </div>
        <div class="table-row color1">
            <div>Subtotal</div>
              <span>{{ $datos_ticket['subtotal'] }}</span>
        </div>
        <div class="table-row color1">
            <div>Monto total</div>
              <span>{{ $datos_ticket['monto_total'] }}</span>
        </div>
        <div class="table-row color1">
            <div>Total con letra</div>
              <span>{{ $datos_ticket['total_letra'] }}</span>
        </div>
        <div class="table-row color1">
            <div>Método de envío</div>
              <span>{{ $datos_ticket['nombre_metodo_envio'] }}</span>
        </div>
        <div class="table-row color1">
            <div>Método de pago</div>
              <span>{{ $datos_ticket['metodoPago'] }}</span>
        </div>
        <div class="table-row color1">
            <div>¿Se requiere factura?</div>
              <span>{{ $datos_ticket['requiere_factura'] }}</span>
        </div>
        <div class="table-row color1">
            <div>Nombre del vendedor</div>
              <span>{{ $datos_ticket['vendedor'] }}</span>
        </div>

    	<div class="table-row color2"  style="display:none">
        	<div>&nbsp;</div>
            <span>&nbsp;</span>
        </div>
    	<div class="table-row color1" style="display:none">
        	<div>&nbsp;</div>
            <span>&nbsp;</span>
        </div>
    </div>
    <div class="DT-margin"></div>
    <div>
        <div class="Big_Bullet">
        	<span></span>
        </div>
    	<div class="col1">
        	<h3>Como realizar el pago</h3>
            <ol>
            	<li>Acude a cualquier tienda afiliada</li>
                <li>Entrega al cajero el código de barras y menciona que realizarás un pago de servicio Paynet</li>
                <li>Realizar el pago en efectivo por $ 260.00 MXN (más $8 pesos por comisión)</li>
                <li>Conserva el ticket para cualquier aclaración</li>
            </ol>
            <small>Si tienes dudas comunicate a NOMBRE TIENDA al teléfono TELEFONO TIENDA o al correo CORREO SOPORTE TIENDA</small>
        </div>
    	<div class="col1">
        	<h3>Instrucciones para el cajero</h3>
            <ol>
            	<li>Ingresar al menú de Pago de Servicios</li>
                <li>Seleccionar Paynet</li>
                <li>Escanear el código de barras o ingresar el núm. de referencia</li>
                <li>Ingresa la cantidad total a pagar</li>
                <li>Cobrar al cliente el monto total más la comisión de $8 pesos</li>
                <li>Confirmar la transacción y entregar el ticket al cliente</li>
            </ol>
            <small>Para cualquier duda sobre como cobrar, por favor llamar al teléfono 01 800 300 08 08 en un horario de 8am a 9pm de lunes a domingo</small>
        </div>
    </div>

    <div class="logos-tiendas">
    	<div><img width="50" src="images/7eleven.png" alt="7elven"></div>
        <div class="margen2"><img width="90" src="images/extra.png" alt="7elven"></div>
        <div class="margen2"><img width="90" src="images/farmacia_ahorro.png" alt="7elven"></div>
        <div class="mg3"><img width="150" src="images/benavides.png" alt="7elven"></div>
        <div class="mg3"><small>¿Quieres pagar en otras tiendas? <br> visita: www.openpay.mx/tiendas</small></div>
    </div>
    <div class="Powered">
    	<img src="images/powered_openpay.png" alt="Powered by Openpay" width="150">
    </div>




</div>

</body>
</html>
