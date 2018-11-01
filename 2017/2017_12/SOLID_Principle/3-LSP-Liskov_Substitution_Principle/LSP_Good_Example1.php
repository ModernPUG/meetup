<?php

namespace App\SOLID\LSP;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Lesson
{

    public function haveLesson()
    {
        // have lesson
    }
}


interface LessonRepositoryInterface
{
    /**
     * Fetch all records
     * @return Collection
     */
    public function getAll(): Collection;
}

class ComputerLessonRepository extends Model
    implements LessonRepositoryInterface
{

    public function getAll(): Collection
    {
        return collect([]);
    }
}

class DbLessonRepository extends ComputerLessonRepository
    implements LessonRepositoryInterface
{

    public function getAll(): Collection
    {
        return $this->all();
    }
}

function havingLesson(LessonRepositoryInterface $lesson)
{
    $lessons = $lesson->getAll();

    $lessons->each(function (Lesson $lesson) {
        $lesson->haveLesson();
    });
}