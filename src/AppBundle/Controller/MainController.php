<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Form\UserInputType;

class MainController extends Controller

{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }
    
    /**
     * @Route("/input/", name="input")
     * @Template()
     */
    public function inputAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Unable to access this page!');
        
        $var = '';
        
        $form = $this->createForm( UserInputType::class );
        
        // vars: User, User.Place
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $place = $user->getPlace();
        
        
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            // Get some variables established
            $input = $this->get('app.interp')->inputMorph($form['input']->getData());
            $repository = $this->getDoctrine()->getRepository('AppBundle:Interaction');
            $query  = $repository->createQueryBuilder('i')
                    ->where('i.place_id = :pid')
                    ->andWhere('i.input = :in')
                    ->setParameter('pid', $place->getId())
                    ->setParameter('in', $input)
                    ->getQuery();
            $interaction = $query->getOneOrNullResult();
            $global = $this->get('app.interp')->checkGlobals($input, $user);
            
            // Log the input
            $this->get('app.interp')->logIt($input, $user, 0);
        
            // check for quit command first; can't be placed in a util class.
            if ($input == 'quit') {return $this->redirectToRoute('fos_user_security_logout');}
            // check to match 'global' commands
            elseif ($global != null) {$var .= $global;} 
            elseif ($interaction) {
                $lf = $interaction->getLogicFlag();
                
                // Output only
                if ($lf == 0) {
                    $var = $interaction->getOutput();
                }
                // TELEPORT. Update place and return output.
                elseif ($lf == 1) {
                    $new_place = $this->getDoctrine()->getRepository('AppBundle:Place')->find($interaction->getNewPlace());
                    $this->get('app.interp')->teleport($user, $new_place);
                    
                    if ($interaction->getOutput() != ' ') {$var = $interaction->getOutput() . '<br>';}
                    $var .= $this->get('app.interp')->teleOutput($user, $new_place);
                }
                // GIVE ITEM.
                elseif ($lf == 2) {
                    $var = $this->get('app.interp')->giveItem($user, $interaction);
                }
                // GIVE ITEM + TELEPORT
                elseif ($lf == 3) {
                    $var = $this->get('app.interp')->giveItem($user, $interaction, 1);
                }
                // ITEM CHECK; TELEPORT IF PLAYER HAS ITEM
                elseif ($lf == 4) {
                    $new_place = $this->getDoctrine()->getRepository('AppBundle:Place')->find($interaction->getNewPlace());
                    $item_check = $this->get('app.interp')->checkItem($user, $interaction->getItem());
                    
                    if ($item_check == 1) {
                        $this->get('app.interp')->teleport($user, $new_place);
                        $var = $interaction->getOutput();
                        $var .= $this->get('app.interp')->teleOutput($user, $new_place);
                    }
                    else {
                        $var = $interaction->getConditionalOutput();
                    }
                }
                // TELEPORT IF ITEM, TELEPORT IF NO ITEM
                elseif ($lf == 5) {
                    $pass_place = $this->getDoctrine()->getRepository('AppBundle:Place')->find($interaction->getNewPlace());
                    $fail_place = $this->getDoctrine()->getRepository('AppBundle:Place')->find($interaction->getConditionalNewPlace());
                    $item_check = $this->get('app.interp')->checkItem($user, $interaction->getItem());
                    
                    if ($item_check == 1) {
                        $this->get('app.interp')->teleport($user, $pass_place);
                        $var = $interaction->getOutput();
                        $var .= $this->get('app.interp')->teleOutput($user, $pass_place);
                    }
                    else {
                        $this->get('app.interp')->teleport($user, $fail_place);
                        $var = $interaction->getConditionalOutput();
                        $var .= $this->get('app.interp')->teleOutput($user, $fail_place);
                    }
                }
                // TELEPORT WITH NO OUTPUT
                elseif ($lf == 6) {
                    $new_place = $this->getDoctrine()->getRepository('AppBundle:Place')->find($interaction->getNewPlace());
                    
                    $this->get('app.interp')->teleport($user, $new_place);
                    $var = $interaction->getOutput();
                }
                // CHECK ONE ITEM TO GET ANOTHER
                elseif ($lf == 7) {
                    $item_check = $this->get('app.interp')->checkItem($user, $interaction->getConditionalItem());
                    $redundancy_check = $this->get('app.interp')->checkItem($user, $interaction->getItem());
                    
                    if ($item_check == 1 && $redundancy_check == 0) {
                        $var = $this->get('app.interp')->giveItem($user, $interaction);
                    }
                    elseif ($item_check == 1 && $redundancy_check == 1) {
                        $var = 'Don\'t you think that\'s a bit redundant?';
                    }
                    else {
                        $var = $interaction->getConditionalOutput();
                    }
                }
                // ITEM CHECK
                // Output on success; ConditionalOutput on failure.
                elseif ($lf == 8) {
                    $item_check = $this->get('app.interp')->checkItem($user, $interaction->getItem());
                    
                    if ($item_check == 1) {
                        $var = $interaction->getOutput();
                    }
                    else {
                        $var = $interaction->getConditionalOutput();
                    }
                }
                // END GAME!
                elseif ($lf == 11) {
                    $new_place = $this->getDoctrine()->getRepository('AppBundle:Place')->find($interaction->getNewPlace());
                    $this->get('app.interp')->teleport($user, $new_place);
                    
                    // Stats, like items found
                    // Number of commands
                    // Scoring based on such.
                }
                // GIVE ITEM + SILENTLY TELEPORT
                elseif ($lf == 12) {
                    $var = $this->get('app.interp')->giveItem($user, $interaction, 1, 1);
                }
            }
            else
                {
                $var = 'Not understood.';
                }
            
            // Log the output
            $this->get('app.interp')->logIt($var, $user, 1);
            
            return new JsonResponse($var);
         }
        
        // Show recent logs to give user context when logging in
        $query = $this->getDoctrine()->getRepository('AppBundle:Log')->createQueryBuilder('l')
                ->where('l.user_id = :uid')
                ->setParameter('uid', $user->getId())
                ->orderBy('l.id', 'DESC')
                ->setMaxResults(10)
                ->getQuery();
        // Reverse the most recent results.
        $logArray = $query->getArrayResult();
        $logData = array_reverse($logArray);
        
        return $this->render('default/main.html.twig', array(
            'form' => $form->createView(),
            'logData' => $logData
            ) );
    }
}

