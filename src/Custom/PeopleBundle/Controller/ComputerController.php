<?php

namespace Custom\PeopleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Custom\PeopleBundle\Entity\Computer;
use Custom\PeopleBundle\Form\ComputerType;

/**
 * Computer controller.
 *
 */
class ComputerController extends Controller
{
    /**
     * Lists all Computer entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('PeopleBundle:Computer')->findAll();

        return $this->render('PeopleBundle:Computer:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Computer entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PeopleBundle:Computer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Computer entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PeopleBundle:Computer:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to create a new Computer entity.
     *
     */
    public function newAction()
    {
        $entity = new Computer();
        $form   = $this->createForm(new ComputerType(), $entity);

        return $this->render('PeopleBundle:Computer:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Computer entity.
     *
     */
    public function createAction()
    {
        $entity  = new Computer();
        $request = $this->getRequest();
        $form    = $this->createForm(new ComputerType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('computer_show', array('id' => $entity->getId())));
            
        }

        return $this->render('PeopleBundle:Computer:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Computer entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PeopleBundle:Computer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Computer entity.');
        }

        $editForm = $this->createForm(new ComputerType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PeopleBundle:Computer:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Computer entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PeopleBundle:Computer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Computer entity.');
        }

        $editForm   = $this->createForm(new ComputerType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('computer_edit', array('id' => $id)));
        }

        return $this->render('PeopleBundle:Computer:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Computer entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('PeopleBundle:Computer')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Computer entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('computer'));
    }

    /**
     * Creates delete form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
