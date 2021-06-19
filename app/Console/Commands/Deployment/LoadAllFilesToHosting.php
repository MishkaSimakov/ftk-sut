<?php

namespace App\Console\Commands\Deployment;

use Illuminate\Console\Command;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

class LoadAllFilesToHosting extends Command
{
    protected $signature = 'project:deploy';

    protected string $zippedProjectDestination = "/_website.zip";

    protected $description = 'Load whole project to hosting, run optimization command and change env for production';

    public function handle()
    {
        $this->callSilent('optimize:clear');

        // меняю файл окружения для загрузки на хостинг
        $this->changeEnvironmentToProduction();


        $this->info('Начинаю архивировать файлы...');

        if (!$this->zipProject()) {
            $this->error('Не удалось архивировать файлы.');
            exit;
        }
        $this->info('Архивация файлов завершена успешно.');


        $this->info('');


        $this->info('Устанавливаю соединение с сервером...');

        if (($ftp = $this->connectToFtpServer()) === false) {
            $this->alert('Не удалось подключиться к серверу.');
            exit;
        }
        $this->info('Соединение с сервером установлено.');


        $this->info('');


        $this->info('Начинаю загрузку файлов на сервер...');

        if (!$this->loadFilesViaFtp($ftp)) {
            $this->info('Не удалось загрузить файлы на сервер.');
            exit;
        }
        $this->info('Файлы успешно загружены на сервер.');

        // закрытие ftp соединения
        ftp_close($ftp);

        $this->changeEnvironmentToDevelopment();
    }

    protected function loadFilesViaFtp($ftp): bool
    {
        return ftp_put($ftp, $this->zippedProjectDestination, base_path($this->zippedProjectDestination));
    }

    protected function connectToFtpServer()
    {
        $conn_id = ftp_connect(config('ftp.server'));
        $login_result = ftp_login($conn_id, config('ftp.username'), config('ftp.password'));

        if ((!$conn_id) || (!$login_result)) {
            return false;
        }

        return $conn_id;
    }

    protected function zipProject()
    {
        $files = scandir(base_path());

        $exclude = [
            '.', '..', '.env.production', '.env.development', '.idea', '.git', 'tests', 'node_modules'
        ];

        $files = array_diff($files, $exclude);

        return $this->zipDirectories($files, base_path('_website.zip'));
    }

    protected function zipDirectories(array $sources, $destination)
    {
        if (!extension_loaded('zip')) {
            return false;
        }

        if (file_exists($destination)) {
            unlink($destination);
        }

        $zip = new ZipArchive();
        if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
            return false;
        }

        foreach ($sources as $source) {
            if (!file_exists($source)) {
                return false;
            }

            if (is_dir($source) === true) {
                $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

                foreach ($files as $file) {
                    if (in_array($file->getFilename(), ['.', '..'])) {
                        continue;
                    }

                    $path = realpath($file);

                    if (is_file($file) === true) {
                        $zip->addFromString($this->transformPath($path), file_get_contents($file));
                    }
                }
            } else if (is_file($source) === true) {
                $zip->addFromString($this->transformPath($source), file_get_contents($source));
            }
        }

        return $zip->close();
    }

    protected function transformPath($path)
    {
        return str_replace(
            '\\', '/',
            str_replace(base_path() . '\\', '', $path)
        );
    }

    protected function changeEnvironmentToProduction()
    {
        copy(base_path('.env'), base_path('.env.development'));

        copy(base_path('.env.production'), base_path('.env'));
    }

    protected function changeEnvironmentToDevelopment()
    {
        copy(base_path('.env.development'), base_path('.env'));

        unlink(base_path('.env.development'));
    }
}
