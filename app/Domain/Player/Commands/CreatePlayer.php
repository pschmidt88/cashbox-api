<?php

namespace App\Domain\Player\Commands;

final class CreatePlayer
{
    /** @var string $firstName */
    private $firstName;
    /** @var string $lastName */
    private $lastName;

    /**
     * CreatePlayer constructor.
     * @param string $firstName
     * @param string $lastName
     */
    public function __construct(string $firstName, string $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function firstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function lastName(): string
    {
        return $this->lastName;
    }
}
