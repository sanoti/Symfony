<?php


namespace App\EventListener;

use App\Entity\User;
use App\Helper\Interface\AuthorInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Contracts\EventDispatcher\Event;

class AuthorListener implements EventSubscriber
{

    public function __construct(
        protected TokenStorageInterface $tokenStorage
    )
    {

    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {

        $entity = $args->getObject();

        if (!($entity instanceof AuthorInterface)){
            return;
        }

        if ($this->tokenStorage->getToken()){
            $user = $this->tokenStorage->getToken()->getUser();
            if ($user instanceof User){
                $entity->setWhoAuthor($user);
            }
        }
    }
}