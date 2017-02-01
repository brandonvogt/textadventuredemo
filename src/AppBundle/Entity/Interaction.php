<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity
 * @ORM\Table(name="responses")
 */
class Interaction
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /** @ORM\Column(type="integer") */
    private $place_id;
    /** @ORM\Column(type="text") */
    private $input;
    /** @ORM\Column(type="text") */
    private $output;
    /** @ORM\Column(type="text") */
    private $conditional_output;
    /** @ORM\Column(type="integer") */
    private $logic_flag;
    /** @ORM\Column(type="integer") */
    private $item;
    /** @ORM\Column(type="integer") */
    private $conditional_item;
    /** @ORM\Column(type="integer") */
    private $new_place;
    /** @ORM\Column(type="integer") */
    private $conditional_new_place;
    /**
     * @ORM\ManyToOne(targetEntity="Place", inversedBy="interactions")
     * @ORM\JoinColumn(name="place_id", referencedColumnName="id")
     */
    private $place;


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
     * Set placeId
     *
     * @param integer $placeId
     *
     * @return Interaction
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
     * Set input
     *
     * @param string $input
     *
     * @return Interaction
     */
    public function setInput($input)
    {
        $this->input = $input;

        return $this;
    }

    /**
     * Get input
     *
     * @return string
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * Set output
     *
     * @param string $output
     *
     * @return Interaction
     */
    public function setOutput($output)
    {
        $this->output = $output;

        return $this;
    }

    /**
     * Get output
     *
     * @return string
     */
    public function getOutput()
    {
        return $this->output;
    }
    
    /**
     * Set output
     *
     * @param string $conditionalOutput
     *
     * @return Interaction
     */
    public function setConditionalOutput($conditionalOutput)
    {
        $this->conditional_output = $conditionalOutput;

        return $this;
    }

    /**
     * Get conditional_output
     *
     * @return string
     */
    public function getConditionalOutput()
    {
        return $this->conditional_output;
    }

    /**
     * Set logicFlag
     *
     * @param integer $logicFlag
     *
     * @return Interaction
     */
    public function setLogicFlag($logicFlag)
    {
        $this->logic_flag = $logicFlag;

        return $this;
    }

    /**
     * Get logicFlag
     *
     * @return integer
     */
    public function getLogicFlag()
    {
        return $this->logic_flag;
    }

    /**
     * Set item
     *
     * @param integer $item
     *
     * @return Interaction
     */
    public function setItem($item)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return integer
     */
    public function getItem()
    {
        return $this->item;
    }
    /**
     * Set item
     *
     * @param integer $item
     *
     * @return Interaction
     */
    public function setConditionalItem($conditional_item)
    {
        $this->conditional_item = $conditional_item;

        return $this;
    }

    /**
     * Get item
     *
     * @return integer
     */
    public function getConditionalItem()
    {
        return $this->conditional_item;
    }

    /**
     * Set newPlace
     *
     * @param integer $newPlace
     *
     * @return Interaction
     */
    public function setNewPlace($newPlace)
    {
        $this->new_place = $newPlace;

        return $this;
    }

    /**
     * Get newPlace
     *
     * @return integer
     */
    public function getNewPlace()
    {
        return $this->new_place;
    }
    
    /**
     * Set newPlace
     *
     * @param integer $conditionalNewPlace
     *
     * @return Interaction
     */
    public function setConditionalNewPlace($conditionalNewPlace)
    {
        $this->conditional_new_place = $conditionalNewPlace;

        return $this;
    }

    /**
     * Get conditionalNewPlace
     *
     * @return integer
     */
    public function getConditionalNewPlace()
    {
        return $this->conditional_new_place;
    }

    /**
     * Set place
     *
     * @param \AppBundle\Entity\Place $place
     *
     * @return Interaction
     */
    public function setPlace(\AppBundle\Entity\Place $place = null)
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
}
