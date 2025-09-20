<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Inicio', route('dashboard'));
});
/* agency */
Breadcrumbs::for('agencies.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Agencias', route('agencies.index'));
});
Breadcrumbs::for('agencies.create', function (BreadcrumbTrail $trail) {
    $trail->parent('agencies.index');
    $trail->push('Crear agencia', route('agencies.create'));
});
Breadcrumbs::for('agencies.edit', function (BreadcrumbTrail $trail, $agency) {
    $trail->parent('agencies.index');
    $trail->push('Editar agencia', route('agencies.edit', $agency));
});

Breadcrumbs::for('agencies.show', function (BreadcrumbTrail $trail, $agency) {
    $trail->parent('agencies.index');
    $trail->push('Ver agencia', route('agencies.show', $agency));
});
// roles y permisos
Breadcrumbs::for('rol-permisos.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Roles y permisos', route('rol-permisos.index'));
});

