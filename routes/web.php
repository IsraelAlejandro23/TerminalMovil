<?php

use Illuminate\Http\Request;



//Rutas de autenticacion

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('terminal/login', '\App\Http\Controllers\Auth\LoginController@showLoginForm');
Route::post('login', '\App\Http\Controllers\Auth\LoginController@login');


Route::get('sucursales', 'Sucursal\SucursalController@index');

//Aqui va a ir el grupo de rutas para los demas roles
Route::get('administrador', 'HomeController@welcome');


//Grupo de rutas para vendedores

Route::group([
	'prefix' => 'vendedores',
	'middleware' => ['auth', 'acl'],
	'is' => 'vendedor',
	'namespace' => 'Vendedor'
], function ()
{

Route::post('enviar-monto', 'VendedorController@enviar_monto');
Route::post('generar-pago', 'VendedorController@generar_pago');

});

Auth::routes();

Route::get('terminal/pay-order', 'HomeController@index')->middleware('auth', 'acl');
