<?php
/**
 * Created by PhpStorm.
 * User: itily
 * Date: 28.10.2022
 * Time: 17:12
 */

namespace razmik\yandex_vision\templates;

/**
 * Водительское удостоверение, обратная сторона
 *
 * Class DriverLicenseBackTemplate
 * @package razmik\yandex_vision\templates
 */
class DriverLicenseBackTemplate extends AbstractDocumentTemplate
{
    /** @var string  */
    private const MODEL = 'driver-license-back';

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
        return new DriverLicenseBackRecognized($data);
    }

    /**
     * @inheritDoc
     */
    public function getModel(): string
    {
        return self::MODEL;
    }
}
