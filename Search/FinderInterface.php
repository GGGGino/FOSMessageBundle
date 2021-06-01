<?php

namespace FOS\MessageBundle\Search;

use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\Model\ThreadInterface;

/**
 * Finds threads of a participant, matching a given query.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
interface FinderInterface
{
    /**
     * Finds threads of a participant, matching a given query.
     *
     * @param Query $query
     * @param ParticipantInterface|null $participant
     *
     * @return ThreadInterface[]
     */
    public function find(Query $query, ParticipantInterface $participant = null);

    /**
     * Finds threads of a participant, matching a given query.
     *
     * @param Query $query
     * @param ParticipantInterface|null $participant
     *
     * @return Builder a query builder suitable for pagination
     */
    public function getQueryBuilder(Query $query, ParticipantInterface $participant = null);
}
