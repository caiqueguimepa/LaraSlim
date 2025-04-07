# LaraSlim

## Descrição

LaraSlim é um framework PHP que combina a simplicidade do Slim Framework com a robustez do Laravel. Ele é projetado para ser leve e fácil de usar, permitindo que você construa aplicações web rapidamente.

## Requisitos

- Vesao do PHP 8.4
- Docker
- Composer

## Instalação

1. Clone o repositório:
    ```sh
    git clone https://github.com/caiquebispo/LaraSlim.git
    cd LaraSlim
    ```

2. Subindo container:
    ```sh
    docker compose up --build -d
    ```

3. Entrando no contêiner:
    ```sh
    docker exec -it LaraSlim_app bash
    ```

4. Instale as dependências:
    ```sh
    composer install
    ```

5. Configure o arquivo `.env`:
    ```sh
    cp .env.exemple .env
    ```
Aplicação está rodando na porta 8001
`http://localhost:8003`

PHPMyAdmin está rodando na porta 8080
`http://localhost:8080`
user: root
password: root


## Estrutura do Projeto

- `app/Http/Controllers`: Contém os controladores da aplicação.
- `app/Http/Request`: Contém os arquivos de from validation.
- `app/Models`: Contém os modelos da aplicação.
- `app/DTOs`: Contém os DTOs da aplicação.'
- `app/Services`: Contém os serviços da aplicação.
- `app/Kernel`: Contém o arquivo de configuração.
- `database/migrations`: Contém os arquivos de migração do banco de dados.
- `public`: Contém os arquivos públicos acessíveis via web (ex: index.php).
- `composer.json`: Arquivo de configuração do Composer.

## Configuração do Banco de Dados

O arquivo `.env` deve ser configurado com as informações do banco de dados. Exemplo para SQLite:

```dotenv
DB_CONNECTION="sqlite"
DB_HOST=""
DB_DATABASE="../database/skeleton_db.sqlite"
DB_USERNAME=""
DB_PASSWORD=""
```

## Uso

### Comandos
Para criar uma nova migração, utilize o comando:

```sh
composer migration-create profiles
```
Para criar um novo model, utilize o comando:

```sh
composer model-create Profiles
```

Para criar um novo controler, utilize o comando:

```sh
composer controller-create ProfileCodntroller
composer controller-create Profiles/StoreController
```
Para criar um novo from validation, utilize o comando:

```sh
composer request-create ProfileRequest
```
### Executar Migrações

As migrations são executadas automaticamente ao iniciar o contêiner:

### Exemplo de Grupo de Rotas

```php

use Slim\Routing\RouteCollectorProxy;

$app->group('/api', function (RouteCollectorProxy $group) {
    $group->get('/users', 'UserController:index');
    $group->post('/users', 'UserController:store');
});
```
### Exemplo de Rotas

```php

use Slim\Routing\RouteCollectorProxy;
use LaraSlim\Controllers\HomeController; 

$app->get('/', [HomeController::class, 'index']);

```

### Exemplo de Controlador

```php
<?php

namespace LaraSlim\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    public function index()
    {
        // Lógica do controlador
    }
}
```
### Exemplo de Form Request

```php

<?php
namespace LaraSlim\Http\Request;

use Illuminate\Validation\Factory;

class UserRequest
{
    public static function validate(array $data, Factory $validator)
    {
        $rules = [
           //'email' => 'required|email',
        ];

        return $validator->make($data, $rules, self::messages());
    }
    public static function messages(): array
    {
        return [
          //'email.unique' => 'O email já está em uso.',
        ];
    }
}

```

### Exemplo de useo do Form Request no Controlador

```php
<?php

namespace LaraSlim\Http\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use LaraSlim\DTOs\UserDTO;
use LaraSlim\Http\Request\UserRequest;
use LaraSlim\Services\UserServices;

class UserController
{
    public function __construct(
        // Fazendo a injeção de dependência do UserServices
        private UserServices $userServices,
        // Fazendo a injeção de dependência do ContainerInterface
        private ContainerInterface $container,
    )
    {}
  
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
```
## Autores

- Caique Bispo (caiquebispodanet86@gmail.com)

## Licença

MIT License

Copyright (c) 2025 Caique Bispo

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

