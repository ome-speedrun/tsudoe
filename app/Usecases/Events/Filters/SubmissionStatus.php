<?php

namespace App\Usecases\Events\Filters;

enum SubmissionStatus: string
{
    case Open = 'open';
    case Close = 'close';
    case FutureOrNothing = 'future-or-nothing';
}
