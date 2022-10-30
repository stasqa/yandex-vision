<?php
/**
 * Created by PhpStorm.
 * User: itily
 * Date: 30.10.2022
 * Time: 13:35
 */

namespace razmik\yandex_vision;

use razmik\yandex_vision\clients\YandexApiClientInterface;
use razmik\yandex_vision\exceptions\YandexIAMFetchException;
use razmik\yandex_vision\exceptions\YandexIAMStorageException;
use razmik\yandex_vision\exceptions\YandexIAMTokenExceptionInterface;
use razmik\yandex_vision\responses\DataResponse;
use razmik\yandex_vision\storages\IAMTokenStorageInterface;

/**
 * Прокси обработки IAM токена перед отправкой запроса
 *
 * Class IAMTokenRequestProxy
 * @package razmik\yandex_vision
 */
class IAMTokenRequestProxy
{
    /**
     * Место хранения IAM токена
     *
     * @var IAMTokenStorageInterface
     */
    private $iamTokenStorage;

    /**
     * Клиент работы с API
     *
     * @var YandexApiClientInterface
     */
    private $apiClient;

    /**
     * @param IAMTokenStorageInterface $iamTokenStorage
     * @param YandexApiClientInterface $apiClient
     */
    public function __construct(
        IAMTokenStorageInterface $iamTokenStorage,
        YandexApiClientInterface $apiClient
    )
    {
        $this->iamTokenStorage = $iamTokenStorage;
        $this->apiClient = $apiClient;
    }

    /**
     * Отправка запроса
     *
     * @param callable $callback
     * @return DataResponse
     * @throws YandexIAMTokenExceptionInterface
     */
    public function send(callable $callback): DataResponse
    {
        $IAMToken = $this->getOrRefreshIAMToken();
        /** @var DataResponse $response */
        $response = call_user_func($callback, $IAMToken);

        if (
            $response->isSuccess() === true ||
            $response->getHttpCode() !== 401
        ) {
            return $response;
        }

        $IAMToken = $this->getOrRefreshIAMToken();

        return call_user_func($callback, $IAMToken);
    }

    /**
     * Обновление токена
     *
     * @return void
     * @throws YandexIAMFetchException
     */
    private function refreshIAMToken()
    {
        $apiClient = $this->apiClient;
        $iamTokenStorage = $this->iamTokenStorage;
        $tokenResponse = $apiClient->fetchIAMToken();

        if (
            $tokenResponse === null ||
            $tokenResponse->isSuccess() === false
        ) {
            throw new YandexIAMFetchException();
        }

        $iamTokenStorage->saveToken($tokenResponse->getIamToken());
    }

    /**
     * Получение или обновления токена авторизации
     *
     * @return IAMToken|null
     * @throws YandexIAMFetchException
     * @throws YandexIAMStorageException
     */
    private function getOrRefreshIAMToken(): ?IAMToken
    {
        $iamTokenStorage = $this->iamTokenStorage;
        $IAMToken = $iamTokenStorage->fetchToken();

        if (
            $IAMToken === null ||
            $IAMToken->isExpired() === true
        ) {
            $this->refreshIAMToken();
            $IAMToken = $iamTokenStorage->fetchToken();

            if ($IAMToken === null) {
                throw new YandexIAMStorageException();
            }
        }

        return $IAMToken;
    }
}
