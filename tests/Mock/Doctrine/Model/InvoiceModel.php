<?php


namespace Seacommerce\MapperBundle\Test\Mock\Doctrine\Model;


class InvoiceModel
{
    /**
     * @var int|null
     */
    private $id;

    /** @var int|null */
    private $customerId;

    /**
     * @var InvoiceItemModel[]
     */
    private $items = [];

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return InvoiceModel
     */
    public function setId(?int $id): InvoiceModel
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCustomerId(): ?int
    {
        return $this->customerId;
    }

    /**
     * @param int|null $customerId
     * @return InvoiceModel
     */
    public function setCustomerId(?int $customerId): InvoiceModel
    {
        $this->customerId = $customerId;
        return $this;
    }

    /**
     * @return InvoiceItemModel[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param InvoiceItemModel[] $items
     * @return InvoiceModel
     */
    public function setItems(array $items): InvoiceModel
    {
        $this->items = $items;
        return $this;
    }
}