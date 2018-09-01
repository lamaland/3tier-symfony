<?php

namespace App\Tier\BO;

use Doctrine\ORM\Mapping AS ORM;
use App\Tier\BO\InvoiceBO;

/**
 * @ORM\Entity
 * @ORM\Table(name="client")
 */
class ClientBO
{
    /** @var int $id
     *  @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue */
    public $id;
    
    /** @var string $firstName
     *  @ORM\Column(type="string") */
    public $firstName;
    
    /** @var string $lastName
     *  @ORM\Column(type="string") */
    public $lastName;
    
    /** @var string $city
     *  @ORM\Column(type="string", nullable=true) */
    public $city;
    
    /** @var InvoiceBO[] $invoices */
    public $invoices;

    public function getDisplayName()
    {
        return implode(' ',[$this->firstName, $this->lastName]);
    }
}