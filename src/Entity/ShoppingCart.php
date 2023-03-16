<?php

namespace App\Entity;

use Exception;

final class ShoppingCart
{
    /**
     * @var CartItem[]
     */
    private array $items = [];

    /**
     * Add a {@link CartItem} to the ShoppingCart
     *
     * @param CartItem $item
     * @return void
     */
    public function addItem(CartItem $item): void
    {
        $this->items[] = $item;
    }

    /**
     * Get items
     *
     * @return CartItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getTotal(): float
    {
        $total = 0;
        if (count($this->items) <= 0) {
            return 0;
        }
        list($listAProduct, $listBProduct, $listCProduct, $VVoucher, $RVoucher, $SVoucher) = $this->filterProductsAndVouchers($this->items);

        $countCProducts = count($listCProduct);

        // Calculate discount for Product A based on Voucher V
        $totalAProducts = $this->calculateVoucherVDiscounts($listAProduct, $VVoucher);
        $total += $totalAProducts;

        // Calculate discount for Product B based on Voucher R
        $totalBProducts = $this->calculateVouchRDiscounts($listBProduct, $RVoucher);
        $total += $totalBProducts;

        // Add to total the list of Product C.
        if ($countCProducts > 0) {
            $totalCProducts = 0;

            foreach ($listCProduct as $product) {
                $totalCProducts += $product->getPrice();
            }

            $total += $totalCProducts;
        }

        // Final discount, Voucher S.
        if (isset($SVoucher) && $total > 40) {
            $total -= $total * $SVoucher->getDiscount();
        }

        return $total;
    }

    /**
     * Undocumented function
     *
     * @param CartItem[] $items
     * @return array<array<Voucher|Product[]>>
     */
    private function filterProductsAndVouchers(array $items): array
    {
        $listAProduct = array();
        $listBProduct = array();
        $listCProduct = array();
        $VVoucher = null;
        $RVoucher = null;
        $SVoucher = null;

        foreach ($items as $item) {
            switch ($item->getId()) {
                case 'A':
                    array_push($listAProduct, $item);
                    break;
                case 'B':
                    array_push($listBProduct, $item);
                    break;
                case 'C':
                    array_push($listCProduct, $item);
                    break;
                case 'V':
                    $VVoucher = $item;
                    break;
                case 'R':
                    $RVoucher = $item;
                    break;
                case 'S':
                    $SVoucher = $item;
                    break;
                default:
                    throw new Exception("CartItem type not recognized");
            }
        }
        return [$listAProduct, $listBProduct, $listCProduct, $VVoucher, $RVoucher, $SVoucher];
    }

    /**
     * Calculate the discount on Product A if there's a second Product A and a V Voucher.
     *
     * @param Product[] $listAProduct
     * @param Voucher $VVoucher
     * @return float
     */
    private function calculateVoucherVDiscounts(array $listAProduct, Voucher|null $VVoucher): float
    {
        $countAProducts = count($listAProduct);
        if ($countAProducts === 0) {
            return 0;
        }
        $totalAProducts = 0;

        for ($i = 0; $i < $countAProducts; $i++) {
            $product = $listAProduct[$i];
            if (isset($VVoucher) && $countAProducts >= 2 && $i === 1) {
                $totalAProducts += $product->getPrice() - $product->getPrice() * $VVoucher->getDiscount();
            } else {
                $totalAProducts += $product->getPrice();
            }
        }

        return $totalAProducts;
    }

    /**
     * Discount X€ to Product B if there's R Vocuher.
     *
     * @param Product[] $listBProduct
     * @param Voucher $RVoucher
     * @return float
     */
    private function calculateVouchRDiscounts(array $listBProduct, Voucher|null $RVoucher): float
    {
        $countBProducts = count($listBProduct);
        if ($countBProducts === 0) {
            return 0;
        }
        $totalBProducts = 0;

        foreach ($listBProduct as $product) {
            if (isset($RVoucher)) {
                $totalBProducts += $product->getPrice() - $RVoucher->getDiscount();
            } else {
                $totalBProducts += $product->getPrice();
            }
        }

        return $totalBProducts;
    }
}
