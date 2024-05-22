<?php

declare(strict_types=1);

namespace App\Core\Domain\User\Entity;

use App\Core\Domain\Order\Entity\Order;
use App\Core\Domain\User\Enum\UserRoleType;
use App\Shared\Domain\Primitive\Entity\Entity;
use App\Shared\Domain\Primitive\Entity\HasTimestampsInterface;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User extends Entity implements HasTimestampsInterface, UserInterface, PasswordAuthenticatedUserInterface
{
    #[Assert\Length(max: 50)]
    private ?string $name = null;

    #[Assert\Email]
    #[Assert\Length(max: 100)]
    private ?string $email = null;

    #[Assert\Length(max: 50)]
    private ?string $password = null;

    private ?DateTimeInterface $createdAt = null;

    private ?DateTimeInterface $updatedAt = null;

    private array $roles = [];

    private Collection $deliveryAddresses;

    private Collection $orders;

    public function __construct()
    {
        $this->deliveryAddresses = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function addRole(UserRoleType $role): static
    {
        if (!$this->hasRole($role)) {
            $this->roles[] = $role->value;
        }

        return $this;
    }

    public function setRoles(array $roles): static
    {
        $this->roles = array_unique($roles);

        return $this;
    }

    public function hasAdminRole(): bool
    {
        return $this->hasRole(UserRoleType::ROLE_ADMIN);
    }

    public function hasRole(UserRoleType $role): bool
    {
        return in_array($role->value, $this->getRoles());
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getPrimaryDeliveryAddress(): ?UserDeliveryAddress
    {
        $firstDeliveryAddress = $this->getDeliveryAddresses()->first();

        return $firstDeliveryAddress instanceof UserDeliveryAddress ? $firstDeliveryAddress : null;
    }

    /**
     * @return Collection<int, UserDeliveryAddress>
     */
    public function getDeliveryAddresses(): Collection
    {
        return $this->deliveryAddresses;
    }

    public function addDeliveryAddress(UserDeliveryAddress $deliveryAddress): static
    {
        if (!$this->deliveryAddresses->contains($deliveryAddress)) {
            $this->deliveryAddresses->add($deliveryAddress);
            $deliveryAddress->setUser($this);
        }

        return $this;
    }

    public function removeDeliveryAddress(UserDeliveryAddress $deliveryAddress): static
    {
        if ($this->deliveryAddresses->removeElement($deliveryAddress)) {
            if ($deliveryAddress->getUser() === $this) {
                $deliveryAddress->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setUser($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): static
    {
        if ($this->orders->removeElement($order)) {
            if ($order->getUser() === $this) {
                $order->setUser(null);
            }
        }

        return $this;
    }

    public function onPrePersist(): void
    {
        $this->addRole(UserRoleType::ROLE_USER);
    }

    public function eraseCredentials(): void
    {
        // Clear it temporary, sensitive data
        // $this->plainPassword = null;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
