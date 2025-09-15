<?php
// 代码生成时间: 2025-09-16 02:39:37
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\MessageNotification;
use App\Models\User;
use App\Jobs\SendMessage;

// MessageNotificationSystem.php
class MessageNotificationSystem {
    public function __construct() {
        // 构造函数中可以初始化一些必要的服务或参数
    }

    /**
     * 发送消息通知
     *
     * @param User $user 用户模型实例
     * @param array $messageData 消息数据
     * @return void
     */
    public function sendMessageNotification(User $user, array $messageData): void
    {
        // 检查用户是否存在
        if (!$user) {
            Log::error('User not found for notification');
            return;
        }

        try {
            // 使用 Laravel 的通知系统发送通知
            Notification::send($user, new MessageNotification($messageData));
        } catch (Exception $e) {
            // 错误处理
            Log::error('Failed to send notification: ' . $e->getMessage());
        }
    }

    /**
     * 异步发送消息
     *
     * @param User $user 用户模型实例
     * @param array $messageData 消息数据
     * @return void
     */
    public function asyncSendMessage(User $user, array $messageData): void
    {
        // 将发送消息的任务推送到队列中，以支持异步执行
        SendMessage::dispatch($user, $messageData);
    }
}

// MessageNotification.php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\MailChannel\MailMessage;

class MessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $messageData;

    public function __construct(array $messageData)
    {
        $this->messageData = $messageData;
    }

    public function via($notifiable)
    {
        // 指定通知发送的渠道，这里以邮件为例
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        // 构建邮件通知内容
        return (new MailMessage)
            ->subject($this->messageData['subject'] ?? 'New Message')
            ->line($this->messageData['message'] ?? 'You have a new message.')
            ->action('View Message', url('/'))
            ->line('Thank you for using our application!');
    }
}

// SendMessage.php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Notifications\MessageNotification;
use App\Models\User;

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $messageData;

    public function __construct(User $user, array $messageData)
    {
        $this->user = $user;
        $this->messageData = $messageData;
    }

    public function handle()
    {
        // 发送通知
        Notification::send($this->user, new MessageNotification($this->messageData));
    }
}
