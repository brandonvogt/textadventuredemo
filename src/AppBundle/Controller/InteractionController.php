<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Interaction;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Interaction controller.
 *
 * @Route("admin/interaction")
 */
class InteractionController extends Controller
{
    /**
     * Lists all interaction entities.
     *
     * @Route("/", name="admin_interaction_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $interactions = $em->getRepository('AppBundle:Interaction')->findAll();

        return $this->render('interaction/index.html.twig', array(
            'interactions' => $interactions,
        ));
    }

    /**
     * Creates a new interaction entity.
     *
     * @Route("/new", name="admin_interaction_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $interaction = new Interaction();
        $form = $this->createForm('AppBundle\Form\InteractionType', $interaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($interaction);
            $em->flush($interaction);

            return $this->redirectToRoute('admin_interaction_show', array('id' => $interaction->getId()));
        }

        return $this->render('interaction/new.html.twig', array(
            'interaction' => $interaction,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a interaction entity.
     *
     * @Route("/{id}", name="admin_interaction_show")
     * @Method("GET")
     */
    public function showAction(Interaction $interaction)
    {
        $deleteForm = $this->createDeleteForm($interaction);

        return $this->render('interaction/show.html.twig', array(
            'interaction' => $interaction,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing interaction entity.
     *
     * @Route("/{id}/edit", name="admin_interaction_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Interaction $interaction)
    {
        $deleteForm = $this->createDeleteForm($interaction);
        $editForm = $this->createForm('AppBundle\Form\InteractionType', $interaction);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_interaction_edit', array('id' => $interaction->getId()));
        }

        return $this->render('interaction/edit.html.twig', array(
            'interaction' => $interaction,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a interaction entity.
     *
     * @Route("/{id}", name="admin_interaction_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Interaction $interaction)
    {
        $form = $this->createDeleteForm($interaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($interaction);
            $em->flush($interaction);
        }

        return $this->redirectToRoute('admin_interaction_index');
    }

    /**
     * Creates a form to delete a interaction entity.
     *
     * @param Interaction $interaction The interaction entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Interaction $interaction)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_interaction_delete', array('id' => $interaction->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
