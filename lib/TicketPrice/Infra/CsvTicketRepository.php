<?php
declare(strict_types=1);

namespace Ngmy\TicketPrice\Infra;

use Ngmy\TicketPrice\Domain\Model\Ticket;
use Ngmy\TicketPrice\Domain\Model\Tickets;
use Ngmy\TicketPrice\Domain\Model\TicketPrice;
use Ngmy\TicketPrice\Domain\Model\TicketPrices;
use Ngmy\TicketPrice\Domain\Model\TicketPriceType;
use Ngmy\TicketPrice\Domain\Model\TicketPriceDayType;
use Ngmy\TicketPrice\Domain\Model\TicketPriceTimeType;
use Ngmy\TicketPrice\Domain\Model\TicketRepositoryInterface;
use Ngmy\TicketPrice\Domain\Type\Money\Money;

class CsvTicketRepository implements TicketRepositoryInterface
{
    private const FILE = __DIR__ . '/tickets.csv';

    public function all(): Tickets
    {
        return Tickets::of(array_map(function (array $rows) {
            return Ticket::of(
                intval($rows[0]),
                $rows[1],
                $this->makeTicketPrices($rows[2], $rows[3], $rows[4], $rows[5], $rows[6]),
                $rows[7]
            );
        }, $this->getData()));
    }

    private function getData(): array
    {
        $data = [];

        $handle = fopen(self::FILE, 'r');
        while ($rows = fgetcsv($handle)) {
            $data[] = $rows;
        }
        fclose($handle);

        return $data;
    }

    private function makeTicketPrices($amount1, $amount2, $amount3, $amount4, $amount5): TicketPrices
    {
        return TicketPrices::of([
            TicketPrice::of(empty($amount1) ? null : Money::of(intval($amount1)), TicketPriceType::of(
                TicketPriceDayType::weekday(),
                TicketPriceTimeType::normal()
            )),
            TicketPrice::of(empty($amount2) ? null : Money::of(intval($amount2)), TicketPriceType::of(
                TicketPriceDayType::weekday(),
                TicketPriceTimeType::late()
            )),
            TicketPrice::of(empty($amount3) ? null : Money::of(intval($amount3)), TicketPriceType::of(
                TicketPriceDayType::holiday(),
                TicketPriceTimeType::normal()
            )),
            TicketPrice::of(empty($amount4) ? null : Money::of(intval($amount4)), TicketPriceType::of(
                TicketPriceDayType::holiday(),
                TicketPriceTimeType::late()
            )),
            TicketPrice::of(empty($amount5) ? null : Money::of(intval($amount5)), TicketPriceType::of(
                TicketPriceDayType::movieDay(),
                TicketPriceTimeType::normal()
            )),
            TicketPrice::of(empty($amount5) ? null : Money::of(intval($amount5)), TicketPriceType::of(
                TicketPriceDayType::movieDay(),
                TicketPriceTimeType::late()
            )),
        ]);
    }
}
