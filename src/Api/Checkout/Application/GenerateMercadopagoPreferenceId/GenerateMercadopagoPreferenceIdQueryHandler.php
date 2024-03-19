<?php

namespace App\Api\Checkout\Application\GenerateMercadopagoPreferenceId;

use App\Api\Checkout\Application\ListUserCart\ListUserCartQuery;
use App\Api\Checkout\Application\ListUserCart\ListUserCartQueryHandler;
use MercadoPago;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

final readonly class GenerateMercadopagoPreferenceIdQueryHandler
{
    public function __construct(
        private ListUserCartQueryHandler $handler,
        private RouterInterface $router
    )
    {
    }

    public function __invoke(GenerateMercadopagoPreferenceIdQuery $query): string
    {
        $cart = $this->handler->__invoke(new ListUserCartQuery($query->getUserId()));

        MercadoPago\SDK::setAccessToken($query->getAccessToken());
        $items = [];
        foreach ($cart as $product) {
            $item = new MercadoPago\Item();
            $item->title = $product['name'];
            $item->picture_url = $product['thumbnail'];
            $item->quantity = $product['quantity'];
            $item->currency_id = "USD";
            $item->unit_price = (float) $product['total'];
            $items []= $item;
        }

        $preference = new MercadoPago\Preference();
        $preference->items = $items;
        $preference->back_urls = array(
            "success" => \sprintf('%s%s', $query->getClientHost(), $query->getWaitingEndpoint() . "/" . $query->getInternalReference()),
            "failure" => \sprintf('%s%s', $query->getClientHost(), $query->getFailureEndpoint()),
            "pending" =>  \sprintf('%s%s', $query->getClientHost(), $query->getWaitingEndpoint() . "/" . $query->getInternalReference())
        );

        //$webhookUrl = $this->router->generate('webhook_mercadopago', [], UrlGeneratorInterface::ABSOLUTE_URL);
        //$preference->notification_url = $webhookUrl;
        $preference->external_reference = $query->getInternalReference();
        $preference->save();

        return $preference->id;
    }
}