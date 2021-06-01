<?php

namespace FOS\MessageBundle\FormHandler;

use FOS\MessageBundle\FormModel\AbstractMessage;
use FOS\MessageBundle\FormModel\NewThreadMultipleMessage;
use FOS\MessageBundle\Model\MessageInterface;
use FOS\MessageBundle\Model\ParticipantInterface;

/**
 * Form handler for multiple recipients support.
 *
 * @author Łukasz Pospiech <zocimek@gmail.com>
 */
class NewThreadMultipleMessageFormHandler extends AbstractMessageFormHandler
{
    /**
     * Composes a message from the form data.
     *
     * @param AbstractMessage $message
     * @param ParticipantInterface|null $sender
     *
     * @throws \InvalidArgumentException if the message is not a NewThreadMessage
     *
     * @return MessageInterface the composed message ready to be sent
     */
    public function composeMessage(AbstractMessage $message, ParticipantInterface $sender = null)
    {
        if (!$message instanceof NewThreadMultipleMessage) {
            throw new \InvalidArgumentException(sprintf('Message must be a NewThreadMultipleMessage instance, "%s" given', get_class($message)));
        }

        $realSender = $sender ?: $this->getAuthenticatedParticipant();

        return $this->composer->newThread()
            ->setSubject($message->getSubject())
            ->addRecipients($message->getRecipients())
            ->setSender($realSender)
            ->setBody($message->getBody())
            ->getMessage();
    }
}
