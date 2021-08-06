<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories\CakeRepository;
use App\Http\Repositories\EmailCakeRepository;
use Illuminate\Http\Request;

class CakeController extends Controller
{

    protected $cakeRepository;

    protected $emailCakeRepository;

    public function __construct(
        CakeRepository $cakeRepository,
        EmailCakeRepository $emailCakeRepository
    ) {
        $this->cakeRepository = $cakeRepository;
        $this->emailCakeRepository = $emailCakeRepository;
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
        $data = $request->only('name', 'weight', 'price', 'quantity', 'list_emails');

        // Camada de Repository
        $cake = $this->cakeRepository->store($data);

        if (isset($data['list_emails'])) {
            array_map(
                function ($email) use ($cake) {
                    $data = [
                        'cake_id' => $cake->cake_id,
                        'email' => $email
                    ];

                    $this->emailCakeRepository->store($data);
                },
                $data['list_emails']
            );
        }

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
        $success = $this->cakeRepository->update($data, $id);
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
        $success = $this->cakeRepository->destroy($id);

        return response()->json($success);
    }
}
