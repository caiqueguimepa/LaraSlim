<?php

declare(strict_types=1);

namespace LaraSlim\Karnel\Console;

class FormRequest
{
    public static function create(string $requestName): void
    {
        if (empty($requestName)) {
            throw new \InvalidArgumentException('Request name must be provided');
        }

        $namespace = self::generateNamespace($requestName);
        $className = self::extractClassName($requestName);
        $directoryPath = self::generateDirectoryPath($requestName);
        $filePath = self::generateFilePath($directoryPath, $className);

        if (file_exists($filePath)) {
            throw new \RuntimeException("Request {$className} already exists at {$filePath}");
        }

        self::ensureDirectoryExists($directoryPath);
        self::generateRequestFile($filePath, $className, $namespace);

        echo "FormRequest {$className} created successfully at {$filePath}\n";
    }

    private static function generateNamespace(string $requestName): string
    {
        $baseNamespace = 'SkeletonPhpApplication\Http\Requests';

        if (str_contains($requestName, '/')) {
            $subDirectory = explode('/', $requestName)[0];
            return "namespace {$baseNamespace}\\{$subDirectory};";
        }

        return "namespace {$baseNamespace};";
    }

    private static function extractClassName(string $requestName): string
    {
        $parts = explode('/', $requestName);
        return ucfirst(end($parts));
    }

    private static function generateDirectoryPath(string $requestName): string
    {
        $basePath = __DIR__ . '/../../Http/Request/';

        if (str_contains($requestName, '/')) {
            $subDirectory = explode('/', $requestName)[0];
            return $basePath . $subDirectory . '/';
        }

        return $basePath;
    }

    private static function generateFilePath(string $directoryPath, string $className): string
    {
        return $directoryPath . $className . '.php';
    }

    private static function ensureDirectoryExists(string $directoryPath): void
    {
        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0755, true);
        }
    }

    private static function generateRequestFile(string $filePath, string $className, string $namespace): void
    {
        $content = <<<PHP
<?php

{$namespace}

class {$className} extends BaseRequest
{
    protected function rules(): array
    {
        return [
            // 'field' => 'required|string|max:255',
        ];
    }

    protected function messages(): array
    {
        return [
            // 'field.required' => 'Este campo é obrigatório.',
        ];
    }
}

PHP;

        file_put_contents($filePath, $content);
        chmod($filePath, 0644); // Permissões seguras para leitura e escrita
    }
}
