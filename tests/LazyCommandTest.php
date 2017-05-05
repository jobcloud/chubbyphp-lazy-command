<?php

namespace Chubbyphp\Tests\Lazy;

use Chubbyphp\Lazy\LazyCommand;
use Interop\Container\ContainerInterface;
use Symfony\Component\Console\Input\InputInterface as Input;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface as Output;

/**
 * @covers \Chubbyphp\Lazy\LazyCommand
 */
final class LazyCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testInvoke()
    {
        $container = $this->getContainer([
            'service' => function (Input $input, Output $output) {
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
     * @return ContainerInterface
     */
    private function getContainer(array $services): ContainerInterface
    {
        /** @var ContainerInterface|\PHPUnit_Framework_MockObject_MockObject $container */
        $container = $this->getMockBuilder(ContainerInterface::class)->setMethods(['get'])->getMockForAbstractClass();

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
     * @return Input|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getInput(): Input
    {
        return $this->getMockBuilder(Input::class)->setMethods([])->getMockForAbstractClass();
    }

    /**
     * @return Output|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getOutput(): Output
    {
        return $this->getMockBuilder(Output::class)->setMethods([])->getMockForAbstractClass();
    }
}
