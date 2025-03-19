<?php

namespace App\Http\Requests\Posts;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
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
                function ($attribute, $value, $fail) {
                    $decodedBody = html_entity_decode($value);
                    $plainText = strip_tags($decodedBody);

                    if (strlen(trim($plainText)) < 5 && empty($this->attachments)) {
                        $fail('The content field must be more than 5 charachters.');
                    }

                    if (strlen($plainText) > 300) {
                        $fail('The content field must not be longer than 1000 charachters.');
                    }

                    if (!is_string($plainText)) {
                        $fail('The content field must be a string.');
                    }
                    
                    if (preg_match('/<script\b[^>]*>(.*?)<\/script>/is', $decodedBody) || 
                        preg_match('/on\w+="[^"]*"/i', $decodedBody)) {
                        $fail('The content contains forbidden script elements.');
                    }
                },
            ],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => [
                function ($attribute, $value, $fail) {
                    if ($value instanceof UploadedFile) {
                        $maxSize = in_array($value->getClientOriginalExtension(), ['mp4']) ? 100 * 1024 : 10 * 1024; // 200MB for videos, 10MB for images
                        if ($value->getSize() / 1024 > $maxSize) {
                            $fail("The Attachment must not be larger than " . ($maxSize / 1024) . "MB.");
                        }
                    }
                },
                File::types(['mp4', 'jpg', 'png', 'jpeg', 'gif', 'avif', 'webp'])
            ],
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
