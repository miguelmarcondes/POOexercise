<?php

namespace Miguel\Calisthenics\Domain\Video;

use Miguel\Calisthenics\Domain\Student\Student;

interface VideoRepository
{
    public function add(Video $video): self;
    public function videosFor(Student $student): array;
}
