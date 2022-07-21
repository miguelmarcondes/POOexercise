<?php

namespace Miguel\Calisthenics\Domain\Student;

use Miguel\Calisthenics\Domain\Video\Video;
use Miguel\Calisthenics\Domain\Email\Email;
use DateTimeInterface;

class Student
{
    private Email $email;
    private DateTimeInterface $birthDate;
    private watchedVideos $watchedVideos;
    private FullName $FullName;
    private FullAddress $FullAddress;

    public function __construct(Email $email, DateTimeInterface $birthDate, FullName $FullName, FullAddress $FullAddress)
    {
        $this->watchedVideos = new watchedVideos();
        $this->$email = $email;
        $this->birthDate = $birthDate;
        $this->FullAddress = $FullAddress;
        $this->FullName = $FullName;
    }

    public function getFullName(): string
    {
        return $this->FullName;
    }

    public function getAddress(): string
    {
        return $this->FullAddress;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getBd(): DateTimeInterface
    {
        return $this->birthDate;
    }

    public function watch(Video $video, DateTimeInterface $date)
    {
        $this->watchedVideos->add($video, $date);
    }

    public function hasAccess(): bool
    {
        if ($this->watchedVideos->count() === 0) {
            return true;     
        }

        $firstDate = $this->watchedVideos->dateOfFirstVideo();
        $today = new \DateTimeImmutable();

        return $firstDate->diff($today)->days < 90;
    }

    public function age(): int
    {
        $today = new \DateTimeImmutable();
        $dateInterval = $this->birthDate->diff($today);

        return $dateInterval->y;
    }
}
