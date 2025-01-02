<?php

namespace Database\Seeders;

use App\Models\CreditCardStatement;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreditCardStatementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $creditData = [
            [
                'client_id' => 11, // Nasabah tepat waktu
                'limit_bal' => 120000,
                'statements' => [
                    ['bill_amt' => 25325, 'pay_amt' => 2500, 'bill_date' => now()->subMonths(5), 'payment_delay' => -2], // 2 hari sebelum jatuh tempo
                    ['bill_amt' => 23832, 'pay_amt' => 2100, 'bill_date' => now()->subMonths(4), 'payment_delay' => -1],
                    ['bill_amt' => 22346, 'pay_amt' => 1800, 'bill_date' => now()->subMonths(3), 'payment_delay' => -3],
                    ['bill_amt' => 21786, 'pay_amt' => 2200, 'bill_date' => now()->subMonths(2), 'payment_delay' => -1],
                    ['bill_amt' => 20123, 'pay_amt' => 1950, 'bill_date' => now()->subMonths(1), 'payment_delay' => -2],
                    ['bill_amt' => 19236, 'pay_amt' => 1850, 'bill_date' => now(), 'payment_delay' => -1],
                ]
            ],
            [
                'client_id' => 2, // Nasabah sering telat 2 bulan
                'limit_bal' => 90000,
                'statements' => [
                    ['bill_amt' => 45549, 'pay_amt' => 1518, 'bill_date' => now()->subMonths(5), 'payment_delay' => 60],
                    ['bill_amt' => 42135, 'pay_amt' => 1425, 'bill_date' => now()->subMonths(4), 'payment_delay' => 58],
                    ['bill_amt' => 39854, 'pay_amt' => 1782, 'bill_date' => now()->subMonths(3), 'payment_delay' => 62],
                    ['bill_amt' => 38127, 'pay_amt' => 1623, 'bill_date' => now()->subMonths(2), 'payment_delay' => 59],
                    ['bill_amt' => 36758, 'pay_amt' => 1405, 'bill_date' => now()->subMonths(1), 'payment_delay' => 61],
                    ['bill_amt' => 35942, 'pay_amt' => 1340, 'bill_date' => now(), 'payment_delay' => 60],
                ]
            ],
            [
                'client_id' => 3, // Nasabah telat 1-2 bulan
                'limit_bal' => 50000,
                'statements' => [
                    ['bill_amt' => 35835, 'pay_amt' => 1250, 'bill_date' => now()->subMonths(5), 'payment_delay' => 45],
                    ['bill_amt' => 34521, 'pay_amt' => 1180, 'bill_date' => now()->subMonths(4), 'payment_delay' => 35],
                    ['bill_amt' => 32897, 'pay_amt' => 1320, 'bill_date' => now()->subMonths(3), 'payment_delay' => 55],
                    ['bill_amt' => 31456, 'pay_amt' => 1145, 'bill_date' => now()->subMonths(2), 'payment_delay' => 40],
                    ['bill_amt' => 30123, 'pay_amt' => 1078, 'bill_date' => now()->subMonths(1), 'payment_delay' => 38],
                    ['bill_amt' => 29874, 'pay_amt' => 1215, 'bill_date' => now(), 'payment_delay' => 42],
                ]
            ],
            [
                'client_id' => 4, // Nasabah dengan pola pembayaran bervariasi
                'limit_bal' => 75000,
                'statements' => [
                    ['bill_amt' => 57110, 'pay_amt' => 2000, 'bill_date' => now()->subMonths(5), 'payment_delay' => -1],
                    ['bill_amt' => 55324, 'pay_amt' => 1875, 'bill_date' => now()->subMonths(4), 'payment_delay' => 15],
                    ['bill_amt' => 53267, 'pay_amt' => 1925, 'bill_date' => now()->subMonths(3), 'payment_delay' => 45],
                    ['bill_amt' => 51892, 'pay_amt' => 1850, 'bill_date' => now()->subMonths(2), 'payment_delay' => 30],
                    ['bill_amt' => 50134, 'pay_amt' => 1780, 'bill_date' => now()->subMonths(1), 'payment_delay' => -2],
                    ['bill_amt' => 48756, 'pay_amt' => 1650, 'bill_date' => now(), 'payment_delay' => 10],
                ]
            ],
            [
                'client_id' => 5, // Nasabah tepat waktu
                'limit_bal' => 200000,
                'statements' => [
                    ['bill_amt' => 67318, 'pay_amt' => 3500, 'bill_date' => now()->subMonths(5), 'payment_delay' => -3],
                    ['bill_amt' => 65234, 'pay_amt' => 3250, 'bill_date' => now()->subMonths(4), 'payment_delay' => -2],
                    ['bill_amt' => 63187, 'pay_amt' => 3100, 'bill_date' => now()->subMonths(3), 'payment_delay' => -1],
                    ['bill_amt' => 61234, 'pay_amt' => 3000, 'bill_date' => now()->subMonths(2), 'payment_delay' => -2],
                    ['bill_amt' => 59876, 'pay_amt' => 2950, 'bill_date' => now()->subMonths(1), 'payment_delay' => -3],
                    ['bill_amt' => 58234, 'pay_amt' => 2850, 'bill_date' => now(), 'payment_delay' => -1],
                ]
            ],
            [
                'client_id' => 6, // Nasabah telat 1 bulan kemudian membaik
                'limit_bal' => 260000,
                'statements' => [
                    ['bill_amt' => 89166, 'pay_amt' => 4500, 'bill_date' => now()->subMonths(5), 'payment_delay' => 30],
                    ['bill_amt' => 87234, 'pay_amt' => 4250, 'bill_date' => now()->subMonths(4), 'payment_delay' => 25],
                    ['bill_amt' => 85645, 'pay_amt' => 4100, 'bill_date' => now()->subMonths(3), 'payment_delay' => 15],
                    ['bill_amt' => 83234, 'pay_amt' => 3950, 'bill_date' => now()->subMonths(2), 'payment_delay' => 5],
                    ['bill_amt' => 81567, 'pay_amt' => 3850, 'bill_date' => now()->subMonths(1), 'payment_delay' => -1],
                    ['bill_amt' => 79876, 'pay_amt' => 3750, 'bill_date' => now(), 'payment_delay' => -2],
                ]
            ],
            [
                'client_id' => 7, // Nasabah tepat waktu kemudian terlambat
                'limit_bal' => 630000,
                'statements' => [
                    ['bill_amt' => 180573, 'pay_amt' => 7500, 'bill_date' => now()->subMonths(5), 'payment_delay' => -2],
                    ['bill_amt' => 175234, 'pay_amt' => 7250, 'bill_date' => now()->subMonths(4), 'payment_delay' => -1],
                    ['bill_amt' => 170876, 'pay_amt' => 7100, 'bill_date' => now()->subMonths(3), 'payment_delay' => 15],
                    ['bill_amt' => 168234, 'pay_amt' => 6950, 'bill_date' => now()->subMonths(2), 'payment_delay' => 25],
                    ['bill_amt' => 165432, 'pay_amt' => 6850, 'bill_date' => now()->subMonths(1), 'payment_delay' => 35],
                    ['bill_amt' => 162345, 'pay_amt' => 6750, 'bill_date' => now(), 'payment_delay' => 45],
                ]
            ],
            [
                'client_id' => 8, // Nasabah selalu telat 2 bulan
                'limit_bal' => 70000,
                'statements' => [
                    ['bill_amt' => 40797, 'pay_amt' => 1200, 'bill_date' => now()->subMonths(5), 'payment_delay' => 60],
                    ['bill_amt' => 39234, 'pay_amt' => 1150, 'bill_date' => now()->subMonths(4), 'payment_delay' => 62],
                    ['bill_amt' => 38123, 'pay_amt' => 1100, 'bill_date' => now()->subMonths(3), 'payment_delay' => 59],
                    ['bill_amt' => 37234, 'pay_amt' => 1050, 'bill_date' => now()->subMonths(2), 'payment_delay' => 61],
                    ['bill_amt' => 36543, 'pay_amt' => 1025, 'bill_date' => now()->subMonths(1), 'payment_delay' => 58],
                    ['bill_amt' => 35876, 'pay_amt' => 1015, 'bill_date' => now(), 'payment_delay' => 60],
                ]
            ],
            [
                'client_id' => 9, // Nasabah tepat waktu
                'limit_bal' => 250000,
                'statements' => [
                    ['bill_amt' => 70246, 'pay_amt' => 3800, 'bill_date' => now()->subMonths(5), 'payment_delay' => -3],
                    ['bill_amt' => 68543, 'pay_amt' => 3650, 'bill_date' => now()->subMonths(4), 'payment_delay' => -2],
                    ['bill_amt' => 66987, 'pay_amt' => 3500, 'bill_date' => now()->subMonths(3), 'payment_delay' => -1],
                    ['bill_amt' => 65432, 'pay_amt' => 3400, 'bill_date' => now()->subMonths(2), 'payment_delay' => -2],
                    ['bill_amt' => 63876, 'pay_amt' => 3300, 'bill_date' => now()->subMonths(1), 'payment_delay' => -1],
                    ['bill_amt' => 62345, 'pay_amt' => 3200, 'bill_date' => now(), 'payment_delay' => -2],
                ]
            ],
            [
                'client_id' => 10, // Nasabah dengan keterlambatan bervariasi
                'limit_bal' => 180000,
                'statements' => [
                    ['bill_amt' => 52774, 'pay_amt' => 2800, 'bill_date' => now()->subMonths(5), 'payment_delay' => 15],
                    ['bill_amt' => 51234, 'pay_amt' => 2650, 'bill_date' => now()->subMonths(4), 'payment_delay' => 45],
                    ['bill_amt' => 49876, 'pay_amt' => 2500, 'bill_date' => now()->subMonths(3), 'payment_delay' => 30],
                    ['bill_amt' => 48543, 'pay_amt' => 2400, 'bill_date' => now()->subMonths(2), 'payment_delay' => 20],
                    ['bill_amt' => 47234, 'pay_amt' => 2300, 'bill_date' => now()->subMonths(1), 'payment_delay' => 35],
                    ['bill_amt' => 46123, 'pay_amt' => 2200, 'bill_date' => now(), 'payment_delay' => 25],
                ]
            ],
        ];

        foreach ($creditData as $data) {
            foreach ($data['statements'] as $statement) {
                $creditStatement = CreditCardStatement::create([
                    'client_id' => $data['client_id'],
                    'bill_amt' => $statement['bill_amt'],
                    'bill_date' => $statement['bill_date'],
                    'pay_amt' => $statement['pay_amt'],
                ]);

                // Create payment record with varied payment dates
                if ($statement['pay_amt'] > 0) {
                    // Calculate payment date based on bill_date and payment_delay
                    $paymentDate = Carbon::parse($statement['bill_date'])->addDays($statement['payment_delay']);

                    Payment::create([
                        'statement_id' => $creditStatement->id,
                        'client_id' => $data['client_id'],
                        'amount_paid' => $statement['pay_amt'],
                        'payment_date' => $paymentDate,
                        'payment_status' => 'completed',
                    ]);
                }
            }
        }
    }
}
