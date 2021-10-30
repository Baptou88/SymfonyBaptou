<?php

namespace App\Entity;


use App\Repository\ProjectRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */

class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $code;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private ?\DateTimeImmutable $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private ?\DateTimeImmutable $ModifiedAt;

    /**
     * @ORM\ManyToOne(targetEntity=TypeProject::class, inversedBy="projects")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?TypeProject $TypeProject;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="projects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;


    public function __construct()
    {

    }

    public function __toString(): string
    {
        return $this->code;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeImmutable $createdAt
     * @return $this
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTimeImmutable();

    }

    /**
     * @ORM\PreUpdate()
     */
    public function setModifiedAtValue()
    {
        dump("ok");
        $this->ModifiedAt = new \DateTimeImmutable();
    }

    public function getModifiedAt(): ?\DateTimeImmutable
    {
        return $this->ModifiedAt;
    }

    public function setModifiedAt(?\DateTimeImmutable $ModifiedAt): self
    {
        $this->ModifiedAt = $ModifiedAt;

        return $this;
    }

    public function getTypeProject(): ?TypeProject
    {
        return $this->TypeProject;
    }

    public function setTypeProject(?TypeProject $TypeProject): self
    {
        $this->TypeProject = $TypeProject;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
