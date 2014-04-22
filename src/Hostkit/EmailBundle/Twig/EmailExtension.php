<?php 

namespace Hostkit\EmailBundle\Twig;

class EmailExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('price', array($this, 'priceFilter')),
        );
    }

    public function priceFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = '$'.$price;

        return $price;
    }

    public function getName()
    {
        return 'acme_extension';
    }
	
	public function getGlobals()
    {
        return array(
            'url' => 'http://test.com'
        );
    }
}