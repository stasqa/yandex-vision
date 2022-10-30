<?php
/**
 * Created by PhpStorm.
 * User: itily
 * Date: 28.10.2022
 * Time: 17:36
 */

namespace razmik\yandex_vision\clients;

use razmik\yandex_vision\requests\RequestFactory;
use razmik\yandex_vision\requests\TextDetectionRequest;
use razmik\yandex_vision\responses\DataResponse;
use razmik\yandex_vision\responses\IAMTokenResponse;

/**
 * Клиент работы с API по умолчанию
 *
 * Class YandexVisionApiClient
 * @package razmik\yandex_vision\clients
 */
class YandexVisionApiClient extends AbstractYandexApiClient
{
    /**
     * @inheritDoc
     */
    public function getDocumentRecognition(TextDetectionRequest $request): DataResponse
    {
        $url = rtrim(self::API_VISION_HOST, '/') . '/batchAnalyze';
        $body = RequestFactory::textDetectionByRequest($this->folderId, $request);
        $header = [
            "Content-Type: application/json",
            "Authorization: Bearer {$request->getIAMToken()}",
        ];

        return $this->sendPostRequest($url, $body, $header);
    }

    /**
     * @inheritDoc
     */
    public function fetchIAMToken(): ?IAMTokenResponse
    {
        $url = rtrim(self::API_IAM_HOST, '/') . '/tokens';
        $body = ['yandexPassportOauthToken' => $this->oathToken];
        $response = $this->sendPostRequest($url, $body);

        if ($response->isSuccess() === false) {
            return null;
        }
        $data = $response->getData();

        return new IAMTokenResponse(
            $response->getHttpCode(),
            $data['iamToken'],
            $data['expiresAt']
        );
    }

    /**
     * Отправка POST запроса
     *
     * @param string $url
     * @param array $body
     * @param array $headers
     * @return DataResponse
     */
    private function sendPostRequest(string $url, array $body, array $headers = []): DataResponse
    {
        $headers = array_merge($headers, [
            'Content-Type: application/json',
        ]);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array_values($headers));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);

        $html = curl_exec($ch);
        $data = json_decode($html, true);

        return new DataResponse(
            curl_getinfo($ch, CURLINFO_RESPONSE_CODE),
            $data !== null ? $data : [$html]
        );
    }
}
