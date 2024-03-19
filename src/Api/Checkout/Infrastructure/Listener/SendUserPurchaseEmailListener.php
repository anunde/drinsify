<?php

namespace App\Api\Checkout\Infrastructure\Listener;

use App\Api\Checkout\Application\SendUserPurchaseEmail\SendUserPurchaseEmailCommand;
use App\Api\Checkout\Application\SendUserPurchaseEmail\SendUserPurchaseEmailCommandHandler;
use App\Api\Checkout\Domain\Event\OrderPaidEvent;
use App\Api\Checkout\Infrastructure\Mailing\SubjectMapping;
use App\Api\Checkout\Infrastructure\Mailing\TemplateMapping;

final readonly class SendUserPurchaseEmailListener
{
    public function __construct(
        private SendUserPurchaseEmailCommandHandler $handler
    )
    {
    }

    public function onOrderPaid(OrderPaidEvent $event): void
    {
        $this->handler->__invoke(
            new SendUserPurchaseEmailCommand(
                $event->getUserId(),
                SubjectMapping::SUBJECT_MAPPING['purchase'],
                TemplateMapping::TEMPLATE_MAPPING['purchase']
            )
        );
    }
}