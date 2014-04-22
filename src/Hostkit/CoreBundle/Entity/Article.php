<?php

namespace Hostkit\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Article
{    
    /**
     * @ORM\OneToMany(targetEntity="ArticleI18n", mappedBy="translatable", cascade={"persist"})
     * )
     */
    protected $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }
}