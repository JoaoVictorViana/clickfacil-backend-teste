<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories\CakeRepository;
use App\Http\Repositories\EmailCakeRepository;
use App\Http\Resources\CakeResource;
use Facades\App\Http\Validators\CakeValidator;
use Exception;
use Illuminate\Http\Request;

class CakeController extends Controller
{
    /**
     * Cake Repository.
     *
     * @var App\Http\Repositories\CakeRepository $cakeRepository.
     */
    protected $cakeRepository;

    /**
     * Email Cake Repository.
     *
     * @var App\Http\Repositories\EmailCakeRepository $emailCakeRepository.
     */
    protected $emailCakeRepository;

    /**
     * Construct of CakeController.
     *
     * @param  App\Http\Repositories\CakeRepository  $cakeRepository
     * @param  App\Http\Repositories\EmailCakeRepository  $emailCakeRepository
     */
    public function __construct(
        CakeRepository $cakeRepository,
        EmailCakeRepository $emailCakeRepository
    ) {
        $this->cakeRepository = $cakeRepository;
        $this->emailCakeRepository = $emailCakeRepository;
    }

    /**
     * Display a listing of the cakes.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $cakes = $this->cakeRepository->all();

        return CakeResource::collection($cakes);
    }

    /**
     * Store a newly created cake in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return App\Http\Resources\CakeResource
     */
    public function store(Request $request)
    {
        $validator = CakeValidator::store($request);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }

        $data = $request->only('name', 'weight', 'price', 'quantity');

        $cake = $this->cakeRepository->store($data);

        if (isset($request->list_emails)) {
            $this->emailCakeRepository->storeList(
                [
                    'cake_id' => $cake->cake_id,
                    'list_emails' => $request->list_emails
                ]
            );
        }

        return new CakeResource($cake);
    }

    /**
     * Display the specified cake.
     *
     * @param  int  $id
     * @return App\Http\Resources\CakeResource
     */
    public function show(int $id)
    {
        $cake = $this->cakeRepository->findById($id);

        return new CakeResource($cake);
    }

    /**
     * Update the specified cake in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $validator = CakeValidator::update($request);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }

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
     * Remove the specified cake from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
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
