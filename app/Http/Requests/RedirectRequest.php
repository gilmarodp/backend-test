<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RedirectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'url_redirect' => [
                'required',
                'url',
                'starts_with:https',
                'not_in:' . config('app.url')
            ],
            'status' => [
                $this->method() === 'PUT' ? 'required' : 'nullable',
                'in:1,0',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'url_redirect.required' => 'URL de destino é obrigatório.',
            'url_redirect.url' => 'URL de destino inválida.',
            'url_redirect.starts_with' => 'URL de destino deve começar com "https".',
            'url_redirect.not_in' => 'URL de destino não pode apontar para a própria aplicação.',

            'status.required' => 'Status é obrigatório.',
            'status.in' => 'Status inválido.',
        ];
    }
}
