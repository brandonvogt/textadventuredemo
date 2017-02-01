<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class DefaultController extends Controller
{
    /**
     * @Route("/admin", name="admin_index")
     */
    public function adminIndexAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/start", name="user_start")
     */
    public function userRegForm(Request $request) {
        
        $error = '';
        // Form Creation with name cleared
        $defaultData = array('username' => '');
        $form = $this->createFormBuilder($defaultData)
                ->add('username', TextType::class, array('label' => '> '))
                ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $username = $form['username']->getData();
            $username_lower = strtolower($username);

            // Find user based on username provided
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('AppBundle:User')->findOneByUsernameCanonical($username_lower);
            
            //If there's a match, log them in
            if ($user != null && $username_lower != 'theanimus') {
                $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
                $this->get('security.token_storage')->setToken($token);
                $this->get('session')->set('_security_main', serialize($token));
                
                return $this->redirectToRoute('input');
            }
            elseif ($user != null && $username_lower == 'theanimus') {
                $error = 'The Maze isn\'t meant for you.';
            }
            else {
                
                $userManager = $this->get('fos_user.user_manager');
                $user = $userManager->createUser();
                $user->setUsername($username);
                $user->setEmail('none@nadda.com');
                $user->setPlainPassword('nooooope');
                $user->setEnabled('1');
                
                
                $em->persist($user);               
                $em->flush($user);
                
                $firstLog = '<h1> The Clearing </h1>'
                        . 'The canopy above you seems to part at the crossroads ahead. <br> '
                        . 'The <b>north</b> path is heavily wooded and shrouded from the sun. '
                        . 'Looking <b>east</b>, you see an ill-kept path under a mess of thorns and burrs.  '
                        . 'You see nothing but sand and desolation to the <b>south</b> and <b>west</b>, '
                        . 'but let\'s be real -- that\'s not going to stop you.';
                
                // Log the input
                $this->get('app.interp')->logIt($firstLog, $user, 1);
                
                $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
                $this->get('security.token_storage')->setToken($token);
                $this->get('session')->set('_security_main', serialize($token));
                
                return $this->redirectToRoute('input');
            }
;
            
        }

        return $this->render('default/reg.html.twig', array(
            'form' => $form->createView(),
            'error' => $error
        ));
    }
}
