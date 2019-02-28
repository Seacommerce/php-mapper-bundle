<?php


namespace Seacommerce\MapperBundle\Test\Mock\Doctrine\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="invoice_item")
 */
class InvoiceItem
{
    /**
     * @var int|null
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", nullable=false)
     */
    private $id;

    /**
     * @var Invoice|null
     * @ORM\ManyToOne(targetEntity="Invoice", inversedBy="items")
     * @ORM\JoinColumn(name="invoice_id", referencedColumnName="id", nullable=false)
     */
    private $invoice;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return InvoiceItem
     */
    public function setId(?int $id): InvoiceItem
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Invoice|null
     */
    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    /**
     * @param Invoice|null $invoice
     * @return InvoiceItem
     */
    public function setInvoice(?Invoice $invoice): InvoiceItem
    {
        $this->invoice = $invoice;
        return $this;
    }

}