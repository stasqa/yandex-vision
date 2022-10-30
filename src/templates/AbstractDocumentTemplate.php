<?php
/**
 * Created by PhpStorm.
 * User: itily
 * Date: 28.10.2022
 * Time: 17:21
 */

namespace razmik\yandex_vision\templates;

/**
 * Базовый шаблон документа на распознание
 *
 * Class AbstractDocumentTemplate
 * @package razmik\yandex_vision\templates
 */
abstract class AbstractDocumentTemplate
{
    /**
     * Язык
     *
     * @var string
     */
    private $language;

    /**
     * @param string $language
     */
    public function __construct(string $language)
    {
        $this->language = $language;
    }

    /**
     * Создание распознанного документа
     *
     * @param array $data
     * @return AbstractDocumentRecognized
     */
    abstract public static function createRecognized(array $data): AbstractDocumentRecognized;

    /**
     * Название модели шаблона
     *
     * @return string
     */
    abstract public function getModel(): string;

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     * @return AbstractDocumentTemplate
     */
    public function setLanguage(string $language): AbstractDocumentTemplate
    {
        $this->language = $language;

        return $this;
    }
}
