<?php

declare(strict_types=1);

namespace Sylius\InvoicingPlugin\Factory;

use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ShopBillingDataInterface;
use Sylius\InvoicingPlugin\Entity\InvoiceShopBillingDataInterface;

final class InvoiceShopBillingDataFactory implements InvoiceShopBillingDataFactoryInterface
{
    /**
     * @var string
     * @psalm-var class-string
     */
    private $className;

    /**
     * @psalm-param class-string $className
     */
    public function __construct(string $className)
    {
        $this->className = $className;
    }

    public function createNew(): InvoiceShopBillingDataInterface
    {
        return new $this->className();
    }

    public function createFromChannel(ChannelInterface $channel): InvoiceShopBillingDataInterface
    {
        $shopBillingData = $channel->getShopBillingData();

        if (null === $shopBillingData) {
            return $this->createNew();
        }

        return $this->createFromShopBillingData($shopBillingData);
    }

    public function createFromShopBillingData(ShopBillingDataInterface $shopBillingData): InvoiceShopBillingDataInterface
    {
        $invoiceShopBillingData = $this->createNew();

        $invoiceShopBillingData->setCompany($shopBillingData->getCompany());
        $invoiceShopBillingData->setTaxId($shopBillingData->getTaxId());
        $invoiceShopBillingData->setCountryCode($shopBillingData->getCountryCode());
        $invoiceShopBillingData->setStreet($shopBillingData->getStreet());
        $invoiceShopBillingData->setCity($shopBillingData->getCity());
        $invoiceShopBillingData->setPostcode($shopBillingData->getPostcode());

        return $invoiceShopBillingData;
    }
}