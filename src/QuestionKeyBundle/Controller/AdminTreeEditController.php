<?php

namespace QuestionKeyBundle\Controller;

use Doctrine\ORM\Mapping\Entity;

use QuestionKeyBundle\StatsDateRange;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use QuestionKeyBundle\Form\Type\AdminTreeEditType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 *  @license 3-clause BSD
 *  @link https://github.com/QuestionKey/QuestionKey-Core
 */
class AdminTreeEditController extends AdminTreeController
{


    public function editAction($treeId)
    {


        // build
        $return = $this->build($treeId);

        //data
        $form = $this->createForm(new AdminTreeEditType(), $this->tree);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $doctrine = $this->getDoctrine()->getManager();
                $doctrine->persist($this->tree);
                $doctrine->flush();
                return $this->redirect($this->generateUrl('questionkey_admin_tree_show', array(
                    'treeId'=>$this->tree->getPublicId()
                )));
            }
        }

        return $this->render('QuestionKeyBundle:AdminTreeEdit:edit.html.twig', array(
            'form' => $form->createView(),
            'tree'=>$this->tree,
        ));


    }

}