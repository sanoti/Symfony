<?php

namespace App\Security\Voter;

use App\Entity\Party;
use App\Entity\User;
use phpDocumentor\Reflection\Types\True_;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class PartyVoter extends Voter
{
    public const NEW = 'new';
    public const SHOW = 'show';
    public const EDIT = 'edit';
    public const DELETE = 'delete';

    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::NEW, self::SHOW, self::EDIT, self::DELETE])
            && $subject instanceof Party;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        $payment = $subject;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::SHOW:
            case self::NEW:
                return (in_array('ROLE_USER', $user->getRoles())
                    or in_array('ROLE_ADMIN', $user->getRoles()));

            case self::EDIT:
                return $this->canEdit($payment, $user);

            case self::DELETE:
                return $this->canDelete($payment, $user);

        }

        return false;
    }

    private function canDelete(Party $party, User $user): bool
    {
        if (in_array('ROLE_ADMIN', $user->getRoles()) or $user === $party->getWhoAuthor() or $user === $party->getGuests()->get()) {
            return true;
        }
        return false;
    }

    private function canEdit(Party $party, User $user): bool
    {
        if (in_array('ROLE_ADMIN', $user->getRoles()) or $this->guestFromParty($user, $party) or $user === $party->getWhoAuthor()) {
            return true;
        }
        return false;
    }

    private function guestFromParty(User $user, Party $party): bool
    {
        $guests = $party->getGuests();

        foreach ($guests as $guest)
        {
            if ($guest->getWhoUser() == $user->getId())
            {
                return true;
            }
        }
        return false;
    }
}
