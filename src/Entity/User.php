<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups (['user:readAll','user_task:readAll','task:readAll'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups (['user:readAll','user_task:readAll'])]
    private ?string $name_user = null;

    #[ORM\Column(length: 50)]
    #[Groups (['user:readAll','user_task:readAll'])]
    private ?string $first_name_user = null;

    #[ORM\Column(length: 50)]
    #[Groups (['user:readAll','user_task:readAll'])]
    private ?string $login_user = null;

    #[ORM\Column(length: 100)]
    #[Groups (['user:readAll','user_task:readAll'])]
    private ?string $mdp_user = null;

    /**
     * @var Collection<int, Task>
     */
    #[ORM\OneToMany(targetEntity: Task::class, mappedBy: 'user_task')]
    #[Groups ('user_task:readAll')]
    private Collection $tasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameUser(): ?string
    {
        return $this->name_user;
    }

    public function setNameUser(string $name_user): static
    {
        $this->name_user = $name_user;

        return $this;
    }

    public function getFirstNameUser(): ?string
    {
        return $this->first_name_user;
    }

    public function setFirstNameUser(string $first_name_user): static
    {
        $this->first_name_user = $first_name_user;

        return $this;
    }

    public function getLoginUser(): ?string
    {
        return $this->login_user;
    }

    public function setLoginUser(string $login_user): static
    {
        $this->login_user = $login_user;

        return $this;
    }

    public function getMdpUser(): ?string
    {
        return $this->mdp_user;
    }

    public function setMdpUser(string $mdp_user): static
    {
        $this->mdp_user = $mdp_user;

        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): static
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->setUserTask($this);
        }

        return $this;
    }

    public function removeTask(Task $task): static
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getUserTask() === $this) {
                $task->setUserTask(null);
            }
        }

        return $this;
    }
}
