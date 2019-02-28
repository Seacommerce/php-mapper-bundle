<?php


namespace Seacommerce\MapperBundle\Test\Mock\Doctrine\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package Seacommerce\MapperBundle\Test\Mock\Doctrine\Entity
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
     * @ORM\Column(name="inv_id", type="integer", nullable=false)
     */
    private $id;

    /**
     * @var Customer|null
     * @ORM\ManyToOne(targetEntity="Customer")
     * @ORM\JoinColumn(name="customer_id",referencedColumnName="id", nullable=false)
     */
    private $customer;

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
     * @return Customer|null
     */
    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    /**
     * @param Customer|null $customer
     * @return Invoice
     */
    public function setCustomer(?Customer $customer): Invoice
    {
        $this->customer = $customer;
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

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }
}