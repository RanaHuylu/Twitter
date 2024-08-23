<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Post;

class MentionNotification extends Notification
{
    use Queueable;

    protected $mention;
    protected $comment;
    protected $post;

    /**
     * Create a new notification instance.
     */
    public function __construct($mention)
    {
        $this->mention = $mention;
        $this->comment = $mention->comment;
        $this->post = $mention->post_id ? Post::find($mention->post_id) : null;
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Yoruma etiketlediniz.',
            'comment_id' => $this->comment ? $this->comment->id : null,
            'post_id' => $this->comment && $this->comment->post ? $this->comment->post->id : null,
            'url' => route('mentions.comment', $this->mention->id),        ];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['database'];
    }


    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable)
    {
        return [
            'message' => "{$notifiable->name} seni yorumda etiketledi.",
            'url' => url("/comments/{$this->comment->id}"),
            'comment_id' => $this->comment->id,
        ];
    }
}
