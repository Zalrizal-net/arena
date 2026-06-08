<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use Carbon\Carbon;

class CompleteFinishedBookings extends Command
{
    protected $signature = 'booking:complete-finished';
    protected $description = 'Menyelesaikan pesanan yang jam selesainya sudah terlewati (Pelepasan dana ke Seller)';

    public function handle()
    {
        $now = Carbon::now();

        // Ambil semua booking yang statusnya sudah dibayar dan dikonfirmasi
        $bookings = Booking::where('status', 'confirmed')->get();

        foreach ($bookings as $booking) {
            $endDateTime = Carbon::parse($booking->booking_date->format('Y-m-d') . ' ' . $booking->end_time);

            // Jika waktu saat ini sudah melewati jadwal selesai main
            if ($now->greaterThan($endDateTime)) {
                
                $booking->update([
                    'status' => 'completed'
                ]);

                $this->info("Booking {$booking->booking_code} telah diselesaikan. Dana siap diteruskan ke Seller.");
            }
        }

        $this->info('Pengecekan jadwal selesai dijalankan.');
    }
}