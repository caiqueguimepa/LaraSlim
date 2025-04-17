<?php

declare(strict_types=1);

namespace LaraSlim\Karnel\Console;

class Model
{
    public static function create(string $modelName): void
    {
        if (empty($modelName)) {
            throw new \InvalidArgumentException('Model name must be provided');
        }

        $namespace = self::getNamespace($modelName);
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

    private static function getNamespace(string $modelName): string
    {
        $baseNamespace = 'SkeletonPhpApplication\\Models';

        if (str_contains($modelName, '/')) {
            $subPaths = explode('/', $modelName);
            array_pop($subPaths); // remove class name
            $subNamespace = implode('\\', array_map('ucfirst', $subPaths));

            return "namespace {$baseNamespace}\\{$subNamespace};";
        }

        return "namespace {$baseNamespace};";
    }

    private static function getClassName(string $modelName): string
    {
        $parts = explode('/', $modelName);
        $lastPart = end($parts);

        return ucfirst($lastPart);
    }

    private static function getTableName(string $className): string
    {
        // Converte o nome da classe para snake_case e pluraliza (opcional)
        // Aqui está simples: apenas camelCase (primeira letra minúscula)
        return lcfirst($className);
    }

    private static function getDirectoryPath(string $modelName): string
    {
        $basePath = __DIR__ . '/../../Models/';

        if (str_contains($modelName, '/')) {
            $subDirectory = dirname(str_replace('/', DIRECTORY_SEPARATOR, $modelName));

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

    private static function createModelFile(string $filePath, string $className, string $tableName, string $namespace): void
    {
        $content = <<<PHP
<?php

{$namespace}

use Illuminate\Database\Eloquent\Model;

class {$className} extends Model
{
    protected \$table = '{$tableName}';
    protected \$primaryKey = 'id';
    public \$timestamps = true;

    protected \$fillable = [
        // Add your fillable fields here
    ];

    // Add your model methods, relationships, etc. here
}

PHP;

        file_put_contents($filePath, $content);
        chmod($filePath, 0777);
    }
}
