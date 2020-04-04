function validateFormPermission(f) {
    if (f.name.value === ''){
        swal("Erro", "O campo [Nome] é obrigatório, favor preencha!", "error");
        return false;
    }else if (f.slug.value === ''){
        swal("Erro", "O campo [Permissão] é obrigatório, favor preencha!", "error");
        return false;
    }

    return true;
}