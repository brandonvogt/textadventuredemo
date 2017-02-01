<?php

namespace AppBundle\Entity;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\HasLifecycleCallbacks
 */
class User extends BaseUser
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /** @ORM\Column(name="place_id", type="text", options={"default":1}) */
    private $place_id = 100;
    /** @ORM\Column(name="sword", type="text", options={"default":0}) */
    private $sword = 0;

    
    
    /**
     * @ORM\OneToMany(targetEntity="Log", mappedBy="user")
     */
    private $logs;
    
    /**
     * @ORM\ManyToOne(targetEntity="Place", inversedBy="users")
     * @ORM\JoinColumn(name="place_id", referencedColumnName="id")
     */
    private $place;

    /**
     * @ORM\PrePersist()
     */
    public function setInitialPlace()
    {
        // This is handled by EventListener/PlaceSetter.php
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->logs = new \Doctrine\Common\Collections\ArrayCollection();
       
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
     * Set name
     *
     * @param string $name
     *
     * @return User
     */

    /**
     * Set placeId
     *
     * @param integer $placeId
     *
     * @return User
     */
    public function setPlaceId($placeId)
    {
        $this->place_id = $placeId;

        return $this;
    }

    /**
     * Get placeId
     *
     * @return integer
     */
    public function getPlaceId()
    {
        return $this->place_id;
    }
    
    /**
     * Add log
     *
     * @param \AppBundle\Entity\Log $log
     *
     * @return User
     */
    public function addLog(\AppBundle\Entity\Log $log)
    {
        $this->logs[] = $log;

        return $this;
    }

    /**
     * Remove log
     *
     * @param \AppBundle\Entity\Log $log
     */
    public function removeLog(\AppBundle\Entity\Log $log)
    {
        $this->logs->removeElement($log);
    }

    /**
     * Get logs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLogs()
    {
        return $this->logs;
    }

    /**
     * Set place
     *
     * @param \AppBundle\Entity\Place $place
     *
     * @return User
     */
    public function setPlace(\AppBundle\Entity\Place $place = NULL)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return \AppBundle\Entity\Place
     */
    public function getPlace()
    {
        return $this->place;
    }


    /**
     * Set sword
     *
     * @param integer $sword
     *
     * @return User
     */
    public function setSword($sword)
    {
        $this->sword = $sword;

        return $this;
    }

    /**
     * Get sword
     *
     * @return integer
     */
    public function getSword()
    {
        return $this->sword;
    }
}
