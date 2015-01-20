<?php

return array(
    'default' => 'testing',

    'connections' => array(

        'setup' => array(
            'driver' => 'sqlite',
            'database' => __DIR__.'/../../database/testing/stubdb.sqlite',
            'prefix' => '',
        ),

        'testing' => array(
            'driver' => 'sqlite',
            'database' => __DIR__.'/../../database/testing/testdb.sqlite',
            'prefix' => '',
        ),

        'sqlite' => array(
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => ''
        ),
    ),

    'migrations' => 'migrations',

);