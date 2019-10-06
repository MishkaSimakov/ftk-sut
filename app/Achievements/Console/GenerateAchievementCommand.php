<?php

namespace App\Achievements\Console;

use Illuminate\Console\Command;

class GenerateAchievementCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:achievement {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new Achievement class';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $stub = file_get_contents(app_path('Achievements/Console/achievement.stub'));

        $stub = str_replace('{{CLASS}}', $this->argument('name'), $stub);

        file_put_contents(app_path('Achievements/Types/' . $this->argument('name') . '.php'), $stub);

        $this->info('app/Achievements/Types/' . $this->argument('name') . '.php was created!');
    }
}
