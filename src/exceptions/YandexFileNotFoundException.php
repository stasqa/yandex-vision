<?php
/**
 * Created by PhpStorm.
 * User: itily
 * Date: 28.10.2022
 * Time: 19:21
 */

namespace razmik\yandex_vision\exceptions;

use Exception;
use Throwable;

/**
 * Не корректный путь к файлу
 *
 * Class YandexFileSizeException
 * @package razmik\yandex_vision\exceptions
 */
class YandexFileNotFoundException extends Exception implements YandexFileExceptionInterface
{
    /**
     * @inheritDoc
     */
    public function __construct(string $sourcePath, Throwable $previous = null)
    {
        $message = "Файл $sourcePath не найден.";
        parent::__construct($message, 0, $previous);
    }

}
