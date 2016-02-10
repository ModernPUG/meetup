<?php
namespace Tetris;

interface GameObject
{
    public function enterFrame();
}

class Tetromino implements GameObject
{
    private static $tiles_data = [
        'I' => [
            [2, 1],
            [2, 2],
            [2, 3],
            [2, 4],
        ],
        'Z' => [
            [1, 1],
            [1, 2],
            [2, 2],
            [2, 3],
        ],
        'S' => [
            [1, 2],
            [1, 3],
            [2, 1],
            [2, 2],
        ],
        'T' => [
            [1, 2],
            [2, 1],
            [2, 2],
            [2, 3],
        ],
        'L' => [
            [1, 2],
            [2, 2],
            [3, 2],
            [3, 3],
        ],
        'J' => [
            [1, 2],
            [2, 2],
            [3, 2],
            [3, 1],
        ],
        'O' => [
            [1, 2],
            [1, 3],
            [2, 2],
            [2, 3],
        ],
    ];

    public $type;

    private $map = [];
    private $old_map = null;

    public $pos_x = 0;
    public $pos_y = 0;
    private $old_pos_x = null;
    private $old_pos_y = null;

    private $is_freez = false;

    private $frame_count = 0;
    private $frame_max = 30;

    private $callback_on_reset = null;
    private $callback_on_move = null;
    private $callback_on_rotate = null;

    private static function typeList()
    {
        return array_keys(self::$tiles_data);
    }

    private static function randType()
    {
        $type_list = self::typeList();
        $rand_idx = rand(0, count($type_list) - 1);
        return $type_list[$rand_idx];
    }

    private static function tilesStartPoint($type)
    {
        if (!in_array($type, self::typeList())) {
            return [];
        }

        return self::$tiles_data[$type];
    }

    public function reset()
    {
        $this->type = self::randType();

        // 맵 초기화
        $this->map = array_fill(0, 5, 0);
        foreach ($this->map as &$row) {
            $row = array_fill(0, 5, 0);
        }

        // 맵에 타일 넣기
        $tiles_start_point = self::tilesStartPoint($this->type);
        foreach ($tiles_start_point as list($y, $x)) {
            $this->map[$y][$x] = 1;
        }

        // 위치 초기화
        $this->pos_x = 3;
        $this->pos_y = -1;

        // 기타 속성 초기화
        $this->frame_count = 0;
        $this->is_freez = false;

        if ($this->callback_on_reset instanceof \Closure) {
            call_user_func($this->callback_on_reset);
        }
    }

    public function freez()
    {
        $this->is_freez = true;
    }

    public function isFreez()
    {
        return $this->is_freez;
    }

    public function tilesPoint()
    {
        foreach ($this->map as $y => &$row) {
            foreach ($row as $x => &$value) {
                if ($value) {
                    yield [$x, $y];
                }
            }
        }
    }

    public function tilesPosPoint()
    {
        foreach ($this->tilesPoint() as list($x, $y)) {
            $pos_point_x = $x + $this->pos_x;
            $pos_point_y = $y + $this->pos_y;
            yield [$pos_point_x, $pos_point_y];
        }
    }

    public function move($direction)
    {
        if ($this->is_freez) {
            return;
        }

        $this->old_pos_x = $this->pos_x;
        $this->old_pos_y = $this->pos_y;

        switch ($direction) {
            case 'down':
                $this->pos_y += 1;
                break;

            case 'left':
                $this->pos_x -= 1;
                break;

            case 'right':
                $this->pos_x += 1;
                break;
        }

        if ($this->callback_on_move instanceof \Closure) {
            call_user_func_array($this->callback_on_move, [$direction]);
        }
    }

    public function rotate()
    {
        if ($this->is_freez) {
            return;
        }

        $map = [];
        foreach ($this->map as $y => &$row) {
            foreach ($row as $x => &$value) {
                $r_y = $x;
                $r_x = 4 - $y;
                $map[$r_y][$r_x] = $value;
            }
        }

        $this->old_map = $this->map;
        $this->map = $map;

        if ($this->callback_on_rotate instanceof \Closure) {
            call_user_func($this->callback_on_rotate);
        }
    }

    public function revertMove()
    {
        if (!is_null($this->old_pos_x) && !is_null($this->old_pos_y)) {
            $this->pos_x = $this->old_pos_x;
            $this->pos_y = $this->old_pos_y;
            $this->old_pos_x = null;
            $this->old_pos_y = null;
        }
    }

    public function revertRotate()
    {
        if (!is_null($this->old_map)) {
            $this->map = $this->old_map;
            $this->old_map = null;
        }
    }

    public function onReset(\Closure $func)
    {
        $this->callback_on_reset = $func;
    }

    public function onMove(\Closure $func)
    {
        $this->callback_on_move = $func;
    }

    public function onRotate(\Closure $func)
    {
        $this->callback_on_rotate = $func;
    }

    public function __construct()
    {
        $this->reset();
    }

    public function enterFrame()
    {
        if ($this->frame_count == 0) {
            $this->move('down');
        }

        $this->frame_count += 1;

        if ($this->frame_count >= $this->frame_max) {
            $this->frame_count = 0;
        }
    }
}

class Board implements GameObject
{
    private $rows = 0;
    private $cols = 0;

    private $map;

    private function init()
    {
        $this->map = array_fill(0, $this->rows, 0);
        foreach ($this->map as &$row) {
            $row = array_fill(0, $this->cols, 0);
        }
    }

    public function __construct($rows, $cols)
    {
        $this->rows = $rows;
        $this->cols = $cols;
        $this->init();
    }

    public function validatePoint($x, $y)
    {
        return $x >= 0 && $x < $this->cols
            && $y >= 0 && $y < $this->rows;
    }

    public function existTile($x, $y)
    {
        if (!$this->validatePoint($x, $y)) {
            return false;
        }

        return !empty($this->map[$y][$x]);
    }

    public function addTile($x, $y, $tile_type)
    {
        if ($this->validatePoint($x, $y)) {
            $this->map[$y][$x] = $tile_type;
        }
    }

    private function removeCompletedLine()
    {
        $map = [];

        foreach ($this->map as $y => &$row) {
            $count = 0;
            $idx_bomb = -1;
            foreach ($row as $i => &$value) {
                if ($value) {
                    ++$count;
                }

                if ($value === 'X') {
                    $idx_bomb = $i;
                }
            }

            if ($count == $this->cols) {
                if ($idx_bomb < $this->cols - 1) {
                    $row[$idx_bomb + 1] = 'X';
                }
            }

            if ($idx_bomb == $this->cols - 1) {
                $row = array_fill(0, $this->cols, 0);
            } else {
                $map[] = $row;
            }
        }

        $row = array_fill(0, $this->cols, 0);
        $count = $this->rows - count($map);
        for ($i = 0; $i < $count; $i++) {
            array_unshift($map, $row);
        }

        $this->map = $map;
    }

    public function mapData()
    {
        return $this->map;
    }

    public function enterFrame()
    {
        $this->removeCompletedLine();
    }
}

class Tetris
{
    private $board = null;
    private $board_rows = 22;
    private $board_cols = 10;

    private $tetromino = null;

    private $canvas;
    private $tile = [
        0 => '◻️',
        'X' => '💥',
        'I' => '🏧',
        'Z' => '🆘️',
        'S' => '✳️',
        'T' => '✡️',
        'L' => '✴️',
        'J' => '🚹',
        'O' => '🚺',
    ];

    private function collisionCheck()
    {
        foreach ($this->tetromino->tilesPosPoint() as list($x, $y)) {
            if (!$this->board->validatePoint($x, $y)) {
                return true;
            }

            if ($this->board->existTile($x, $y)) {
                return true;
            }
        }

        return false;
    }

    private function drawCanvas()
    {
        $this->canvas = $this->board->mapData();

        foreach ($this->tetromino->tilesPosPoint() as list($x, $y)) {
            if ($this->board->validatePoint($x, $y)) {
                $this->canvas[$y][$x] = $this->tetromino->type;
            }
        }
    }

    private function freezTetromino()
    {
        if ($this->tetromino->isFreez()) {
            return;
        }

        $this->tetromino->freez();

        foreach ($this->tetromino->tilesPosPoint() as list($x, $y)) {
            $this->board->addTile($x, $y, $this->tetromino->type);
        }
    }

    private function readKeyCode()
    {
        $code = 0;
        while ($str = fread(STDIN, 1)) {
            $code = ord($str);
        }

        return $code;
    }

    private function screenHideCursor()
    {
        fprintf(STDOUT, "\033[?25l"); // hide cursor
        register_shutdown_function(function () {
            fprintf(STDOUT, "\033[?25h"); //show cursor
        });
    }

    private function screenClear()
    {
        echo "\033[2J\033[;H";
    }

    private function screenDisplay()
    {
        $this->drawCanvas();

        echo "\033[0;0H";

        $str = '';
        foreach ($this->canvas as &$row) {
            foreach ($row as &$col) {
                $str .= $this->tile[$col];
                $str .= "\033[1C";
            }
            $str .= "\n";
        }

        echo $str;
    }

    private function init()
    {
        $this->board = new Board($this->board_rows, $this->board_cols);
        $this->tetromino = new Tetromino();
    }

    public function run()
    {
        system('stty -icanon -echo < /dev/tty');

        $this->screenClear();
        $this->screenHideCursor();
        $this->init();

        $is_play = true;

        $this->tetromino->onReset(function () use (&$is_play) {
            $is_collision = $this->collisionCheck();
            if ($is_collision) {
                $is_play = false;
            }
        });

        $this->tetromino->onRotate(function () {
            $is_collision = $this->collisionCheck();
            if ($is_collision) {
                $this->tetromino->revertRotate();
            }
        });

        $this->tetromino->onMove(function ($direction) {
            $is_collision = $this->collisionCheck();
            if ($is_collision) {
                $this->tetromino->revertMove();

                if ($direction == 'down') {
                    $this->freezTetromino();
                    $this->tetromino->reset();
                }
            }
        });

        while ($is_play) {
            $key_code = $this->readKeyCode();

            switch ($key_code) {
                // esc
                case 27:
                // q
                case 113:
                    $is_play = false;
                    break;

                // w
                case 119:
                    $this->tetromino->rotate();
                    break;

                // s
                case 115:
                    $this->tetromino->move('down');
                    break;

                // a
                case 97:
                    $this->tetromino->move('left');
                    break;

                // d
                case 100:
                    $this->tetromino->move('right');
                    break;

                default:
                    if ($key_code) {
                        echo "#{$key_code}#";
                    }
                    break;
            }

            $this->board->enterFrame();
            $this->tetromino->enterFrame();

            $this->screenDisplay();

            usleep(20000);
        }

        echo "### GAME OVER ###\n";
    }

    public function __construct()
    {
        stream_set_blocking(STDIN, false);
    }
}

$tetris = new \Tetris\Tetris();
$tetris->run();
exit;
