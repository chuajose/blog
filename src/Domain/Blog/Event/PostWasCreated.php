<?php declare(strict_types=1);

namespace App\Domain\Blog\Event;


use App\Domain\Blog\Model\Post;
use App\Domain\Shared\Event\Event;

class PostWasCreated implements Event
{
    private Post $post;

    public function __construct( Post $post) {
        $this->post = $post;
    }

    #[\Override]
    public function eventName(): string {

        return __CLASS__;
    }

    /**
     * @return array<string, string>
     */
    #[\Override]
    public function payload(): array {
        return [
            'id' => $this->post->id()->toRfc4122(),
            'user_id' => $this->post->author()->id()->toRfc4122(),
        ];
    }

}