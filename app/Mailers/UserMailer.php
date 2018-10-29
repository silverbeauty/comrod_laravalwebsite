<?php

namespace App\Mailers;

use App\User;
use App\Message;
use App\Mailers\Mailer;

class UserMailer extends Mailer
{
    public function sendWelcomeMessage(User $user)
    {
        if (!$user->verified_email && !$user->hasRole('translator')) {
            $view = 'emails.welcome';        
            $subject = trans('email.registration_verification');
            $data['firstname'] = $user->first_name;
            $data['verificationUrl'] = route('account::getVerifyEmail', $user->email_verification_token);

            return $this->send($user, $subject, $view, $data);
        }
    }

    public function sendEmailConfirmation(User $user)
    {
        $view = 'emails.confirm_email';        
        $subject = trans('email.please_confirm_your_email_address');
        $data['firstname'] = $user->first_name;
        $data['verificationUrl'] = route('account::getVerifyEmail', $user->email_verification_token);

        if (!$user->verified_email) {
            return $this->send($user, $subject, $view, $data);
        }
    }

    public function sendNewMessage(User $sender, User $recipient, Message $message)
    {
        $view = 'emails.new_message';        
        $subject = 'New Message';
        $data['recipientFirstName'] = $recipient->firstname;
        $data['senderFullName'] = $sender->fullname;
        $data['content'] = $message->content;
        $data['conversationUrl'] = route('message::conversation', $message->conversation_id);

        return $this->send($recipient, $subject, $view, $data);
    }

    public function sendResetPasswordLink(User $user, $token)
    {
        $view = 'emails.password';        
        $subject = 'Your Password Reset Link';
        $data['token'] = $token;

        return $this->send($user, $subject, $view, $data);
    }

    public function sendTranslatorPassword(User $user, $password)
    {
        $view = 'emails.translator_password';
        $subject = 'Your account credentials';
        $data['firstname'] = $user->first_name;
        $data['username'] = $user->username;
        $data['password'] = $password;
        $data['admin_url'] = route('admin::getIndex');

        return $this->send($user, $subject, $view, $data);
    }
}