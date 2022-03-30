<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class LoginRequest extends FormRequest
{
    private $fields;

    public function __construct(Request $request)
    {
        $this->fields = $request->all();
    }

    /**
     * Determine if the user is authorized to make this request.     
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            "token_google" => ["required", "string", "max:100", "min:6"],
            //"senha" => ["required", "string", "min:4", "max:60"],
        ];
    }

    /**
     * Tratar mensagens de erro de retorno
     */
    public function messages()
    {
        return [
            
        ];
    }

    /**
     * Sobrescrita do método de validação
     */
    public function validateResolved()
    {
        parent::validateResolved();
        
    //    $this->fields['jokenpo'] = 'joooookenpo!';

        $this->replace($this->fields);
    }
}
