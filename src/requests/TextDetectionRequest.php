<?php
/**
 * Created by PhpStorm.
 * User: itily
 * Date: 28.10.2022
 * Time: 17:17
 */

namespace razmik\yandex_vision\requests;

use razmik\yandex_vision\contents\YandexContentInterface;
use razmik\yandex_vision\IAMToken;
use razmik\yandex_vision\templates\AbstractDocumentTemplate;

/**
 *
 *
 * Class DocumentRecognizeRequest
 * @package razmik\yandex_vision\requests
 */
class TextDetectionRequest
{
    /**
     * Документ на распознание
     *
     * @var YandexContentInterface
     */
    private $visionDocument;

    /**
     * Шаблон документа
     *
     * @var AbstractDocumentTemplate
     */
    private $template;

    /**
     * Токен авторизации
     *
     * @var IAMToken
     */
    private $iAMToken;

    /**
     * @param IAMToken $iAMToken
     * @param YandexContentInterface $document
     * @param AbstractDocumentTemplate $template
     */
    public function __construct(
        IAMToken                 $iAMToken,
        YandexContentInterface   $document,
        AbstractDocumentTemplate $template
    )
    {
        $this->visionDocument = $document;
        $this->template = $template;
        $this->iAMToken = $iAMToken;
    }

    /**
     * Контент документа
     *
     * @return string
     */
    public function getContent(): string
    {
        return $this->visionDocument->asString();
    }

    /**
     * Язык шаблона
     *
     * @return array
     */
    public function getLanguages(): array
    {
        return [
            $this->template->getLanguage(),
        ];
    }

    /**
     * Токен IAM-токен
     *
     * @return string
     */
    public function getIAMToken(): string
    {
        return $this->iAMToken->getToken();
    }

    /**
     * Токен IAM-токен
     *
     * @return string
     */
    public function getModel(): string
    {
        return $this->template->getModel();
    }
}
