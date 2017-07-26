<?php

namespace App\Http\Controllers\Sucursal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//Models
use App\Models\Sucursal;

class SucursalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         //Obtenemos las sucursales existentes
        $success = false;
        $msg = '';

        try{

            $sucursales = Sucursal::select('id', 'branch_office_name')->get();

            if ( count($sucursales) > 0) {
               $success = true;
               $msg = 'Lista de sucursales';
            }else {
              $msg = 'No hay sucursales existentes';
            }

        }catch (\Exception $e) {
            $msg = 'ERROR: ' .$e->getMessage();
        }

        return compact('msg', 'sucursales');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
