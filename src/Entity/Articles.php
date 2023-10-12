<?php

namespace App\Entity;

use App\Repository\ArticlesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ArticlesRepository::class)]
#[ORM\Index(name: "title_content_idx", columns: ["title", "content"], flags: ["fulltext"])]
// #[ORM\Index(name: "title_idx", columns: ["content"], flags: ["fulltext"])]
// #[ORM\Index(name: "content_idx", columns: ["content"], flags: ["fulltext"])]

class Articles
{
    #[ORM\Id]
    #[Groups("articles")]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups("articles")]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups("articles")]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups("articles")]
    private ?string $content = null;

    #[ORM\Column(length: 255)]
    #[Groups("articles")]
    private ?string $image = null;

    #[ORM\Column]
    #[Groups("articles")]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups("articles")]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[Groups("articles")]
    // #[ORM\JoinColumn(onDelete: "CASCADE")]
    private ?Categories $category = null;

    #[ORM\Column]
    #[Groups("articles")]
    private ?int $readTime = null;

    public function __construct()
    {
        $this->updatedAt = new \DateTimeImmutable();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCategory(): ?Categories
    {
        return $this->category;
    }

    public function setCategory(?Categories $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getReadTime(): ?int
    {
        return $this->readTime;
    }

    public function setReadTime(int $readTime): static
    {
        $this->readTime = $readTime;

        return $this;
    }
}
