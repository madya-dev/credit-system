<?php

namespace App\Filament\Resources\CreditResource\Actions;

use Filament\Tables\Actions\Action;
use App\Models\Payment;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;

class PaymentAction extends Action
{
  public static function make(?string $name = "Bayar"): static
  {
    return parent::make($name)
      ->label('Bayar')
      ->color('gray')
      ->icon('heroicon-o-credit-card')
      ->form([
        TextInput::make('payment_amount')
          ->label('Jumlah Bayar')
          ->numeric()
          ->required()
          ->minValue(0)
          ->placeholder('Masukan Jumlah Bayar'),
      ])
      ->modalHeading('Bayar')
      ->modalSubmitActionLabel('Konfirmasi')
      ->action(function ($record, array $data) {
        $record->update([
          'pay_amt' => $record->pay_amt + $data['payment_amount']
        ]);

        $payment = $record->payments()->where('statement_id', $record->id)->first();
        if ($payment) {
          $payment['amount_paid'] = $payment->amount_paid + $data['payment_amount'];
          $payment->save();
        } else {
          Payment::create([
            'client_id' => $record->client_id,
            'statement_id' => $record->id,
            'amount_paid' => $data['payment_amount'],
            'payment_date' => now(),
            'payment_status' => 'completed'
          ]);
        }

        Notification::make()
          ->title('Pembayaran Berhasil')
          ->success()
          ->send();
      })
      ->hidden(function ($record) {
        return $record->pay_amt > 0;
      });
  }
}
