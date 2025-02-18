<?php

declare(strict_types=1);


namespace WapplerSystems\ComposerReactions\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ExecService
{

    public function __construct(
        private readonly LoggerInterface $logger
    )
    {
    }

    public function exec(array $cmdarray, ?string $cwd = null, ?string $input = null): void
    {
        $this->logger->warning("Executing: " . join(" ", $cmdarray));
        $process = new Process(
            $cmdarray,
            cwd: $cwd,
            input: $input
        );
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }

    public function shell(array $cmdarray, ?string $cwd = null, ?string $input = null): void
    {
        $shellcmd = join(" ", array_map("escapeshellarg", $cmdarray));
        $this->exec(
            [
                "/bin/sh",
                "-c",
                $shellcmd
            ],
            cwd: $cwd,
            input: $input
        );
    }
}
