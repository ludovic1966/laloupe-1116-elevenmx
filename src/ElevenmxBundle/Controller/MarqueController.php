<?php

namespace ElevenmxBundle\Controller;

use ElevenmxBundle\Entity\Marque;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Marque controller.
 *
 */
class MarqueController extends Controller
{
    /**
     * Lists all marque entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $marques = $em->getRepository('ElevenmxBundle:Marque')->findAll();

        return $this->render('ElevenmxBundle:marque:index.html.twig', array(
            'marques' => $marques,
        ));
    }

    /**
     * Creates a new marque entity.
     *
     */
    public function newAction(Request $request)
    {
        $marque = new Marque();
        $form = $this->createForm('ElevenmxBundle\Form\MarqueType', $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($marque);
            $em->flush($marque);

            return $this->redirectToRoute('marque_show', array('id' => $marque->getId()));
        }

        return $this->render('ElevenmxBundle:marque:new.html.twig', array(
            'marque' => $marque,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a marque entity.
     *
     */
    public function showAction(Marque $marque)
    {
        $deleteForm = $this->createDeleteForm($marque);

        return $this->render('ElevenmxBundle:marque:show.html.twig', array(
            'marque' => $marque,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing marque entity.
     *
     */
    public function editAction(Request $request, Marque $marque)
    {
        $deleteForm = $this->createDeleteForm($marque);
        $editForm = $this->createForm('ElevenmxBundle\Form\MarqueType', $marque);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('marque_edit', array('id' => $marque->getId()));
        }

        return $this->render('ElevenmxBundle:marque:edit.html.twig', array(
            'marque' => $marque,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a marque entity.
     *
     */
    public function deleteAction(Request $request, Marque $marque)
    {
        $form = $this->createDeleteForm($marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($marque);
            $em->flush($marque);
        }

        return $this->redirectToRoute('marque_index');
    }

    /**
     * Creates a form to delete a marque entity.
     *
     * @param Marque $marque The marque entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Marque $marque)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('marque_delete', array('id' => $marque->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
