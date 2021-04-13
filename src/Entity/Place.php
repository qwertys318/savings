<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Place
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    public $name;

    /**
     * @ORM\Column(type="datetime")
     */
    public $createdTs;
}
