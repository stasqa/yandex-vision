<?php
/**
 * Created by PhpStorm.
 * User: itily
 * Date: 30.10.2022
 * Time: 21:02
 */

use PHPUnit\Framework\TestCase;
use razmik\yandex_vision\contents\YandexImageContent;
use razmik\yandex_vision\exceptions\YandexFileExceptionInterface;
use razmik\yandex_vision\exceptions\YandexFileNotFoundException;
use razmik\yandex_vision\exceptions\YandexFileSizeException;
use razmik\yandex_vision\exceptions\YandexFileTypeException;

/**
 * Тест загруженного документа
 *
 * Class FileContentTest
 */
class FileContentTest extends TestCase
{
    /**
     * Ошибка, если файл большой
     *
     * @return void
     * @throws YandexFileExceptionInterface
     */
    public function testShouldFailureBySize()
    {
        $this->expectException(YandexFileSizeException::class);
        new YandexImageContent(__DIR__ . '/data/test1.jpg');
    }

    /**
     * Ошибка, если файл не того типа
     *
     * @return void
     * @throws YandexFileExceptionInterface
     */
    public function testShouldFailureByType()
    {
        $this->expectException(YandexFileTypeException::class);
        new YandexImageContent(__DIR__ . '/data/test2.txt');
    }

    /**
     * Ошибка, если файл не найден
     *
     * @return void
     * @throws YandexFileExceptionInterface
     */
    public function testShouldNotFound()
    {
        $this->expectException(YandexFileNotFoundException::class);
        new YandexImageContent(sys_get_temp_dir() . '/none.jpg');
    }
}
