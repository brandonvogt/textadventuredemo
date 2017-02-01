<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="logs")
 */
class Log
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /** @ORM\Column(type="integer") */
    private $user_id;
    /** @ORM\Column(type="text") */
    private $text;
    /** @ORM\Column(type="datetime") */
    private $timestamp;
    /** @ORM\Column(type="integer") */
    private $io_bit;
    /** @ORM\Column(type="integer") */
    private $place_context;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="logs")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    

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
     * Set userId
     *
     * @param integer $userId
     *
     * @return Log
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Log
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     *
     * @return Log
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set ioBit
     *
     * @param integer $ioBit
     *
     * @return Log
     */
    public function setIoBit($ioBit)
    {
        $this->io_bit = $ioBit;

        return $this;
    }

    /**
     * Get ioBit
     *
     * @return integer
     */
    public function getIoBit()
    {
        return $this->io_bit;
    }
        /**
     * Set placeContext
     *
     * @param integer $placeContext
     *
     * @return Log
     */
    public function setPlaceContext($placeContext)
    {
        $this->place_context = $placeContext;

        return $this;
    }

    /**
     * Get placeContext
     *
     * @return integer
     */
    public function getPlaceContext()
    {
        return $this->place_context;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Log
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
