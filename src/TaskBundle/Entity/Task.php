<?php

namespace TaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Task
 *
 * @ORM\Table(name="task")
 * @ORM\Entity(repositoryClass="TaskBundle\Repository\TaskRepository")
 */
class Task
{
    /**
     * @ORM\ManyToOne(targetEntity="TaskCategory", inversedBy="tasks")
     * @ORM\JoinColumn(name="taskcategory_id", referencedColumnName="id")
     */
    private $taskCategory;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="important", type="integer")
     */
    private $important;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="duedate", type="datetime")
     */
    private $duedate;

    /**
     * @var int
     *
     * @ORM\Column(name="done", type="integer")
     */
    private $done = false;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Task
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set important
     *
     * @param integer $important
     *
     * @return Task
     */
    public function setImportant($important)
    {
        $this->important = $important;

        return $this;
    }

    /**
     * Get important
     *
     * @return int
     */
    public function getImportant()
    {
        return $this->important;
    }

    /**
     * Set duedate
     *
     * @param \DateTime $duedate
     *
     * @return Task
     */
    public function setDuedate($duedate)
    {
        $this->duedate = $duedate;

        return $this;
    }

    /**
     * Get duedate
     *
     * @return \DateTime
     */
    public function getDuedate()
    {
        return $this->duedate;
    }

    /**
     * Set taskCategory
     *
     * @param \TaskBundle\Entity\TaskCategory $taskCategory
     *
     * @return Task
     */
    public function setTaskCategory(\TaskBundle\Entity\TaskCategory $taskCategory = null)
    {
        $this->taskCategory = $taskCategory;

        return $this;
    }

    /**
     * Get taskCategory
     *
     * @return \TaskBundle\Entity\TaskCategory
     */
    public function getTaskCategory()
    {
        return $this->taskCategory;
    }

    /**
     * Set done
     *
     * @param integer $done
     *
     * @return Task
     */
    public function setDone($done)
    {
        $this->done = $done;

        return $this;
    }

    /**
     * Get done
     *
     * @return int
     */
    public function getDone()
    {
        return $this->done;
    }

    public function getDaysLeft()
    {
        $diff = $this->duedate->diff(new \DateTime('now'));

        return $diff->format('%d');
    }

    
}
