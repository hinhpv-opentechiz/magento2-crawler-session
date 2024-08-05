<?php

declare(strict_types=1);

namespace FriendsOfHyva\CrawlerSession\Plugin\Magento\Framework\Session;

use FriendsOfHyva\CrawlerSession\Model\Service\LogService;
use Magento\Framework\Session\SessionManager;
use Magento\Framework\App\Request\Http as HttpRequest;
use FriendsOfHyva\CrawlerSession\Helper\Config;
use FriendsOfHyva\CrawlerSession\Model\Service\BlacklistService;
use FriendsOfHyva\CrawlerSession\Model\Service\WhitelistService;

class SessionManagerPlugin
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var HttpRequest
     */
    private $httpRequest;

    /**
     * @var BlacklistService
     */
    private $blacklistService;

    /**
     * @var WhitelistService
     */
    private $whitelistService;

    /**
     * @var LogService
     */
    private $logService;

    public function __construct(
        Config $config,
        HttpRequest $httpRequest,
        BlacklistService $blacklistService,
        WhitelistService $whitelistService,
        LogService $logService
    ) {
        $this->config = $config;
        $this->httpRequest = $httpRequest;
        $this->blacklistService = $blacklistService;
        $this->whitelistService = $whitelistService;
        $this->logService = $logService;
    }

    public function aroundStart(SessionManager $subject, callable $proceed)
    {
        $userAgent = $this->httpRequest->getServer('HTTP_USER_AGENT', '');

        if (
            $this->config->isEnabled() &&
            !$this->whitelistService->isWhitelisted($userAgent) &&
            $this->blacklistService->isBlacklisted($userAgent)
        ) {
            if ($this->config->isLogEnabled()) {
                $this->logService->log($userAgent);
            }

            return $subject;
        }

        return $proceed();
    }
}
