<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AdminEditContentRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {   
        $user = $this->user();

        if ($user->can('manage_content')) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'id' => 'required|exists:contents',
            'user_id' => 'required|exists:users,id',
            'type' => 'required|in:photo,video',
            'start_in_seconds' => 'integer',
            'youtube_url' => 'required_if:embed_type,youtube|youtube',
            'vidme_url' => 'required_if:embed_type,vidme|vidme',
            'embed_type' => 'in:youtube,vidme',
            'country_code' => 'required:exists:countries,code',
            'city_id' => 'exists:cities,id',
            'region_code' => 'exists:regions,code',
            'offence_date' => 'date',
            'offence_time' => 'date_format:H:i:s',
            'licenses.*.country_code' => 'required_with:licenses.*.name|exists:countries,code',
            'licenses.*.region_code' => 'required_if:licenses.*.country_code,AU,CA,US|exists:regions,code'
        ];

        foreach ($this->titles as $key => $title) {
            if ($key == 'en') {
                $rules['titles.'.$key] = 'required';
            }
        }        

        return $rules;
    }

    public function messages()
    {
        $messages = [];

        $messages['licenses.*.region_code.required_if'] = 'Please select a state for the license.';

        return $messages;
    }
}
