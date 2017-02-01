<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Log;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Log controller.
 *
 * @Route("admin/log")
 */
class LogController extends Controller
{
    /**
     * Lists all log entities.
     *
     * @Route("/", name="admin_log_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $logs = $em->getRepository('AppBundle:Log')->findAll();

        return $this->render('log/index.html.twig', array(
            'logs' => $logs,
        ));
    }

    /**
     * Creates a new log entity.
     *
     * @Route("/new", name="admin_log_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $log = new Log();
        $form = $this->createForm('AppBundle\Form\LogType', $log);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($log);
            $em->flush($log);

            return $this->redirectToRoute('admin_log_show', array('id' => $log->getId()));
        }

        return $this->render('log/new.html.twig', array(
            'log' => $log,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a log entity.
     *
     * @Route("/{id}", name="admin_log_show")
     * @Method("GET")
     */
    public function showAction(Log $log)
    {
        $deleteForm = $this->createDeleteForm($log);

        return $this->render('log/show.html.twig', array(
            'log' => $log,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing log entity.
     *
     * @Route("/{id}/edit", name="admin_log_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Log $log)
    {
        $deleteForm = $this->createDeleteForm($log);
        $editForm = $this->createForm('AppBundle\Form\LogType', $log);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_log_edit', array('id' => $log->getId()));
        }

        return $this->render('log/edit.html.twig', array(
            'log' => $log,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a log entity.
     *
     * @Route("/{id}", name="admin_log_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Log $log)
    {
        $form = $this->createDeleteForm($log);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($log);
            $em->flush($log);
        }

        return $this->redirectToRoute('admin_log_index');
    }

    /**
     * Creates a form to delete a log entity.
     *
     * @param Log $log The log entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Log $log)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_log_delete', array('id' => $log->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
