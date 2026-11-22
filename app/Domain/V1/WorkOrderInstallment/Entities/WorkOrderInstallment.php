<?php

namespace App\Domain\V1\WorkOrderInstallment\Entities;

use App\Domain\V1\BaseEntity\Entities\TenantAwareEntity;
use App\Domain\V1\BaseEntity\ValueObjects\BaseEntityTenantId;
use App\Domain\V1\BaseEntity\ValueObjects\BaseEntityUserId;
use App\Domain\V1\WorkOrderInstallment\ValueObjects\WorkOrderInstallmentId;
use App\Domain\V1\WorkOrderInstallment\ValueObjects\WorkOrderInstallmentWorkOrderId;
use App\Domain\V1\WorkOrderInstallment\ValueObjects\WorkOrderInstallmentExternalCode;
use App\Domain\V1\WorkOrderInstallment\ValueObjects\WorkOrderInstallmentPaymentMethod;
use App\Domain\V1\WorkOrderInstallment\ValueObjects\WorkOrderInstallmentDocumentNumber;
use App\Domain\V1\WorkOrderInstallment\ValueObjects\WorkOrderInstallmentChargeAmount;
use App\Domain\V1\WorkOrderInstallment\ValueObjects\WorkOrderInstallmentSurchargeAmount;
use App\Domain\V1\WorkOrderInstallment\ValueObjects\WorkOrderInstallmentFinalAmount;

class WorkOrderInstallment extends TenantAwareEntity
{
    protected ?WorkOrderInstallmentId $id = null;
    protected ?WorkOrderInstallmentWorkOrderId $workOrderId = null;
    protected ?WorkOrderInstallmentExternalCode $externalCode = null;
    protected ?WorkOrderInstallmentPaymentMethod $paymentMethod = null;
    protected ?WorkOrderInstallmentDocumentNumber $documentNumber = null;
    protected ?WorkOrderInstallmentChargeAmount $chargeAmount = null;
    protected ?WorkOrderInstallmentSurchargeAmount $surchargeAmount = null;
    protected ?WorkOrderInstallmentFinalAmount $finalAmount = null;

    public function id(WorkOrderInstallmentId $value): static
    {
        $this->id = $value;
        return $this;
    }

    public function getId(): ?WorkOrderInstallmentId
    {
        return $this->id;
    }

    public function workOrderId(WorkOrderInstallmentWorkOrderId $value): static
    {
        $this->workOrderId = $value;
        return $this;
    }

    public function getWorkOrderId(): ?WorkOrderInstallmentWorkOrderId
    {
        return $this->workOrderId;
    }

    public function externalCode(WorkOrderInstallmentExternalCode $value): static
    {
        $this->externalCode = $value;
        return $this;
    }

    public function getExternalCode(): ?WorkOrderInstallmentExternalCode
    {
        return $this->externalCode;
    }

    public function paymentMethod(WorkOrderInstallmentPaymentMethod $value): static
    {
        $this->paymentMethod = $value;
        return $this;
    }

    public function getPaymentMethod(): ?WorkOrderInstallmentPaymentMethod
    {
        return $this->paymentMethod;
    }

    public function documentNumber(WorkOrderInstallmentDocumentNumber $value): static
    {
        $this->documentNumber = $value;
        return $this;
    }

    public function getDocumentNumber(): ?WorkOrderInstallmentDocumentNumber
    {
        return $this->documentNumber;
    }

    public function chargeAmount(WorkOrderInstallmentChargeAmount $value): static
    {
        $this->chargeAmount = $value;
        return $this;
    }

    public function getChargeAmount(): ?WorkOrderInstallmentChargeAmount
    {
        return $this->chargeAmount;
    }

    public function surchargeAmount(WorkOrderInstallmentSurchargeAmount $value): static
    {
        $this->surchargeAmount = $value;
        return $this;
    }

    public function getSurchargeAmount(): ?WorkOrderInstallmentSurchargeAmount
    {
        return $this->surchargeAmount;
    }

    public function finalAmount(WorkOrderInstallmentFinalAmount $value): static
    {
        $this->finalAmount = $value;
        return $this;
    }

    public function getFinalAmount(): ?WorkOrderInstallmentFinalAmount
    {
        return $this->finalAmount;
    }


    /** Hydration only; map scalar values to typed Value Objects. */
    public static function buildEntity(array $data): self
    {
        $entity = new self();
        $map = [
            'id' => fn ($value) => $entity->id(
                new WorkOrderInstallmentId((int) $value)
            ),
            'work_order_id' => fn ($value) => $entity->workOrderId(
                new WorkOrderInstallmentWorkOrderId((int) $value)
            ),
            'external_code' => fn ($value) => $entity->externalCode(
                new WorkOrderInstallmentExternalCode((string) $value)
            ),
            'payment_method' => fn ($value) => $entity->paymentMethod(
                new WorkOrderInstallmentPaymentMethod((string) $value)
            ),
            'document_number' => fn ($value) => $entity->documentNumber(
                new WorkOrderInstallmentDocumentNumber((string) $value)
            ),
            'charge_amount' => fn ($value) => $entity->chargeAmount(
                new WorkOrderInstallmentChargeAmount((string) $value)
            ),
            'surcharge_amount' => fn ($value) => $entity->surchargeAmount(
                new WorkOrderInstallmentSurchargeAmount((string) $value)
            ),
            'final_amount' => fn ($value) => $entity->finalAmount(
                new WorkOrderInstallmentFinalAmount((string) $value)
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
