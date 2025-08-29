<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\SecurityService;

class TextTransformationRequest extends FormRequest
{
    protected SecurityService $securityService;
    
    public function __construct()
    {
        parent::__construct();
        $this->securityService = app(SecurityService::class);
    }
    
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (!$this->securityService->checkRateLimit()) {
            abort(429, 'Too many requests. Please try again later.');
        }
        
        if (!$this->securityService->validateOrigin()) {
            abort(403, 'Invalid request origin.');
        }
        
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'text' => 'required|string|max:50000',
            'format' => 'required|string|max:100|regex:/^[a-z\-]+$/',
            'options' => 'nullable|array|max:10',
            'options.*' => 'string|max:100'
        ];
    }
    
    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'text.required' => 'Please provide text to transform.',
            'text.max' => 'Text cannot exceed 50,000 characters.',
            'format.required' => 'Please select a transformation format.',
            'format.regex' => 'Invalid format selected.',
            'options.array' => 'Invalid options provided.',
        ];
    }
    
    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $text = $this->input('text', '');
        
        if ($this->securityService->checkSQLInjection($text)) {
            abort(400, 'Invalid input detected.');
        }
        
        if ($this->securityService->checkCommandInjection($text)) {
            abort(400, 'Invalid input detected.');
        }
        
        $this->merge([
            'text' => $this->securityService->sanitize($text, 'text'),
            'format' => $this->securityService->sanitize($this->input('format', ''), 'alphanumeric')
        ]);
    }
    
    /**
     * Handle a passed validation attempt.
     */
    protected function passedValidation(): void
    {
        $this->securityService->logSecurityEvent('Text transformation request validated', [
            'format' => $this->input('format'),
            'text_length' => strlen($this->input('text'))
        ]);
    }
}