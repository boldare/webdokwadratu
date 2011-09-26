<?php

namespace Custom\PeopleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Custom\PeopleBundle\Entity\Person;
use Custom\PeopleBundle\Form\PersonType;

/**
 * Person controller.
 *
 */
class PersonController extends Controller
{
    const PHOTOS = 5;
    const TAGS = 3;
    /**
     * Lists all Person entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('PeopleBundle:Person')->findAll();

        return $this->render('PeopleBundle:Person:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Person entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PeopleBundle:Person')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Person entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PeopleBundle:Person:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to create a new Person entity.
     *
     */
    public function newAction()
    {
        $entity = new Person();
        for($i = 0; $i < self::PHOTOS; $i++)
        {
            $entity->addPhotos(new \Custom\PeopleBundle\Entity\Photo());
        }

        for($i = 0; $i < self::TAGS; $i++)
        {
            $entity->addTags(new \Custom\PeopleBundle\Entity\Tag());
        }

        $form = $this->createForm(new PersonType(), $entity);

        return $this->render('PeopleBundle:Person:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Person entity.
     *
     */
    public function createAction()
    {
        $entity  = new Person();
        for($i = 0; $i < self::PHOTOS; $i++)
        {
            $entity->addPhotos(new \Custom\PeopleBundle\Entity\Photo());
        }

        for($i = 0; $i < self::TAGS; $i++)
        {
            $entity->addTags(new \Custom\PeopleBundle\Entity\Tag());
        }

        $request = $this->getRequest();
        $form    = $this->createForm(new PersonType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('person_show', array('id' => $entity->getId())));
            
        }

        return $this->render('PeopleBundle:Person:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Person entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PeopleBundle:Person')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Person entity.');
        }

        for ($i = count($entity->getPhotos()); $i < self::PHOTOS; $i++)
        {
            $entity->addPhotos(new \Custom\PeopleBundle\Entity\Photo());
        }

        $editForm = $this->createForm(new PersonType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PeopleBundle:Person:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Person entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PeopleBundle:Person')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Person entity.');
        }

        $editForm   = $this->createForm(new PersonType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('person_edit', array('id' => $id)));
        }

        return $this->render('PeopleBundle:Person:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Person entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('PeopleBundle:Person')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Person entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('person'));
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
