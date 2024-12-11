<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity]
class SavingsAccount extends BankAccount
{
  #[ORM\Column(type: Types::FLOAT)]
  private ?float $interestRate = null;

  public function getInterestRate(): ?float
  {
    return $this->interestRate;
  }

  public function setInterestRate(?float $interestRate): self
  {
    $this->interestRate = $interestRate;

    return $this;
  }
}