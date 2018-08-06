<?php

namespace Chubbyphp\Tests\Lazy;

use Chubbyphp\Lazy\LazyCommand;
use Interop\Container\ContainerInterface as InteropContainerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface as PsrContainerInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @covers \Chubbyphp\Lazy\LazyCommand
 */
final class LazyCommandTest extends TestCase
{
    public function testInvokeInteropt()
    {
        $container = $this->getInteroptContainer([
            'service' => function (InputInterface $input, OutputInterface $output) {
                return 5;
            },
        ]);

        $input = $this->getInput();
        $output = $this->getOutput();

        $argument = new InputArgument('argument');

        $command = new LazyCommand(
            $container,
            'service',
            'name',
            [$argument],
            'description',
            'help'
        );

        self::assertSame('name', $command->getName());
        self::assertSame($argument, $command->getDefinition()->getArgument('argument'));
        self::assertSame('description', $command->getDescription());
        self::assertSame('help', $command->getHelp());
        self::assertSame(5, $command->run($input, $output));
    }

    public function testInvokePsr()
    {
        $container = $this->getPsrContainer([
            'service' => function (InputInterface $input, OutputInterface $output) {
                return 5;
            },
        ]);

        $input = $this->getInput();
        $output = $this->getOutput();

        $argument = new InputArgument('argument');

        $command = new LazyCommand(
            $container,
            'service',
            'name',
            [$argument],
            'description',
            'help'
        );

        self::assertSame('name', $command->getName());
        self::assertSame($argument, $command->getDefinition()->getArgument('argument'));
        self::assertSame('description', $command->getDescription());
        self::assertSame('help', $command->getHelp());
        self::assertSame(5, $command->run($input, $output));
    }

    /**
     * @param array $services
     *
     * @return InteropContainerInterface
     */
    private function getInteroptContainer(array $services): InteropContainerInterface
    {
        /** @var InteropContainerInterface|MockObject $container */
        $container = $this->getMockBuilder(InteropContainerInterface::class)->setMethods(['get'])->getMockForAbstractClass();

        $container
            ->expects(self::any())
            ->method('get')
            ->willReturnCallback(function (string $id) use ($services) {
                return $services[$id];
            })
        ;

        return $container;
    }

    /**
     * @param array $services
     *
     * @return PsrContainerInterface
     */
    private function getPsrContainer(array $services): PsrContainerInterface
    {
        /** @var PsrContainerInterface|MockObject $container */
        $container = $this->getMockBuilder(PsrContainerInterface::class)->setMethods(['get'])->getMockForAbstractClass();

        $container
            ->expects(self::any())
            ->method('get')
            ->willReturnCallback(function (string $id) use ($services) {
                return $services[$id];
            })
        ;

        return $container;
    }

    /**
     * @return Input|MockObject
     */
    private function getInput(): InputInterface
    {
        return $this->getMockBuilder(InputInterface::class)->setMethods([])->getMockForAbstractClass();
    }

    /**
     * @return Output|MockObject
     */
    private function getOutput(): OutputInterface
    {
        return $this->getMockBuilder(OutputInterface::class)->setMethods([])->getMockForAbstractClass();
    }
}
