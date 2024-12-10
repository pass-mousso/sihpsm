<?php

namespace App\EventSubscriber;

use App\Entity\Hospital;
use App\Entity\HospitalEmails;
use App\Entity\HospitalPhoneNumbers;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class HospitalFormSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private Security $security)
    {}

    public function onFormPostSubmit(FormEvent $event): void
    {
        $form = $event->getForm();
        $hospital = $event->getData();

        if (!$hospital instanceof Hospital) {
            return;
        }

        // Récupérez le business_contact depuis le formulaire
        $businessContact = $form->get('business_contact')->getData();
        $businessEmail = $form->get('business_email')->getData();

        if ($businessContact) {
            $hospitalPhoneNumber = new HospitalPhoneNumbers();
            $hospitalPhoneNumber->setPhoneNumber($businessContact)
                ->setType($hospital::TYPE_CONTACT[3]);
            $hospital->addHospitalPhoneNumber($hospitalPhoneNumber);
        }

        if ($businessEmail) {
            $hospitalEmail = new HospitalEmails();
            $hospitalEmail->setEmail($businessEmail)
                ->setType($hospital::TYPE_EMAIL[4]);
            $hospital->addHospitalEmail($hospitalEmail);
        }

        $currentUser = $this->security->getUser();
        if ($currentUser) {
            $hospital->setOwner($currentUser);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::POST_SUBMIT => 'onFormPostSubmit',
        ];
    }
}
