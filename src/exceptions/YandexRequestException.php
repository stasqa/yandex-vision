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
 * Не корректный запрос
 *
 * Class YandexRequestException
 * @package razmik\yandex_vision\exceptions
 */
class YandexRequestException extends Exception implements YandexVisionExceptionInterface
{
    /**
     * @inheritDoc
     */
    public function __construct(array $data, Throwable $previous = null)
    {
        if (isset($data['code']) === true) {
            parent::__construct($data['message'], $data['code'], $previous);

            return;
        }

        $message = 'Не известная ошибка.';
        parent::__construct($message, 0, $previous);
    }
}
