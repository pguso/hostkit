<?php
namespace Hostkit\ClientBundle\Extensions;

use Hostkit\ClientBundle\Extensions\TwigVars;

class TwigVarsExtension extends \Twig_Extension
{
    protected $twigVars;

    function __construct(TwigVars $twigVars) {
        $this->twigVars = $twigVars;
    }

    public function getGlobals() {
        return array(
            'twigVars' => $this->twigVars
        );
    }

    public function getName()
    {
        return 'twigVars';
    }

}