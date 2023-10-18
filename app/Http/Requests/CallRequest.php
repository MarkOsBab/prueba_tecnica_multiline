<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CallRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'cliente_id' => 'Cliente',
            'llamada_telefono' => 'Teléfono',
            'llamada_observacion' => 'Observación',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cliente_id' => ['required', 'exists:'.env('CLIENT_TABLE_NAME').',cliente_id'],
            'llamada_telefono' => ['required', 'regex:/^(09[0-9]{7}|2[2-9][0-9]{6})$/'],
            'llamada_observacion' => ['required']
        ];
    }

    public function messages(): array
    {
        return [
            'cliente_id.required' => 'El :attribute es requerido.',
            'cliente_id.exists' => 'El :attribute no existe.',
            'llamada_telefono.required' => 'El :attribute es requerido.',
            'llamada_telefono.regex' => 'El campo :attribute tiene caracteres no válidos.',
            'llamada_observacion.required' => 'El :attribute es requerido',
            'llamada_observacion.regex' => 'El campo :attribute tiene caracteres no válidos.',
        ];
    }
}
