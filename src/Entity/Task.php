<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name_task = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content_task = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_task = null;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_task = null;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cat $cat_task = null;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameTask(): ?string
    {
        return $this->name_task;
    }

    public function setNameTask(string $name_task): static
    {
        $this->name_task = $name_task;

        return $this;
    }

    public function getContentTask(): ?string
    {
        return $this->content_task;
    }

    public function setContentTask(string $content_task): static
    {
        $this->content_task = $content_task;

        return $this;
    }

    public function getDateTask(): ?\DateTimeImmutable
    {
        return $this->date_task;
    }

    public function setDateTask(\DateTimeImmutable $date_task): static
    {
        $this->date_task = $date_task;

        return $this;
    }

    public function getUserTask(): ?User
    {
        return $this->user_task;
    }

    public function setUserTask(?User $user_task): static
    {
        $this->user_task = $user_task;

        return $this;
    }

    public function getCatTask(): ?Cat
    {
        return $this->cat_task;
    }

    public function setCatTask(?Cat $cat_task): static
    {
        $this->cat_task = $cat_task;

        return $this;
    }

}
