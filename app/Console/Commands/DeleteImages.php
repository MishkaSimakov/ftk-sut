<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeleteImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all images';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->delete_files(public_path('image'));

        $this->info('All images deleted successfully!');
    }

    protected function delete_files($target) {
        if(is_dir($target)){
            $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

            foreach( $files as $file ){
                $this->delete_files($file);
            }

            rmdir( $target );
        } elseif(is_file($target)) {
            unlink( $target );
        }
    }
}
