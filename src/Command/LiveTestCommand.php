<?php
namespace App\Command;

use App\Tier\BO\ClientBO;
// use App\Tier\BO\InvoiceBO;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\SerializerInterface;

// class BO_Invoice
// {
//     public $date;
//     public $quantity;
// }

// class BO_Client
// {
//     public $firstName;
//     public $lastName;
//     /** @var BO_Invoice[] $invoices */
//     public $invoices;
// }

class LiveTestCommand extends Command
{
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;

        parent::__construct();
    }

    protected function configure()
    {
        $this
        ->setName('app:livetest')
        ->setDescription('Live testing.')
        ->setHelp('This command allows execute code for testing purposes.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $json = '
        {
            "firstName":"John",
            "lastName":"DOE",
            "invoices":[
                {"date":"20190101","quantity":10},
                {"date":"20190326","quantity":8, "tata":"hihi"},
                {}
            ]
        }';

        $client = $this->serializer->deserialize($json,ClientBO::class,'json');
        dump($client);
    }
}