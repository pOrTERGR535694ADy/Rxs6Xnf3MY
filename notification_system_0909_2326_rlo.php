<?php
// 代码生成时间: 2025-09-09 23:26:38
// notification_system.php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationMail;
use App\Models\User;
use App\Exceptions\AppException;

class NotificationService {
    /**
     * 发送通知给用户
     *
     * @param User $user 用户模型
     * @param string $message 要发送的消息
     * @param string $subject 邮件主题
     * @return bool
     * @throws AppException
     */
    public function sendNotification(User $user, string $message, string $subject): bool {
        try {
            // 检查用户是否为空
            if (!$user) {
                throw new AppException('User is not found.', 404);
            }

            // 创建邮件数据
            $mailData = [
                'message' => $message,
                'subject' => $subject
            ];

            // 发送邮件
            Mail::to($user->email)->send(new NotificationMail($mailData));

            // 记录日志
            Log::info('Notification sent to user: ' . $user->email);

            return true;
        } catch (\Exception $e) {
            // 记录错误日志
            Log::error('Error sending notification: ' . $e->getMessage());

            // 抛出异常
            throw new AppException('Failed to send notification.', 500);
        }
    }
}

// NotificationMail.php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificationMail extends Mailable implements ShouldQueue {
    use Queueable, SerializesModels;

    public $message;
    public $subject;
    public $user;

    /**
     * 创建一个新的通知邮件实例
     *
     * @param User $user 用户模型
     * @param string $message 要发送的消息
     * @param string $subject 邮件主题
     */
    public function __construct(User $user, string $message, string $subject) {
        $this->user = $user;
        $this->message = $message;
        $this->subject = $subject;
    }

    /**
     * 构建邮件内容
     *
     * @return $this
     */
    public function build() {
        return $this->view('emails.notification')
            ->with([
                'message' => $this->message,
                'subject' => $this->subject
            ])
            ->subject($this->subject);
    }
}

// email.blade.php (存放在 resources/views/emails/ 目录下)

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
</head>
<body>
    <h1>{{ $subject }}</h1>
    <p>{{ $message }}</p>
</body>
</html>
