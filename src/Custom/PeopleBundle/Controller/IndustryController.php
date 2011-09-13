<?php

namespace Custom\PeopleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Custom\PeopleBundle\Entity\Industry;
use Custom\PeopleBundle\Form\IndustryType;

/**
 * Industry controller.
 *
 */
class IndustryController extends Controller
{
    /**
     * Lists all Industry entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('PeopleBundle:Industry')->findAll();

        return $this->render('PeopleBundle:Industry:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Industry entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PeopleBundle:Industry')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Industry entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PeopleBundle:Industry:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to create a new Industry entity.
     *
     */
    public function newAction()
    {
        $entity = new Industry();
        $form   = $this->createForm(new IndustryType(), $entity);

        return $this->render('PeopleBundle:Industry:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Industry entity.
     *
     */
    public function createAction()
    {
        $entity  = new Industry();
        $request = $this->getRequest();
        $form    = $this->createForm(new IndustryType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('industry_show', array('id' => $entity->getId())));
            
        }

        return $this->render('PeopleBundle:Industry:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Industry entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PeopleBundle:Industry')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Industry entity.');
        }

        $editForm = $this->createForm(new IndustryType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PeopleBundle:Industry:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Industry entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PeopleBundle:Industry')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Industry entity.');
        }

        $editForm   = $this->createForm(new IndustryType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('industry_edit', array('id' => $id)));
        }

        return $this->render('PeopleBundle:Industry:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Industry entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('PeopleBundle:Industry')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Industry entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('industry'));
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
