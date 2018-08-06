<?php

declare(strict_types=1);

namespace Chubbyphp\Lazy;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CommandAdapter
{
    /**
     * @var Command
     */
    private $command;

    /**
     * @param Command $command
     */
    public function __construct(Command $command)
    {
        $this->command = $command;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null
     */
    public function __invoke(InputInterface $input, OutputInterface $output)
    {
        $execute = \Closure::bind(
            function (InputInterface $input, OutputInterface $output) {
                return $this->execute($input, $output);
            },
            $this->command,
            get_class($this->command)
        );

        return $execute($input, $output);
    }
}
