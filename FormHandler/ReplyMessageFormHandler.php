<?php

namespace FOS\MessageBundle\FormHandler;

use FOS\MessageBundle\FormModel\AbstractMessage;
use FOS\MessageBundle\FormModel\ReplyMessage;
use FOS\MessageBundle\Model\MessageInterface;
use FOS\MessageBundle\Model\ParticipantInterface;

class ReplyMessageFormHandler extends AbstractMessageFormHandler
{
    /**
     * Composes a message from the form data.
     *
     * @param AbstractMessage $message
     * @param ParticipantInterface|null $sender
     *
     * @throws \InvalidArgumentException if the message is not a ReplyMessage
     *
     * @return MessageInterface the composed message ready to be sent
     */
    public function composeMessage(AbstractMessage $message, ParticipantInterface $sender = null)
    {
        if (!$message instanceof ReplyMessage) {
            throw new \InvalidArgumentException(sprintf('Message must be a ReplyMessage instance, "%s" given', get_class($message)));
        }

        $realSender = $sender ?: $this->getAuthenticatedParticipant();

        return $this->composer->reply($message->getThread())
            ->setSender($realSender)
            ->setBody($message->getBody())
            ->getMessage();
    }
}
