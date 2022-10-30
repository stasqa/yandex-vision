<?php
/**
 * Created by PhpStorm.
 * User: itily
 * Date: 28.10.2022
 * Time: 17:02
 */

namespace razmik\yandex_vision;

use razmik\yandex_vision\clients\YandexApiClientInterface;
use razmik\yandex_vision\contents\YandexContentInterface;
use razmik\yandex_vision\exceptions\YandexRequestException;
use razmik\yandex_vision\requests\TextDetectionRequest;
use razmik\yandex_vision\storages\IAMTokenFileStorage;
use razmik\yandex_vision\storages\IAMTokenStorageInterface;
use razmik\yandex_vision\templates\AbstractDocumentTemplate;
use razmik\yandex_vision\templates\AbstractDocumentRecognized;

/**
 * Компонент анализа изображения
 *
 * Class YandexCloudVision
 * @package razmik\yandex_vision
 */
class YandexCloudVision
{
    /**
     * Клиент работы с запросами API
     *
     * @var YandexApiClientInterface
     */
    private $apiClient;

    /**
     * Место хранения IAM токена
     *
     * @var IAMTokenStorageInterface
     */
    private $iamTokenStorage;

    /**
     * @param YandexApiClientInterface $apiClient
     */
    public function __construct(YandexApiClientInterface $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Изменение места хранения токена авторизации
     *
     * @param IAMTokenStorageInterface $iamTokenStorage
     * @return YandexCloudVision
     */
    public function changeIamTokenStorage(IAMTokenStorageInterface $iamTokenStorage): YandexCloudVision
    {
        $this->iamTokenStorage = $iamTokenStorage;

        return $this;
    }

    /**
     * Получить распознанный документ
     *
     * @param YandexContentInterface $document
     * @param AbstractDocumentTemplate $template
     * @return AbstractDocumentRecognized[]
     * @throws YandexRequestException
     */
    public function getDocumentRecognition(
        YandexContentInterface   $document,
        AbstractDocumentTemplate $template
    ): array
    {
        $this->initIAMStorage();

        $IAMTokenProxy = new IAMTokenRequestProxy(
            $this->iamTokenStorage,
            $this->apiClient
        );
        $response = $IAMTokenProxy->send(
            function (IAMToken $iamToken) use ($template, $document) {
                $apiClient = $this->apiClient;
                $request = new TextDetectionRequest($iamToken, $document, $template);

                return $apiClient->getDocumentRecognition($request);
            }
        );

        if ($response->isSuccess() === false) {
            throw new YandexRequestException($response->getData());
        }

        $results = current($response->getData()['results']);
        $pages = current($results['results'])['textDetection']["pages"];

        array_walk($pages, function (array &$page) use ($template) {
            $page = $template::createRecognized($page);
        });

        return $pages;
    }

    /**
     * Инициализация места хранения токена авторизации
     *
     * @return void
     */
    private function initIAMStorage()
    {
        $this->iamTokenStorage = $this->iamTokenStorage ?: new IAMTokenFileStorage();
    }
}
