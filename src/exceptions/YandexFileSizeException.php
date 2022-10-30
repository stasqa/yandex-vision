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
 * Не корректный размер файла
 *
 * Class YandexFileSizeException
 * @package razmik\yandex_vision\exceptions
 */
class YandexFileSizeException extends Exception implements YandexFileExceptionInterface
{
    /**
     * @inheritDoc
     */
    public function __construct(Throwable $previous = null)
    {
        $message = "Не удалось определить размер файла.";
        parent::__construct($message, 0, $previous);
    }

}
