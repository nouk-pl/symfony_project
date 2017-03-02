<?php

namespace ImieBundle\Controller;

use ImieBundle\Entity\person;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Person controller.
 *
 * @Route("person")
 */
class personController extends Controller
{
    /**
     * Lists all person entities.
     *
     * @Route("/", name="person_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $people = $em->getRepository('ImieBundle:person')->findAll();

        return $this->render('person/index.html.twig', array(
            'people' => $people,
        ));
    }

    /**
     * Creates a new person entity.
     *
     * @Route("/new", name="person_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $person = new Person();
        $form = $this->createForm('ImieBundle\Form\personType', $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush($person);

            return $this->redirectToRoute('person_show', array('id' => $person->getId()));
        }

        return $this->render('person/new.html.twig', array(
            'person' => $person,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a person entity.
     *
     * @Route("/{id}", name="person_show")
     * @Method("GET")
     */
    public function showAction(person $person)
    {
        $deleteForm = $this->createDeleteForm($person);

        return $this->render('person/show.html.twig', array(
            'person' => $person,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing person entity.
     *
     * @Route("/{id}/edit", name="person_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, person $person)
    {
        $deleteForm = $this->createDeleteForm($person);
        $editForm = $this->createForm('ImieBundle\Form\personType', $person);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('person_edit', array('id' => $person->getId()));
        }

        return $this->render('person/edit.html.twig', array(
            'person' => $person,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a person entity.
     *
     * @Route("/{id}", name="person_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, person $person)
    {
        $form = $this->createDeleteForm($person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($person);
            $em->flush($person);
        }

        return $this->redirectToRoute('person_index');
    }

    /**
     * Creates a form to delete a person entity.
     *
     * @param person $person The person entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(person $person)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('person_delete', array('id' => $person->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
