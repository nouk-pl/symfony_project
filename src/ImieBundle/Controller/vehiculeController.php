<?php

namespace ImieBundle\Controller;

use ImieBundle\Entity\vehicule;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vehicule controller.
 *
 * @Route("vehicule")
 */
class vehiculeController extends Controller
{
    /**
     * Lists all vehicule entities.
     *
     * @Route("/", name="vehicule_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vehicules = $em->getRepository('ImieBundle:vehicule')->findAll();

        return $this->render('vehicule/index.html.twig', array(
            'vehicules' => $vehicules,
        ));
    }

    /**
     * Creates a new vehicule entity.
     *
     * @Route("/new", name="vehicule_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $vehicule = new Vehicule();
        $form = $this->createForm('ImieBundle\Form\vehiculeType', $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vehicule);
            $em->flush($vehicule);

            return $this->redirectToRoute('vehicule_show', array('id' => $vehicule->getId()));
        }

        return $this->render('vehicule/new.html.twig', array(
            'vehicule' => $vehicule,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a vehicule entity.
     *
     * @Route("/{id}", name="vehicule_show")
     * @Method("GET")
     */
    public function showAction(vehicule $vehicule)
    {
        $deleteForm = $this->createDeleteForm($vehicule);

        return $this->render('vehicule/show.html.twig', array(
            'vehicule' => $vehicule,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vehicule entity.
     *
     * @Route("/{id}/edit", name="vehicule_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, vehicule $vehicule)
    {
        $deleteForm = $this->createDeleteForm($vehicule);
        $editForm = $this->createForm('ImieBundle\Form\vehiculeType', $vehicule);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vehicule_edit', array('id' => $vehicule->getId()));
        }

        return $this->render('vehicule/edit.html.twig', array(
            'vehicule' => $vehicule,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a vehicule entity.
     *
     * @Route("/{id}", name="vehicule_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, vehicule $vehicule)
    {
        $form = $this->createDeleteForm($vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vehicule);
            $em->flush($vehicule);
        }

        return $this->redirectToRoute('vehicule_index');
    }

    /**
     * Creates a form to delete a vehicule entity.
     *
     * @param vehicule $vehicule The vehicule entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(vehicule $vehicule)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vehicule_delete', array('id' => $vehicule->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
