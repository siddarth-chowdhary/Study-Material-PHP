<?php

namespace Alpha\AlphaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Alpha\AlphaBundle\Entity\Category;
use Alpha\AlphaBundle\Form\CategoryType;


use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * Category controller.
 *
 */
class CategoryController extends Controller
{
    public function indexAction(Request $request) {
        $page = $request->get('page');
        $count_per_page = 5;
        $total_count = $this->getTotalCategories();
        $total_pages = ceil($total_count / $count_per_page);

        /* validations for pagination starts */
        //numeric check
        if (!is_numeric($page)) {
            $page = 1;
        } else {
            $page = floor($page);
        }
        //if total is less than number to be shown per page
        if ($total_count <= $count_per_page) {
            $page = 1;
        }
        //page exceeds the total result
        if (($page * $count_per_page) > $total_count) {
            $page = $total_pages;
        }
        if ($page < 0) {
            $page = 1;
        }
        //setting the offset
        $offset = 0;
        if ($page > 1) {
            $offset = $count_per_page * ($page - 1);
        }
        /* validations for pagination ends */
        
        /* get the entities based on the start values only count_per_page values */
        $em = $this->getDoctrine()->getManager();
        $categoryQuery = $em->createQueryBuilder()
                ->select('c')
                ->from('AlphaAlphaBundle:Category', 'c')
                ->orderBy('c.updated', 'DESC')
                ->setFirstResult($offset)
                ->setMaxResults($count_per_page);
        $categoryFinalQuery = $categoryQuery->getQuery();

        $entities = $categoryFinalQuery->getArrayResult();
        return $this->render('AlphaAlphaBundle:Category:index.html.twig', array(
                    'entities' => $entities,
                    'total_pages' => $total_pages,
                    'current_page' => $page
        ));

    }

    public function getTotalCategories() {
        $em = $this->getDoctrine()->getManager();
        $countQuery = $em->createQueryBuilder()
                ->select('Count(c)')
                ->from('AlphaAlphaBundle:Category', 'c');
        $finalQuery = $countQuery->getQuery();
        $total = $finalQuery->getSingleScalarResult();
        return $total;
    }
    
    public function getTotalSearchedCategories($categoryName) {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQueryBuilder('c');
        $query->select('Count(c)')
              ->where($query->expr()->like('c.name', ':name'))
              ->setParameter('name',$categoryName)  
              ->from('AlphaAlphaBundle:Category', 'c');
        $finalQuery = $query->getQuery();
        $total = $finalQuery->getSingleScalarResult();
        return $total;
    }
    
    public function searchAction(Request $request) {
        $categoryName = '%' . $request->get('cat') . '%';
        $page = $request->get('page');
        $count_per_page = 2;
        $total_count = $this->getTotalSearchedCategories($categoryName);
        $total_pages = ceil($total_count / $count_per_page);

        /* validations for pagination starts */
        //numeric check
        if (!is_numeric($page)) {
            $page = 1;
        } else {
            $page = floor($page);
        }
        //if total is less than number to be shown per page
        if ($total_count <= $count_per_page) {
            $page = 1;
        }
        //page exceeds the total result
        if (($page * $count_per_page) > $total_count) {
            $page = $total_pages;
        }
        if ($page < 0) {
            $page = 1;
        }
        //setting the offset
        $offset = 0;
        if ($page > 1) {
            $offset = $count_per_page * ($page - 1);
        }
        /* validations for pagination ends */

        /* get the entities based on the start values only count_per_page values */
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQueryBuilder('c');
        $query->select('c')
                ->where($query->expr()->like('c.name', ':name'))
                ->setParameter('name', $categoryName)
                ->from('AlphaAlphaBundle:Category', 'c')
                ->orderBy('c.updated', 'DESC')
                ->setFirstResult($offset)
                ->setMaxResults($count_per_page);
        $finalQuery = $query->getQuery();
        $entities = $finalQuery->getArrayResult();
        return $this->render('AlphaAlphaBundle:Category:index.html.twig', array(
                    'entities' => $entities,
                    'total_pages' => $total_pages,
                    'current_page' => $page
        ));
    }
    
    /**
     * Creates a new Category entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Category();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        
        if ($form->isValid()) {
            //IMP CHANGE get the user entity from session
            $userid = 1;
            $userEntity = $this->getUserEntity($userid);
            if ($userEntity) {
                $entity->setUser($userEntity);
            }
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('category_show', array('id' => $entity->getId())));
        }

        return $this->render('AlphaAlphaBundle:Category:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Category entity.
     *
     * @param Category $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Category $entity)
    {
        $form = $this->createForm(new CategoryType(), $entity, array(
            'action' => $this->generateUrl('category_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create','attr' => array('class' => 'btn btn-xs btn-info')));

        return $form;
    }

    /**
     * Displays a form to create a new Category entity.
     *
     */
    public function newAction()
    {
        $entity = new Category();
        $form   = $this->createCreateForm($entity);

        return $this->render('AlphaAlphaBundle:Category:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    
    
    public function newajaxAction(Request $request)
    {
        if ($request->isXMLHttpRequest()) {         
            $categoryName = $request->request->get('name');
            $categoryDesc = $request->request->get('desc');
            
            //IMP apply validations for category name and description
            
            $entity = new Category();
            
            $entity->setName($categoryName);
            $entity->setDescription($categoryDesc);
            
            $em = $this->getDoctrine()->getManager();
            $userid = 1;
            $userEntity = $this->getUserEntity($userid);
            if ($userEntity) {
                $entity->setUser($userEntity);
            }
            
            $em->persist($entity);
            $em->flush();
            
//            $responseURL = $this->forward('AlphaAlphaBundle:Category:index')->getContent(); 
            return new JsonResponse(array('data' => 'success'));
        } 
        
        return new Response('This is not ajax!', 400);
    }
    

    /**
     * Finds and displays a Category entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AlphaAlphaBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AlphaAlphaBundle:Category:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Category entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AlphaAlphaBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AlphaAlphaBundle:Category:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Category entity.
    *
    * @param Category $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Category $entity)
    {
        $form = $this->createForm(new CategoryType(), $entity, array(
            'action' => $this->generateUrl('category_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update','attr' => array('class' => 'btn btn-xs btn-info')));

        return $form;
    }
    /**
     * Edits an existing Category entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AlphaAlphaBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('category_edit', array('id' => $id)));
        }

        return $this->render('AlphaAlphaBundle:Category:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Category entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AlphaAlphaBundle:Category')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Category entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('category'));
    }

    /**
     * Creates a form to delete a Category entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('category_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete','attr' => array('class' => 'btn btn-xs btn-danger')))
            ->getForm()
        ;
    }
    
    
    /**
     * 
     * @param type $id the user id for which the complete user entity is fetched
     * @return user User entity for the $id
     */
    private function getUserEntity($id) {
        if ($id !== NULL) {
            $em = $this->getDoctrine()->getManager();
            $userRepository = $em->getRepository('AlphaAlphaBundle:User');
            $userEntity = $userRepository->findOneBy(array('id' => $id));
            if ($userEntity !== NULL) {
                return $userEntity;
            } else {
                return false;
            }
        } else {
                return false;
        }
    }
    
    
}
