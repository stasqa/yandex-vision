<?php
/**
 * Created by PhpStorm.
 * User: itily
 * Date: 30.10.2022
 * Time: 15:20
 */

namespace razmik\yandex_vision\templates;

/**
 * Распознанное водительское удостоверение, обратная сторона
 *
 * Class DriverLicenseBackRecognized
 * @package razmik\yandex_vision\templates
 */
class DriverLicenseBackRecognized extends AbstractDocumentRecognized
{
    /**
     * Водительский стаж (с какого года)
     *
     * @var string|null
     */
    protected $experience_from;

    /**
     * Номер предыдущего водительского удостоверения
     *
     * @var string|null
     */
    protected $prev_number;

    /**
     * Номер паспорта
     *
     * @var string|null
     */
    protected $number;

    /**
     * Дата выдачи
     *
     * @var string|null
     */
    protected $issue_date;

    /**
     * Дата окончания срока действия
     *
     * @var string|null
     */
    protected $expiration_date;

    /**
     * @inheritDoc
     * @param array $data
     */
    public function __construct(array $data)
    {
        $entities = isset($data['entities']) === true ?
            $data['entities'] :
            [];

        parent::__construct($entities);
    }

    /**
     * @return string|null
     */
    public function getExperienceFrom(): ?string
    {
        return $this->experience_from;
    }

    /**
     * @return string|null
     */
    public function getPrevNumber(): ?string
    {
        return $this->prev_number;
    }

    /**
     * @return string|null
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * @return string|null
     */
    public function getIssueDate(): ?string
    {
        return $this->issue_date;
    }

    /**
     * @return string|null
     */
    public function getExpirationDate(): ?string
    {
        return $this->expiration_date;
    }
}
