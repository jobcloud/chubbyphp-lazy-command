<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Lazy\Unit;

use Chubbyphp\Lazy\CommandAdapter;
use Chubbyphp\Mock\Call;
use Chubbyphp\Mock\MockByCallsTrait;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @covers \Chubbyphp\Lazy\CommandAdapter
 *
 * @internal
 */
final class CommandAdapterTest extends TestCase
{
    use MockByCallsTrait;

    public function testExecute()
    {
        /** @var InputInterface|MockObject $input */
        $input = $this->getMockByCalls(InputInterface::class, [
            Call::create('getArgument')->with('name')->willReturn('test'),
        ]);

        /** @var OutputInterface|MockObject $output */
        $output = $this->getMockByCalls(OutputInterface::class, [
            Call::create('writeln')->with('test', 0),
        ]);

        $command = new class('command:name') extends Command {
            protected function execute(InputInterface $input, OutputInterface $output)
            {
                $output->writeln($input->getArgument('name'));

                return 0;
            }
        };

        $commandAdapter = new CommandAdapter($command);

        self::assertSame(0, $commandAdapter($input, $output));
    }
}
