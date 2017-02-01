<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="places")
 */
class Place
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /** @ORM\Column(type="text") */
    private $title;
    /** @ORM\Column(type="text") */
    private $base_desc;
    /** @ORM\Column(type="text") */
    private $with_sword;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Interaction", mappedBy="place")
     */
    private $interactions;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\User", mappedBy="place")
     */
    private $users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->interactions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Set title
     *
     * @param string $title
     *
     * @return Place
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set baseDesc
     *
     * @param string $baseDesc
     *
     * @return Place
     */
    public function setBaseDesc($baseDesc)
    {
        $this->base_desc = $baseDesc;

        return $this;
    }

    /**
     * Get baseDesc
     *
     * @return string
     */
    public function getBaseDesc()
    {
        return $this->base_desc;
    }

    /**
     * Add interaction
     *
     * @param \AppBundle\Entity\Interaction $interaction
     *
     * @return Place
     */
    public function addInteraction(\AppBundle\Entity\Interaction $interaction)
    {
        $this->interactions[] = $interaction;

        return $this;
    }

    /**
     * Remove interaction
     *
     * @param \AppBundle\Entity\Interaction $interaction
     */
    public function removeInteraction(\AppBundle\Entity\Interaction $interaction)
    {
        $this->interactions->removeElement($interaction);
    }

    /**
     * Get interactions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInteractions()
    {
        return $this->interactions;
    }

    /**
     * Add user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Place
     */
    public function addUser(\AppBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \AppBundle\Entity\User $user
     */
    public function removeUser(\AppBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
    
    /**
     * Set withGloves
     *
     * @param string $withGloves
     *
     * @return Place
     */
    public function setWithGloves($withGloves)
    {
        $this->with_gloves = $withGloves;

        return $this;
    }

    /**
     * Get withGloves
     *
     * @return string
     */
    public function getWithGloves()
    {
        return $this->with_gloves;
    }

    /**
     * Set withFruit
     *
     * @param string $withFruit
     *
     * @return Place
     */
    public function setWithFruit($withFruit)
    {
        $this->with_fruit = $withFruit;

        return $this;
    }

    /**
     * Get withFruit
     *
     * @return string
     */
    public function getWithFruit()
    {
        return $this->with_fruit;
    }
    
    /**
     * Set withMask
     *
     * @param string $withMask
     *
     * @return Place
     */
    
    public function setWithMask($withMask)
    {
        $this->with_mask = $withMask;

        return $this;
    }

    /**
     * Get withMask
     *
     * @return string
     */
    public function getWithMask()
    {
        return $this->with_mask;
    }

    /**
     * Set withSword
     *
     * @param string $withSword
     *
     * @return Place
     */
    public function setWithSword($withSword)
    {
        $this->with_sword = $withSword;

        return $this;
    }

    /**
     * Get withSword
     *
     * @return string
     */
    public function getWithSword()
    {
        return $this->with_sword;
    }
    
    /**
     * Set withEye
     *
     * @param string $withEye
     *
     * @return Place
     */
    public function setWithEye($withEye)
    {
        $this->with_eye = $withEye;

        return $this;
    }

    /**
     * Get withEye
     *
     * @return string
     */
    public function getWithEye()
    {
        return $this->with_eye;
    }

    /**
     * Set withMeteor
     *
     * @param string $withMeteor
     *
     * @return Place
     */
    public function setWithMeteor($withMeteor)
    {
        $this->with_meteor = $withMeteor;

        return $this;
    }

    /**
     * Get withMeteor
     *
     * @return string
     */
    public function getWithMeteor()
    {
        return $this->with_meteor;
    }
    
    /**
     * Set withStone
     *
     * @param string $withStone
     *
     * @return Place
     */
    public function setWithStone($withStone)
    {
        $this->with_stone = $withStone;

        return $this;
    }

    /**
     * Get withStone
     *
     * @return string
     */
    public function getWithStone()
    {
        return $this->with_stone;
    }

    /**
     * Set withBeetle
     *
     * @param string $withBeetle
     *
     * @return Place
     */
    public function setWithBeetle($withBeetle)
    {
        $this->with_beetle = $withBeetle;

        return $this;
    }

    /**
     * Get withBeetle
     *
     * @return string
     */
    public function getWithBeetle()
    {
        return $this->with_beetle;
    }
    
    /**
     * Set withOrb
     *
     * @param string $withOrb
     *
     * @return Place
     */
    public function setWithOrb($withOrb)
    {
        $this->with_orb = $withOrb;

        return $this;
    }

    /**
     * Get withOrb
     *
     * @return string
     */
    public function getWithOrb()
    {
        return $this->with_orb;
    }

    /**
     * Set withFeathers
     *
     * @param string $withFeathers
     *
     * @return Place
     */
    public function setWithFeathers($withFeathers)
    {
        $this->with_feathers = $withFeathers;

        return $this;
    }

    /**
     * Get withFeathers
     *
     * @return string
     */
    public function getWithFeathers()
    {
        return $this->with_feathers;
    }
    
    /**
     * Set withFsActive
     *
     * @param string $withFsActive
     *
     * @return Place
     */
    public function setWithFsActive($withFsActive)
    {
        $this->with_fs_active = $withFsActive;

        return $this;
    }

    /**
     * Get withFsActive
     *
     * @return string
     */
    public function getWithFsActive()
    {
        return $this->with_fs_active;
    }

    /**
     * Set withMsActive
     *
     * @param string $withMsActive
     *
     * @return Place
     */
    public function setWithMsActive($withMsActive)
    {
        $this->with_ms_active = $withMsActive;

        return $this;
    }

    /**
     * Get withMsActive
     *
     * @return string
     */
    public function getWithMsActive()
    {
        return $this->with_ms_active;
    }
    
    /**
     * Set withDsActive
     *
     * @param string $withDsActive
     *
     * @return Place
     */
    public function setWithDsActive($withDsActive)
    {
        $this->with_ds_active = $withDsActive;

        return $this;
    }

    /**
     * Get withDsActive
     *
     * @return string
     */
    public function getWithDsActive()
    {
        return $this->with_ds_active;
    }
}
