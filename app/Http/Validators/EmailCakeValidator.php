<?php

namespace App\Http\Validators;

use Illuminate\Contracts\Validation\Validator as IValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmailCakeValidator
{
    protected $messages = [
        'required' => 'The :attribute field is required.',
        'string' => 'The :attribute field is not string.',
        'numeric' => 'The :attribute field is not numeric.',
    ];

    public function store(Request $request): IValidator
    {
        return Validator::make(
            $request->all(),
            [
                'cake_id' => 'required|numeric',
                'email' => 'required|string',
            ],
            $this->messages
        );
    }

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

    public function update(Request $request): IValidator
    {
        return Validator::make(
            $request->all(),
            [
                'cake_id' => 'numeric',
                'email' => 'string',
            ],
            $this->messages
        );
    }
}
