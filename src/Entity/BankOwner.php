<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
class BankOwner extends User
{
  #[ORM\OneToMany(mappedBy: 'bankOwner', targetEntity: Customer::class, cascade: ['persist', 'remove'])]
  private Collection $customers;

  public function __construct()
  {
      $this->customers = new ArrayCollection();
  }

  public function getCustomers(): Collection
  {
      return $this->customers;
  }

  public function addCustomer(Customer $customer): self
  {
      if (!$this->customers->contains($customer)) {
          $this->customers->add($customer);
          $customer->setBankOwner($this);
      }

      return $this;
  }

  public function removeCustomer(Customer $customer): self
  {
      if ($this->customers->removeElement($customer)) {
          // Unset the owning side
          if ($customer->getBankOwner() === $this) {
              $customer->setBankOwner(null);
          }
      }

      return $this;
  }
}