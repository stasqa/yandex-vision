<?php
/**
 * Created by PhpStorm.
 * User: itily
 * Date: 28.10.2022
 * Time: 20:24
 */

namespace razmik\yandex_vision\storages;


use razmik\yandex_vision\IAMToken;

/**
 * Файловое хранилище токена авторизации
 *
 * Class YandexIAMTokenFileStorage
 * @package razmik\yandex_vision\storages
 */
class IAMTokenFileStorage implements IAMTokenStorageInterface
{
    /** @var string */
    private const FILE_NAME = "YandexIAMToken";

    /**
     * Путь к файлу
     *
     * @var string
     */
    private $pathToFile;

    /**
     *
     */
    public function __construct()
    {
        $this->initStoragePath();
    }

    /**
     * @inheritDoc
     */
    public function fetchToken(): ?IAMToken
    {
        $pathToFile = $this->pathToFile;

        if (file_exists($pathToFile) === false) {
            return null;
        } elseif (($content = file_get_contents($pathToFile)) === false) {
            return null;
        }
        $dateAt = filemtime($pathToFile);

        return new IAMToken($content, $dateAt);
    }

    /**
     * @inheritDoc
     */
    public function saveToken(string $token): void
    {
        $pathToFile = $this->pathToFile;

        if (file_exists($pathToFile) === false) {
            unlink($pathToFile);
        }

        file_put_contents($pathToFile, $token);
    }

    /**
     * Инициализация места хранения токена
     *
     * @return void
     */
    private function initStoragePath()
    {
        $this->pathToFile = sys_get_temp_dir() . DIRECTORY_SEPARATOR . self::FILE_NAME;
    }
}
