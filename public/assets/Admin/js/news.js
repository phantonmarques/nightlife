function validateFormNews(f) {
    if (f.title.value.length === 0 || f.title.value.trim() === '') {
        swal("Erro", "O campo [Título] é obrigatório, favor preencha!", "error");
        return false;
    } else if (f.description.value.length === 0 || f.description.value.trim() === '') {
        swal("Erro", "O campo [Descrição Notícia] é obrigatório, favor preencha!", "error");
        return false;
    }

    return true;
}