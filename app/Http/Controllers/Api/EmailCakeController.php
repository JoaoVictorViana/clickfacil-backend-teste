<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories\EmailCakeRepository;
use Illuminate\Http\Request;

class EmailCakeController extends Controller
{
    protected $emailCakeRepository;

    public function __construct(EmailCakeRepository $emailCakeRepository)
    {
        $this->emailCakeRepository = $emailCakeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emailsCakes = $this->emailCakeRepository->all();

        return response()->json($emailsCakes);
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
        $data = $request->only('cake_id', 'email');
        // Camada de Repository
        $emailCake = $this->emailCakeRepository->store($data);
        // Camada de API Resource

        return response()->json($emailCake);
    }

    public function storeList(Request $request)
    {
        $data = $request->only('cake_id', 'list_emails');
        
        $success = $this->emailCakeRepository->storeList($data);
            
        return response()->json($success);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $emailCake = $this->emailCakeRepository->findById($id);

        return response()->json($emailCake);
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
        $data = $request->only('cake_id', 'email');
        // Camada de Repository
        $success = $this->emailCakeRepository->update($data, $id);
        // Camada de API Resource

        return response()->json($success);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $success = $this->emailCakeRepository->destroy($id);

        return response()->json($success);
    }
}
