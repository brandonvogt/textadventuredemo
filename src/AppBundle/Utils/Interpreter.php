<?php
namespace AppBundle\Utils;

use AppBundle\Entity\Log;

class Interpreter 
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }
    
    public function logIt($input, \AppBundle\Entity\User $user, $ioBit) 
        {
            $log = new Log();
            $log->setUser($user);
            $log->setText($input);
            $log->setIoBit($ioBit);
            $log->setPlaceContext($user->getPlaceId());
            $log->setTimestamp(new \DateTime("now"));
            
            $em = $this->doctrine->getManager();
            $em->persist($log);
            $em->flush();
        }
    
    public function checkGlobals($input, \AppBundle\Entity\User $user)
        {
            // TODO
            if ($input == 'inventory')
                {
                    $output = $this->inventoryOutput($user);
                    return $output;
                }
            else {return null;}
        }
        
    public function inventoryOutput(\AppBundle\Entity\User $user) {
                    $output = 'You have... <br>';
                    $item_counter = 0;
                    
                    if ($user->getSword()){
                        $output .= 'A sword. <br>';
                        $item_counter += 1;
                    }
                    if ($item_counter == 0) {
                        $output .= '... a whole lot of nothing.';
                    }
            return $output;
    }
        
    public function teleport(\AppBundle\Entity\User $user, \AppBundle\Entity\Place $new_place)
        {
            $user->setPlace($new_place);
            $em = $this->doctrine->getManager();
            $em->persist($user);
            $em->flush($user);
        }
    
    public function teleOutput(\AppBundle\Entity\User $user, \AppBundle\Entity\Place $new_place) 
        {   $output = '';
            if ($new_place->getTitle()) {$output = '<h2>' . $new_place->getTitle() . '</h2>';}
                    
            $has_item1 = $user->getSword();
            $item1desc = $new_place->getWithSword();

            if ($has_item1 > 0 && $item1desc != null)
                {$output .= $item1desc;}
            else 
                {$output .= $new_place->getBaseDesc();}
            
            return $output;
        }
    /*
     * Output = Item Got
     * Conditional Output = Have Item Already
     */
    public function giveItem(\AppBundle\Entity\User $user, \AppBundle\Entity\Interaction $interaction, $tp_flag = null, $silent_flag = null)
        {
            $item = $interaction->getItem();
            $has_item = $this->checkItem($user, $item);
            $item_got = 0;
            
            if ($has_item > 0) { $output = $interaction->getConditionalOutput();}
            else {
                // Figure out which item to give. TODO: Normalize Items!!
                switch($item) {
                    case 1:
                        $user->setSword(1);
                        break;
                }
                
                $output = $interaction->getOutput();
                $item_got = 1;
            }
            
            if ($tp_flag == 1 && $item_got == 1) 
                {
                    $new_place = $this->doctrine->getRepository('AppBundle:Place')->find($interaction->getNewPlace());
                    $user->setPlace($new_place);
                    if ($silent_flag == 1) {$output .= $interaction->getOutput();}
                    else {$output .= $this->teleOutput($user, $new_place);}
                }
            
            $em = $this->doctrine->getManager();
            $em->persist($user);
            $em->flush($user);
            
            return $output;
        }
    
    public function checkItem(\AppBundle\Entity\User $user, $item)
        {
            $has_sword = $user->getSword();
            
            switch($item) {
                case 1:
                    if ($has_sword > 0) {return 1;}
                    else {return 0;}
                    break;
                }
        }
 
    /*
     * Handles capslock and various shorthand / alternate commands
     */
    public function inputMorph($rawInput) {
        
        $input = strtolower($rawInput);
        if ($input == 'go north' || $input == 'n') {$newInput = 'north';}
        elseif ($input == 'go east' || $input == 'e') {$newInput = 'east';}
        elseif ($input == 'go south' || $input == 's') {$newInput = 'south';}
        elseif ($input == 'go west' || $input == 'w') {$newInput = 'west';}
        else {$newInput = $input;}
        return $newInput;
    }
}