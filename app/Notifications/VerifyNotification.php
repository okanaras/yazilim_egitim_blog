<?php

namespace App\Notifications;

use App\Models\EmailTheme;
use App\Models\EmailThemesActive;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public string $token)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $theme = EmailThemesActive::query()
            ->with("themeActive")
            ->whereHas("themeActive")
            ->where("process_id", 1)
            ->firstOrFail();


        $theme = $theme->themeActive;

        if ($theme->getRawOriginal("theme_type") == 1) {

            $theme = str_replace(
                [
                    "{username}",
                    "useremail",
                    "http://{link}",
                    "https://{link}"
                ],
                [
                    $notifiable->name,
                    $notifiable->email,
                    route('verify-token', ['token' => $this->token]),
                    route('verify-token', ['token' => $this->token])
                ],
                json_decode($theme->body)
            );

            return (new MailMessage)
                ->view('email.custom', ['theme' => $theme]);
        }
        return (new MailMessage)
            ->line("Merhaba $notifiable->name, hosgeldin.")
            ->line("Lutfen asagidaki linkten email adresinizi dogrulayiniz.")
            ->action('Mailimi dogrula', route('verify-token', ['token' => $this->token]))
            ->line('Aramiza hosgeldiniz!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}