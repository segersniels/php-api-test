<?php

require __DIR__ . '/store.php';

class API
{
    private $store;

    public function __construct($db)
    {
        $this->store = new Store($db);
    }

    public function getProducts()
    {
        $products = $this->store->query('SELECT * FROM products');
        return $products;
    }

    public function getProduct($id)
    {
        $product = $this->store->queryById("SELECT * FROM products WHERE id=?", $id);
        return $product;
    }

    public function getCustomers()
    {
        $customers = $this->store->query('SELECT * FROM customers');
        return $customers;
    }

    public function getCustomer($id)
    {
        $customer = $this->store->queryById("SELECT * FROM customers WHERE id=?", $id);
        return $customer;
    }

    public function calculateSwitchDiscount($items)
    {
        $discounted = $items;
        foreach ($items as $idx => $item) {
            $product = json_decode($this->getProduct($item['product-id']));
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
            $product = json_decode($this->getProduct($item['product-id']));
            if ((int) $product->category == 1) {
                return true;
            }
            return false;
        }));
        // Get lowest priced item
        if ($tools >= 2) {
            $index = 0;
            foreach ($items as $idx => $item) {
                $product = json_decode($this->getProduct($item['product-id']));
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
        $user = json_decode($this->getCustomer($id));
        $revenue = $user->revenue;
        if ((float) $revenue > 1000) {
            $discounted = $total - ($total * 0.1);
        } else {
            $discounted = $total;
        }
        return $discounted;
    }

    public function calculateDiscount($order)
    {
        // Extract order details
        $discounted = $order;
        $id = $order['customer-id'];
        $items = $order['items'];
        $total = $order['total'];

        // Calculate overal revenue 10% discount
        // Calculate category discounts
        $discounted_switches = $this->calculateSwitchDiscount($items);
        $discounted_tools = $this->calculateToolDiscount($discounted_switches);
        $discounted_total = $this->calculateRevenueDiscount($id, $discounted_tools);

        // Apply discounts on initial order
        $discounted['total'] = (string) $discounted_total;
        $discounted['items'] = $discounted_tools;

        return json_encode($discounted);
    }
}
