<?php
/**
 * Created by PhpStorm.
 * User: itily
 * Date: 28.10.2022
 * Time: 17:12
 */

namespace razmik\yandex_vision\templates;

/**
 * Распознавание паспорта
 *
 * Class PassportTemplate
 * @package razmik\yandex_vision\templates
 */
class PassportTemplate extends AbstractDocumentTemplate
{
    /** @var string  */
    private const MODEL = 'passport';

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        parent::__construct("*");
    }

    /**
     * @inheritDoc
     */
    public static function createRecognized(array $data): AbstractDocumentRecognized
    {
        return new PassportRecognized($data);
    }

    /**
     * @inheritDoc
     */
    public function getModel(): string
    {
        return self::MODEL;
    }
}
