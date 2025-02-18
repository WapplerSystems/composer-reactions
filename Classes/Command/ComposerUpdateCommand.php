<?php

declare(strict_types=1);

namespace WapplerSystems\ComposerReactions\Command;

use Override;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Core\Environment;
use WapplerSystems\ComposerReactions\Reaction\ComposerUpdateReaction;
use WapplerSystems\ComposerReactions\Service\ComposerService;

class ComposerUpdateCommand extends Command
{
    public function __construct(
        private readonly Environment $environment,
        private readonly ComposerService $composerService,
        private readonly ComposerUpdateReaction $composerUpdateReaction
    ) {
        parent::__construct();
    }

    #[Override]
    protected function configure(): void
    {
        $this->addArgument('package', InputArgument::OPTIONAL, 'Package to update', 'wapplersystems/github-webhook');
    }

    #[Override]
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        if(empty($input->getArgument('package'))) {
            $output->writeln("Emitting reaction");
            $this->composerUpdateReaction->react(null, [], null);
            $output->writeln("Done!");
            return Command::SUCCESS;
        }

        $output->writeln("composer update " . $input->getArgument('package'));
        $this->composerService->update($input->getArgument('package'));
        $output->writeln("Done!");

        return Command::SUCCESS;
    }
}
