
<p align="center">
  <img src="https://i.postimg.cc/qq23mpW5/Chat-GPT-Image-14-de-abr-de-2025-08-09-53.png" alt="LaraSlim Logo" width="500px" />
</p>

<p align="center">
  <a href="https://packagist.org/packages/caiquebispo/laraslim"><img src="http://poser.pugx.org/caiquebispo/laraslim/v" alt="Latest Stable Version"></a>
  <a href="https://packagist.org/packages/caiquebispo/laraslim"><img src="http://poser.pugx.org/caiquebispo/laraslim/downloads" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/caiquebispo/laraslim"><img src="http://poser.pugx.org/caiquebispo/laraslim/v/unstable" alt="Latest Unstable Version"></a>
  <a href="https://packagist.org/packages/caiquebispo/laraslim"><img src="http://poser.pugx.org/caiquebispo/laraslim/license" alt="License"></a>
  <a href="https://packagist.org/packages/caiquebispo/laraslim"><img src="http://poser.pugx.org/caiquebispo/laraslim/require/php" alt="PHP Version Require"></a>
</p>

## Description

**LaraSlim** is a microframework for PHP that combines the lightness of the [Slim Framework](https://www.slimframework.com/) with a structure inspired by [Laravel](https://laravel.com/). It's ideal for creating clean, modular APIs with a lightweight and fast setup.

> **Note:** This project **does not include an authentication engine** by default. You can integrate your own or use third-party libraries.

It also doesn't include a template engine, but you can integrate it with Blade (Laravel) or any other engine of your choice.

> ⚠️ This is a **beta** project: some features may be under development and bugs may occur.

---

## Requirements

- PHP ^8.4
- Docker
- Composer
---

## Installation via Composer

```bash
composer create-project caiquebispo/laraslim example_app
```

---

## Manual Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/caiquebispo/LaraSlim.git
   cd LaraSlim
   ```

2. Build Docker containers:
   ```bash
   sh build
   ```

3. Start the Docker containers:
   ```bash
   sh up
   ```
4. Attach the Docker containers:
   ```bash
   sh attach
   ```
5. Down the Docker containers:
   ```bash
   sh down
   ```
6. Install dependencies:
   ```bash
   composer install
   ```
7. Copy the `.env` file:
   ```bash
   cp .env.exemple .env
   ```
8. Run tests and checks:
   ```bash
   composer test
   ```
---

## Application Access

- API: `http://localhost:8003`
- PHPMyAdmin: `http://localhost:8080`
    - **User:** `root`
    - **Password:** `root`

---

## Project Structure

- `app/Http/Controllers`: Application controllers.
- `app/Http/Request`: Form validation files.
- `app/Models`: Data models.
- `app/DTOs`: Data Transfer Objects.
- `app/Services`: Business logic layer.
- `app/Kernel`: Configuration and setup files.
- `database/migrations`: Database migration files.
- `public`: Web-accessible files (e.g., `index.php`).
- `composer.json`: Composer configuration.

---

## Database Configuration

Configure your `.env` file as needed. Example using SQLite:

```dotenv
DB_CONNECTION="sqlite"
DB_HOST=""
DB_DATABASE="../database/skeleton_db.sqlite"
DB_USERNAME=""
DB_PASSWORD=""
```

---

## Useful Commands

Create a new migration:
```bash
composer migration-create profiles
```

Create a new model:
```bash
composer model-create Profiles
```

Create a new controller:
```bash
composer controller-create ProfileController
composer controller-create Profiles/StoreController
```

Create a new form request:
```bash
composer request-create ProfileRequest
```

> Migrations are automatically executed when the container is started.

---

## Examples

### Route Group

```php
use Slim\Routing\RouteCollectorProxy;

$app->group('/api', function (RouteCollectorProxy $group) {
    $group->get('/users', 'UserController:index');
    $group->post('/users', 'UserController:store');
});
```

### Simple Route

```php
use LaraSlim\Controllers\HomeController;

$app->get('/', [HomeController::class, 'index']);
```

### Basic Controller

```php
<?php

namespace LaraSlim\Controllers;

class HomeController
{
    public function index()
    {
        // Controller logic here
    }
}
```

### Form Request

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
            //'email.required' => 'The email field is required.',
        ];
    }
}
```

### Using Form Request in Controller

```php
<?php

namespace LaraSlim\Http\Controllers;

use LaraSlim\DTOs\UserDTO;
use LaraSlim\Http\Request\UserRequest;
use LaraSlim\Karnel\Providers\Response;
use LaraSlim\Services\UserServices;

class UserController
{
    public function __construct(private UserServices $userServices) {}

    public function store(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
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

---

## Author

- **Caique Bispo**  
  📧 caiquebispodanet86@gmail.com

---

## License

This project is licensed under the terms of the [MIT License](LICENSE).
