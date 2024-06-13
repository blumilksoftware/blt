<?php

declare(strict_types=1);

namespace Blumilk\BLT\Helpers;

enum TypesEnum: string
{
    case MODEL = "model";
    case JOB = "job";
    case POLICY = "policy";
    case REQUEST = "request";
    case RESOURCE = "resource";
    case SEEDER = "seeder";
    case ENUM = "enum";
    case EVENT = "event";
    case LISTENER = "listener";
    case MIDDLEWARE = "middleware";
    case NOTIFICATION = "notification";
    case PROVIDER = "provider";
    case SERVICE = "service";
}
