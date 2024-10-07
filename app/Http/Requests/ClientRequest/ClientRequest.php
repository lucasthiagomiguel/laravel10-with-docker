<?php

namespace App\Http\Requests\ClientRequest;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        
        $clientId = $this->route('client') ? $this->route('client') : $this->route('id');

        $rules = [
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'birth_date' => 'required|date',
            'address' => 'required|string',
            'complement' => 'nullable|string',
            'neighborhood' => 'required|string',
            'zip_code' => 'required|string',
        ];

        if ($this->isMethod('post')) {
            $rules['email'] = 'required|string|email|unique:clients,email';
        } elseif ($this->isMethod('put')) {
            $rules['email'] = 'required|string|email|unique:clients,email,' . $clientId;
        } elseif ($this->isMethod('patch')) {
             $rules['email'] = 'sometimes|required|string|email|unique:clients,email,' . $clientId;
             $rules['birth_date'] = 'sometimes|required|date';
             $rules['name'] = 'sometimes|required|string|max:255';
             $rules['phone'] = 'sometimes|required|string';
             $rules['address'] = 'sometimes|required|string';
             $rules['complement'] = 'sometimes|nullable|string';
             $rules['neighborhood'] = 'sometimes|required|string';
             $rules['zip_code'] = 'sometimes|required|string';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a string.',
            'name.max' => 'Name cannot exceed 255 characters.',
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.unique' => 'This email is already in use.',
            'phone.required' => 'Phone is required.',
            'phone.string' => 'Phone must be a string.',
            'birth_date.required' => 'Birth date is required.',
            'birth_date.date' => 'Birth date must be a valid date.',
            'address.required' => 'Address is required.',
            'address.string' => 'Address must be a string.',
            'complement.string' => 'Complement must be a string.',
            'neighborhood.required' => 'Neighborhood is required.',
            'neighborhood.string' => 'Neighborhood must be a string.',
            'zip_code.required' => 'ZIP code is required.',
            'zip_code.string' => 'ZIP code must be a string.',
        ];
    }
}
