<?php
/**
 * Created by PhpStorm.
 * User: itily
 * Date: 30.10.2022
 * Time: 20:39
 */

use PHPUnit\Framework\TestCase;
use razmik\yandex_vision\clients\YandexApiClientInterface;
use razmik\yandex_vision\IAMToken;
use razmik\yandex_vision\IAMTokenRequestProxy;
use razmik\yandex_vision\responses\DataResponse;
use razmik\yandex_vision\responses\IAMTokenResponse;
use razmik\yandex_vision\storages\IAMTokenStorageInterface;

/**
 * Тестирование прокси запросов
 *
 * Class IAMTokenRequestProxyTest
 */
class IAMTokenRequestProxyTest extends TestCase
{
    /**
     * Проверка обновления токена в хранилище
     *
     * @return void
     */
    public function testShouldSaveToken()
    {
        $dateAt = time();

        $mockClient = $this
            ->getMockBuilder(YandexApiClientInterface::class)
            ->getMock();
        $mockClient
            ->method('fetchIAMToken')
            ->willReturn(
                new IAMTokenResponse(200, 'test', date('Y-m-d H:i:s'))
            );

        $mockStorage = $this
            ->getMockBuilder(IAMTokenStorageInterface::class)
            ->getMock();
        $mockStorage
            ->expects($this->at(1))
            ->method('fetchToken')
            ->willReturn(null);
        $mockStorage
            ->expects($this->at(2))
            ->method('fetchToken')
            ->willReturn(new IAMToken('test', $dateAt));
        $mockStorage
            ->expects($this->once())
            ->method('saveToken')
            ->with('test');

        $IAMTokenProxy = new IAMTokenRequestProxy($mockStorage, $mockClient);
        $IAMTokenProxy->send(function (IAMToken $iamToken) {
            return new DataResponse(200);
        });
    }

    /**
     * Токен не должен запрашиваться, если был найден в хранилище
     *
     * @return void
     */
    public function testShouldNotRefreshToken()
    {
        $dateAt = time();

        $mockClient = $this
            ->getMockBuilder(YandexApiClientInterface::class)
            ->getMock();
        $mockClient
            ->expects($this->never())
            ->method('fetchIAMToken');

        $mockStorage = $this
            ->getMockBuilder(IAMTokenStorageInterface::class)
            ->getMock();
        $mockStorage
            ->expects($this->any())
            ->method('fetchToken')
            ->willReturn(new IAMToken('test', $dateAt));
        $mockStorage
            ->expects($this->never())
            ->method('saveToken');

        $IAMTokenProxy = new IAMTokenRequestProxy($mockStorage, $mockClient);
        $IAMTokenProxy->send(function (IAMToken $iamToken) {
            return new DataResponse(200);
        });
    }
}
