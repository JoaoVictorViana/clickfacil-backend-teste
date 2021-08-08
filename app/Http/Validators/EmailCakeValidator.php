<?php

namespace App\Http\Validators;

use Illuminate\Contracts\Validation\Validator as IValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmailCakeValidator
{
    /**
     * Message list.
     *
     * @var array $messages.
     */
    protected $messages = [
        'required' => 'The :attribute field is required.',
        'string' => 'The :attribute field is not string.',
        'numeric' => 'The :attribute field is not numeric.',
    ];

    /**
     * Validate request data before store a email in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function store(Request $request): IValidator
    {
        return Validator::make(
            $request->all(),
            [
                'cake_id_fk' => 'required|numeric',
                'email' => 'required|string',
            ],
            $this->messages
        );
    }

    /**
     * Validate request data before store a email list in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function storeList(Request $request): IValidator
    {
        return Validator::make(
            $request->all(),
            [
                'cake_id' => 'required|numeric',
                'list_emails' => 'required|array',
            ],
            $this->messages
        );
    }

    /**
     * Validate request data before update a email in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function update(Request $request): IValidator
    {
        return Validator::make(
            $request->all(),
            [
                'cake_id_fk' => 'numeric',
                'email' => 'string',
            ],
            $this->messages
        );
    }
}
