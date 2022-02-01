<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FoldersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=FoldersRepository::class)
 */
class Folders
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
     * @ORM\OneToMany(targetEntity=Files::class, mappedBy="folders")
     */
    private $file;

    /**
     * @ORM\ManyToOne(targetEntity=Folders::class, inversedBy="subFolder")
     */
    private $subFolders;

    /**
     * @ORM\OneToMany(targetEntity=Folders::class, mappedBy="subFolders")
     */
    private $subFolder;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="folders")
     */
    private $users;

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
     * @return Collection|Files[]
     */
    public function getFile(): Collection
    {
        return $this->file;
    }

    public function addFile(Files $file): self
    {
        if (!$this->file->contains($file)) {
            $this->file[] = $file;
            $file->setFolders($this);
        }

        return $this;
    }

    public function removeFile(Files $file): self
    {
        if ($this->file->removeElement($file)) {
            // set the owning side to null (unless already changed)
            if ($file->getFolders() === $this) {
                $file->setFolders(null);
            }
        }

        return $this;
    }

    public function getSubFolders(): ?self
    {
        return $this->subFolders;
    }

    public function setSubFolders(?self $subFolders): self
    {
        $this->subFolders = $subFolders;

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
            $subFolder->setSubFolders($this);
        }

        return $this;
    }

    public function removeSubFolder(self $subFolder): self
    {
        if ($this->subFolder->removeElement($subFolder)) {
            // set the owning side to null (unless already changed)
            if ($subFolder->getSubFolders() === $this) {
                $subFolder->setSubFolders(null);
            }
        }

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): self
    {
        $this->users = $users;

        return $this;
    }
}
