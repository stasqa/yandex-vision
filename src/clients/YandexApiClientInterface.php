<?php
/**
 * Created by PhpStorm.
 * User: itily
 * Date: 28.10.2022
 * Time: 17:04
 */

namespace razmik\yandex_vision\clients;

use razmik\yandex_vision\requests\TextDetectionRequest;
use razmik\yandex_vision\responses\IAMTokenResponse;
use razmik\yandex_vision\responses\DataResponse;

/**
 * Интерфейс запросов к сервису
 *
 * Class YandexApiClientInterface
 * @package razmik\yandex_vision\clients
 */
interface YandexApiClientInterface
{
    /**
     * Получить распознанный документ
     *
     * @param TextDetectionRequest $request
     * @return DataResponse
     */
    public function getDocumentRecognition(TextDetectionRequest $request): DataResponse;

    /**
     * Получение токена авторизации
     *
     * @return IAMTokenResponse|null
     */
    public function fetchIAMToken(): ?IAMTokenResponse;
}