<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface|string $id;


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



    public function getId(): UuidInterface|string
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






















}