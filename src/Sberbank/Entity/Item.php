<?php

namespace Sberbank\Entity;

class Item extends AbstractEntity
{
    /**
     * Уникальный идентификатор товарной позиции внутри корзины заказа.
     * @var string
     */
    protected string $positionId = '';

    /**
     * Наименование или описание товарной позиции в свободной форме не более 100 символов.
     * @var string
     */
    protected string $name = '';

    /**
     * Элемент описывающий общее количество товарных позиций одного positionId и их меру измерения.
     * @var array
     */
    protected array $quantity = ['value' => 1, 'measure' => 'шт'];

    /**
     * Номер (идентификатор) товарной позиции в системе магазина.
     * @var string
     */
    protected string $itemCode = '';

    /**
     * Дополнительный тег с атрибутами описания налога.
     * @var Tax
     */
    protected Tax $tax;

    /**
     * Стоимость одной товарной позиции в минимальных единицах валюты. Обязательно для продавцов с фискализацией.
     * @var int
     */
    protected int $itemPrice = 0;

    /**
     * Блок атрибутов товарной позиции.
     * @var array|array[]
     */
    protected array $itemAttributes = ['attributes' => []];

    /**
     * @return string
     */
    public function getPositionId(): string
    {
        return $this->positionId;
    }

    /**
     * @param string $positionId
     * @return Item
     */
    public function setPositionId(string $positionId): Item
    {
        $this->positionId = $positionId;
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
     * @return Item
     */
    public function setName(string $name): Item
    {
        $this->name = mb_substr($name, 0, 100);
        return $this;
    }

    /**
     * @return array
     */
    public function getQuantity(): array
    {
        return $this->quantity;
    }

    /**
     * @param array $quantity
     * @return Item
     */
    public function setQuantity(array $quantity): Item
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return string
     */
    public function getItemCode(): string
    {
        return $this->itemCode;
    }

    /**
     * @param string $itemCode
     * @return Item
     */
    public function setItemCode(string $itemCode): Item
    {
        $this->itemCode = $itemCode;
        return $this;
    }

    /**
     * @return Tax
     */
    public function getTax(): Tax
    {
        return $this->tax;
    }

    /**
     * @param Tax $tax
     * @return Item
     */
    public function setTax(Tax $tax): Item
    {
        $this->tax = $tax;
        return $this;
    }

    /**
     * @return int
     */
    public function getItemPrice(): int
    {
        return $this->itemPrice;
    }

    /**
     * @param int $itemPrice
     * @return Item
     */
    public function setItemPrice(int $itemPrice): Item
    {
        $this->itemPrice = $itemPrice;
        return $this;
    }

    /**
     * @return array|array[]
     */
    public function getItemAttributes(): array
    {
        return $this->itemAttributes;
    }

    /**
     * @param ItemAttribute[]|array|array[] $itemAttributes
     * @return Item
     */
    public function setItemAttributes(array $itemAttributes): Item
    {
        foreach ($itemAttributes as $itemAttribute) {
            if ($itemAttribute instanceof AbstractEntity) {
                $this->itemAttributes['attributes'][] = $itemAttribute->toArray();
            } else {
                $this->itemAttributes['attributes'][] = $itemAttribute;
            }
        }

        return $this;
    }
}