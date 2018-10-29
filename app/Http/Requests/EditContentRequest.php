<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EditContentRequest extends Request
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
        $rules = [
            'id' => 'required|exists:contents',
            'type' => 'required|in:photo,video',
            'start_in_seconds' => 'integer',
            'title' => 'required',
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

        return $rules;
    }

    public function messages()
    {
        $messages = [];

        $messages['licenses.*.region_code.required_if'] = 'Please select a state for the license.';

        return $messages;
    }
}
