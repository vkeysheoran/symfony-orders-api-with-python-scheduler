<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrdersRepository::class)
 */
class Orders
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $delivery_address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $billing_address;

    /**
     * @ORM\Column(type="date")
     */
    private $expected_delivery;

    /**
     * @ORM\Column(type="integer")
     */
    private $customer_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $order_items;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_delayed;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDeliveryAddress(): ?string
    {
        return $this->delivery_address;
    }

    public function setDeliveryAddress(string $delivery_address): self
    {
        $this->delivery_address = $delivery_address;

        return $this;
    }

    public function getBillingAddress(): ?string
    {
        return $this->billing_address;
    }

    public function setBillingAddress(string $billing_address): self
    {
        $this->billing_address = $billing_address;

        return $this;
    }

    public function getExpectedDelivery(): ?\DateTimeInterface
    {
        return $this->expected_delivery;
    }

    public function setExpectedDelivery(\DateTimeInterface $expected_delivery): self
    {
        $this->expected_delivery = $expected_delivery;

        return $this;
    }

    public function getCustomerId(): ?int
    {
        return $this->customer_id;
    }

    public function setCustomerId(int $customer_id): self
    {
        $this->customer_id = $customer_id;

        return $this;
    }

    public function getOrderItems(): ?string
    {
        return $this->order_items;
    }

    public function setOrderItems(string $order_items): self
    {
        $this->order_items = $order_items;

        return $this;
    }

    public function getIsDelayed(): ?bool
    {
        return $this->is_delayed;
    }

    public function setIsDelayed(bool $is_delayed): self
    {
        $this->is_delayed = $is_delayed;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }
}
