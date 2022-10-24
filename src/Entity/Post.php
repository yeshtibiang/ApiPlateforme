<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Put;
use App\Repository\PostRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ApiResource(
    operations: [
        new \ApiPlatform\Metadata\Post(
            denormalizationContext: [
                'groups' => ['write:post']
            ],
            validationContext: [
                'groups' => ['create:post']
            ]
        )
    ],
    /*operations: [
        new Get(
        normalizationContext: [
            'groups' => ['read:collection', 'read:item']
        ]
        ),
        new Put(),
        new \ApiPlatform\Metadata\Post()
    ],*/
    normalizationContext: ['groups' => ['read:collection']]
)]
#[Get(
    normalizationContext: [
        'groups' => ['read:collection', 'read:item', 'read:post']
    ]
)]
#[\ApiPlatform\Metadata\Post]
#[Put(
    denormalizationContext: [
        'groups' => ['put:post']
    ]
)]
#[GetCollection]
/*#[\ApiPlatform\Metadata\Post(
    validationContext: [
        'groups' => ['create:post']
    ]
)]*/
#[Delete]
#[Patch]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:collection'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(
        ['read:collection', 'put:post', 'write:post']),
        /*Length(min: 5, groups: ['create:post'])*/
    ]
    #[Assert\Length(min: 5, groups: ['create:post'])]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:collection', 'write:post'])]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['read:item', 'write:post'])]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['read:item', 'write:post']), Assert\Valid]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['read:item', 'write:post'])]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'posts')]
    #[Groups(['read:item', 'put:post', 'write:post'])]
    private ?Category $category = null;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
