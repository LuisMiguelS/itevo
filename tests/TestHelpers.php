<?php

namespace Tests;

trait TestHelpers
{
    protected function assertDatabaseEmpty($table, $connection = null)
    {
        $total = $this->getConnection($connection)->table($table)->count();
        $this->assertSame(0, $total, sprintf(
            "Failed asserting the table [%s] is empty. %s %s found", $table, $total, str_plural('row', $total)
        ));
    }

    protected function getSessionErrors()
    {
        return $this->app['session.store'];
    }

    protected function withData($data = [])
    {
        return array_filter(array_merge($this->defaultData, $data));
    }

    protected function createAdmin()
    {
        return tap(factory(\App\User::class)->create(), function ($user) {
            $user->assign(\App\User::ROLE_ADMIN);
        });
    }
}
