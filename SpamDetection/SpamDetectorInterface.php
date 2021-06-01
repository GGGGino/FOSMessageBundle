<?php

namespace FOS\MessageBundle\SpamDetection;

use FOS\MessageBundle\FormModel\NewThreadMessage;
use FOS\MessageBundle\Model\ParticipantInterface;

/**
 * Tells whether or not a new message looks like spam.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
interface SpamDetectorInterface
{
    /**
     * Tells whether or not a new message looks like spam.
     *
     * @param NewThreadMessage $message
     * @param ParticipantInterface|null $participant
     *
     * @return bool true if it is spam, false otherwise
     */
    public function isSpam(NewThreadMessage $message, ParticipantInterface $participant = null);
}
