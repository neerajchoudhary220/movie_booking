<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Screen;
use App\Models\Seat;
use Illuminate\Support\Str;

class SeatSeeder extends Seeder
{
    public function run()
    {
        // For each screen, ensure seats exist according to rows x cols
        Screen::query()->each(function (Screen $screen) {
            $totalCreated = 0;

            for ($r = 1; $r <= (int) $screen->rows; $r++) {
                $rowLabel = $this->numToLetters($r); // 1->A, 2->B, ... 27->AA

                for ($c = 1; $c <= (int) $screen->cols; $c++) {
                    // seat_number like A01, A02 ... zero-padded to 2 (or 3 if big halls)
                    $seatNumber = $rowLabel . str_pad((string)$c, $this->colPadWidth($screen->cols), '0', STR_PAD_LEFT);

                    Seat::updateOrCreate(
                        [
                            'screen_id'  => $screen->id,
                            'row_index'  => $r,
                            'col_number' => $c,
                        ],
                        [
                            'row_label'     => $rowLabel,
                            'seat_number'   => $seatNumber,
                            'type'          => $this->inferType($r, $screen->rows), // e.g., last few rows VIP
                            'status'        => Seat::STATUS_AVAILABLE,
                            'price_override' => null,
                        ]
                    );

                    $totalCreated++;
                }
            }

            // (Optional) Keep screen capacity in sync
            if ((int) $screen->capacity !== $screen->rows * $screen->cols) {
                $screen->capacity = $screen->rows * $screen->cols;
                $screen->save();
            }

            // You could log per screen if needed
            // info("Seeded {$totalCreated} seats for Screen {$screen->name} (ID {$screen->id})");
        });
    }

    /**
     * Convert 1-based number to Excel-like letters (1->A, 26->Z, 27->AA, 28->AB, ...)
     */
    protected function numToLetters(int $num): string
    {
        $letters = '';
        while ($num > 0) {
            $rem = ($num - 1) % 26;
            $letters = chr(65 + $rem) . $letters;
            $num = intdiv($num - 1, 26);
        }
        return $letters;
    }

    /**
     * Pad width for column numbers: 1..9 -> 1 digit, 10..99 -> 2, etc.
     * Common cinema look is 2 digits; we auto-choose based on max cols.
     */
    protected function colPadWidth(int $maxCols): int
    {
        if ($maxCols >= 100) return 3;
        if ($maxCols >= 10)  return 2;
        return 2; // force 2-digit style (01,02...) for consistency
    }

    /**
     * Example seat type distribution:
     *  - Front 60% rows = regular
     *  - Next 30% rows  = premium
     *  - Last 10% rows  = vip
     */
    protected function inferType(int $rowIndex, int $totalRows): string
    {
        $cutRegular = (int) floor($totalRows * 0.60);
        $cutPremium = (int) floor($totalRows * 0.90);

        if ($rowIndex <= $cutRegular) return 'regular';
        if ($rowIndex <= $cutPremium) return 'premium';
        return 'vip';
    }
}
