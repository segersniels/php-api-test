<?php

require __DIR__ . '/store.php';
require __DIR__ . '/discount.php';
class API
{
    private $store;
    private $discount;

    public function __construct($settings)
    {
        $this->store = new Store($settings);
        $this->discount = new Discount($this->store);
    }

    public function getProducts()
    {
        return $this->store->getProducts();
    }

    public function getProduct($id)
    {
        return $this->store->getProduct($id);
    }

    public function getCustomers()
    {
        return $this->store->getCustomers();
    }

    public function getCustomer($id)
    {
        return $this->store->getCustomer($id);
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
        $discounted_switches = $this->discount->calculateSwitchDiscount($items);
        $discounted_tools = $this->discount->calculateToolDiscount($discounted_switches);
        $discounted_total = $this->discount->calculateRevenueDiscount($id, $discounted_tools);

        // Apply discounts on initial order
        $discounted['total'] = (string) $discounted_total;
        $discounted['items'] = $discounted_tools;

        return json_encode($discounted);
    }
}
