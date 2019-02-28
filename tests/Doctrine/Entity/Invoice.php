<?php


namespace Seacommerce\MapperBundle\Test\Doctrine\Entity;


use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package Seacommerce\MapperBundle\Test\Doctrine\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="invoice")
 */
class Invoice
{
    /**
     * @var int|null
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", nullable=false)
     */
    private $id;

    /**
     * @var Collection|InvoiceItem[]
     * @ORM\OneToMany(targetEntity="InvoiceItem", mappedBy="invoice")
     */
    private $items;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Invoice
     */
    public function setId(?int $id): Invoice
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Collection|InvoiceItem[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param Collection|InvoiceItem[] $items
     * @return Invoice
     */
    public function setItems($items)
    {
        $this->items = $items;
        return $this;
    }
}