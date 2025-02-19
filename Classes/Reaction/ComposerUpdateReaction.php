<?php

declare(strict_types=1);

namespace WapplerSystems\ComposerReactions\Reaction;

use Override;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Reactions\Model\ReactionInstruction;
use TYPO3\CMS\Reactions\Reaction\ReactionInterface;
use WapplerSystems\ComposerReactions\Service\ComposerService;

class ComposerUpdateReaction implements ReactionInterface
{

    #[Override]
    public static function getType(): string
    {
        return 'composer-update';
    }

    #[Override]
    public static function getDescription(): string
    {
        return 'Update composer package';
    }

    #[Override]
    public static function getIconIdentifier(): string
    {
        return 'actions-extension-refresh';
    }

    public function __construct(
        private readonly ResponseFactoryInterface $responseFactory,
        private readonly StreamFactoryInterface $streamFactory,
        private readonly LoggerInterface $logger,
        private readonly ComposerService $composerService,
        private readonly ExtensionConfiguration $extensionConfiguration
    ) {}

    /** @return string[] */
    private function getComposerPackagesToUpdate(): array {
        $cfgValue = $this->extensionConfiguration->get('composer_update', 'composerPackagesToUpdate');
        return array_filter(array_map('trim', explode(' ', $cfgValue)));
    }

    public function react(
        ServerRequestInterface $request,
        array $payload,
        ReactionInstruction $reaction
    ): ResponseInterface {
        $packagesToUpdate = $this->getComposerPackagesToUpdate();
        if(empty($packagesToUpdate)) {
            $this->logger->warning('No composer packages to update');
            return $this->responseFactory->createResponse(202)->withHeader('Content-Type', 'application/json')->withBody($this->streamFactory->createStream(json_encode(['success' => true, 'packages_updated' => []], JSON_THROW_ON_ERROR)));
        }

        $this->logger->warning('Updating composer packages: ' . implode(', ', $packagesToUpdate));

        $this->composerService->update($packagesToUpdate);

        return $this->responseFactory->createResponse(202)->withHeader('Content-Type', 'application/json')->withBody($this->streamFactory->createStream(json_encode(['success' => true, 'packages_updated' => $packagesToUpdate], JSON_THROW_ON_ERROR)));
    }
}
