<?php

namespace App\Entity;

use App\Repository\ManufacturerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ManufacturerRepository::class)
 */
class Manufacturer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $site_url;

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

    public function getSiteUrl(): ?string
    {
        return $this->site_url;
    }

    public function setSiteUrl(string $site_url): self
    {
        $this->site_url = $site_url;

        return $this;
    }
}
