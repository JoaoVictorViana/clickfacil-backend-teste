<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories\CakeRepository;
use Illuminate\Http\Request;
use App\Models\Cake;

class ApiController extends Controller
{

    protected $cakeRepository;

    public function __construct(CakeRepository $cakeRepository)
    {
        $this->cakeRepository = $cakeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cakes = $this->cakeRepository->all();

        return response()->json($cakes);
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
        $data = $request->only('name', 'weight', 'price', 'quantity');
        // Camada de Repository
        $cake = $this->cakeRepository->store($data);
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
        $cake = $this->cakeRepository->findById($id);

        return response()->json($cake);
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
        $data = $request->only('name', 'weight', 'price', 'quantity');
        // Camada de Repository
        $cake = $this->cakeRepository->update($data, $id);
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
        $cake = $this->cakeRepository->destroy($id);

        return response()->json($cake);
    }
}
