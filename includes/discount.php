<?php

class Discount
{
    private $store;

    public function __construct($store)
    {
        $this->store = $store;
    }

    public function calculateSwitchDiscount($items)
    {
        $discounted = $items;
        foreach ($items as $idx => $item) {
            $product = json_decode($this->store->getProduct($item['product-id']));
            if ((int) $product->category == 2) {
                $free_items = (int) $item['quantity'] / 5;
                $discounted[$idx]['quantity'] += $free_items;
                $discounted[$idx]['quantity'] = (string) $discounted[$idx]['quantity'];
            }
        }
        return $discounted;
    }

    public function calculateToolDiscount($items)
    {
        $discounted = $items;
        // Calculate tool 20% discount on lowest item
        // Get amount of tools in order
        $tools = count(array_filter($items, function ($item) {
            $product = json_decode($this->store->getProduct($item['product-id']));
            if ((int) $product->category == 1) {
                return true;
            }
            return false;
        }));
        // Get lowest priced item
        if ($tools >= 2) {
            $index = 0;
            foreach ($items as $idx => $item) {
                $product = json_decode($this->store->getProduct($item['product-id']));
                if ((int) $product->category == 1) {
                    if ($items[$index]['total'] > $item['total'] || $idx == 0) {
                        $index = $idx;
                    }
                }
            }
            $discounted[$index]['total'] = (string) ((float) $discounted[$index]['total'] - ((float) $discounted[$index]['total'] * 0.2));
        }
        return $discounted;
    }

    public function calculateRevenueDiscount($id, $items)
    {
        $total = 0;
        $discounted = null;
        foreach ($items as $item) {
            $total += (float) $item['total'];
        }
        // Get user revenue
        $user = json_decode($this->store->getCustomer($id));
        $revenue = $user->revenue;
        if ((float) $revenue > 1000) {
            $discounted = $total - ($total * 0.1);
        } else {
            $discounted = $total;
        }
        return $discounted;
    }
}
