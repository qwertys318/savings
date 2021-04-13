<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Saving
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    public $id;

    /**
     * @ORM\ManyToOne(targetEntity="Asset", inversedBy="savings")
     * @ORM\JoinColumn(name="asset_id", referencedColumnName="id")
     */
    public Asset $asset;

    /**
     * @ORM\ManyToOne(targetEntity="Place", inversedBy="savings")
     * @ORM\JoinColumn(name="place_id", referencedColumnName="id")
     */
    public Place $place;

    /**
     * @ORM\Column(type="decimal", precision=16, scale=8)
     */
    public $amount;

    /**
     * @ORM\Column(type="datetime")
     */
    public $createdTs;
}
