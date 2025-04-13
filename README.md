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

5. Rodando pestphp e phpstan:
    ```sh
    composer test
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

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomeController
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

class UserRequest extends BaseRequest
{
    protected function rules(): array
    {
        return [
            //'name' => 'required|string|max:255',
        ];
    }

    protected function messages(): array
    {
        return [
            //'email.required' => 'O campo email é obrigatório.',
        ];
    }
}

```

### Exemplo de useo do Form Request no Controlador

```php
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
    )
    {}
  
     public function store(ServerRequestInterface $request, ResponseInterface $response, mixed $args): ResponseInterface
    {

        $validator = (new UserRequest($request->getParsedBody()))->validate();

        if ($validator->fails()) {

           return (new Response($response))->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);

        }

        $user = $this->userServices->store(new UserDTO(...$request->getParsedBody()));

        return (new Response($response))->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user
        ], 201);
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

