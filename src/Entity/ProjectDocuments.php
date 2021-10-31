<?php

namespace App\Entity;

use App\Repository\ProjectDocumentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ProjectDocumentsRepository::class)
 * @Vich\Uploadable()
 */
class ProjectDocuments
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column (type="string", nullable=true)
     * @Vich\UploadableField(mapping="project_docs", fileNameProperty="docName", size="docSize")
     * @var File|null
     */
    private $docFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $docName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $docSize;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity=Project::class, mappedBy="doc")
     */
    private $projects;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getdocFile(): ?File
    {
        return $this->docFile;
    }

    public function setdocFile(?File $docFile = null): self
    {
        $this->docFile = $docFile;

        if (null !== $docFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
        return $this;
    }

    public function getDocName(): ?string
    {
        return $this->docName;
    }

    public function setDocName(?string $docName): self
    {
        $this->docName = $docName;

        return $this;
    }

    public function getDocSize(): ?string
    {
        return $this->docSize;
    }

    public function setDocSize(?string $docSize): self
    {
        $this->docSize = $docSize;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdateAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->addDoc($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->removeElement($project)) {
            $project->removeDoc($this);
        }

        return $this;
    }
}
