<?php

namespace Hostkit\CoreBundle\Entity\Factory;

use
    Symfony\Component\Validator\ExecutionContext,
    Symfony\Component\Validator\Constraints as Assert,
    Hostkit\AdminBundle\Entity\Product,
    Hostkit\AdminBundle\Entity\Category;

/**
* @Assert\Callback(methods={"isValidCustomer"})
*/
class ProductFactory
{
    /**
    * @return \Hostkit\AdminBundle\Entity\Category
    */
    public function make()
    {
        $category = new Category();
        //$order->setCustomer($this->customer);

        /*foreach ($this->items as $item) {
            $order->addItem($item);
        }*/

        return $category;
    }
    
}