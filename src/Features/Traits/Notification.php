<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Blumilk\BLT\Helpers\ContextHelper;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Notifications\Dispatcher;
use Illuminate\Support\Testing\Fakes\NotificationFake;

trait Notification
{
    use Application;

    public NotificationFake $notificationFake;

    /**
     * @Given notifications are being faked
     * @throws BindingResolutionException
     */
    public function fakeNotifications(): void
    {
        $this->notificationFake = $this->getContainer()->make(NotificationFake::class);
        $this->getContainer()->instance(Dispatcher::class, $this->notificationFake);
    }

    /**
     * @Given :notification notification is sent
     * @Given :notification notification is sent to :object with :value value in :field field
     */
    public function sendNotification(string $notification, string $object = "User", string $value = "", string $field = ""): void
    {
        $object = $this->getNotifiable($object, $field, $value);
        $notificationClass = ContextHelper::getClassHelper()->recognizeObjectClass($notification);

        $this->notificationFake->send($object, new $notificationClass());
    }

    /**
     * @Then :notification notification was sent
     * @Then :notification notification was sent :count times
     */
    public function assertNotificationSent(string $notification, int $count = 1): void
    {
        $notificationClass = ContextHelper::getClassHelper()->recognizeObjectClass($notification);
        $this->notificationFake->assertSentTimes($notificationClass, $count);
    }

    /**
     * @Then :notification notification was sent to :object with :value value in :field field
     */
    public function assertNotificationSentToUser(string $notification, string $object, string $value, string $field): void
    {
        $object = $this->getNotifiable($object, $field, $value);

        $notificationClass = ContextHelper::getClassHelper()->recognizeObjectClass($notification);
        $this->notificationFake->assertSentTo($object, $notificationClass);
    }

    /**
     * @Then :notification was not sent to :object with :value value in :field field
     */
    public function assertNotificationNotSent(string $notification, string $object, string $value, string $field): void
    {
        $object = $this->getNotifiable($object, $field, $value);

        $notificationClass = ContextHelper::getClassHelper()->recognizeObjectClass($notification);
        $this->notificationFake->assertNotSentTo($object, $notificationClass);
    }

    /**
     * @Then not one notification was sent
     */
    public function assertNothingWasSent(): void
    {
        $this->notificationFake->assertNothingSent();
    }

    private function getNotifiable(string $object, string $field, string $value): object
    {
        return ContextHelper::getClassHelper()->recognizeObjectClass($object)::query()->where($field, $value)->first();
    }
}
