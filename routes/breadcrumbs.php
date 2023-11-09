<?php

use App\Http\Controllers\TicketController;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
 
Breadcrumbs::for('users.index', function (BreadcrumbTrail $trail): void {
    $trail->push('TicketController', route('users.index'));
});