<?php

declare(strict_types=1);

namespace Blumilk\BLT\Helpers;

enum TypesEnum: string
{
    case Model = "model";
    case Job = "job";
    case Policy = "policy";
    case Request = "request";
    case Resource = "resource";
    case Seeder = "seeder";
    case Enum = "enum";
    case Event = "event";
    case Listener = "listener";
    case Middleware = "middleware";
    case Notification = "notification";
    case Provider = "provider";
    case Service = "service";
}
