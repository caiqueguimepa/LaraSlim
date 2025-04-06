<?php

namespace SkeletonProjectPHP\Http\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use SkeletonProjectPHP\DTOs\UserDTO;
use SkeletonProjectPHP\Http\Request\UserRequest;
use SkeletonProjectPHP\Services\UserServices;

class UserController
{
    public function __construct(

        private UserServices $userServices,
        private ContainerInterface $container,
    )
    {
    }

    public function index(Request $request,Response $response, array $args): MessageInterface|Response
    {
        $users = $this->userServices->all();

        $response->getBody()
            ->write(json_encode(['message' => 'Users retrieved successfully', 'users' => $users]));
        return $response->withHeader('Content-Type', 'application/json');
    }
    public function store(Request $request, Response $response, array $args)
    {

        $validator = UserRequest::validate(
            [
                'name' =>$request->getParsedBody()['name'] ?? null,
                'email' =>$request->getParsedBody()['email'] ?? null,
                'password' =>$request->getParsedBody()['password'] ?? null,
            ],
            $this->container->get('validator')
        );

        if ($validator->fails()) {
            $response->getBody()->write(json_encode([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ]));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(422);
        }

        $user = $this->userServices->store(new UserDTO(...$request->getParsedBody()));

        $response->getBody()->write(json_encode(['message' => 'User created successfully', 'user' => $user]));
        return $response->withHeader('Content-Type', 'application/json');
    }

}