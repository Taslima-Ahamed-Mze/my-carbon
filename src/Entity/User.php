<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[Vich\Uploadable]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Vich\UploadableField(mapping: 'users', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;


    #[ORM\Column(length: 30)]
    #[Assert\Email(
        message: 'Votre adresse email {{ value }} n\'est pas valide.',
    )]
    private ?string $email = null;
    

    #[ORM\Column]
    private array $roles = ["ROLE_USER"];

    /**
     * @var string
     */
    #[ORM\Column]
    private ?string $password = null;

    #[SecurityAssert\UserPassword(groups: ['edit'])]
    private ?string $oldPassword = null;


    #[Assert\Regex(
        pattern: '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{8,}$/',
        message: 'Assurez-vous que votre mot de passe respecte les critères suivants : il doit comporter au moins huit caractères, inclure au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.',
    )]
    private ?string $plainPassword = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: 'Le nom est obligatoire')]
    #[Assert\Regex(
        pattern: '/^[^\d]+$/',
        message: 'Le nom ne peut pas contenir de chiffres',
    )]
    private ?string $lastname = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: 'Le prénom est obligatoire')]
    #[Assert\Regex(
        pattern: '/^[^\d]+$/',
        message: 'Le nom ne peut pas contenir de chiffres',
    )]
    private ?string $firstname = null;


    #[ORM\OneToMany(mappedBy: 'collaborator', targetEntity: EventRegister::class)]
    private Collection $eventRegisters;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Profile $profile = null;

    #[ORM\OneToMany(mappedBy: 'collaborator', targetEntity: UserSkills::class, cascade: ['all'], orphanRemoval: true)]
    private Collection $userSkills;

    #[ORM\OneToMany(mappedBy: 'collaborator', targetEntity: FormationRegister::class)]
    private Collection $formationRegisters;

    public function __construct()
    {
        $this->eventRegisters = new ArrayCollection();
        $this->userSkills = new ArrayCollection();
        $this->formationRegisters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    public function setOldPassword(?string $oldPassword): self
    {
        $this->oldPassword = $oldPassword;

        return $this;
    }


    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return Collection<int, EventRegister>
     */
    public function getEventRegisters(): Collection
    {
        return $this->eventRegisters;
    }

    public function addEventRegister(EventRegister $eventRegister): static
    {
        if (!$this->eventRegisters->contains($eventRegister)) {
            $this->eventRegisters->add($eventRegister);
            $eventRegister->setCollaborator($this);
        }

        return $this;
    }

    public function removeEventRegister(EventRegister $eventRegister): static
    {
        if ($this->eventRegisters->removeElement($eventRegister)) {
            // set the owning side to null (unless already changed)
            if ($eventRegister->getCollaborator() === $this) {
                $eventRegister->setCollaborator(null);
            }
        }

        return $this;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): static
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * @return Collection<int, UserSkills>
     */
    public function getUserSkills(): Collection
    {
        return $this->userSkills;
    }

    public function addUserSkill(UserSkills $userSkill): static
    {
        if (!$this->userSkills->contains($userSkill)) {
            $this->userSkills->add($userSkill);
            $userSkill->setCollaborator($this);
        }

        return $this;
    }

    public function removeUserSkill(UserSkills $userSkill): static
    {
        if ($this->userSkills->removeElement($userSkill)) {
            // set the owning side to null (unless already changed)
            if ($userSkill->getCollaborator() === $this) {
                $userSkill->setCollaborator(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FormationRegister>
     */
    public function getFormationRegisters(): Collection
    {
        return $this->formationRegisters;
    }

    public function addFormationRegister(FormationRegister $formationRegister): static
    {
        if (!$this->formationRegisters->contains($formationRegister)) {
            $this->formationRegisters->add($formationRegister);
            $formationRegister->setCollaborator($this);
        }

        return $this;
    }

    public function removeFormationRegister(FormationRegister $formationRegister): static
    {
        if ($this->formationRegisters->removeElement($formationRegister)) {
            // set the owning side to null (unless already changed)
            if ($formationRegister->getCollaborator() === $this) {
                $formationRegister->setCollaborator(null);
            }
        }

        return $this;
    }

    
}