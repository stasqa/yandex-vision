<?php
/**
 * Created by PhpStorm.
 * User: itily
 * Date: 30.10.2022
 * Time: 15:20
 */

namespace razmik\yandex_vision\templates;

/**
 * Распознанное водительское удостоверение, лицевая сторона
 *
 * Class DriverLicenseFrontRecognized
 * @package razmik\yandex_vision\templates
 */
class DriverLicenseFrontRecognized extends AbstractDocumentRecognized
{
    /**
     * Имя
     *
     * @var string|null
     */
    protected $name;

    /**
     * Отчество
     *
     * @var string|null
     */
    protected $middle_name;

    /**
     * Фамилия
     *
     * @var string|null
     */
    protected $surname;

    /**
     * Дата рождения
     *
     * @var string|null
     */
    protected $birth_date;

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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getMiddleName(): ?string
    {
        return $this->middle_name;
    }

    /**
     * @return string|null
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * @return string|null
     */
    public function getBirthDate(): ?string
    {
        return $this->birth_date;
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
