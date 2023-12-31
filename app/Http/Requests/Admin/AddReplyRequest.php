<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddReplyRequest extends FormRequest
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
        return [
            'comment_text'    => 'required|string|min:5',
            'attachments' => $this->hasFile('attachments') ? 'array|max:5' : '',
            'attachments.*' => $this->hasFile('attachments') ? 'max:5120' : '',
        ];
    }

    public function attributes()
    {
        return [
            'comment_text' => 'reply'
        ];
    }
}
