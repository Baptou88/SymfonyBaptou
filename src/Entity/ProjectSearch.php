<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class ProjectSearch
{
    private ArrayCollection $typeProject;
    private ArrayCollection $projects;

    /**
     *
     */
    public function __construct()
    {
        $this->typeProject = new ArrayCollection();
        $this->projects = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getProjects(): ArrayCollection
    {
        return $this->projects;
    }

    /**
     * @param ArrayCollection $projects
     */
    public function setProjects(ArrayCollection $projects): void
    {
        $this->projects = $projects;
    }

    /**
     * @return ArrayCollection
     */
    public function getTypeProject(): ArrayCollection
    {
        return $this->typeProject;
    }

    /**
     * @param ArrayCollection $typeProject
     */
    public function setTypeProject(ArrayCollection $typeProject): void
    {
        $this->typeProject = $typeProject;
    }
}