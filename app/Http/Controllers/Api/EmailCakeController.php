<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories\EmailCakeRepository;
use App\Http\Resources\EmailCakeResource;
use Facades\App\Http\Validators\EmailCakeValidator;
use Exception;
use Illuminate\Http\Request;

class EmailCakeController extends Controller
{
    /**
     * Email Cake Repository.
     *
     * @var App\Http\Repositories\EmailCakeRepository $emailCakeRepository.
     */
    protected $emailCakeRepository;

    /**
     * Construct of EmailCakeController.
     *
     * @param  App\Http\Repositories\EmailCakeRepository  $emailCakeRepository
     */
    public function __construct(EmailCakeRepository $emailCakeRepository)
    {
        $this->emailCakeRepository = $emailCakeRepository;
    }

    /**
     * Display a listing of the emails.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $emailsCakes = $this->emailCakeRepository->all();

        return EmailCakeResource::collection($emailsCakes);
    }

    /**
     * Store a newly created email in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return App\Http\Resources\EmailCakeResource
     */
    public function store(Request $request)
    {
        $validator = EmailCakeValidator::store($request);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }

        $data = $request->only('cake_id_fk', 'email');

        $emailCake = $this->emailCakeRepository->store($data);

        return new EmailCakeResource($emailCake);
    }

    
    /**
     * Store a list of the emails in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return App\Http\Resources\EmailCakeResource
     */
    public function storeList(Request $request)
    {
        $validator = EmailCakeValidator::storeList($request);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }

        $data = $request->only('cake_id', 'list_emails');
        $status = 200;
        $payload = [
            'message' => 'E-mails cadastrados com sucesso!',
        ];

        try {
            $this->emailCakeRepository->storeList($data);
        } catch ( Exception $e ) {
            $status = 500;
            $payload['message'] = $e->getMessage();
        }

        return response()->json($payload, $status);
    }

    /**
     * Display the specified email.
     *
     * @param  int  $id
     * @return App\Http\Resources\EmailCakeResource
     */
    public function show(int $id)
    {
        $emailCake = $this->emailCakeRepository->findById($id);

        return new EmailCakeResource($emailCake);
    }

    /**
     * Update the specified email in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = EmailCakeValidator::update($request);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }

        $data = $request->only('cake_id_fk', 'email');
        $status = 200;
        $payload = [
            'message' => 'E-mail atualizado com sucesso!',
        ];

        try {
            $this->emailCakeRepository->update($data, $id);
        } catch ( Exception $e ) {
            $status = 500;
            $payload['message'] = $e->getMessage();
        }

        return response()->json($payload, $status);
    }

    /**
     * Remove the specified email from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $status = 200;
        $payload = [
            'message' => 'E-mail deletado com sucesso!',
        ];

        try {
            $this->emailCakeRepository->destroy($id);
        } catch ( Exception $e ) {
            $status = 500;
            $payload['message'] = $e->getMessage();
        }

        return response()->json($payload, $status);
    }
}
