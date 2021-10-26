<?php

namespace App\Entity;

use App\Repository\MedicamentRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=MedicamentRepository::class)
 * @ApiResource(
 *     collectionOperations={"get"={"normalization_context"={"groups"="medicaments:list"}}},
 *     itemOperations={"get"={"normalization_context"={"groups"="medicaments:item"}}},
 *     paginationEnabled=false
 * )
 */
class Medicament
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['medicaments:list', 'medicaments:item'])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['medicaments:list', 'medicaments:item'])]
    private $title;

    /**
     * @ORM\Column(type="integer")
     */
    #[Groups(['medicaments:list', 'medicaments:item'])]
    private $id_active_substance;

    /**
     * @ORM\Column(type="integer")
     */
    #[Groups(['medicaments:list', 'medicaments:item'])]
    private $id_manufacturer;

    /**
     * @ORM\Column(type="integer")
     */
    #[Groups(['medicaments:list', 'medicaments:item'])]
    private $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getIdActiveSubstance(): ?int
    {
        return $this->id_active_substance;
    }

    public function setIdActiveSubstance(int $id_active_substance): self
    {
        $this->id_active_substance = $id_active_substance;

        return $this;
    }

    public function getIdManufacturer(): ?int
    {
        return $this->id_manufacturer;
    }

    public function setIdManufacturer(int $id_manufacturer): self
    {
        $this->id_manufacturer = $id_manufacturer;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }
}
