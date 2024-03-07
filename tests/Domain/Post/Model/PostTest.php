<?php declare(strict_types=1);

namespace App\Tests\Domain\Post\Model;

use App\Domain\Blog\Event\PostWasCreated;
use App\Domain\Blog\Model\Post;
use App\Domain\Shared\Messenger\MessengerBusInterface;
use App\Domain\User\Model\User;
use App\Domain\User\ValueObject\EmailAddress;

class PostTest extends \PHPUnit\Framework\TestCase
{
    private const TITLE = 'title';
    private const BODY = 'content';
    private const AUTHOR_NAME= 'jose';
    private const AUTHOR_EMAIL= 'example@example.com';

    public function testCreatePostReturnPost(): void
    {
        $post = Post::create(self::TITLE, self::BODY, User::create(self::AUTHOR_NAME, EmailAddress::fromString(self::AUTHOR_EMAIL)));
        self::assertInstanceOf(Post::class, $post);
        self::assertSame(self::TITLE, $post->title());
        self::assertSame(self::BODY, $post->body());
        self::assertInstanceOf(User::class, $post->author());
    }


    public function testCreatePostGenerateEvent(): void
    {
        $post = Post::create(self::TITLE, self::BODY, User::create(self::AUTHOR_NAME, EmailAddress::fromString(self::AUTHOR_EMAIL)));
        self::assertCount(1, $post->getEvents());
        self::assertInstanceOf(PostWasCreated::class, $post->getEvents()[0]);
    }

    public function testEventGeneratedWhenCreatedPost(): void
    {
        $post = Post::create(self::TITLE, self::BODY, User::create(self::AUTHOR_NAME, EmailAddress::fromString(self::AUTHOR_EMAIL)));
        self::assertCount(1, $post->getEvents());
        self::assertInstanceOf(PostWasCreated::class, $post->getEvents()[0]);

        self::assertSame(PostWasCreated::class, $post->getEvents()[0]->eventName());
        self::assertIsArray($post->getEvents()[0]->payload());
        self::assertArrayHasKey('id', $post->getEvents()[0]->payload());
        self::assertArrayHasKey('user_id', $post->getEvents()[0]->payload());
        self::assertSame($post->id()->toRfc4122(), $post->getEvents()[0]->payload()['id']);
        self::assertSame($post->author()->id()->toRfc4122(), $post->getEvents()[0]->payload()['user_id']);

    }

}