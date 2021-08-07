<?php

namespace App\Http\Validators;

use Illuminate\Contracts\Validation\Validator as IValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CakeValidator
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
                'name' => 'required|string',
                'weight' => 'required|numeric',
                'price' => 'required|numeric',
                'quantity' => 'required|numeric',
            ],
            $this->messages
        );
    }

    public function update(Request $request): IValidator
    {
        return Validator::make(
            $request->all(),
            [
                'name' => 'string',
                'weight' => 'numeric',
                'price' => 'numeric',
                'quantity' => 'numeric',
            ],
            $this->messages
        );
    }
}
