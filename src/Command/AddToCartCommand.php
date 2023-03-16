<?php

namespace App\Command;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\ShoppingCart;
use App\Entity\Product;
use App\Entity\Voucher;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(
    name: 'flora:calculate:cart',
    description: 'Calculates the total of the cart.',
)]
class AddToCartCommand extends Command
{

    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('example', null, InputOption::VALUE_REQUIRED)
            ->addOption('test', null, InputOption::VALUE_REQUIRED, '', false);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var int */
        $id = $input->getOption('example');
        /** @var bool */
        $test = $input->getOption('test');
        if ($id == 1) {
            $this->example1($output, $test);
        } else if ($id == 2) {
            $this->example2($output, $test);
        }

        return Command::SUCCESS;
    }

    private function example1(OutputInterface $output, bool $test): void
    {
        if (!$test) {
            $output->write('========================Flora Candidate Begin======================' . PHP_EOL);
            $output->write(PHP_EOL);
        }

        try {
            $shoppingCart = new ShoppingCart();

            $productA = new Product('A', 10);
            $productB = new Product('B', 8);
            $productC = new Product('C', 12);

            $voucherV = new Voucher('V', 0.10);
            $voucherS = new Voucher('S', 0.05);

            // Example 1.
            $shoppingCart->addItem($productA);
            $shoppingCart->addItem($productC);
            $shoppingCart->addItem($voucherS);
            $shoppingCart->addItem($productA);
            $shoppingCart->addItem($voucherV);
            $shoppingCart->addItem($productB);

            $total = $shoppingCart->getTotal();

            if (!$test) {
                $output->writeln('+-------------------- Example 1 ----------+---------+');
                $output->writeln('| items                                   | total    |');
                $output->writeln('+-----------------------------------------+---------+');

                foreach ($shoppingCart->getItems() as $item) {
                    if ($item instanceof Voucher) {
                        $output->writeln('| ' . $item->getId() . '                                       | ' . $item->getDiscount() . '    |');
                    }
                    if ($item instanceof Product) {
                        $output->writeln('| ' . $item->getId() . '                                       | ' . $item->getPrice() . '      |');
                    }
                }

                $output->writeln('+---------------- total cart: ' . $total . '€ -----------------+');

                $output->writeln('');
            }

            $output->writeln(number_format((float)$total, 2, '.', ''));
        } catch (Exception $error) {
            throw $error;
        }
    }

    private function example2(OutputInterface $output, bool $test): void
    {
        if (!$test) {
            $output->writeln('');
        }

        try {
            $shoppingCart = new ShoppingCart();

            $productA = new Product('A', 10);
            $productB = new Product('B', 8);
            $productC = new Product('C', 12);

            $voucherV = new Voucher('V', 0.10);
            $voucherR = new Voucher('R', 5);
            $voucherS = new Voucher('S', 0.05);

            // Example 2.
            $shoppingCart->addItem($productA);
            $shoppingCart->addItem($voucherS);
            $shoppingCart->addItem($productA);
            $shoppingCart->addItem($voucherV);
            $shoppingCart->addItem($productB);
            $shoppingCart->addItem($voucherR);
            $shoppingCart->addItem($productC);
            $shoppingCart->addItem($productC);
            $shoppingCart->addItem($productC);

            $total = $shoppingCart->getTotal();


            if (!$test) {
                $output->writeln('+-------------------- Example 2 ----------+---------+');
                $output->writeln('| items                                   | total    |');
                $output->writeln('+-----------------------------------------+---------+');

                foreach ($shoppingCart->getItems() as $item) {
                    if ($item instanceof Voucher) {
                        $output->writeln('| ' . $item->getId() . '                                       | ' . $item->getDiscount() . '    |');
                    }
                    if ($item instanceof Product) {
                        $output->writeln('| ' . $item->getId() . '                                       | ' . $item->getPrice() . '      |');
                    }
                }

                $output->writeln('+---------------- total cart: ' . $total . '€ -----------------+');

                $output->writeln('');
                $output->writeln('========================Flora Candidate End========================');
            }

            $output->writeln(number_format((float)$total, 2, '.', ''));
        } catch (Exception $error) {
            throw $error;
        }
    }
}
