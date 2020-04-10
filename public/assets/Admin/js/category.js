function validateFormCategory(f) {
    if (f.name.value.length === undefined || f.name.value === '') {
        swal("Erro", "O campo [Nome] é obrigatório, favor preencha!", "error");
        return false;
    }

    return true;
}