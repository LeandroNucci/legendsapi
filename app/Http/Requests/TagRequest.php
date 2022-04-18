<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class TagRequest extends FormRequest
{
    private $fields;

    public function __construct(Request $request)
    {
        $this->fields = $request->all();
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "tag" => ["required", "string", 'regex:/^[\w]*$/', 'not_regex:/^(cm|gm|adm)$/i', "min:2", "max:4"],
        ];
    }

    /**
     * Tratar mensagens de erro de retorno
     */
    public function messages()
    {
        return [
            'regex' => '1',
            'required' => '2',
            'unique' => '3',
            'max' => 4,
            'min' => 5,
            'not_regex' => 6,
        ];
    }

     /**
     * Sobrescrita do método de validação
     */
    public function validateResolved()
    {
        parent::validateResolved();
        $this->replace($this->fields);
    }
}
