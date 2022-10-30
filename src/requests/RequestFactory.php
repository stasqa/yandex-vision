<?php
/**
 * Created by PhpStorm.
 * User: itily
 * Date: 28.10.2022
 * Time: 17:44
 */

namespace razmik\yandex_vision\requests;

/**
 * Фабрика создания запроса
 *
 * Class RequestFactory
 * @package \razmik\yandex_vision\factories
 */
class RequestFactory
{
    /** @var string */
    private const TEXT_DETECTION = "TEXT_DETECTION";

    /**
     * YandexRequestFactory constructor.
     */
    private function __construct()
    {
    }

    /**
     * Создание запроса на распознание текста
     *
     * @param string $folderId
     * @param TextDetectionRequest $request
     * @return array
     */
    public static function textDetectionByRequest(string $folderId, TextDetectionRequest $request): array
    {
        return [
            "folderId" => $folderId,
            "analyze_specs" => [
                "content" => $request->getContent(),
                "features" => [
                    [
                        "type" => self::TEXT_DETECTION,
                        "text_detection_config" => [
                            "language_codes" => $request->getLanguages(),
                            "model" => $request->getModel(),
                        ],
                    ],
                ],
            ],
        ];
    }
}

