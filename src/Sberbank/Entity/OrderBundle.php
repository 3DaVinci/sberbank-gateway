<?php

namespace Sberbank\Entity;

class OrderBundle extends AbstractEntity
{
    protected string $orderCreationDate = '';

    protected ?array $customerDetails = null;

    protected array $cartItems = [];

    /**
     * @return mixed
     */
    public function getOrderCreationDate()
    {
        return $this->orderCreationDate;
    }

    /**
     * @param mixed $orderCreationDate
     * @return OrderBundle
     */
    public function setOrderCreationDate($orderCreationDate): OrderBundle
    {
        $this->orderCreationDate = $orderCreationDate;
        return $this;
    }

    /**
     * @return array
     */
    public function getCustomerDetails(): array
    {
        return $this->customerDetails;
    }

    /**
     * @param mixed $customerDetails
     * @return OrderBundle
     */
    public function setCustomerDetails(array $customerDetails): OrderBundle
    {
        $this->customerDetails = $customerDetails;
        return $this;
    }

    /**
     * @return array
     */
    public function getCartItems(): array
    {
        return $this->cartItems;
    }

    /**
     * @param Item[]|array $cartItems
     * @return OrderBundle
     */
    public function setCartItems(array $cartItems): OrderBundle
    {
        foreach ($cartItems as $cartItem) {
            if ($cartItem instanceof AbstractEntity) {
                $this->cartItems['items'][] = $cartItem->toArray();
            } else {
                $this->cartItems['items'][] = $cartItem;
            }
        }

        return $this;
    }


}