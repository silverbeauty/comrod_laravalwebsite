<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Http\Request;
use Illuminate\Support\ViewErrorBag;
use Exception;
use DateTime;


abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Validate the given request with the given rules.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $customAttributes
     * @return void
     *
     * @throws \Illuminate\Http\Exception\HttpResponseException
     */
    public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = [])
    {
        
    	$validator = $this->getValidationFactory()->make($request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
	    	$errors = $validator->errors();
	        if ($errors->has()) {
	            try {
	                $result = array_merge($errors->all(), [
	                    'ip' => $request->ip(),
	                    'url' => $request->url(),
                    	'method' => $request->method(),
	                    'date' => new DateTime
	                ]);
	                $message = json_encode($result);
	                errorLog()->set($message);
	            } catch (Exception $exception) {
	                errorLog()->set($exception->getMessage());
	            }
	        }
            $this->throwValidationException($request, $validator);
        }
    }
}
