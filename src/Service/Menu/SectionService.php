<?php

/**
 * Class SectionService
 *
 * This service handles subscription-related checks, such as determining whether
 * a user has an active subscription and retrieving the current subscription.
 *
 * @package App\Service\Menu
 * @author Jean Mermoz Effi
 * @email jeanmermozeffi@gmail.com
 * @version 1.0
 * @created 16/12/2024
 */

namespace App\Service\Menu;
use App\Entity\Section;
use App\Repository\SectionRepository;

class SectionService
{
    private SectionRepository $sectionRepository;

    public function __construct(SectionRepository $sectionRepository)
    {
        $this->sectionRepository = $sectionRepository;
    }

    public function initializeSectionOrder(Section $section): void
    {
        if ($section->getSectionOrder() === null) {
            $maxOrder = $this->sectionRepository->findMaxSectionOrder();
            $section->setSectionOrder($maxOrder + 1);
        }
    }
}