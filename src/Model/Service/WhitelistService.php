<?php

declare(strict_types=1);

namespace FriendsOfHyva\CrawlerSession\Model\Service;

use FriendsOfHyva\CrawlerSession\Helper\Config;

class WhitelistService
{
    /**
     * @var Config
     */
    private $config;

    public function __construct(
        Config $config
    ) {
        $this->config = $config;
    }

    public function isWhitelisted(string $userAgent): bool
    {
        if (in_array($userAgent, $this->config->getWhitelist())) {
            return true;
        }

        return false;
    }
}
