<!DOCTYPE html>
<html lang="es">
<head>
  <!-- META -->
	<meta charset="utf-8">
  <meta name="csrf-token">
	<meta name="theme-color" content="#f8971d">
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1, maximum-scale=1.0, user-scalable=no, minimal-ui">
	<meta name="description" content="Marisa">
	<meta name="keywords" content="Marisa">
	<meta name="author" content="unexpect.mx">
</head>
<body>
  <span id="url-location" data-url="{{ url('') }}"></span>
  <div id="content">
		<!-- <payment-form></payment-form> -->
		<pay-order></pay-order>
  </div>
	<!-- JS -->
  <script src="{{asset('/js/app.js')}}"></script>
	<!-- OPENPAY -->
	<script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
	<script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>


  <!-- Claves Openpay -->
    <span id="openpay" data-openpay_id="{{ config('openpay_sucursales.sucursales.default.id') }}"
          data-openpay_public_key="{{ config('openpay_sucursales.sucursales.default.public_key') }}"
          data-openpay_mode_sandbox="{{ config('openpay_sucursales.sucursales.default.mode_sandbox') }}"></span>

		<script src="{{asset('/js/main.js')}}"></script>
</body>
</html>
