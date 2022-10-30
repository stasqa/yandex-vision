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
 * Не удалось получить токен авторизации из хранилища
 *
 * Class YandexIAMStorageException
 * @package razmik\yandex_vision\exceptions
 */
class YandexIAMStorageException extends Exception implements YandexIAMTokenExceptionInterface
{
    /**
     * @inheritDoc
     */
    public function __construct(Throwable $previous = null)
    {
        $message = "Не удалось получить токен авторизации из хранилища.";
        parent::__construct($message, 0, $previous);
    }

}
