<?php

namespace App\Http\Requests\Posts;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\File;

class PostRequest extends FormRequest
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
        return [
            'body' => [
                'string',
                function ($attribute, $value, $fail) {
                    $decodedBody = html_entity_decode($value);
                    $plainText = strip_tags($decodedBody);

                    if (strlen(trim($plainText)) < 5 && empty($this->attachments)) {
                        $fail('The content field must be more than 5 charachters.');
                    }
                    
                    if (preg_match('/<script\b[^>]*>(.*?)<\/script>/is', $decodedBody) || 
                        preg_match('/on\w+="[^"]*"/i', $decodedBody)) {
                        $fail('The content contains forbidden script elements.');
                    }
                },
            ],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => [File::types(['mp3'])],
        ];
    }

    public function messages()
    {
        return [
            // 'attachments.*.mimes' => 'Each attachment must be an MP3 file.',
        ];
    }

    public function attributes()
    {
        return [
            'body' => 'content',
            'attachments' => 'attachments',
            'attachments.*' => 'Attachment',
        ];
    }
}
