<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FolderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=FolderRepository::class)
 */
class Folder
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=File::class, mappedBy="folder")
     */
    private $file;

    /**
     * @ORM\ManyToOne(targetEntity=Folder::class, inversedBy="subFolder")
     */
    private $folder;

    /**
     * @ORM\OneToMany(targetEntity=Folder::class, mappedBy="folder")
     */
    private $subFolder;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="folders")
     */
    private $user;

    public function __construct()
    {
        $this->file = new ArrayCollection();
        $this->subFolder = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|File[]
     */
    public function getFile(): Collection
    {
        return $this->file;
    }

    public function addFile(File $file): self
    {
        if (!$this->file->contains($file)) {
            $this->file[] = $file;
            $file->setFolder($this);
        }

        return $this;
    }

    public function removeFile(File $file): self
    {
        if ($this->file->removeElement($file)) {
            // set the owning side to null (unless already changed)
            if ($file->getFolder() === $this) {
                $file->setFolder(null);
            }
        }

        return $this;
    }

    public function getFolder(): ?self
    {
        return $this->folder;
    }

    public function setFolder(?self $folder): self
    {
        $this->folder = $folder;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getSubFolder(): Collection
    {
        return $this->subFolder;
    }

    public function addSubFolder(self $subFolder): self
    {
        if (!$this->subFolder->contains($subFolder)) {
            $this->subFolder[] = $subFolder;
            $subFolder->setFolder($this);
        }

        return $this;
    }

    public function removeSubFolder(self $subFolder): self
    {
        if ($this->subFolder->removeElement($subFolder)) {
            // set the owning side to null (unless already changed)
            if ($subFolder->getFolder() === $this) {
                $subFolder->setFolder(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
