<?php

namespace App\Filament\Resources\CreditResource\Actions;

use App\Models\CreditCardStatement;
use Filament\Tables\Actions\Action;
use Filament\Support\Colors\Color;
use App\Models\DefaultPayment;
use Carbon\Carbon;
use Carbon\Month;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class CheckRisikoCreditAction extends Action
{
  public static function make(?string $name = "Check Risiko"): static
  {
    return parent::make($name)
      ->label('Check Risiko')
      ->color('warning')
      ->icon('heroicon-o-exclamation-triangle')
      ->action(function ($record) {

        if (!$record->predict) {

          $data = CreditCardStatement::where('client_id', $record->client_id)
            ->with('payments')
            ->orderByDesc('bill_date')
            ->limit(6)
            ->get();
          $client = $data->first()->client;

          $history = [
            "LIMIT_BAL" => $client->limit_bal,
            "SEX" => $client->sex == 'male' ? 1 : 2,
            "EDUCATION" => $client->education_id,
            "MARRIAGE" => $client->marriage_id,
            "AGE" => $client->age,
            "PAY_0" => ($monthDiff = $data[0]->payments
              ? (int)round(Carbon::parse($data[0]->bill_date)->diffInMonths(Carbon::parse($data[0]->payments->payment_date)))
              : (int)round(Carbon::parse($data[0]->bill_date)->diffInMonths(now()))) == 0 ? -1 : $monthDiff,
            "PAY_2" => ($monthDiff = $data[1]->payments
              ? (int)round(Carbon::parse($data[1]->bill_date)->diffInMonths(Carbon::parse($data[1]->payments->payment_date)))
              : (int)round(Carbon::parse($data[1]->bill_date)->diffInMonths(now()))) == 0 ? -1 : $monthDiff,
            "PAY_3" => ($monthDiff = $data[2]->payments
              ? (int) round(Carbon::parse($data[2]->bill_date)->diffInMonths(Carbon::parse($data[2]->payments->payment_date)))
              : (int) round(Carbon::parse($data[2]->bill_date)->diffInMonths(now()))) == 0 ? -1 : $monthDiff,
            "PAY_4" => ($monthDiff = $data[3]->payments
              ? (int)round(Carbon::parse($data[3]->bill_date)->diffInMonths(Carbon::parse($data[3]->payments->payment_date)))
              : (int)round(Carbon::parse($data[3]->bill_date)->diffInMonths(now()))) == 0 ? -1 : $monthDiff,
            "PAY_5" => ($monthDiff = $data[4]->payments
              ? (int)round(Carbon::parse($data[4]->bill_date)->diffInMonths(Carbon::parse($data[4]->payments->payment_date)))
              : (int)round(Carbon::parse($data[4]->bill_date)->diffInMonths(now()))) == 0 ? -1 : $monthDiff,
            "PAY_6" => ($monthDiff = $data[5]->payments
              ? (int)round(Carbon::parse($data[5]->bill_date)->diffInMonths(Carbon::parse($data[5]->payments->payment_date)))
              : (int)round(Carbon::parse($data[5]->bill_date)->diffInMonths(now()))) == 0 ? -1 : $monthDiff,
            "BILL_AMT1" => $data[0]->bill_amt,
            "BILL_AMT2" => $data[1]->bill_amt,
            "BILL_AMT3" => $data[2]->bill_amt,
            "BILL_AMT4" => $data[3]->bill_amt,
            "BILL_AMT5" => $data[4]->bill_amt,
            "BILL_AMT6" => $data[5]->bill_amt,
            "PAY_AMT1" => $data[0]->payments ? $data[0]->payments->amount_paid : 0,
            "PAY_AMT2" => $data[1]->payments ? $data[1]->payments->amount_paid : 0,
            "PAY_AMT3" => $data[2]->payments ? $data[2]->payments->amount_paid : 0,
            "PAY_AMT4" => $data[3]->payments ? $data[3]->payments->amount_paid : 0,
            "PAY_AMT5" => $data[4]->payments ? $data[4]->payments->amount_paid : 0,
            "PAY_AMT6" => $data[5]->payments ? $data[5]->payments->amount_paid : 0
          ];

          $response = Http::post("47.129.186.50:8000/predict", $history);
          $resJSON = $response->json();

          $d = [
            'client_id' => $record->client_id,
            'statement_id' => $record->id,
            'default_payment_next_month' => $resJSON['isLate'], // Set initial status
            'created_at' => now(),
          ];
          // dd($d);
          // Create new default payment record
          $res = DefaultPayment::create($d);

          // dd($res);

          // Show success notification
          Notification::make()
            ->title('Pengecekan risiko selesai')
            ->success()
            ->send();
        } else {
          // Show info notification that check was already done
          Notification::make()
            ->title('Risiko already checked for this statement')
            ->warning()
            ->send();
        }
      })
      ->requiresConfirmation()
      ->modalHeading('Cek Risiko Kredit')
      ->modalDescription('Yakin ingin cek risko kredit Nasabah ini?')
      ->modalSubmitActionLabel('Ya, Cek Risiko')
      ->modalCancelActionLabel('Batal')
      // Only show button if risk hasn't been checked yet
      ->hidden(function ($record) {
        $defaultPayment = $record->predict;
        return $defaultPayment !== null;
      });
  }
}
