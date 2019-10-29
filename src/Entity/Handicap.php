<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HandicapRepository")
 */
class Handicap
{
    /**
    * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Structure")
     * @ORM\JoinColumn(nullable=false)
     */
    private $structureId;

    /**
    * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeHandicap")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeHandicapId;

    public function getStructureId(): ?Structure
    {
        return $this->structureId;
    }

    public function setStructureId(?Structure $structureId): self
    {
        $this->structureId = $structureId;

        return $this;
    }

    public function getTypeHandicapId(): ?TypeHandicap
    {
        return $this->typeHandicapId;
    }

    public function setTypeHandicapId(?TypeHandicap $typeHandicapId): self
    {
        $this->typeHandicapId = $typeHandicapId;

        return $this;
    }
}
