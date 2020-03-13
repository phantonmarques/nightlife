<?php
    use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
    use App\Models\Site\User;
    use App\Models\Admin\Establishment;

    Breadcrumbs::for('home', function ($trail) {
        $trail->push('Home', route('home'));
    });

    # ESTABLISHMENT
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

    # ESTABLISHMENT ADDRESS

    Breadcrumbs::for('establishmentAddress.prepareIndex', function ($trail) {
        $trail->parent('home');
        $trail->push('Endereços Estabelecimentos', route('establishmentAddress.prepareIndex'));
    });

    Breadcrumbs::for('establishmentAddress.index', function ($trail) {
        $trail->parent('home');
        $trail->push('Endereços Estabelecimentos', route('establishmentAddress.index'));
    });

    Breadcrumbs::for('establishmentAddress.create', function ($trail) {
        $trail->parent('establishmentAddress.index');
        $trail->push('Novo Endereço', route('establishmentAddress.create'));
    });

    Breadcrumbs::for('establishmentAddress.show', function ($trail, Establishment $establishment) {
        $trail->parent('establishmentAddress.index');
        $trail->push($establishment->corporate_name, route('establishmentAddress.show', $establishment));
    });

    Breadcrumbs::for('establishmentAddress.edit', function ($trail, Establishment $establishment) {
        $trail->parent('establishmentAddress.index', $establishment);
        $trail->push('Editar', route('establishmentAddress.edit', $establishment));
    });





    Breadcrumbs::for('errors.404', function ($trail) {
        $trail->parent('home');
        $trail->push('Page Not Found');
    });