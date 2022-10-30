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
 * Не корректный тип файла
 *
 * Class YandexFileTypeException
 * @package razmik\yandex_vision\exceptions
 */
class YandexFileTypeException extends Exception implements YandexFileExceptionInterface
{
    /**
     * @inheritDoc
     */
    public function __construct(string $type, Throwable $previous = null)
    {
        $message = "Тип файла $type не поддерживается.";
        parent::__construct($message, 0, $previous);
    }

}
