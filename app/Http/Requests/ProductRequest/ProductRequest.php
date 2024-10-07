<?php

namespace App\Http\Requests\ProductRequest;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
       // Getting the product ID if present in the route
        $productId = $this->route('product') ? $this->route('product') : $this->route('id');

        $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
               // Check if it is POST or PUT/PATCH
                $this->isMethod('post') ? 'unique:products,name' : 'unique:products,name,' . $productId
            ],
        ];

        if ($this->isMethod('post')) {
            // Specific validations for the POST method (creation)
            $rules['price'] = 'required|numeric';
            $rules['photo'] = 'required|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        } elseif ($this->isMethod('put')) {
            // Specific validations for the PUT method (full update)
            $rules['price'] = 'required|numeric';
            $rules['photo'] = 'required|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        } elseif ($this->isMethod('patch')) {
            // Validations for PATCH (partial update)
            $rules['price'] = 'sometimes|required|numeric';
            $rules['photo'] = 'sometimes|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required.',
            'name.alpha' => 'Name must contain only letters.',
            'name.unique' => 'Name already exists.',
            'price.required' => 'Price is required.',
            'price.numeric' => 'Price must be a number.',
            'photo.required' => 'Photo is required.',
            'photo.photo' => 'File must be a photo.',
            'photo.mimes' => 'Photo must be in the following formats: jpeg, png, jpg, gif or svg.',
            'photo.max' => 'Maximum size allowed for photo is 2MB.'
        ];
    }
}
