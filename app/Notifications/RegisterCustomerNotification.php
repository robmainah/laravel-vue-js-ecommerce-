<?php

namespace App\Notifications;

use App\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RegisterCustomerNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    private $name;
    private $email;
    private $token;

    public function __construct(Customer $customer)
    {
        // return $customer;
        // $this->customer = $thisUser;
        $this->name = $customer->name;
        $this->email = $customer->email;
        $this->token = $customer->email_verified_at;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // return $this->email;
        // $url = url('/email/verify/' . $this->customer);
        return (new MailMessage)
            ->greeting('Hello ' . $this->name . ",")
            ->subject('Verify Email')
            ->line('You are receiving this email because you created an account with us.')
            ->line('Click the link below to verify your email and activate your account.')
            // ->action('Verify Email', $url)
            ->action('Verify Email', route(
                'email.verified',
                ['email' => $this->email, 'verifyToken' => $this->token]
            ))
            ->line('Thank you for using our application!');
    }

    /**z
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'data' => "First Notification"
        ];
    }
}