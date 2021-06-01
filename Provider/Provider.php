<?php

namespace FOS\MessageBundle\Provider;

use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\ModelManager\MessageManagerInterface;
use FOS\MessageBundle\ModelManager\ThreadManagerInterface;
use FOS\MessageBundle\Reader\ReaderInterface;
use FOS\MessageBundle\Security\AuthorizerInterface;
use FOS\MessageBundle\Security\ParticipantProviderInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Provides threads for the current authenticated user.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class Provider implements ProviderInterface
{
    /**
     * The thread manager.
     *
     * @var ThreadManagerInterface
     */
    protected $threadManager;

    /**
     * The message manager.
     *
     * @var MessageManagerInterface
     */
    protected $messageManager;

    /**
     * The reader used to mark threads as read.
     *
     * @var ReaderInterface
     */
    protected $threadReader;

    /**
     * The authorizer manager.
     *
     * @var authorizerInterface
     */
    protected $authorizer;

    /**
     * The participant provider instance.
     *
     * @var ParticipantProviderInterface
     */
    protected $participantProvider;

    public function __construct(ThreadManagerInterface $threadManager, MessageManagerInterface $messageManager, ReaderInterface $threadReader, AuthorizerInterface $authorizer, ParticipantProviderInterface $participantProvider)
    {
        $this->threadManager = $threadManager;
        $this->messageManager = $messageManager;
        $this->threadReader = $threadReader;
        $this->authorizer = $authorizer;
        $this->participantProvider = $participantProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function getInboxThreads(ParticipantInterface $participant = null)
    {
        $realParticipant = $participant ?: $this->getAuthenticatedParticipant();

        return $this->threadManager->findParticipantInboxThreads($realParticipant);
    }

    /**
     * {@inheritdoc}
     */
    public function getSentThreads(ParticipantInterface $participant = null)
    {
        $realParticipant = $participant ?: $this->getAuthenticatedParticipant();

        return $this->threadManager->findParticipantSentThreads($realParticipant);
    }

    /**
     * {@inheritdoc}
     */
    public function getDeletedThreads(ParticipantInterface $participant = null)
    {
        $realParticipant = $participant ?: $this->getAuthenticatedParticipant();

        return $this->threadManager->findParticipantDeletedThreads($realParticipant);
    }

    /**
     * {@inheritdoc}
     */
    public function getThread($threadId, ParticipantInterface $participant = null)
    {
        $realParticipant = $participant ?: $this->getAuthenticatedParticipant();

        $thread = $this->threadManager->findThreadById($threadId);
        if (!$thread) {
            throw new NotFoundHttpException('There is no such thread');
        }
        if (!$this->authorizer->canSeeThread($thread, $realParticipant)) {
            throw new AccessDeniedException('You are not allowed to see this thread');
        }
        // Load the thread messages before marking them as read
        // because we want to see the unread messages
        $thread->getMessages();
        $this->threadReader->markAsRead($thread, $realParticipant);

        return $thread;
    }

    /**
     * {@inheritdoc}
     */
    public function getNbUnreadMessages(ParticipantInterface $participant = null)
    {
        $realParticipant = $participant ?: $this->getAuthenticatedParticipant();

        return $this->messageManager->getNbUnreadMessageByParticipant($realParticipant);
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
