<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\ViewErrorBag;
use Illuminate\Http\JsonResponse;
use Exception;
use DateTime;

abstract class Request extends FormRequest
{
    /**
     * Get the proper failed validation response for the request.
     *
     * @param  array  $errors
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
		if (!empty($errors)) {
            try {
                $result = array_merge($errors, [
                    'ip' => $this->ip(),
                    'url' => $this->url(),
                    'method' => $this->method(),
                    'date' => new DateTime
                ]);
                $message = json_encode($result);
                errorLog()->set($message);
            } catch (Exception $exception) {
                errorLog()->set($exception->getMessage());
            }
        }
        if ($this->ajax() || $this->wantsJson()) {
            return new JsonResponse($errors, 400);
        }
        return $this->redirector->to($this->getRedirectUrl())
                                        ->withInput($this->except($this->dontFlash))
                                        ->withErrors($errors, $this->errorBag);
    }
}
