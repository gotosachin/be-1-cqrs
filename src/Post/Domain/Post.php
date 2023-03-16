<?php

declare(strict_types=1);

namespace App\Post\Domain;

use App\Shared\Domain\AggregateRoot;
use Assert\Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'post')]
class Post extends AggregateRoot
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    private Uuid $id;

    #[ORM\Column(length: 20)]
    private string $title;

    #[ORM\Column(length: 255)]
    private string $summary;

    /**
     * @param string $id
     * @param string $title
     * @param string $summary
     */
    public function __construct(string $id, string $title, string $summary)
    {
        $this->id = Uuid::fromString($id);
        $this->title = $title;
        $this->summary = $summary;
    }

    public static function new(string $id, string $title, string $summary): self
    {
        Assert::that($id)->uuid();
        Assert::that($title)->maxLength(20)->notBlank();
        Assert::that($summary)->maxLength(255)->notBlank();

        return new self($id, $title, $summary);
    }

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getSummary(): string
    {
        return $this->summary;
    }
}
