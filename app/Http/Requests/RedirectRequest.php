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

    protected function prepareForValidation(): void
    {
        $parseUrl = parse_url($this->get('url_redirect'));

        if (isset($parseUrl['query']) && !is_null($parseUrl['query'])) {
            $params = [];

            foreach (explode('&', $parseUrl['query']) as $param) {
                $param = explode('=', $param);

                $key = $param[0] ?? null;
                $value = $param[1] ?? null;

                $params[] = [
                    'key' => $key,
                    'value' => $value,
                ];
            }
        } else {
            $params = null;
        }

        $this->merge(['query_params' => $params]);
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
                'doesnt_start_with:' . config('app.url')
            ],
            'query_params' => [
                'nullable',
                'array',
            ],
            'query_params.*.key' => [
                'required',
            ],
            'query_params.*.value' => [
                'nullable',
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
            'url_redirect.doesnt_start_with' => 'URL de destino não pode apontar para a própria aplicação.',

            'query_params.array' => 'Os parametros da URL são inválidos.',
            'query_params.*.key.required' => 'As chaves dos parametros da URL são não pode ser vazio.',

            'status.required' => 'Status é obrigatório.',
            'status.in' => 'Status inválido.',
        ];
    }
}
