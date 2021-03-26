<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotNull
     */
    private $description;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\NotNull
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Assert\NotNull
     */
    private $isPublished;

    /**
     * Si je veux pouvoir récupérer les articles depuis les catégories, je dois ajouter
     * la relation inverse au ManyToOne déclaré dans l'entité article, donc un OneToMany et je le relie
     * avec l'entité Article.
     *
     * Je précise aussi, dans l'entité quelle propriété fait l'inverse du OneToMany (donc le ManyToOne),
     * soit la propriété Category.
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="category")
     */
    private $articles;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(?bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getArticles()
    {
        return $this->articles;
    }

    public function setArticles($articles): void
    {
        $this->articles = $articles;
    }
}