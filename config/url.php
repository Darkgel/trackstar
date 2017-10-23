<?php
/**
 * Created by PhpStorm.
 * User: michael.shi
 * Date: 2017/10/23
 * Time: 9:39
 */

return [
    [
        'pattern' => 'commentfeed',
        'route' => 'comment/feed',
        'suffix' => '.xml',
    ],
    [
        'pattern' => '<pid:\d+>/commentfeed',
        'route' => 'site/commentfeed',
        'suffix' => '.xml',
    ],
];