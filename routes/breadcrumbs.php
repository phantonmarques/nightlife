<?php
    use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
    use App\Models\Site\User;
    use App\Models\Admin\Category;
    use App\Models\Admin\Establishment;
    use App\Models\Admin\EstablishmentAddress;
    use App\Models\Admin\Permission;
    use App\Models\Admin\Role;
    use App\Models\Admin\Rhythm;
    use App\Models\Admin\Event;
    use App\Models\Admin\UserAccess;

    # TODO: ESTABLSIHMENT ROUTES ACESS

    Breadcrumbs::for('home', function ($trail) {
        $trail->push('Home', route('home'));
    });

    Breadcrumbs::for('admin.dashboard', function ($trail) {
        $trail->push('Dashboard', route('admin.dashboard'));
    });

    Breadcrumbs::for('admin.details', function ($trail) {
        $trail->push('Detalhes Conta Estabelecimento', route('admin.details'));
    });

    # TODO: ESTABLISHMENT
    Breadcrumbs::for('establishment.index', function ($trail) {
        $trail->parent('home');
        $trail->push('Estabelecimentos', route('establishment.index'));
    });

    Breadcrumbs::for('establishment.create', function ($trail) {
        $trail->parent('establishment.index');
        $trail->push('Novo Estabelecimento', route('establishment.create'));
    });

    Breadcrumbs::for('establishment.show', function ($trail, Establishment $establishment) {
        $trail->parent('establishment.index');
        $trail->push($establishment->corporate_name, route('establishment.show', $establishment));
    });

    Breadcrumbs::for('establishment.edit', function ($trail, Establishment $establishment) {
        $trail->parent('establishment.index', $establishment);
        $trail->push('Editar', route('establishment.edit', $establishment));
    });

    # TODO: ESTABLISHMENT ADDRESS

    Breadcrumbs::for('establishmentAddress.index', function ($trail) {
        $trail->parent('home');
        $trail->push('Endereços Estabelecimentos', route('establishmentAddress.index'));
    });

    Breadcrumbs::for('establishmentAddress.create', function ($trail) {
        $trail->parent('establishmentAddress.index');
        $trail->push('Novo Endereço', route('establishmentAddress.create'));
    });

    Breadcrumbs::for('establishmentAddress.show', function ($trail, EstablishmentAddress $establishmentAddress) {
        $trail->parent('establishmentAddress.index');
        $trail->push($establishmentAddress->establishment, route('establishmentAddress.show', $establishmentAddress));
    });

    Breadcrumbs::for('establishmentAddress.edit', function ($trail, Establishment $establishment) {
        $trail->parent('establishmentAddress.index', $establishment);
        $trail->push('Editar', route('establishmentAddress.edit', $establishment));
    });

    # TODO: USER

    Breadcrumbs::for('user.index', function ($trail) {
        $trail->parent('home');
        $trail->push('Usuários', route('user.index'));
    });

    Breadcrumbs::for('user.create', function ($trail) {
        $trail->parent('user.index');
        $trail->push('Novo Usuário', route('user.create'));
    });

    Breadcrumbs::for('user.show', function ($trail, User $user) {
        $trail->parent('user.index');
        $trail->push($user->name, route('user.show', $user));
    });

    Breadcrumbs::for('user.edit', function ($trail, User $user) {
        $trail->parent('user.index', $user);
        $trail->push('Editar Usuário', route('user.edit', $user));
    });

    # TODO: ROLES USER

    Breadcrumbs::for('role.index', function ($trail) {
        $trail->parent('home');
        $trail->push('Funções', route('role.index'));
    });

    Breadcrumbs::for('role.create', function ($trail) {
        $trail->parent('role.index');
        $trail->push('Nova Função', route('role.create'));
    });

    Breadcrumbs::for('role.show', function ($trail, Role $role) {
        $trail->parent('role.index');
        $trail->push($role->name, route('role.show', $role));
    });

    Breadcrumbs::for('role.edit', function ($trail, Role $role) {
        $trail->parent('role.index', $role);
        $trail->push('Editar Função', route('role.edit', $role));
    });

    # TODO: PERMISSIONS USER

    Breadcrumbs::for('permission.index', function ($trail) {
        $trail->parent('home');
        $trail->push('Permissões', route('permission.index'));
    });

    Breadcrumbs::for('permission.create', function ($trail) {
        $trail->parent('permission.index');
        $trail->push('Novo Permissão', route('permission.create'));
    });

    Breadcrumbs::for('permission.show', function ($trail, Permission $permission) {
        $trail->parent('permission.index');
        $trail->push($permission->name, route('permission.show', $permission));
    });

    Breadcrumbs::for('permission.edit', function ($trail, Permission $permission) {
        $trail->parent('permission.index', $permission);
        $trail->push('Editar Permissão', route('permission.edit', $permission));
    });

    # TODO: CATEGORY FOR ESTABLISHMENT

    Breadcrumbs::for('category.index', function ($trail) {
        $trail->parent('home');
        $trail->push('Categorias', route('category.index'));
    });

    Breadcrumbs::for('category.create', function ($trail) {
        $trail->parent('category.index');
        $trail->push('Nova Categoria', route('category.create'));
    });

    Breadcrumbs::for('category.show', function ($trail, Category $category) {
        $trail->parent('category.index');
        $trail->push($category->name, route('category.show', $category));
    });

    Breadcrumbs::for('category.edit', function ($trail, Category $category) {
        $trail->parent('category.index', $category);
        $trail->push('Editar Categoria', route('category.edit', $category));
    });

    # TODO: MUSICAL RHYTHM

    Breadcrumbs::for('rhythm.index', function ($trail) {
        $trail->parent('home');
        $trail->push('Ritmos Musicais', route('rhythm.index'));
    });

    Breadcrumbs::for('rhythm.create', function ($trail) {
        $trail->parent('rhythm.index');
        $trail->push('Novo Ritmo Musical', route('rhythm.create'));
    });

    Breadcrumbs::for('rhythm.show', function ($trail, Rhythm $rhythm) {
        $trail->parent('rhythm.index');
        $trail->push($rhythm->name, route('rhythm.show', $rhythm));
    });

    Breadcrumbs::for('rhythm.edit', function ($trail, Rhythm $rhythm) {
        $trail->parent('rhythm.index', $rhythm);
        $trail->push('Editar Ritmo Musical', route('rhythm.edit', $rhythm));
    });

    # TODO: EVENT ESTABLISHMENT

    Breadcrumbs::for('event.index', function ($trail) {
        $trail->parent('home');
        $trail->push('Eventos Estabelecimento', route('event.index'));
    });

    Breadcrumbs::for('event.create', function ($trail) {
        $trail->parent('event.index');
        $trail->push('Novo Evento', route('event.create'));
    });

    Breadcrumbs::for('event.show', function ($trail, Event $event) {
        $trail->parent('event.index');
        $trail->push($event->name, route('event.show', $event));
    });

    Breadcrumbs::for('event.edit', function ($trail, Event $event) {
        $trail->parent('event.index', $event);
        $trail->push('Editar Evento', route('event.edit', $event));
    });

    # TODO: LOG ACCESS USERS

    Breadcrumbs::for('logs.index', function ($trail) {
        $trail->parent('home');
        $trail->push('Eventos Estabelecimento', route('logs.index'));
    });

    Breadcrumbs::for('logs.show', function ($trail, UserAccess $log) {
        $trail->parent('logs.index');
        $trail->push($log->description, route('logs.show', $log));
    });

    # TODO: ERROR

    Breadcrumbs::for('errors.404', function ($trail) {
        $trail->parent('home');
        $trail->push('Page Not Found');
    });