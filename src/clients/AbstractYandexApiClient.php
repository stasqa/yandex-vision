<?php
/**
 * Created by PhpStorm.
 * User: itily
 * Date: 28.10.2022
 * Time: 17:38
 */

namespace razmik\yandex_vision\clients;

/**
 *
 *
 * Class AbstractYandexApiClient
 * @package razmik\yandex_vision\clients
 */
abstract class AbstractYandexApiClient implements YandexApiClientInterface
{
    /** @var string  */
    protected const API_VISION_HOST = "https://vision.api.cloud.yandex.net/vision/v1";

    /** @var string  */
    protected const API_IAM_HOST = "https://iam.api.cloud.yandex.net/iam/v1";

    /**
     *
     *
     * @var string
     */
    protected $oathToken;
    /**
     *
     *
     * @var string
     */
    protected $folderId;

    /**
     * @param string $oathToken
     * @param string $folderId
     */
    public function __construct(string $oathToken, string $folderId)
    {
        $this->oathToken = $oathToken;
        $this->folderId = $folderId;
    }
}
