<?php

namespace FOS\MessageBundle\FormHandler;

use FOS\MessageBundle\FormModel\AbstractMessage;
use FOS\MessageBundle\FormModel\NewThreadMessage;
use FOS\MessageBundle\Model\MessageInterface;
use FOS\MessageBundle\Model\ParticipantInterface;

class NewThreadMessageFormHandler extends AbstractMessageFormHandler
{
    /**
     * Composes a message from the form data.
     *
     * @param AbstractMessage $message
     * @param ParticipantInterface|null $sender
     *
     * @return MessageInterface the composed message ready to be sent
     */
    public function composeMessage(AbstractMessage $message, ParticipantInterface $sender = null)
    {
        if (!$message instanceof NewThreadMessage) {
            throw new \InvalidArgumentException(sprintf('Message must be a NewThreadMessage instance, "%s" given', get_class($message)));
        }

        $realSender = $sender ?: $this->getAuthenticatedParticipant();

        return $this->composer->newThread()
            ->setSubject($message->getSubject())
            ->addRecipient($message->getRecipient())
            ->setSender($realSender)
            ->setBody($message->getBody())
            ->getMessage();
    }
}
