<?php

namespace TaskBundle\Repository;

/**
 * TaskRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TaskRepository extends \Doctrine\ORM\EntityRepository
{
	public function findTasksIndex($taskCategory=0, $done=0)
    {
      if($taskCategory == 0 || $taskCategory == '')
      	$taskCategory = '1=1';
      else
      	$taskCategory = 't.taskCategory = '. $taskCategory;

      $em = $this->getEntityManager();
      $qb = $em->createQueryBuilder();

      $q  = $qb->select(array('t'))
               ->from('TaskBundle:Task', 't')
               ->where('t.done='.$done)
               ->andWhere($taskCategory)
               ->orderBy('t.taskCategory', 'DESC')
               ->getQuery();

      return $q->getResult();


      /*$em = $this->getEntityManager();
      $repository = $this->getEntityManager()->getDoctrine()->getRepository('TaskBundle:Task');

    // createQueryBuilder() automatically selects FROM AppBundle:Product
    // and aliases it to "p"
    $query = $repository->createQueryBuilder('t')
        ->where('t.taskCategory = :taskCategory')
        ->setParameter('taskCategory', $taskCategory)
        ->orderBy('t.important', 'DESC')
        ->getQuery();

     return $query->getResult();
*/
    }
}
