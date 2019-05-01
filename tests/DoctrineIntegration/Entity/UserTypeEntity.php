<?php


namespace Seacommerce\MapperBundle\Test\DoctrineIntegration\Entity;


use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_type")
 */
class UserTypeEntity
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=20, nullable=false)
     */
    protected $code;

    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    protected $name;

    /**
     * @var Collection
     * @ORM\ManyToOne(targetEntity="UserEntity", inversedBy="type")
     */
    protected $users;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return UserTypeEntity
     */
    public function setId(int $id): UserTypeEntity
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return UserTypeEntity
     */
    public function setCode(string $code): UserTypeEntity
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return UserTypeEntity
     */
    public function setName(string $name): UserTypeEntity
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    /**
     * @param Collection $users
     * @return UserTypeEntity
     */
    public function setUsers(Collection $users): UserTypeEntity
    {
        $this->users = $users;
        return $this;
    }
}