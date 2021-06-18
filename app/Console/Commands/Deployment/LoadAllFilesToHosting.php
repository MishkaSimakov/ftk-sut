<?php

namespace App\Console\Commands\Deployment;

use Illuminate\Console\Command;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

class LoadAllFilesToHosting extends Command
{
    protected $signature = 'hosting:load';

    protected $description = 'Load whole project to hosting and change env for production';

    public function handle()
    {
        $this->changeEnvironmentToProduction();

        $this->info('Начинаю архивировать файлы...');

        $files = scandir(base_path());

        $exclude = [
            '.', '..', '.env.production', '.env.development', '.idea', '.git', 'tests', 'node_modules'
        ];

        $files = array_diff($files, $exclude);

        $result = $this->zipFiles($files, base_path('_website.zip'));

        if (!$result) {
            $this->error('Не удалось архивировать файлы.');
            return false;
        }
        $this->info('Архивация файлов завершена успешно.');

        $this->info('');





        // установка соединения
        $conn_id = ftp_connect(config('ftp.server'));

        // вход с именем пользователя и паролем
        $login_result = ftp_login($conn_id, config('ftp.username'), config('ftp.password'));

        // проверка соединения
        if ((!$conn_id) || (!$login_result)) {
            $this->alert('Не удалось подключиться к серверу.');
            exit;
        } else {
            $this->info('Соединение с сервером установлено.');
        }



        //
        $this->info('Начинаю загрузку файлов на сервер...');
        $status = ftp_put($conn_id, '/_website.zip', base_path('_website.zip'));

        if (!$status) {
            $this->info('Не удалось загрузить файлы на сервер.');
            return false;
        }
        $this->info('Файлы успешно загружены на сервер.');

        unlink(base_path('_website.zip'));



        // закрытие соединения
        ftp_close($conn_id);

        $this->changeEnvironmentToDevelopment();
    }

    protected function loadFiles($ftp): bool
    {
        return true;
    }

    protected function zipFiles(array $sources, $destination)
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
