<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PostContentRequest extends Request
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
        
        if (!session()->has('video_filename') && !session()->has('photos') && empty($this->youtube_url) && empty($this->vidme_url) && empty($this->embed_type)) {
            $rules[$this->type] = 'required';
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
