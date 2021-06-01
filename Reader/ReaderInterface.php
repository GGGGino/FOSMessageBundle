<?php

namespace FOS\MessageBundle\Reader;

use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\Model\ReadableInterface;

/**
 * Marks messages and threads as read or unread.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
interface ReaderInterface
{
    /**
     * Marks the readable as read by the current authenticated user.
     * @param ReadableInterface $readable
     * @param ParticipantInterface|null $participant
     */
    public function markAsRead(ReadableInterface $readable, ParticipantInterface $participant = null);

    /**
     * Marks the readable as unread by the current authenticated user.
     * @param ReadableInterface $readable
     * @param ParticipantInterface|null $participant
     */
    public function markAsUnread(ReadableInterface $readable, ParticipantInterface $participant = null);
}
