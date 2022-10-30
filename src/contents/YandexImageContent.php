<?php
/**
 * Created by PhpStorm.
 * User: itily
 * Date: 28.10.2022
 * Time: 17:23
 */

namespace razmik\yandex_vision\contents;

use razmik\yandex_vision\exceptions\YandexFileExceptionInterface;
use razmik\yandex_vision\exceptions\YandexFileNotFoundException;
use razmik\yandex_vision\exceptions\YandexFileSizeException;
use razmik\yandex_vision\exceptions\YandexFileTypeException;

/**
 * Изображение
 *
 * Class YandexImageContent
 * @package razmik\yandex_vision\contents
 */
class YandexImageContent implements YandexContentInterface
{
    /** @var string[] */
    private const MIME_TYPES = [
        'image/png',
        'image/jpeg',
    ];

    /**
     * Путь к файлу
     *
     * @var string
     */
    private $sourcePath;

    /**
     * @param string $sourcePath
     * @throws YandexFileExceptionInterface
     */
    public function __construct(string $sourcePath)
    {
        $this->validateSourcePath($sourcePath);
        $this->validateMimeType($sourcePath);

        $this->sourcePath = $sourcePath;
    }

    /**
     * @inheritDoc
     */
    public function asString(): string
    {
        $data = file_get_contents($this->sourcePath);

        return base64_encode($data);
    }

    /**
     * Валидация пути файла
     *
     * @param string $sourcePath
     * @return void
     * @throws YandexFileNotFoundException
     * @throws YandexFileSizeException
     */
    private function validateSourcePath(string $sourcePath)
    {
        if (file_exists($sourcePath) === false) {
            throw new YandexFileNotFoundException($sourcePath);
        }

        $fileSize = filesize($sourcePath);

        if (
            $fileSize === false ||
            $fileSize / pow(1024, 2) > self::MAX_FILE_SIZE
        ) {
            throw new YandexFileSizeException();
        }
    }

    /**
     * Проверка файла по типу
     *
     * @throws YandexFileTypeException
     */
    private function validateMimeType(string $sourcePath)
    {
        $type = mime_content_type($sourcePath);

        if (in_array($type, self::MIME_TYPES) === false) {
            throw new YandexFileTypeException($type);
        }
    }
}
