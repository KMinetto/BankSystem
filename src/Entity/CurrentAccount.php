<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity]
class CurrentAccount extends BankAccount
{
  #[ORM\Column(type: Types::FLOAT)]
  private ?float $overdraftLimit = null;

  public function getOverdraftLimit(): ?float
  {
    return $this->overdraftLimit;
  }

  public function setOverdraftLimit(?float $overdraftLimit): self
  {
    $this->overdraftLimit = $overdraftLimit;

    return $this;
  }
}