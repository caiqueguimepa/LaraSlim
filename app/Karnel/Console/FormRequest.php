<?php

namespace LaraSlim\Karnel\Console;

use Composer\Script\Event;
use Illuminate\Validation\Factory;

class FormRequest
{
    public static function create($event): void
    {
        $args = self::getArguments($event);

        if (empty($args[0])) {
            throw new \InvalidArgumentException('Model name must be provided');
        }

        $modelName = $args[0];
        $namespace = self::verifyContainsSubDirectory($args);
        $className = self::getClassName($modelName);
        $tableName = self::getTableName($className);
        $directoryPath = self::getDirectoryPath($modelName);
        $filePath = self::getFilePath($directoryPath, $className);

        if (file_exists($filePath)) {
            throw new \RuntimeException("Model {$className} already exists at {$filePath}");
        }

        self::ensureDirectoryExists($directoryPath);
        self::createModelFile($filePath, $className, $tableName, $namespace);

        echo "Model {$className} created successfully at {$filePath}\n";
    }

    private static function getTableName(string $className): string
    {
        // Converte para camelCase (primeira letra minúscula)
        return lcfirst($className);
    }

    private static function verifyContainsSubDirectory(array $args): string
    {
        $baseNamespace = 'SkeletonPhpApplication\Http\Requests';

        if (str_contains($args[0], '/')) {
            $subDirectory = explode('/', $args[0])[0];
            return "namespace {$baseNamespace}\\{$subDirectory};";
        }

        return "namespace {$baseNamespace};";
    }

    private static function getArguments($event): array
    {
        return $event instanceof Event ? $event->getArguments() : [$event];
    }

    private static function getClassName(string $modelName): string
    {
        $parts = explode('/', $modelName);
        $lastPart = end($parts);
        return ucfirst($lastPart);
    }

    private static function getDirectoryPath(string $modelName): string
    {
        $basePath = __DIR__ . '/../../Http/Request/';

        if (str_contains($modelName, '/')) {
            $subDirectory = explode('/', $modelName)[0];
            return $basePath . $subDirectory . '/';
        }

        return $basePath;
    }

    private static function getFilePath(string $directoryPath, string $className): string
    {
        return $directoryPath . $className . '.php';
    }

    private static function ensureDirectoryExists(string $directoryPath): void
    {
        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0755, true);
        }
    }

    private static function createModelFile(string $filePath, string $className, string $tableName, string $namespace): void
    {
        $content = <<<PHP
<?php

{$namespace}

use Illuminate\Validation\Factory;

class {$className}
{
    /**
     * Validate the incoming request data.
     *
     * @param array \$data The data to validate
     * @param Factory \$validator The validator factory
     * @return \Illuminate\Validation\Validator
     */
    public static function validate(array \$data, Factory \$validator)
    {
        \$rules = [
            // Define your validation rules here
            // Example: 'email' => 'required|email|unique:users',
            // 'name' => 'required|string|max:255',
        ];

        return \$validator->make(\$data, \$rules, self::messages());
    }

    /**
     * Get the validation error messages.
     *
     * @return array
     */
    public static function messages(): array
    {
        return [
            // Define your custom error messages here
            // Example: 'email.required' => 'The email field is required.',
            // 'name.required' => 'The name field is required.',
        ];
    }
}

PHP;

        file_put_contents($filePath, $content);
        chmod($filePath, 0777); // Permissões mais seguras
    }
}