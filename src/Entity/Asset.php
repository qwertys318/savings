<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Asset
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    public $id;

    /**
     * @ORM\ManyToOne(targetEntity="RateProvider", inversedBy="assets")
     * @ORM\JoinColumn(name="rate_provider_id", referencedColumnName="id", nullable=true)
     */
    public ?RateProvider $rateProvider;

    /**
     * @ORM\Column(type="string", length=64)
     */
    public $name;

    /**
     * @ORM\Column(type="smallint")
     */
    public $decimals;

    /**
     * @ORM\Column(type="decimal", precision=16, scale=8)
     */
    public $rate;

    /**
     * @ORM\Column(type="json")
     */
    public $rateProviderParams;

    /**
     * @ORM\Column(type="datetime")
     */
    public $createdTs;
}
