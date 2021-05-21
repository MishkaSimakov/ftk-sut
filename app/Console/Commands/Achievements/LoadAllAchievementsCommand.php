<?php

namespace App\Console\Commands\Achievements;

use Assada\Achievements\Achievement;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class LoadAllAchievementsCommand extends Command
{
    protected $signature = 'achievements:load-all
                {--path=app/Achievements : The path to the achievements files to be executed}';

    protected $description = 'Load all achievements from all subfolders to database';

    public function handle()
    {
        $path = $this->option('path');

        $this->load_folder($path);
    }

    protected function load_folder($path, $depth = 0)
    {
        $classes = [];

        $this->info(sprintf(str_repeat('    ', $depth) . 'Load classes in %s...', $path));

        $files = array_diff(scandir($path, SCANDIR_SORT_ASCENDING), array('.', '..'));
        foreach ($files as $file) {
            if (is_dir($path . '/' . $file)) {
                $this->load_folder($path . '/' . $file, $depth + 1);
                continue;
            }

            if (!Str::endsWith($file, '.php')) {
                continue;
            }

            $classes[] = [
                'name' => Str::before($file, '.php'),
                'namespace' => $this->getNamespace(file_get_contents($path . '/' . $file))
            ];
        }

        $objects = [];
        foreach ($classes as $class) {
            $fullClass = sprintf('%s\%s', $class['namespace'], $class['name']);
            $objects[] = new $fullClass;
        }

        if (count($objects) === 0) {
            return;
        }

        foreach ($objects as $object) {
            if (!$object instanceof Achievement) {
                continue;
            }

            $object->getModel();
        }
    }

    private function getNamespace($src): ?string
    {
        if (preg_match('#^namespace\s+(.+?);#sm', $src, $m)) {
            return $m[1];
        }
        return null;
    }
}
