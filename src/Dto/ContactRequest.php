<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class ContactRequest
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(max: 120)]
        public string $name = '',

        #[Assert\NotBlank]
        #[Assert\Email]
        public string $email = '',

        #[Assert\NotBlank]
        #[Assert\Length(max: 5000)]
        public string $message = '',
    ) {
    }
}
