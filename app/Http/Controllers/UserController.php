<?php

namespace LaraSlim\Http\Controllers;

use LaraSlim\DTOs\UserDTO;
use LaraSlim\Http\Request\UserRequest;
use LaraSlim\Karnel\Providers\Response;
use LaraSlim\Services\UserServices;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserController
{
    public function __construct(
        private UserServices $userServices,
    ) {
    }

    public function index(ServerRequestInterface $request, ResponseInterface $response, mixed $args): ResponseInterface
    {
        return (new Response($response))->json([
            'status' => 'success',
            'message' => 'User list retrieved successfully',
            'users' => $this->userServices->all(),
        ]);
    }

    public function store(ServerRequestInterface $request, ResponseInterface $response, mixed $args): ResponseInterface
    {

        $validator = (new UserRequest($request->getParsedBody()))->validate();

        if ($validator->fails()) {

            return (new Response($response))->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);

        }

        $user = $this->userServices->store(new UserDTO(...$request->getParsedBody()));

        return (new Response($response))->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
        ], 201);
    }

    public function show(ServerRequestInterface $request, ResponseInterface $response, mixed $args): ResponseInterface
    {
        $user = $this->userServices->find($args['id']);

        if (!$user) {
            return (new Response($response))->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }

        return (new Response($response))->json([
            'status' => 'success',
            'message' => 'User retrieved successfully',
            'user' => $user,
        ]);
    }

    public function update(ServerRequestInterface $request, ResponseInterface $response, mixed $args): ResponseInterface
    {
        $validator = (new UserRequest($request->getParsedBody()))->validate();

        if ($validator->fails()) {

            return (new Response($response))->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = $this->userServices->update($args['id'], (new UserDTO(...$request->getParsedBody()))->withoutPassword());

        if (!$user) {
            return (new Response($response))->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }

        return (new Response($response))->json([
            'status' => 'success',
            'message' => 'User updated successfully',
            'user' => $user,
        ]);
    }

    public function delete(ServerRequestInterface $request, ResponseInterface $response, mixed $args): ResponseInterface
    {
        $user = $this->userServices->delete($args['id']);

        if (!$user) {
            return (new Response($response))->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }

        return (new Response($response))->json([
            'status' => 'success',
            'message' => 'User deleted successfully',
        ]);
    }
}
