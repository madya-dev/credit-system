<?php

namespace App\Filament\Resources\CreditResource\Actions;

use Filament\Tables\Actions\Action;
use Filament\Support\Colors\Color;
use App\Models\DefaultPayment;
use Filament\Notifications\Notification;

class CheckRisikoCreditAction extends Action
{
  public static function make(?string $name = "Check Risiko"): static
  {
    return parent::make($name)
      ->label('Check Risiko')
      ->color('warning')
      ->icon('heroicon-o-exclamation-triangle')
      ->action(function ($record) {
        // Get the bill date month
        $billDateMonth = $record->bill_date->format('m');

        // Check if default payment exists for this month
        $defaultPayment = $record->client->defaultPayment()
          ->whereMonth('created_at', $billDateMonth)
          ->first();

        if (!$defaultPayment) {
          // Create new default payment record
          DefaultPayment::create([
            'client_id' => $record->client_id,
            'default_payment_next_month' => false, // Set initial status
            'created_at' => now(),
          ]);

          // Show success notification
          Notification::make()
            ->title('Pengecekan risiko selesai')
            ->success()
            ->send();
        } else {
          // Show info notification that check was already done
          Notification::make()
            ->title('Risiko already checked for this month')
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
        $billDateMonth = $record->bill_date->format('m');
        $defaultPayment = $record->client->defaultPayment()
          ->whereMonth('created_at', $billDateMonth)
          ->first();

        return $defaultPayment !== null;
      });
  }
}
