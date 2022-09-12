<?php

namespace App\Security\Voter;

use App\Entity\Payment;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class PaymentVoter extends Voter
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
            && $subject instanceof Payment;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        $payment = $subject;

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

    private function canDelete(Payment $payment, User $user): bool
    {
        if (in_array('ROLE_ADMIN', $user->getRoles()) or $user === $payment->getWhoAuthor()) {
            return true;
        }
        return false;
    }

    private function canEdit(Payment $payment, User $user): bool
    {
        if (in_array('ROLE_ADMIN', $user->getRoles()) or $user === $payment->getWhoAuthor()) {
            return true;
        }
        return false;
    }
}
