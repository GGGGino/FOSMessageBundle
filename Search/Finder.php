<?php

namespace FOS\MessageBundle\Search;

use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\ModelManager\ThreadManagerInterface;
use FOS\MessageBundle\Security\ParticipantProviderInterface;

/**
 * Finds threads of a participant, matching a given query.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class Finder implements FinderInterface
{
    /**
     * The participant provider instance.
     *
     * @var ParticipantProviderInterface
     */
    protected $participantProvider;

    /**
     * The thread manager.
     *
     * @var ThreadManagerInterface
     */
    protected $threadManager;

    public function __construct(ParticipantProviderInterface $participantProvider, ThreadManagerInterface $threadManager)
    {
        $this->participantProvider = $participantProvider;
        $this->threadManager = $threadManager;
    }

    /**
     * {@inheritdoc}
     */
    public function find(Query $query, ParticipantInterface $participant = null)
    {
        $realParticipant = $participant ?: $this->getAuthenticatedParticipant();

        return $this->threadManager->findParticipantThreadsBySearch($realParticipant, $query->getEscaped());
    }

    /**
     * {@inheritdoc}
     */
    public function getQueryBuilder(Query $query, ParticipantInterface $participant = null)
    {
        $realParticipant = $participant ?: $this->getAuthenticatedParticipant();

        return $this->threadManager->getParticipantThreadsBySearchQueryBuilder($realParticipant, $query->getEscaped());
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
