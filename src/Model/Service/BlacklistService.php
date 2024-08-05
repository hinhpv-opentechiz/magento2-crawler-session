<?php

declare(strict_types=1);

namespace FriendsOfHyva\CrawlerSession\Model\Service;

use FriendsOfHyva\CrawlerSession\Helper\Config;
use Jaybizzle\CrawlerDetect\CrawlerDetect;

class BlacklistService
{
    /**
     * @var Config
     */
    private $config;
    /**
     * @var CrawlerDetect
     */
    private $crawlerDetect;

    public function __construct(
        Config $config,
        CrawlerDetect $crawlerDetect
    ) {
        $this->config = $config;
        $this->crawlerDetect = $crawlerDetect;
    }

    public function isBlacklisted(string $userAgent): bool
    {
        if (in_array($userAgent, $this->config->getBlacklist())
            || $this->crawlerDetect->isCrawler($userAgent)
        ) {
            return true;
        }

        return false;
    }
}