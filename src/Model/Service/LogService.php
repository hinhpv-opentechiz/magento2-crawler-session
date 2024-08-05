<?php

declare(strict_types=1);

namespace FriendsOfHyva\CrawlerSession\Model\Service;

use FriendsOfHyva\CrawlerSession\Model\Logger;

class LogService
{
    private $alreadyLogged = false;

    /**
     * @var Logger
     */
    private $logger;

    public function __construct(
        Logger $logger
    ) {
        $this->logger = $logger;
    }

    public function log(string $userAgent): void
    {
        if (!$this->alreadyLogged) {
            $this->logger->debug($userAgent);
            $this->alreadyLogged = true;
        }
    }
}
