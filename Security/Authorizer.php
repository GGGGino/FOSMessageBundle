<?php

namespace FOS\MessageBundle\Security;

use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\Model\ThreadInterface;

/**
 * Manages permissions to manipulate threads and messages.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class Authorizer implements AuthorizerInterface
{
    /**
     * @var ParticipantProviderInterface
     */
    protected $participantProvider;

    public function __construct(ParticipantProviderInterface $participantProvider)
    {
        $this->participantProvider = $participantProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function canSeeThread(ThreadInterface $thread, ParticipantInterface $participant = null)
    {
        $realParticipant = $participant ?: $this->getAuthenticatedParticipant();
//        var_dump(
//            get_class($realParticipant),
//            $realParticipant->getId(),
//            $thread->isParticipant($realParticipant),
//            $thread->getId(),
//            array_map(function($item) { return $item->getId(); }, $thread->getParticipants())
//        );
        return $realParticipant && $thread->isParticipant($realParticipant);
    }

    /**
     * {@inheritdoc}
     */
    public function canDeleteThread(ThreadInterface $thread, ParticipantInterface $participant = null)
    {
        return $this->canSeeThread($thread, $participant);
    }

    /**
     * {@inheritdoc}
     */
    public function canMessageParticipant(ParticipantInterface $participant)
    {
        return true;
    }

    /**
     * Gets the current authenticated user.
     *
     * @return ParticipantInterface
     */
    protected function getAuthenticatedParticipant()
    {
        return $this->participantProvider->getAuthenticatedParticipant();
    }
}
