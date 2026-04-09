<?php

namespace App\Entity;

use App\Repository\DocumentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DocumentRepository::class)]
class Document
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $doc = null;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'])]
    private ?Request $request = null;

    #[ORM\ManyToOne(inversedBy: 'documents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Home $home = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDoc(): ?string
    {
        return $this->doc;
    }

    public function setDoc(string $doc): static
    {
        $this->doc = $doc;

        return $this;
    }

    public function getRequest(): ?Request
    {
        return $this->request;
    }

    public function setRequest(?Request $request): static
    {
        $this->request = $request;

        return $this;
    }

    public function getHome(): ?Home
    {
        return $this->home;
    }

    public function setHome(?Home $home): static
    {
        $this->home = $home;

        return $this;
    }
}
