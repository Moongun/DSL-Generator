<?php

namespace DSL\DSLBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FilePath
 *
 * @ORM\Table(name="file_path")
 * @ORM\Entity(repositoryClass="DSL\DSLBundle\Repository\FilePathRepository")
 */
class FilePath
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="path", type="string", length=255, unique=true)
     */
    private $path;

    /**
     * @ORM\OneToOne(targetEntity="DietRules")
     * @ORM\JoinColumn(name="diet_rules_id", referencedColumnName="id")
     * @var type
     */
    private $dietRule;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return FilePath
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set path.
     *
     * @param string $path
     *
     * @return FilePath
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set dietRule.
     *
     * @param DietRules $dietRule
     *
     * @return FilePath
     */
    public function setDietRule(DietRules $dietRule)
    {
        $this->dietRule = $dietRule;

        return $this;
    }

    /**
     * Get dietRule.
     *
     * @return \stdClass
     */
    public function getDietRule()
    {
        return $this->dietRule;
    }

    /**
     * Set user.
     *
     * @param User $user
     *
     * @return FilePath
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return int
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return FilePath
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
