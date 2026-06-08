<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage; // Wajib ditambahkan

class PaymentSuccessNotification extends Notification
{
    use Queueable;

    private $booking;
    private $type;

    public function __construct($booking, $type)
    {
        $this->booking = $booking;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        // Tambahkan 'mail' agar notifikasi dikirim ke database DAN email
        return ['database', 'mail'];
    }

    // FUNGSI BARU UNTUK MERAKIT EMAIL
    public function toMail($notifiable)
    {
        $priceFormatted = 'Rp ' . number_format($this->booking->total_price, 0, ',', '.');
        
        if ($this->type === 'buyer') {
            return (new MailMessage)
                ->subject('Pembayaran Berhasil - ' . $this->booking->booking_code)
                ->greeting('Halo, ' . $notifiable->name . '!')
                ->line('Pembayaran Anda untuk pesanan ' . $this->booking->booking_code . ' sebesar ' . $priceFormatted . ' telah berhasil dikonfirmasi.')
                ->line('Fasilitas: ' . $this->booking->facility->name)
                ->line('Jadwal: ' . \Carbon\Carbon::parse($this->booking->booking_date)->format('d F Y') . ' pukul ' . $this->booking->start_time . ' WIB')
                ->action('Lihat Pesanan Anda', route('buyer.dashboard'))
                ->line('Terima kasih telah menggunakan layanan kami. Selamat bermain!');
        }

        // Desain Email untuk Seller
        return (new MailMessage)
            ->subject('Pesanan Lunas - ' . $this->booking->booking_code)
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Hore! Pembayaran untuk pesanan ' . $this->booking->booking_code . ' sebesar ' . $priceFormatted . ' telah masuk.')
            ->line('Fasilitas: ' . $this->booking->facility->name)
            ->line('Jadwal: ' . \Carbon\Carbon::parse($this->booking->booking_date)->format('d F Y') . ' pukul ' . $this->booking->start_time . ' WIB')
            ->line('Nama Pemesan: ' . $this->booking->user->name)
            ->action('Kelola Pesanan', route('seller.dashboard'))
            ->line('Segera persiapkan fasilitas Anda ya!');
    }

    // Fungsi Database tetap dipertahankan
    public function toDatabase($notifiable)
    {
        if ($this->type === 'buyer') {
            return [
                'title' => 'Pembayaran Berhasil!',
                'message' => 'Pembayaran Anda untuk pesanan ' . $this->booking->booking_code . ' sebesar Rp ' . number_format($this->booking->total_price, 0, ',', '.') . ' telah berhasil dikonfirmasi. Selamat bermain!',
                'booking_id' => $this->booking->id,
                'url' => route('buyer.dashboard')
            ];
        }

        return [
            'title' => 'Pesanan Baru Telah Dibayar!',
            'message' => 'Hore! Pembayaran untuk pesanan ' . $this->booking->booking_code . ' sebesar Rp ' . number_format($this->booking->total_price, 0, ',', '.') . ' telah masuk. Segera persiapkan fasilitas Anda.',
            'booking_id' => $this->booking->id,
            'url' => route('seller.dashboard')
        ];
    }
}