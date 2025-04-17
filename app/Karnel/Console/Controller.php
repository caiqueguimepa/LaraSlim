<?php

declare(strict_types=1);

namespace LaraSlim\Karnel\Console;

class Controller
{
    public static function create(string $controllerName): void
    {
        if (empty($controllerName)) {
            throw new \InvalidArgumentException('Controller name must be provided');
        }

        $namespace = self::getNamespace($controllerName);
        $className = self::getClassName($controllerName);
        $directoryPath = self::getDirectoryPath($controllerName);
        $filePath = self::getFilePath($directoryPath, $className);

        if (file_exists($filePath)) {
            throw new \RuntimeException("Controller {$className} already exists at {$filePath}");
        }

        self::ensureDirectoryExists($directoryPath);
        self::createControllerFile($filePath, $className, $namespace);

        echo "Controller {$className} created successfully at {$filePath}\n";
    }

    private static function getNamespace(string $controllerName): string
    {
        $baseNamespace = 'LaraSlim\\Controllers';

        if (str_contains($controllerName, '/')) {
            $subPaths = explode('/', $controllerName);
            array_pop($subPaths); // remove class name
            $subNamespace = implode('\\', array_map('ucfirst', $subPaths));

            return "namespace {$baseNamespace}\\{$subNamespace};";
        }

        return "namespace {$baseNamespace};";
    }

    private static function getClassName(string $controllerName): string
    {
        $parts = explode('/', $controllerName);
        $lastPart = end($parts);

        return ucfirst($lastPart) . 'Controller';
    }

    private static function getDirectoryPath(string $controllerName): string
    {
        $basePath = __DIR__ . '/../../Http/Controllers/';

        if (str_contains($controllerName, '/')) {
            $subDirectory = dirname(str_replace('/', DIRECTORY_SEPARATOR, $controllerName));

            return rtrim($basePath . $subDirectory, '/') . '/';
        }

        return $basePath;
    }

    private static function getFilePath(string $directoryPath, string $className): string
    {
        return $directoryPath . $className . '.php';
    }

    private static function ensureDirectoryExists(string $directoryPath): void
    {
        if (!is_dir($directoryPath)) {
            mkdir($directoryPath, 0755, true);
        }
    }

    private static function createControllerFile(string $filePath, string $className, string $namespace): void
    {
        $content = <<<PHP
<?php

{$namespace}
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class {$className}
{
    public function __construct()
    {
        // Controller initialization
    }

    // Add your controller methods here
}

PHP;

        file_put_contents($filePath, $content);
        chmod($filePath, 0777);
    }
}
