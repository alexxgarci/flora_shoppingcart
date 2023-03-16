<?php

namespace App;

use App\Command\AddToCartCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class AddToCartCommandTest extends TestCase
{
    private Command $command;
    private CommandTester $commandTester;

    protected function setUp(): void
    {
        $application = new Application();
        $application->add(new AddToCartCommand());
        $this->command = $application->find('flora:calculate:cart');
        $this->commandTester = new CommandTester($this->command);
    }

    public function testExecuteShouldReturnExample1()
    {
        $this->commandTester->execute([
            'command' => $this->command->getName(),
            '--example' => 1,
            '--test' => true,
        ]);

        $output = trim($this->commandTester->getDisplay());
        $this->assertEquals(39, $output);
    }

    public function testExecuteShouldReturnExample2()
    {
        $this->commandTester->execute([
            'command' => $this->command->getName(),
            '--id' => 1,
            '--test' => true,
        ]);

        $output = trim($this->commandTester->getDisplay());
        $this->assertEquals(55.1, $output);
    }
}
