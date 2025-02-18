<?php

declare(strict_types=1);


namespace WapplerSystems\ComposerReactions\Service;

use Psr\Log\LoggerInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Core\Environment;


class ComposerService
{
    public function __construct(
        private readonly ExecService $execService,
        private readonly Environment $environment,
        private readonly LoggerInterface $logger,
        private readonly ExtensionConfiguration $extensionConfiguration
    ) {    }

    public function getComposerHome() {
        return $this->extensionConfiguration->get('composer_reactions', 'composerHome') ?: $this->environment->getProjectPath() . '/.composer';
    }

    public function update(string|array $packages): void {
        if(is_string($packages)) {
            $packages = [$packages];
        }

        if(!$packages || count($packages) === 0) {
            throw new \InvalidArgumentException('No packages given');
        }

        $typo3Root = $this->environment->getProjectPath();
        $this->logger->info('Updating composer packages: ' . implode(', ', $packages));
        $this->execService->exec(['composer', 'update', ...$packages], cwd: $typo3Root, env: [
            'COMPOSER_HOME' => $this->getComposerHome()
        ]);
    }
}
