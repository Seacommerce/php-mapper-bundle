<?php


namespace Seacommerce\MapperBundle\Test\DoctrineIntegration\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class UserEntity
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=200, nullable=false)
     */
    protected $email;

    /**
     * @var UserTypeEntity|null
     * @ORM\ManyToOne(targetEntity="UserTypeEntity", inversedBy="users")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    protected $type;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return UserEntity
     */
    public function setId(int $id): UserEntity
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return UserEntity
     */
    public function setEmail(string $email): UserEntity
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return UserTypeEntity|null
     */
    public function getType(): ?UserTypeEntity
    {
        return $this->type;
    }

    /**
     * @param UserTypeEntity|null $type
     * @return UserEntity
     */
    public function setType(?UserTypeEntity $type): UserEntity
    {
        $this->type = $type;
        return $this;
    }
}