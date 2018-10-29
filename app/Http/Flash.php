<?php

namespace App\Http;

class Flash
{
    private function create($title, $body, $type)
    {
        return session()->flash('flash_message', [
            'title' => $title,
            'body' => $body,
            'type' => $type
        ]);
    }

    public function message($title, $body)
    {
        return $this->create($title, $body, 'info');
    }

    public function success($title, $body)
    {
        return $this->create($title, $body, 'success');
    }

    public function error($title, $body)
    {
        return $this->create($title, $body, 'error');
    }
}