<?php

namespace App\Domain\V1\WorkOrderItem\Entities;

use App\Domain\V1\BaseEntity\Entities\TenantAwareEntity;
use App\Domain\V1\BaseEntity\ValueObjects\BaseEntityTenantId;
use App\Domain\V1\BaseEntity\ValueObjects\BaseEntityUserId;
use App\Domain\V1\WorkOrderItem\ValueObjects\WorkOrderItemId;
use App\Domain\V1\WorkOrderItem\ValueObjects\WorkOrderItemWorkOrderId;
use App\Domain\V1\WorkOrderItem\ValueObjects\WorkOrderItemExternalCode;
use App\Domain\V1\WorkOrderItem\ValueObjects\WorkOrderItemServiceName;
use App\Domain\V1\WorkOrderItem\ValueObjects\WorkOrderItemQuantity;
use App\Domain\V1\WorkOrderItem\ValueObjects\WorkOrderItemAmount;
use App\Domain\V1\WorkOrderItem\ValueObjects\WorkOrderItemGrossAmount;
use App\Domain\V1\WorkOrderItem\ValueObjects\WorkOrderItemTotalAmount;
use App\Domain\V1\WorkOrderItem\ValueObjects\WorkOrderItemFinalAmount;
use App\Domain\V1\WorkOrderItem\ValueObjects\WorkOrderItemDiscountAmount;
use App\Domain\V1\WorkOrderItem\ValueObjects\WorkOrderItemDiscountPercentage;
use App\Domain\V1\WorkOrderItem\ValueObjects\WorkOrderItemSurchargeAmount;
use App\Domain\V1\WorkOrderItem\ValueObjects\WorkOrderItemSurchargePercentage;

class WorkOrderItem extends TenantAwareEntity
{
    protected ?WorkOrderItemId $id = null;
    protected ?WorkOrderItemWorkOrderId $workOrderId = null;
    protected ?WorkOrderItemExternalCode $externalCode = null;
    protected ?WorkOrderItemServiceName $serviceName = null;
    protected ?WorkOrderItemQuantity $quantity = null;
    protected ?WorkOrderItemAmount $itemAmount = null;
    protected ?WorkOrderItemGrossAmount $grossItemAmount = null;
    protected ?WorkOrderItemTotalAmount $totalAmount = null;
    protected ?WorkOrderItemFinalAmount $finalAmount = null;
    protected ?WorkOrderItemDiscountAmount $discountAmount = null;
    protected ?WorkOrderItemDiscountPercentage $discountPercentage = null;
    protected ?WorkOrderItemSurchargeAmount $surchargeAmount = null;
    protected ?WorkOrderItemSurchargePercentage $surchargePercentage = null;

    public function id(WorkOrderItemId $value): static
    {
        $this->id = $value;
        return $this;
    }

    public function getId(): ?WorkOrderItemId
    {
        return $this->id;
    }

    public function workOrderId(WorkOrderItemWorkOrderId $value): static
    {
        $this->workOrderId = $value;
        return $this;
    }

    public function getWorkOrderId(): ?WorkOrderItemWorkOrderId
    {
        return $this->workOrderId;
    }

    public function externalCode(WorkOrderItemExternalCode $value): static
    {
        $this->externalCode = $value;
        return $this;
    }

    public function getExternalCode(): ?WorkOrderItemExternalCode
    {
        return $this->externalCode;
    }

    public function serviceName(WorkOrderItemServiceName $value): static
    {
        $this->serviceName = $value;
        return $this;
    }

    public function getServiceName(): ?WorkOrderItemServiceName
    {
        return $this->serviceName;
    }

    public function quantity(WorkOrderItemQuantity $value): static
    {
        $this->quantity = $value;
        return $this;
    }

    public function getQuantity(): ?WorkOrderItemQuantity
    {
        return $this->quantity;
    }

    public function itemAmount(WorkOrderItemAmount $value): static
    {
        $this->itemAmount = $value;
        return $this;
    }

    public function getItemAmount(): ?WorkOrderItemAmount
    {
        return $this->itemAmount;
    }

    public function grossItemAmount(WorkOrderItemGrossAmount $value): static
    {
        $this->grossItemAmount = $value;
        return $this;
    }

    public function getGrossItemAmount(): ?WorkOrderItemGrossAmount
    {
        return $this->grossItemAmount;
    }

    public function totalAmount(WorkOrderItemTotalAmount $value): static
    {
        $this->totalAmount = $value;
        return $this;
    }

    public function getTotalAmount(): ?WorkOrderItemTotalAmount
    {
        return $this->totalAmount;
    }

    public function finalAmount(WorkOrderItemFinalAmount $value): static
    {
        $this->finalAmount = $value;
        return $this;
    }

    public function getFinalAmount(): ?WorkOrderItemFinalAmount
    {
        return $this->finalAmount;
    }

    public function discountAmount(WorkOrderItemDiscountAmount $value): static
    {
        $this->discountAmount = $value;
        return $this;
    }

    public function getDiscountAmount(): ?WorkOrderItemDiscountAmount
    {
        return $this->discountAmount;
    }

    public function discountPercentage(WorkOrderItemDiscountPercentage $value): static
    {
        $this->discountPercentage = $value;
        return $this;
    }

    public function getDiscountPercentage(): ?WorkOrderItemDiscountPercentage
    {
        return $this->discountPercentage;
    }

    public function surchargeAmount(WorkOrderItemSurchargeAmount $value): static
    {
        $this->surchargeAmount = $value;
        return $this;
    }

    public function getSurchargeAmount(): ?WorkOrderItemSurchargeAmount
    {
        return $this->surchargeAmount;
    }

    public function surchargePercentage(WorkOrderItemSurchargePercentage $value): static
    {
        $this->surchargePercentage = $value;
        return $this;
    }

    public function getSurchargePercentage(): ?WorkOrderItemSurchargePercentage
    {
        return $this->surchargePercentage;
    }


    /** Hydration only; map scalar values to typed Value Objects. */
    public static function buildEntity(array $data): self
    {
        $entity = new self();
        $map = [
            'id' => fn ($value) => $entity->id(
                new WorkOrderItemId((int) $value)
            ),
            'work_order_id' => fn ($value) => $entity->workOrderId(
                new WorkOrderItemWorkOrderId((int) $value)
            ),
            'external_code' => fn ($value) => $entity->externalCode(
                new WorkOrderItemExternalCode((string) $value)
            ),
            'service_name' => fn ($value) => $entity->serviceName(
                new WorkOrderItemServiceName((string) $value)
            ),
            'quantity' => fn ($value) => $entity->quantity(
                new WorkOrderItemQuantity((string) $value)
            ),
            'item_amount' => fn ($value) => $entity->itemAmount(
                new WorkOrderItemAmount((string) $value)
            ),
            'gross_item_amount' => fn ($value) => $entity->grossItemAmount(
                new WorkOrderItemGrossAmount((string) $value)
            ),
            'total_amount' => fn ($value) => $entity->totalAmount(
                new WorkOrderItemTotalAmount((string) $value)
            ),
            'final_amount' => fn ($value) => $entity->finalAmount(
                new WorkOrderItemFinalAmount((string) $value)
            ),
            'discount_amount' => fn ($value) => $entity->discountAmount(
                new WorkOrderItemDiscountAmount((string) $value)
            ),
            'discount_percentage' => fn ($value) => $entity->discountPercentage(
                new WorkOrderItemDiscountPercentage((string) $value)
            ),
            'surcharge_amount' => fn ($value) => $entity->surchargeAmount(
                new WorkOrderItemSurchargeAmount((string) $value)
            ),
            'surcharge_percentage' => fn ($value) => $entity->surchargePercentage(
                new WorkOrderItemSurchargePercentage((string) $value)
            ),
            'tenant_id' => fn ($value) => $entity->tenantId(
                new BaseEntityTenantId((string) $value)
            ),
            'user_id' => fn ($value) => $entity->userId(
                new BaseEntityUserId((int) $value)
            ),
            'user_update_id' => fn ($value) => $entity->userUpdateId(
                new BaseEntityUserId((int) $value)
            ),
            'active' => fn ($value) => $entity->active((bool) $value),
        ];

        foreach ($map as $key => $setter) {
            if (array_key_exists($key, $data) && $data[$key] !== null) {
                $setter($data[$key]);
            }
        }

        return $entity;
    }
}
