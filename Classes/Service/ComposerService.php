<?php

declare(strict_types=1);


namespace WapplerSystems\ComposerReactions\Service;

use Psr\Log\LoggerInterface;
use TYPO3\CMS\Core\Core\Environment;


class ComposerService
{
    public function __construct(
        private readonly ExecService $execService,
        private readonly Environment $environment,
        private readonly LoggerInterface $logger
    ) {    }

    public function update(string|array $packages): void {
        if(is_string($packages)) {
            $packages = [$packages];
        }

        if(!$packages || count($packages) === 0) {
            throw new \InvalidArgumentException('No packages given');
        }

        $typo3Root = $this->environment->getProjectPath();
        $this->logger->info('Updating composer packages: ' . implode(', ', $packages));
        $this->execService->exec(['composer', 'update', ...$packages], cwd: $typo3Root, env: $_ENV);
    }
}
