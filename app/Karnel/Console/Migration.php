<?php

declare(strict_types=1);

namespace LaraSlim\Karnel\Console;

class Migration
{
    public static function create(string $migrationName): void
    {
        if (empty($migrationName)) {
            echo "Erro: Nome da migration não informado.\n";
            return;
        }

        $filename = self::generateMigrationFilename($migrationName);
        $template = self::generateMigrationTemplate($migrationName);

        file_put_contents($filename, $template);
        chmod($filename, 0777);

        echo "Migration criada: {$filename}\n";
    }

    public static function loadMigrationFiles(): void
    {
        foreach (glob(__DIR__ . '/../../../database/migrations/*.php') as $file) {
            require_once $file;
        }
    }

    private static function generateMigrationFilename(string $migrationName): string
    {
        $timestamp = date('Y_m_d_His');
        $directory = __DIR__ . '/../../../database/migrations/';

        // Sanitiza para evitar caracteres inválidos
        $fileSafeName = preg_replace('/[^a-zA-Z0-9_]/', '_', $migrationName);

        return "{$directory}{$timestamp}_{$fileSafeName}.php";
    }

    private static function generateMigrationTemplate(string $migrationName): string
    {
        $table = self::extractTableName($migrationName);

        return <<<PHP
<?php

use Illuminate\Database\Capsule\Manager as Capsule;

// Cria a tabela de {$table} se não existir
if (!Capsule::schema()->hasTable('{$table}')) {

    Capsule::schema()->create('{$table}', function (\$table) {
        \$table->increments('id');
        \$table->timestamps();
    });

}

PHP;
    }

    private static function extractTableName(string $migrationName): string
    {
        // Exemplo: create_users_table → users
        if (str_starts_with($migrationName, 'create_') && str_ends_with($migrationName, '_table')) {
            return substr($migrationName, 7, -6);
        }

        return $migrationName;
    }

    /** @phpstan-ignore method.unused */
    private static function findMigrationFile(string $migrationName): ?string
    {
        $migrationFiles = glob(__DIR__ . '/../../../database/migrations/*_' . $migrationName . '.php');

        return $migrationFiles[0] ?? null;
    }
}
