<?php

declare(strict_types=1);

namespace KrzysztofRewak\Larahat\Helpers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

trait SimpleRequesting
{
    protected Response $response;

    public function request(Request $request): void
    {
        $this->response = app()->handle($request);
        $this->response->send();
    }

    public function getResponseContent(): array
    {
        return json_decode($this->response->getContent(), true);
    }
}
