<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LicensePlate extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'country_code',
        'region_code',
        'type_id',
        'color_id',
        'make_id',
        'model_id'
    ];

    public function process(array $plate)
    {
        $exists = $this->exists($plate);

        if ($exists) {
            if ($exists->make_id != $plate['make_id'] || $exists->model_id != $plate['model_id']) {
                $exists->invalid = 1;
                $exists->make_id = $plate['make_id'];
                $exists->model_id = $plate['model_id'];
                $exists->type_id = $plate['type_id'];
                $exists->color_id = $plate['color_id'];
                $exists->save();
            }

            return $exists;
        }

        return $this->create($plate);
    }

    public function exists(array $plate)
    {
        if (in_array($plate['country_code'], config('app.countries_need_state'))) {
            return $this->whereName($plate['name'])
                        ->whereCountryCode($plate['country_code'])
                        ->whereRegionCode($plate['region_code'])
                        ->first();
        } 

        return $this->whereName($plate['name'])->whereCountryCode($plate['country_code'])->first();        
    }
}
