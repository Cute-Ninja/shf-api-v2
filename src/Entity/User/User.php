<?php

namespace App\Entity\User;

use App\Entity\AbstractBaseEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation as Serializer;

class User extends AbstractBaseEntity implements UserInterface
{
    /**
     * @var int
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $id;

    /**
     * @var string
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $username;

    /**
     * @var string
     *
     * @Serializer\Groups({"user-details", "admin","test"})
     */
    protected $email;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var bool
     */
    protected $isAdmin = false;

    /**
     * @var \DateTime
     *
     * @Serializer\Groups({"admin"})
     */
    protected $lastLogin;

    /**
     * @var string[]
     *
     * @Serializer\Groups({"admin", "test"})
     */
    protected $roles;

    /**
     * @var UserBodyMeasurement
     *
     * @Serializer\Groups({"user-body-measurement", "admin", "test"})
     */
    protected $bodyMeasurement;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return null|string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    /**
     * @param bool $isAdmin
     */
    public function setIsAdmin(bool $isAdmin): void
    {
        $this->isAdmin = $isAdmin;
    }

    /**
     * @return \DateTime|null
     */
    public function getLastLogin(): ?\DateTime
    {
        return $this->lastLogin;
    }

    /**
     * @param \DateTime $lastLogin
     */
    public function setLastLogin(\DateTime $lastLogin): void
    {
        $this->lastLogin = $lastLogin;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles ? : ['ROLES_USER'];
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }

    /**
     * @param string $role
     *
     * @return bool
     */
    public function hasRole(string $role): bool
    {
        return in_array($role, $this->getRoles());
    }

    /**
     * @return null|string
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @return null|string
     */
    public function eraseCredentials(): ?string
    {
        return null;
    }

    /**
     * @return UserBodyMeasurement|null
     */
    public function getBodyMeasurement(): ?UserBodyMeasurement
    {
        return $this->bodyMeasurement;
    }

    /**
     * @param UserBodyMeasurement $bodyMeasurement
     */
    public function setBodyMeasurement(UserBodyMeasurement $bodyMeasurement): void
    {
        $this->bodyMeasurement = $bodyMeasurement;
    }
}