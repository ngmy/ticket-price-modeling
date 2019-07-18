<?php
declare(strict_types=1);

namespace Tests\TicketPrice\App;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Ngmy\TicketPrice\App\TicketPriceService;
use Ngmy\TicketPrice\App\GetTicketPriceByCommand;

class TicketPriceServiceTest extends TestCase
{
    public function getTicketPriceByProvider(): array
    {
        $weekday  = '2019-07-18';
        $holiday  = '2019-07-20';
        $movieDayWeekday = '2019-08-01';
        $movieDayHoliday = '2019-09-01';

        $normalTime = '19:59:59';
        $lateTime = '20:00:00';

        $movieStartDateTime1 = "$weekday $normalTime";
        $movieStartDateTime2 = "$weekday $lateTime";
        $movieStartDateTime3 = "$holiday $normalTime";
        $movieStartDateTime4 = "$holiday $lateTime";
        $movieStartDateTime5 = "$movieDayWeekday $normalTime";
        $movieStartDateTime6 = "$movieDayWeekday $lateTime";
        $movieStartDateTime7 = "$movieDayHoliday $normalTime";
        $movieStartDateTime8 = "$movieDayHoliday $lateTime";

        return [
            'シネマシティズン・平日・通常'                               => [ 1, $movieStartDateTime1, false, false, false, 1000],
            'シネマシティズン・平日・レイト'                             => [ 1, $movieStartDateTime2, false, false, false, 1000],
            'シネマシティズン・土日祝・通常'                             => [ 1, $movieStartDateTime3, false, false, false, 1300],
            'シネマシティズン・土日祝・レイト'                           => [ 1, $movieStartDateTime4, false, false, false, 1000],
            'シネマシティズン・映画の日（平日）・通常'                   => [ 1, $movieStartDateTime5, false, false, false, 1000],
            'シネマシティズン・映画の日（平日）・レイト'                 => [ 1, $movieStartDateTime6, false, false, false, 1000],
            'シネマシティズン・映画の日（土日祝）・通常'                 => [ 1, $movieStartDateTime7, false, false, false, 1100],
            'シネマシティズン・映画の日（土日祝）・レイト'               => [ 1, $movieStartDateTime8, false, false, false, 1000],

            'シネマシティズン（60才以上）・平日・通常'                   => [ 2, $movieStartDateTime1, false, false, false, 1000],
            'シネマシティズン（60才以上）・平日・レイト'                 => [ 2, $movieStartDateTime2, false, false, false, 1000],
            'シネマシティズン（60才以上）・土日祝・通常'                 => [ 2, $movieStartDateTime3, false, false, false, 1000],
            'シネマシティズン（60才以上）・土日祝・レイト'               => [ 2, $movieStartDateTime4, false, false, false, 1000],
            'シネマシティズン（60才以上）・映画の日（平日）・通常'       => [ 2, $movieStartDateTime5, false, false, false, 1000],
            'シネマシティズン（60才以上）・映画の日（平日）・レイト'     => [ 2, $movieStartDateTime6, false, false, false, 1000],
            'シネマシティズン（60才以上）・映画の日（土日祝）・通常'     => [ 2, $movieStartDateTime7, false, false, false, 1000],
            'シネマシティズン（60才以上）・映画の日（土日祝）・レイト'   => [ 2, $movieStartDateTime8, false, false, false, 1000],

            '一般・平日・通常'                                           => [ 3, $movieStartDateTime1, false, false, false, 1800],
            '一般・平日・レイト'                                         => [ 3, $movieStartDateTime2, false, false, false, 1300],
            '一般・土日祝・通常'                                         => [ 3, $movieStartDateTime3, false, false, false, 1800],
            '一般・土日祝・レイト'                                       => [ 3, $movieStartDateTime4, false, false, false, 1300],
            '一般・映画の日（平日）・通常'                               => [ 3, $movieStartDateTime5, false, false, false, 1100],
            '一般・映画の日（平日）・レイト'                             => [ 3, $movieStartDateTime6, false, false, false, 1100],
            '一般・映画の日（土日祝）・通常'                             => [ 3, $movieStartDateTime7, false, false, false, 1100],
            '一般・映画の日（土日祝）・レイト'                           => [ 3, $movieStartDateTime8, false, false, false, 1100],

            'シニア（70才以上）・平日・通常'                             => [ 4, $movieStartDateTime1, false, false, false, 1100],
            'シニア（70才以上）・平日・レイト'                           => [ 4, $movieStartDateTime2, false, false, false, 1100],
            'シニア（70才以上）・土日祝・通常'                           => [ 4, $movieStartDateTime3, false, false, false, 1100],
            'シニア（70才以上）・土日祝・レイト'                         => [ 4, $movieStartDateTime4, false, false, false, 1100],
            'シニア（70才以上）・映画の日（平日）・通常'                 => [ 4, $movieStartDateTime5, false, false, false, 1100],
            'シニア（70才以上）・映画の日（平日）・レイト'               => [ 4, $movieStartDateTime6, false, false, false, 1100],
            'シニア（70才以上）・映画の日（土日祝）・通常'               => [ 4, $movieStartDateTime7, false, false, false, 1100],
            'シニア（70才以上）・映画の日（土日祝）・レイト'             => [ 4, $movieStartDateTime8, false, false, false, 1100],

            '学生（大・専）・平日・通常'                                 => [ 5, $movieStartDateTime1, false, false, false, 1500],
            '学生（大・専）・平日・レイト'                               => [ 5, $movieStartDateTime2, false, false, false, 1300],
            '学生（大・専）・土日祝・通常'                               => [ 5, $movieStartDateTime3, false, false, false, 1500],
            '学生（大・専）・土日祝・レイト'                             => [ 5, $movieStartDateTime4, false, false, false, 1300],
            '学生（大・専）・映画の日（平日）・通常'                     => [ 5, $movieStartDateTime5, false, false, false, 1100],
            '学生（大・専）・映画の日（平日）・レイト'                   => [ 5, $movieStartDateTime6, false, false, false, 1100],
            '学生（大・専）・映画の日（土日祝）・通常'                   => [ 5, $movieStartDateTime7, false, false, false, 1100],
            '学生（大・専）・映画の日（土日祝）・レイト'                 => [ 5, $movieStartDateTime8, false, false, false, 1100],

            '中・高校生・平日・通常'                                     => [ 6, $movieStartDateTime1, false, false, false, 1000],
            '中・高校生・平日・レイト'                                   => [ 6, $movieStartDateTime2, false, false, false, 1000],
            '中・高校生・土日祝・通常'                                   => [ 6, $movieStartDateTime3, false, false, false, 1000],
            '中・高校生・土日祝・レイト'                                 => [ 6, $movieStartDateTime4, false, false, false, 1000],
            '中・高校生・映画の日（平日）・通常'                         => [ 6, $movieStartDateTime5, false, false, false, 1000],
            '中・高校生・映画の日（平日）・レイト'                       => [ 6, $movieStartDateTime6, false, false, false, 1000],
            '中・高校生・映画の日（土日祝）・通常'                       => [ 6, $movieStartDateTime7, false, false, false, 1000],
            '中・高校生・映画の日（土日祝）・レイト'                     => [ 6, $movieStartDateTime8, false, false, false, 1000],

            '幼児（3才以上）・小学生・平日・通常'                        => [ 7, $movieStartDateTime1, false, false, false, 1000],
            '幼児（3才以上）・小学生・平日・レイト'                      => [ 7, $movieStartDateTime2, false, false, false, 1000],
            '幼児（3才以上）・小学生・土日祝・通常'                      => [ 7, $movieStartDateTime3, false, false, false, 1000],
            '幼児（3才以上）・小学生・土日祝・レイト'                    => [ 7, $movieStartDateTime4, false, false, false, 1000],
            '幼児（3才以上）・小学生・映画の日（平日）・通常'            => [ 7, $movieStartDateTime5, false, false, false, 1000],
            '幼児（3才以上）・小学生・映画の日（平日）・レイト'          => [ 7, $movieStartDateTime6, false, false, false, 1000],
            '幼児（3才以上）・小学生・映画の日（土日祝）・通常'          => [ 7, $movieStartDateTime7, false, false, false, 1000],
            '幼児（3才以上）・小学生・映画の日（土日祝）・レイト'        => [ 7, $movieStartDateTime8, false, false, false, 1000],

            '障がい者（学生以上）・平日・通常'                           => [ 8, $movieStartDateTime1, false, false, false, 1000],
            '障がい者（学生以上）・平日・レイト'                         => [ 8, $movieStartDateTime2, false, false, false, 1000],
            '障がい者（学生以上）・土日祝・通常'                         => [ 8, $movieStartDateTime3, false, false, false, 1000],
            '障がい者（学生以上）・土日祝・レイト'                       => [ 8, $movieStartDateTime4, false, false, false, 1000],
            '障がい者（学生以上）・映画の日（平日）・通常'               => [ 8, $movieStartDateTime5, false, false, false, 1000],
            '障がい者（学生以上）・映画の日（平日）・レイト'             => [ 8, $movieStartDateTime6, false, false, false, 1000],
            '障がい者（学生以上）・映画の日（土日祝）・通常'             => [ 8, $movieStartDateTime7, false, false, false, 1000],
            '障がい者（学生以上）・映画の日（土日祝）・レイト'           => [ 8, $movieStartDateTime8, false, false, false, 1000],
            '障がい者（高校以下）・平日・通常'                           => [ 9, $movieStartDateTime1, false, false, false,  900],
            '障がい者（高校以下）・平日・レイト'                         => [ 9, $movieStartDateTime2, false, false, false,  900],
            '障がい者（高校以下）・土日祝・通常'                         => [ 9, $movieStartDateTime3, false, false, false,  900],
            '障がい者（高校以下）・土日祝・レイト'                       => [ 9, $movieStartDateTime4, false, false, false,  900],
            '障がい者（高校以下）・映画の日（平日）・通常'               => [ 9, $movieStartDateTime5, false, false, false,  900],
            '障がい者（高校以下）・映画の日（平日）・レイト'             => [ 9, $movieStartDateTime6, false, false, false,  900],
            '障がい者（高校以下）・映画の日（土日祝）・通常'             => [ 9, $movieStartDateTime7, false, false, false,  900],
            '障がい者（高校以下）・映画の日（土日祝）・レイト'           => [ 9, $movieStartDateTime8, false, false, false,  900],

            '夫婦50割引・平日・通常'                                     => [10, $movieStartDateTime1, false, false, false, 2200],
            '夫婦50割引・平日・レイト'                                   => [10, $movieStartDateTime2, false, false, false, 2200],
            '夫婦50割引・土日祝・通常'                                   => [10, $movieStartDateTime3, false, false, false, 2200],
            '夫婦50割引・土日祝・レイト'                                 => [10, $movieStartDateTime4, false, false, false, 2200],
            '夫婦50割引・映画の日（平日）・通常'                         => [10, $movieStartDateTime5, false, false, false, 2200],
            '夫婦50割引・映画の日（平日）・レイト'                       => [10, $movieStartDateTime6, false, false, false, 2200],
            '夫婦50割引・映画の日（土日祝）・通常'                       => [10, $movieStartDateTime7, false, false, false, 2200],
            '夫婦50割引・映画の日（土日祝）・レイト'                     => [10, $movieStartDateTime8, false, false, false, 2200],

            'エムアイカード・平日・通常'                                 => [11, $movieStartDateTime1, false, false, false, 1600],
            'エムアイカード・平日・レイト'                               => [11, $movieStartDateTime2, false, false, false, 1300],
            'エムアイカード・土日祝・通常'                               => [11, $movieStartDateTime3, false, false, false, 1600],
            'エムアイカード・土日祝・レイト'                             => [11, $movieStartDateTime4, false, false, false, 1300],
            'エムアイカード・映画の日（平日）・通常'                     => [11, $movieStartDateTime5, false, false, false, 1600],
            'エムアイカード・映画の日（平日）・レイト'                   => [11, $movieStartDateTime6, false, false, false, 1300],
            'エムアイカード・映画の日（土日祝）・通常'                   => [11, $movieStartDateTime7, false, false, false, 1600],
            'エムアイカード・映画の日（土日祝）・レイト'                 => [11, $movieStartDateTime8, false, false, false, 1300],

            '駐車場パーク80割引・平日・通常'                             => [12, $movieStartDateTime1, false, false, false, 1400],
            '駐車場パーク80割引・平日・レイト'                           => [12, $movieStartDateTime2, false, false, false, 1100],
            '駐車場パーク80割引・土日祝・通常'                           => [12, $movieStartDateTime3, false, false, false, 1400],
            '駐車場パーク80割引・土日祝・レイト'                         => [12, $movieStartDateTime4, false, false, false, 1100],
            '駐車場パーク80割引・映画の日（平日）・通常'                 => [12, $movieStartDateTime5, false, false, false, 1400],
            '駐車場パーク80割引・映画の日（平日）・レイト'               => [12, $movieStartDateTime6, false, false, false, 1100],
            '駐車場パーク80割引・映画の日（土日祝）・通常'               => [12, $movieStartDateTime7, false, false, false, 1400],
            '駐車場パーク80割引・映画の日（土日祝）・レイト'             => [12, $movieStartDateTime8, false, false, false, 1100],

            '一般・平日・通常・3D作品・3Dメガネ非持参'                   => [ 3, $movieStartDateTime1, true,  false, false, 2200],
            '一般・平日・通常・3D作品・3Dメガネ持参'                     => [ 3, $movieStartDateTime1, true,   true, false, 2100],

            'シネマシティズン・平日・通常・極上爆音上映'                 => [ 1, $movieStartDateTime1, false, false,  true, 1000],
            'シネマシティズン・平日・レイト・極上爆音上映'               => [ 1, $movieStartDateTime2, false, false,  true, 1000],
            'シネマシティズン・土日祝・通常・極上爆音上映'               => [ 1, $movieStartDateTime3, false, false,  true, 1300],
            'シネマシティズン・土日祝・レイト・極上爆音上映'             => [ 1, $movieStartDateTime4, false, false,  true, 1300],
            'シネマシティズン・映画の日（平日）・通常・極上爆音上映'     => [ 1, $movieStartDateTime5, false, false,  true, 1000],
            'シネマシティズン・映画の日（平日）・レイト・極上爆音上映'   => [ 1, $movieStartDateTime6, false, false,  true, 1000],
            'シネマシティズン・映画の日（土日祝）・通常・極上爆音上映'   => [ 1, $movieStartDateTime7, false, false,  true, 1100],
            'シネマシティズン・映画の日（土日祝）・レイト・極上爆音上映' => [ 1, $movieStartDateTime8, false, false,  true, 1100],
        ];
    }

    /**
     * @dataProvider getTicketPriceByProvider
     */
    public function testGetTicketPriceBy(
        int $ticketId,
        string $movieStartDateTime,
        bool $isThreeDimensionalMovie,
        bool $hasThreeDimensionalGlasses,
        bool $isGokubakuScreening,
        int $expectedResult
    ): void {
        $service = app(TicketPriceService::class);

        $command = new GetTicketPriceByCommand($ticketId, $movieStartDateTime);
        $command
            ->setIsThreeDimensionalMovie($isThreeDimensionalMovie)
            ->setHasThreeDimensionalGlasses($hasThreeDimensionalGlasses)
            ->setIsGokubakuScreening($isGokubakuScreening)
            ;

        $actualResult = $service->getTicketPriceBy($command);

        $this->assertEquals($expectedResult, $actualResult);
    }
}
