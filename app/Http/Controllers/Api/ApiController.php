<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cake;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Cake::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Camada de validator

        // Camada de segurança
        $datas = $request->only('name', 'weight', 'price', 'quantity');
        // Camada de Repository
        $cake = Cake::create($datas);
        // Camada de API Resource

        return response()->json($cake);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cake = Cake::find($id);

        return response()->json();
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
        $datas = $request->only('name', 'weight', 'price', 'quantity');
        // Camada de Repository
        $cake = Cake::where('cake_id', $id)->update(
            $datas
        );
        // Camada de API Resource

        return response()->json($cake);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cake = Cake::destroy('cake_id', $id);

        return response()->json($cake);
    }
}
