<?php

namespace LaraSlim\Kernel\Providers;

use Psr\Http\Message\ResponseInterface;

class Response
{
    /**
     * @var array<mixed,mixed>
     */
    private array $data = [];

    private int $status = 200;

    public function __construct(
        private ResponseInterface $response
    ) {
    }

    public function json(mixed $data, int $status = 200): ResponseInterface
    {
        $this->data = $data;
        $this->status = $status;

        return $this->send($this->response);
    }

    private function send(ResponseInterface $response): ResponseInterface
    {
        $response->getBody()->write(json_encode($this->data));

        return $response->withStatus($this->status)
            ->withHeader('Content-Type', 'application/json');
    }
}
