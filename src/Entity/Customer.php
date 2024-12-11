<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Customer extends User
{
  #[ORM\ManyToOne(targetEntity: BankOwner::class, inversedBy: 'customers')]
  #[ORM\JoinColumn(nullable: false)] // Empêche un Customer d'être sans BankOwner
  private ?BankOwner $bankOwner = null;

  /**
   * @var Collection<int, BankAccount>
   */
  #[ORM\OneToMany(targetEntity: BankAccount::class, mappedBy: 'customer')]
  private Collection $bankAccounts;

  public function __construct()
  {
      $this->bankAccounts = new ArrayCollection();
  }

  public function getBankOwner(): ?BankOwner
  {
      return $this->bankOwner;
  }

  public function setBankOwner(?BankOwner $bankOwner): self
  {
      $this->bankOwner = $bankOwner;

      return $this;
  }

  /**
   * @return Collection<int, BankAccount>
   */
  public function getBankAccounts(): Collection
  {
      return $this->bankAccounts;
  }

  public function addBankAccount(BankAccount $bankAccount): static
  {
      if (!$this->bankAccounts->contains($bankAccount)) {
          $this->bankAccounts->add($bankAccount);
          $bankAccount->setCustomer($this);
      }

      return $this;
  }

  public function removeBankAccount(BankAccount $bankAccount): static
  {
      if ($this->bankAccounts->removeElement($bankAccount)) {
          // set the owning side to null (unless already changed)
          if ($bankAccount->getCustomer() === $this) {
              $bankAccount->setCustomer(null);
          }
      }

      return $this;
  }
}