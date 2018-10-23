<?php

namespace App\Entity\User;

use Symfony\Component\Serializer\Annotation as Serializer;

class UserBodyMeasurementHistory extends AbstractBodyMeasurement
{
    /**
     * @var int
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $id;

    /**
     * UserBodyMeasurementHistory constructor.
     *
     * @param UserBodyMeasurement $userBodyMeasurement
     */
    public function __construct(UserBodyMeasurement $userBodyMeasurement)
    {
        $this->setHeight($userBodyMeasurement->getHeight());
        $this->setWeight($userBodyMeasurement->getWeight());
        $this->setRestingHeartRate($userBodyMeasurement->getRestingHeartRate());
        $this->setUser($userBodyMeasurement->getUser());
    }
}