<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Storage;

class DeleteTemporaryFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'temp:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear temporary storage';

    protected $lifeTime;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->lifeTime = config('filesystems.disks.temp.lifetime');
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Get all files from temporary storage
        $files = Storage::disk('temp')->allFiles();

        // Iterate through all files in directory
        foreach ($files as $file) {
            // Get a Carbon instance for the file modified date and time.
            $modTimestamp = Storage::disk('temp')->lastModified($file);
            $modeDate = Carbon::createFromTimestamp($modTimestamp);

            // Calculate date difference
            $length = $modeDate->diffInSeconds(now());

            // Check if the file is old enough to delete it
            if ($length > $this->lifeTime) {
                $this->info('Deleted: ' . $file);

                Storage::disk('temp')->delete($file);
            }
        }
    }
}
