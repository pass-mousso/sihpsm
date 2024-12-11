<?php

namespace App\Twig\Subscription;

use App\Service\Subscription\SubscriptionChecker;
use App\Service\ThemeHelper;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFunction;

class SubscriptionExtension extends AbstractExtension implements GlobalsInterface
{
    public function __construct(
        private SubscriptionChecker $subscriptionChecker,
        private ThemeHelper $themeHelper,
    ){}

    public function getGlobals(): array
    {
        return [
            'has_active_subscription' => $this->subscriptionChecker->hasActiveSubscription(),
            'theme' => $this->themeHelper,
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_current_active_subscription', [$this->subscriptionChecker, 'getCurrentActiveSubscription']),
        ];
    }
}