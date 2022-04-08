<?php

namespace App\Http\Requests\Skins;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkinRequest extends FormRequest
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
            'character_id' => ['required', 'integer'],
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

        $this->replace($this->fields);
    }
}
