<?php

namespace App\Console\Commands;

use App\Nova\Resource;
use Illuminate\Console\Command;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use Spatie\Permission\Models\Permission;
use Symfony\Component\Console\Command\Command as CommandAlias;

class SyncPermission extends Command
{

    protected $signature = 'sync-permission';


    protected $description = 'Command description';


    public function handle(): int
    {

        $permissions = [];

        foreach ($this->getClasses() as $class) {
            if (is_subclass_of($class, Resource::class)) {
                $permissions = [...$permissions, ...array_merge(array_values($class::$permissions))];
            }
        }

        foreach (array_unique($permissions) as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        $this->info('Sync '.count(array_unique($permissions))." permissions");

        return CommandAlias::SUCCESS;
    }


    public function getClasses(): array
    {
        $classes = [];

        $allFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(
            app_path('Nova')
        ));
        $phpFiles = new RegexIterator($allFiles, '/\.php$/');
        foreach ($phpFiles as $phpFile) {
            $content = file_get_contents($phpFile->getRealPath());
            $tokens = token_get_all($content);
            $namespace = '';
            for ($index = 0; isset($tokens[$index]); $index++) {
                if (!isset($tokens[$index][0])) {
                    continue;
                }
                if (T_NAMESPACE === $tokens[$index][0]) {
                    $index += 2;
                    while (isset($tokens[$index]) && is_array($tokens[$index])) {
                        $namespace .= $tokens[$index++][1];
                    }
                }
                if (T_CLASS === $tokens[$index][0] && T_WHITESPACE === $tokens[$index + 1][0] && T_STRING === $tokens[$index + 2][0]) {
                    $index += 2;
                    $classes[] = $namespace . '\\' . $tokens[$index][1];

                    break;
                }
            }
        }

        return $classes;
    }
}
