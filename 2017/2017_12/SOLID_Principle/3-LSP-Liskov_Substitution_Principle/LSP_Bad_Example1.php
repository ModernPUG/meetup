<?php

namespace App\SOLID\LSP\Bad;

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

    public function getAll();
}

class ComputerLessonRepository extends Model
    implements LessonRepositoryInterface
{

    /**
     * @return array
     */
    public function getAll()
    {
        return [];
    }
}

class DbLessonRepository extends ComputerLessonRepository
    implements LessonRepositoryInterface
{

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return $this->all();
    }
}

function havingLesson(LessonRepositoryInterface $lessonRepository)
{

    $lessons = $lessonRepository->getAll();

    if ($lessonRepository instanceof ComputerLessonRepository) {

        /** @var Lesson $lesson */
        foreach ($lessons as $lesson) {
            $lesson->haveLesson();
        }

    } elseif ($lessonRepository instanceof DbLessonRepository) {
        $lessons->each(function (Lesson $lesson) {
            $lesson->haveLesson();
        });
    }


}
