<?php

namespace FOS\MessageBundle\SpamDetection;

use FOS\MessageBundle\FormModel\NewThreadMessage;
use FOS\MessageBundle\Model\ParticipantInterface;

class NoopSpamDetector implements SpamDetectorInterface
{
    /**
     * {@inheritdoc}
     */
    public function isSpam(NewThreadMessage $message, ParticipantInterface $participant = null)
    {
        return false;
    }
}
