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
        /*if(!Auth::check()){
            return false;
        }*/

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            "token_google" => ['required', "string", "max:100", "min:6"],
            "nickname" => ["nullable", "string", 'regex:/^[\w]*$/', "min:3", "max:16", "unique:users,nickname"],
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
            'max' => '4',
            'min' => '5',
        ];
    }    
    
    /**
     * Sobrescrita do método de validação
     */
    public function validateResolved()
    {
        parent::validateResolved();
        
        $this->fields['enable'] = 1;
        //$this->fields["token_google"] = $this->fields["token_google"];
        //$this->fields["nickname"] = $this->fields["nickname"] ?? null;

    //    $this->fields['jokenpo'] = 'joooookenpo!';
        //$this->inputs["nick"] = $this->inputs["nickname"] ?? null;

        $this->replace($this->fields);
    }
}
