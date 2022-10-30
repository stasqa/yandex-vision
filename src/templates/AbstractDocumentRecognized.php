<?php
/**
 * Created by PhpStorm.
 * User: itily
 * Date: 30.10.2022
 * Time: 15:19
 */

namespace razmik\yandex_vision\templates;

/**
 * Распознанный документ
 *
 * Class AbstractDocumentRecognized
 * @package razmik\yandex_vision\templates
 */
abstract class AbstractDocumentRecognized
{
    /**
     * Данные сущности
     *
     * @var array
     */
    private $data = [];

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->configure($data);
    }

    /**
     *
     *
     * @param array $data
     * @return void
     */
    private function configure(array $data)
    {
        array_walk($data, function (array $datum) {
            list($key, $value) = array_values($datum);
            $value = $value === '-' ? null : $value;

            if (property_exists(static::class, $key) === true) {
                $this->$key = $value;
                $this->data[$key] = $value;
            }
        });
    }

    /**
     * Данные сущности в массив
     *
     * @return array
     */
    public function asArray(): array
    {
        return $this->data;
    }
}
