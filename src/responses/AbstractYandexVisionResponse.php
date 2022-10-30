<?php
/**
 * Created by PhpStorm.
 * User: itily
 * Date: 30.10.2022
 * Time: 13:50
 */

namespace razmik\yandex_vision\responses;

/**
 *
 *
 * Class AbstractYandexVisionResponse
 * @package razmik\yandex_vision\responses
 */
abstract class AbstractYandexVisionResponse
{
    /**
     * Код ответа
     *
     * @var int
     */
    private $httpCode;

    /**
     * @param int $httpCode
     */
    public function __construct(int $httpCode)
    {
        $this->httpCode = $httpCode;
    }

    /**
     * Успешный ответ
     *
     * @return bool
     */
    public function isSuccess(): bool
    {
        return
            $this->httpCode >= 200 &&
            $this->httpCode < 300;
    }

    /**
     * @return int
     */
    public function getHttpCode(): int
    {
        return $this->httpCode;
    }
}
