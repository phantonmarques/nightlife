@if(session('form_validation.error'))
<div class="row">
    <div class="col-md-12">
        @if(session('form_validation.success'))
        <div class="alert callout callout-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fas fa-check"></i> Sucesso!</h4>
            <p>{{ session('form_validation.success') }}</p>
        </div>
        @endif

        @if(session('form_validation.error'))
        <div class="alert callout callout-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> Ops!</h4>
            @if(session('form_validation.error') !== null && session('form_validation.error') !== true)
            <p>{{ session('form_validation.error') }}</p>
            @else
            <p>O formulário contém erros de validação, verifique os campos em destaque e tente novamente.</p>
            @endif
        </div>
        @endif

        @if(session('form_validation.warning'))
        <div class="alert callout callout-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fas fa-exclamation-triangle"></i> Aviso!</h4>
            <p>{{ session('form_validation.warning') }}</p>
        </div>
        @endif
    </div>
</div>
@endif
