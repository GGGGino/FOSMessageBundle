<?php

namespace FOS\MessageBundle\Provider;

use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\Model\ThreadInterface;

/**
 * Provides threads for the current authenticated user.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
interface ProviderInterface
{
    /**
     * Gets the thread in the inbox of the current user.
     *
     * @param ParticipantInterface|null $participant
     * @return ThreadInterface[]
     */
    public function getInboxThreads(ParticipantInterface $participant = null);

    /**
     * Gets the thread in the sentbox of the current user.
     *
     * @param ParticipantInterface|null $participant
     * @return ThreadInterface[]
     */
    public function getSentThreads(ParticipantInterface $participant = null);

    /**
     * Gets the deleted threads of the current user.
     *
     * @param ParticipantInterface|null $participant
     * @return ThreadInterface[]
     */
    public function getDeletedThreads(ParticipantInterface $participant = null);

    /**
     * Gets a thread by its ID
     * Performs authorization checks
     * Marks the thread as read.
     *
     * @param $threadId
     * @param ParticipantInterface|null $participant
     * @return ThreadInterface
     */
    public function getThread($threadId, ParticipantInterface $participant = null);

    /**
     * Tells how many unread messages the authenticated participant has.
     *
     * @param ParticipantInterface|null $participant
     * @return int the number of unread messages
     */
    public function getNbUnreadMessages(ParticipantInterface $participant = null);
}
