<?php

namespace Chubbyphp\Tests\Lazy;

use Chubbyphp\Lazy\CommandAdapter;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @covers \Chubbyphp\Lazy\CommandAdapter
 */
final class CommandAdapterTest extends TestCase
{
    public function testExecute()
    {
        $command = new class('command:name') extends Command {
            /**
             * @param InputInterface  $input
             * @param OutputInterface $output
             */
            protected function execute(InputInterface $input, OutputInterface $output)
            {
                $output->writeln($input->getArgument('name'));

                return 0;
            }
        };

        $commandAdapter = new CommandAdapter($command);

        /** @var InputInterface|MockObject $input */
        $input = $this->getMockBuilder(InputInterface::class)->getMockForAbstractClass();
        $input->expects(self::once())->method('getArgument')->with('name')->willReturn('test');

        /** @var OutputInterface|MockObject $output */
        $output = $this->getMockBuilder(OutputInterface::class)->getMockForAbstractClass();
        $output->expects(self::once())->method('writeln')->with('test');

        self::assertSame(0, $commandAdapter($input, $output));
    }
}
