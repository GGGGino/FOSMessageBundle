<?php

namespace FOS\MessageBundle\SpamDetection;

use FOS\MessageBundle\FormModel\NewThreadMessage;
use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\Security\ParticipantProviderInterface;
use Ornicar\AkismetBundle\Akismet\AkismetInterface;

class AkismetSpamDetector implements SpamDetectorInterface
{
    /**
     * @var AkismetInterface
     */
    protected $akismet;

    /**
     * @var ParticipantProviderInterface
     */
    protected $participantProvider;

    public function __construct(AkismetInterface $akismet, ParticipantProviderInterface $participantProvider)
    {
        $this->akismet = $akismet;
        $this->participantProvider = $participantProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function isSpam(NewThreadMessage $message, ParticipantInterface $participant = null)
    {
        $participant = $participant ?: $this->participantProvider->getAuthenticatedParticipant();

        return $this->akismet->isSpam(array(
            'comment_author' => (string) $participant,
            'comment_content' => $message->getBody(),
        ));
    }
}
