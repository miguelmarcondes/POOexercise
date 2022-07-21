<?php

namespace Miguel\Calisthenics\Tests\Unit\Domain\Student;

use Miguel\Calisthenics\Domain\Email\Email;
use Miguel\Calisthenics\Domain\Student\FullAddress;
use Miguel\Calisthenics\Domain\Student\FullName;
use Miguel\Calisthenics\Domain\Student\Student;
use Miguel\Calisthenics\Domain\Video\Video;
use PHPUnit\Framework\TestCase;

class StudentTest extends TestCase
{
    private Student $student;

    protected function setUp(): void
    {
        $this->student = new Student(
            new Email('email@example.com'),
            new \DateTimeImmutable('1997-10-15'),
            new FullName('Miguel', 'Marcondes'),
            new FullAddress('Rua de Exemplo',
            '71B',
            'Meu Bairro',
            'Minha Cidade',
            'Meu estado',
            'Brasil')
        );
    }

    public function testFullAddressMustBeRepresentedAsString()
    {
        self::assertEquals('Rua de Exemplo, 71B, Meu Bairro - Minha Cidade, Meu estado, Brasil', $this->student->getAddress());
    }

    public function testFullNameMustBeRepresentedAsString()
    {
        self::assertEquals('Miguel Marcondes', $this->student->getFullName());
    }

    public function testStudentWithoutWatchedVideosHasAccess()
    {
        self::assertTrue($this->student->hasAccess());
    }

    public function testStudentWithFirstWatchedVideoInLessThan90DaysHasAccess()
    {
        $date = new \DateTimeImmutable('89 days');
        $this->student->watch(new Video(), $date);

        self::assertTrue($this->student->hasAccess());
    }

    public function testStudentWithFirstWatchedVideoInLessThan90DaysButOtherVideosWatchedHasAccess()
    {
        $this->student->watch(new Video(), new \DateTimeImmutable('-89 days'));
        $this->student->watch(new Video(), new \DateTimeImmutable('-60 days'));
        $this->student->watch(new Video(), new \DateTimeImmutable('-30 days'));

        self::assertTrue($this->student->hasAccess());
    }

    public function testStudentWithFirstWatchedVideoIn90DaysDoesntHaveAccess()
    {
        $date = new \DateTimeImmutable('-90 days');
        $this->student->watch(new Video(), $date);

        self::assertFalse($this->student->hasAccess());
    }

    public function testStudentWithFirstWatchedVideoIn90DaysButOtherVideosWatchedDoesntHaveAccess()
    {
        $this->student->watch(new Video(), new \DateTimeImmutable('-90 days'));
        $this->student->watch(new Video(), new \DateTimeImmutable('-60 days'));
        $this->student->watch(new Video(), new \DateTimeImmutable('-30 days'));

        self::assertFalse($this->student->hasAccess());
    }
}
