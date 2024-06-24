<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Blumilk\BLT\Helpers\RecognizeClassHelper;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Testing\Fakes\NotificationFake;

trait Notification
{
    use Application;

    public NotificationFake $notificationFake;

    /**
     * @Given notifications are being faked
     *
     * @throws BindingResolutionException
     */
    public function fakeNotifications(): void
    {
        $this->notificationFake = $this->getContainer()->make(NotificationFake::class);
        $this->getContainer()->instance(\Illuminate\Support\Facades\Notification::class,$this->notificationFake);
    }

    /**
     * @Given :notification notification is sent
     * @Given :notification notification is sent to :object with :value value in :field field
     */
    public function sendNotification(string $notification, string $object = "User", string $value = "", string $field = ""): void
    {
        $object = RecognizeClassHelper::recognizeObjectClass($object)::query()->where($field, $value)->first();
        $notificationClass = RecognizeClassHelper::recognizeObjectClass($notification);

        $this->notificationFake->send($object, new $notificationClass());
    }

    /**
     * @Then :notification notification was sent
     * @Then :notification notification was sent :count times
     */
    public function assertNotificationSent(string $notification, int $count = 1): void
    {
        $notificationClass = RecognizeClassHelper::recognizeObjectClass($notification);
        $this->notificationFake->assertSentTimes($notificationClass, $count);
    }
}
