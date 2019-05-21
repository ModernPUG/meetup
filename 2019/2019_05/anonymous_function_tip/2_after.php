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

        $fn_foo = function (): string {
            if ($this->isAdmin()) {
                return 'run';
            }

            if (!$this->isOwner()) {
                return 'stop';
            }

            $data = $this->getData();

            if ($data['n'] <= 9 && $data['m'] >= 3) {
                return 'run';
            } else {
                return 'stop';
            }
        };

        $this->state = $fn_foo();
    }
}

echo "HI\n";
$foo = new Foo();
$foo->exec();
echo "{$foo->state}\n";
