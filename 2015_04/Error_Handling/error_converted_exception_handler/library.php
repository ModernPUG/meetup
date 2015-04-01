<?php
function auth_check()
{
    verify_is_exists_user_at_db();
    verify_is_not_quit_user();
}

function verify_is_exists_user_at_db()
{
    if (rand(0, 1)) {
        trigger_error("로그인 에러", E_USER_ERROR);
    }
}

function verify_is_not_quit_user()
{
    if (rand(0, 1)) {
        throw new \Exception("로그인 에러");
    }
}
