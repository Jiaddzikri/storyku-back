<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class StoreStoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        Log::info($this->all());
        return [
            "title" => "required|max:100",
            "author" => "required|max:100",
            "synopsis" => "required",
            "status" => "required",
            "category" => "required",
            "keywords" => "json|required",
            "cover_image" => "required|max:4096",
            "chapters" => "array"
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator) 
    {
        throw new HttpResponseException(response([
            "message" => $validator->getMessageBag()
        ], 400));
    }
}
