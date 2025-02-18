<?php

namespace App\Entity;

use App\Repository\ConsultantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConsultantRepository::class)]
class Consultant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateNaiss = null;

    /**
     * @var Collection<int, ConsultantData>
     */
    #[ORM\OneToMany(targetEntity: ConsultantData::class, mappedBy: 'consultant')]
    private Collection $consultantData;

    public function __construct()
    {
        $this->consultantData = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getDateNaiss(): ?\DateTimeImmutable
    {
        return $this->dateNaiss;
    }

    public function setDateNaiss(\DateTimeImmutable $dateNaiss): static
    {
        $this->dateNaiss = $dateNaiss;

        return $this;
    }

    /**
     * @return Collection<int, ConsultantData>
     */
    public function getConsultantData(): Collection
    {
        return $this->consultantData;
    }

    public function addConsultantData(ConsultantData $consultantData): static
    {
        if (!$this->consultantData->contains($consultantData)) {
            $this->consultantData->add($consultantData);
            $consultantData->setConsultant($this);
        }

        return $this;
    }

    public function removeConsultantData(ConsultantData $consultantData): static
    {
        if ($this->consultantData->removeElement($consultantData)) {
            // set the owning side to null (unless already changed)
            if ($consultantData->getConsultant() === $this) {
                $consultantData->setConsultant(null);
            }
        }

        return $this;
    }
}
