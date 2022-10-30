<?php
/**
 * Created by PhpStorm.
 * User: itily
 * Date: 28.10.2022
 * Time: 17:23
 */

namespace razmik\yandex_vision\contents;

/**
 * Документ на отправку
 *
 * Class YandexContentInterface
 * @package razmik\yandex_vision\contents
 */
interface YandexContentInterface
{
    /** @var int  */
    const MAX_FILE_SIZE = 1;

    /**
     *
     *
     * @return string
     */
    public function asString(): string;
}