<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
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

        $id    = $this->route("id");
        $rules = [
            "number" => "required|unique:books,number",
            "name"   => "required|unique:books,name",
        ];

        if($id){
            $rules["number"] = "required|unique:books,number,$id,_id";
            $rules["name"]   = "required|unique:books,name,$id,_id";
        }

        return $rules;
    }
}
