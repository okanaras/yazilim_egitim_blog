<?php

namespace App\Mail;

use App\Models\User;
use App\Models\EmailTheme;
use App\Models\EmailThemesActive;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(public User $user, public string $token)
    {
        //
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Parola Sifirlama Maili',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        $theme = EmailThemesActive::query()
            ->with("themeActive")
            ->whereHas("themeActive")
            ->where("process_id", 2)
            ->firstOrFail();

        $theme = $theme->themeActive;

        if ($theme->getRawOriginal("theme_type") == 2) {

            $theme = json_decode($theme->body);

            return new Content(
                view: 'email.reset-password',
                with: ['theme' => $theme, 'token' => $this->token]

            );
        } else if ($theme->getRawOriginal("theme_type") == 1) {

            $theme = str_replace(
                [
                    "{username}",
                    "useremail",
                    "http://{link}",
                    "https://{link}"
                ],
                [
                    $this->user->name,
                    $this->user->email,
                    route('verify-token', ['token' => $this->token])
                ],
                json_decode($theme->body)
            );

            return new Content(
                view: 'email.reset-password',
                with: ['theme' => $theme]

            );
        }

        return new Content(
            view: 'email.reset-password',
            with: ['user' => $this->user, 'token' => $this->token, 'title' => 'Parola Sifirlama']

        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}