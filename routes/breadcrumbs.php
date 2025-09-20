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

// roles y permisos
Breadcrumbs::for('rol-permisos.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Roles y permisos', route('rol-permisos.index'));
});

/* paradas */
Breadcrumbs::for('stops.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Paradas', route('stops.index'));
});

Breadcrumbs::for('stops.create', function (BreadcrumbTrail $trail) {
    $trail->parent('stops.index');
    $trail->push('Nuevo', route('stops.create'));
});
Breadcrumbs::for('stops.edit', function (BreadcrumbTrail $trail, $model) {
    $trail->parent('stops.index');
    $trail->push('Editar', route('stops.edit', $model));
});
Breadcrumbs::for('stops.show', function (BreadcrumbTrail $trail, $model) {
    $trail->parent('stops.index');
    $trail->push('Ver', route('stops.show', $model));
});


/* vehicles */
Breadcrumbs::for('vehicles.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Vehículos', route('vehicles.index'));
});
Breadcrumbs::for('vehicles.create', function (BreadcrumbTrail $trail) {
    $trail->parent('vehicles.index');
    $trail->push('Nuevo', route('vehicles.create'));
});
Breadcrumbs::for('vehicles.edit', function (BreadcrumbTrail $trail, $model) {
    $trail->parent('vehicles.index');
    $trail->push('Editar', route('vehicles.edit', $model));
});
Breadcrumbs::for('vehicles.show', function (BreadcrumbTrail $trail, $model) {
    $trail->parent('vehicles.index');
    $trail->push('Ver', route('vehicles.show', $model));
});

/* routes */
Breadcrumbs::for('routes.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Rutas', route('routes.index'));
});
Breadcrumbs::for('routes.create', function (BreadcrumbTrail $trail) {
    $trail->parent('routes.index');
    $trail->push('Nuevo', route('routes.create'));
});
Breadcrumbs::for('routes.edit', function (BreadcrumbTrail $trail, $model) {
    $trail->parent('routes.index');
    $trail->push('Editar', route('routes.edit', $model));
});
Breadcrumbs::for('routes.show', function (BreadcrumbTrail $trail, $model) {
    $trail->parent('routes.index');
    $trail->push('Ver', route('routes.show', $model));
});

/* route.stops */
Breadcrumbs::for('route.stops.index', function (BreadcrumbTrail $trail, $route) {
    $trail->parent('routes.index');
    $trail->push('Paradas de la ruta ' . $route->code, route('route.stops.index', $route));
});
Breadcrumbs::for('route.stops.create', function (BreadcrumbTrail $trail, $route) {
    $trail->parent('route.stops.index', $route);
    $trail->push('Crear o Actualizar', route('route.stops.create', $route));
});

Breadcrumbs::for('routes.stops.index', function ($trail, $route) {
    $trail->parent('routes.index');
    $trail->push('Stops', route('routes.stops.index', $route->id));
});


Breadcrumbs::for('routes.stops.create', function ($trail, $route) {
    $trail->parent('routes.stops.index', $route);
    $trail->push('Crear o Actualizar', route('routes.stops.create', $route->id));
});
