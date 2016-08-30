<?php

namespace Peg\Bundles\ApiBundle\GraphQL\Resolver;

final class CommentResolver
{
    public function resolveCommentsByPegEvent($pegEvents): array
    {
        return [
            [
                'id' => 'b614f268-6d73-462c-b4fd-708e804f1f91',
                'comment' => 'This is a comment!',
                'user_id' => '87baac55-3cb4-4d00-af3f-fc466faa899a',
                'happenedAt' => (new \DateTime('2016-08-25 11:39:10'))->format(DATE_ATOM),
            ],
        ];
    }
}
