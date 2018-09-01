<?php

namespace App\Tier\BO;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="invoice")
 */
class InvoiceBO
{
    /** @var int $id @ORM\Id
     *  @ORM\Column(type="integer") @ORM\GeneratedValue */
    public $id;
    
    /** @var int $idClient
     *  @ORM\Column(type="string") */
    public $idClient;
    
    /** @var \DateTime $date
     *  @ORM\Column(type="string") */
    public $date;

    /** @var int $quantity
     *  @ORM\Column(type="integer") */
    public $quantity;
}