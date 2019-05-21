<?php
namespace Mpug;

class Foo
{
    public $state = 'stop';

    private function isAdmin(): bool
    {
        /*
        가벼운 코드만 있음
         */
        return false;
    }

    private function isOwner(): bool
    {
        /*
        엄청 무거운 코드가 있음
         */
        return true;
    }

    private function getData(): array
    {
        /*
        엄청 무거운 코드가 있음
         */
        return [
            'n' => 5,
            'm' => 7,
        ];
    }

    public function exec()
    {
        /*
        관리자는 무조건 run
        소유자는 데이터의 값이 유효하면 run
        그 외는 stop
         */

        if (!$this->isAdmin()) {
            if ($this->isOwner()) {
                $data = $this->getData();

                if ($data['n'] <= 9 && $data['m'] >= 3) {
                    $state = 'run';
                } else {
                    $state = 'stop';
                }
            } else {
                $state = 'stop';
            }
        } else {
            $state = 'run';
        }

        $this->state = $state;
    }
}

$foo = new Foo();
$foo->exec();
echo "{$foo->state}\n";
