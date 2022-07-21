<?php

namespace Alura\Calisthenics\Domain\Email;

class Email
{
    private string $email

    public function __construct(string $email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
            $this->email = $email;
        } else {
            throw new \InvalidArgumentException('Invalid e-mail address');
        }
    }
}
