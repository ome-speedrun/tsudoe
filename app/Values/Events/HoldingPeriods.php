<?php

namespace App\Values\Events;

use App\Exceptions\Values\InvalidValueException;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;

class HoldingPeriods
{
    /** @var Collection<int, Period> */
    protected Collection $sections;

    public function __construct(
        Period ...$sections,
    ) {

        /** @var Collection<int, Period> */
        $collection = collect($sections);

        if ($collection->isEmpty()) {
            throw new InvalidValueException('Event holding periods must not be empty.');
        }

        // まずは開始日時でソート
        $sorted = $collection->sort(function (Period $a, Period $b): int {
            return CarbonImmutable::make($b->start)->diffInSeconds($a->start, absolute: false);
        });

        // 重複期間をマージ
        $merged = [];
        /** @var Period|null */
        $tmpBefore = null;
        foreach ($sorted->values() as $idx => $section) {
            $next = $sorted[$idx + 1] ?? null;
            // とりあえずtmpとマージ
            $section = $tmpBefore
                ? new Period($tmpBefore->start, max($tmpBefore->end, $section->end))
                : $section;

            // 次区間と被ってるなら次区間まで残す
            if ($next && $section->contains($next->start)) {
                $tmpBefore = $section;
                continue;
            }

            // 次がない、次と被ってないならマージ済みに格納
            $merged[] = $section;
            $tmpBefore = null;
        }

        $this->sections = collect($merged);
    }

    /**
     * @return Period[]
     */
    public function all(): array
    {
        return $this->sections->all();
    }
}
