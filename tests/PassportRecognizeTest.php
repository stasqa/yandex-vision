<?php
/**
 * Created by PhpStorm.
 * User: itily
 * Date: 30.10.2022
 * Time: 17:59
 */

use PHPUnit\Framework\TestCase;
use razmik\yandex_vision\clients\YandexApiClientInterface;
use razmik\yandex_vision\contents\YandexContentInterface;
use razmik\yandex_vision\exceptions\YandexIAMFetchException;
use razmik\yandex_vision\exceptions\YandexRequestException;
use razmik\yandex_vision\IAMToken;
use razmik\yandex_vision\responses\DataResponse;
use razmik\yandex_vision\responses\IAMTokenResponse;
use razmik\yandex_vision\storages\IAMTokenStorageInterface;
use razmik\yandex_vision\templates\PassportRecognized;
use razmik\yandex_vision\templates\PassportTemplate;
use razmik\yandex_vision\YandexCloudVision;

/**
 * Тест распознания паспорта
 *
 * Class YandexVisionTest
 */
class PassportRecognizeTest extends TestCase
{
    /**
     * Успешное распознание паспорта
     *
     * @return void
     * @throws YandexRequestException
     */
    public function testShouldSuccess()
    {
        $responsesData = require 'responses.php';
        $template = new PassportTemplate();

        $mockClient = $this
            ->getMockBuilder(YandexApiClientInterface::class)
            ->getMock();
        $mockClient
            ->method('fetchIAMToken')
            ->willReturn(
                new IAMTokenResponse(200, 'test', date('Y-m-d H:i:s'))
            );
        $mockClient
            ->method('getDocumentRecognition')
            ->willReturn(
                new DataResponse(200, json_decode($responsesData['passportSuccess'], true))
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
            ->willReturn(new IAMToken('test', time()));

        $mockDocument = $this
            ->getMockBuilder(YandexContentInterface::class)
            ->getMock();
        $mockDocument
            ->method('asString')
            ->willReturn('base64String...');

        $vision = new YandexCloudVision($mockClient);
        $vision->changeIamTokenStorage($mockStorage);
        $responses = $vision->getDocumentRecognition($mockDocument, $template);

        /** @var PassportRecognized $response */
        $response = current($responses);

        $this->assertEquals('rus', $response->getCitizenship());
        $this->assertEquals('жен', $response->getGender());
        $this->assertEquals('12.08.2013', $response->getIssueDate());
        $this->assertEquals('санса', $response->getName());
        $this->assertEquals('эддардовна', $response->getMiddleName());
        $this->assertEquals('04.06.1993', $response->getBirthDate());
        $this->assertEquals('гор. винтерфелл', $response->getBirthPlace());
        $this->assertEquals('7512221182', $response->getNumber());
        $this->assertNull($response->getIssueBy());
        $this->assertNull($response->getExpirationDate());
    }

    /**
     * Ошибка, если не получилось запросить токен авторизации
     *
     * @return void
     * @throws YandexRequestException
     */
    public function testShouldFailureByFetchIAMToken()
    {
        $this->expectException(YandexIAMFetchException::class);
        $template = new PassportTemplate();

        $mockClient = $this
            ->getMockBuilder(YandexApiClientInterface::class)
            ->getMock();
        $mockClient
            ->method('fetchIAMToken')
            ->willReturn(null);

        $mockStorage = $this
            ->getMockBuilder(IAMTokenStorageInterface::class)
            ->getMock();
        $mockStorage
            ->method('fetchToken')
            ->willReturn(null);

        $mockDocument = $this
            ->getMockBuilder(YandexContentInterface::class)
            ->getMock();

        $vision = new YandexCloudVision($mockClient);
        $vision->changeIamTokenStorage($mockStorage);
        $vision->getDocumentRecognition($mockDocument, $template);
    }

    /**
     * Ошибка, если токена авторизации не верный
     *
     * @return void
     * @throws YandexRequestException
     */
    public function testShouldFailureByExpiredIAMToken()
    {
        $this->expectException(YandexRequestException::class);

        $responsesData = require 'responses.php';
        $template = new PassportTemplate();

        $mockClient = $this
            ->getMockBuilder(YandexApiClientInterface::class)
            ->getMock();
        $mockClient
            ->method('getDocumentRecognition')
            ->willReturn(
                new DataResponse(401, json_decode($responsesData['failureToken'], true))
            );

        $mockStorage = $this
            ->getMockBuilder(IAMTokenStorageInterface::class)
            ->getMock();
        $mockStorage
            ->expects($this->any())
            ->method('fetchToken')
            ->willReturn(new IAMToken('test', time()));

        $mockDocument = $this
            ->getMockBuilder(YandexContentInterface::class)
            ->getMock();
        $mockDocument
            ->method('asString')
            ->willReturn('base64String...');

        $vision = new YandexCloudVision($mockClient);
        $vision->changeIamTokenStorage($mockStorage);
        $vision->getDocumentRecognition($mockDocument, $template);
    }
}
