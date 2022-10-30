<?php
/**
 * Created by PhpStorm.
 * User: itily
 * Date: 28.10.2022
 * Time: 17:12
 */

namespace razmik\yandex_vision\templates;

/**
 * Водительское удостоверение, лицевая сторона
 *
 * Class DriverLicenseFrontTemplate
 * @package razmik\yandex_vision\templates
 */
class DriverLicenseFrontTemplate extends AbstractDocumentTemplate
{
    /** @var string  */
    private const MODEL = 'driver-license-front';

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
        return new DriverLicenseFrontRecognized($data);
    }

    /**
     * @inheritDoc
     */
    public function getModel(): string
    {
        return self::MODEL;
    }
}
