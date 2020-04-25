function validateFormRhythm(f) {
    if (f.name.value.length === 0 || f.name.value.trim() === '') {
        swal("Erro", "O campo [Nome] é obrigatório, favor preencha!", "error");
        return false;
    }

    return true;
}