<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories\CakeRepository;
use App\Http\Repositories\EmailCakeRepository;
use App\Http\Resources\CakeResource;
use Exception;
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

        return CakeResource::collection($cakes);
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

        $data = $request->only('name', 'weight', 'price', 'quantity', 'list_emails');

        $cake = $this->cakeRepository->store($data);

        if (isset($data['list_emails'])) {
            $this->emailCakeRepository->storeList(
                [
                    'cake_id' => $cake->cake_id,
                    'list_emails' => $data['list_emails']
                ]
            );
        }

        return new CakeRepository($cake);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $cake = $this->cakeRepository->findById($id);

        return new CakeResource($cake);
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
        $status = 200;
        $payload = [
            'message' => 'Bolo atualizado com sucesso!',
        ];

        try {
            $this->cakeRepository->update($data, $id);
        } catch ( Exception $e ) {
            $status = 500;
            $payload['message'] = $e->getMessage();
        }

        return response()->json($payload, $status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = 200;
        $payload = [
            'message' => 'Bolo deletado com sucesso!',
        ];

        try {
            $this->cakeRepository->destroy($id);
        } catch ( Exception $e ) {
            $status = 500;
            $payload['message'] = $e->getMessage();
        }

        return response()->json($payload, $status);
    }
}
