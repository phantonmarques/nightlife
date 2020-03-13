<?php $__env->startSection('title', 'Criar Estabelecimento'); ?>

<?php $__env->startSection('content_header'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
        <li><a href="">Inicio</a></li>
        <li><a href="">Criar Usuário</a></li>
    </ol>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="box">
        <div class="box box-success">
            <div class="box-header with-border">
                <h1 class="box-title">Novo Estabelecimento</h1>
                <h6 align="right" style="color:red">* Campos obrigatórios</h6>
            </div>
            <form method="POST" action="<?php echo e(Route('inserirEstabelecimento')); ?>"  id="frm_cadastroEstab" onsubmit="return validarFormulario(this)">
                <?php echo csrf_field(); ?>

                <div class="box-body">
                    <div class="form-group">
                        <label for="razaoSocialEstab">Razão Social <span class="span-required">*</span></label>
                        <input type="name" class="form-control" id="razaoSocialEstab" name="razaoSocialEstab" placeholder="Informe a razão social do estabelecimento.">
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="nomeFantasiaEstab">Nome Fantasia</label>
                            <input type="name" class="form-control" id="nomeFantasiaEstab" name="nomeFantasiaEstab" placeholder="Informe nome fantasia do estabelecimento.">
                        </div>
                        <div class="col-lg-6">
                            <label for="inscrEstadualEstab">Inscrição Estadual <span class="span-required">*</span></label>
                            <input type="name" class="form-control" id="inscrEstadualEstab" name="inscrEstadualEstab" placeholder="Informe a inscrição do estabelecimento." onkeypress="return somenteNumeros(event)">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-6">
                        <label for="emailEstab">E-mail <span class="span-required">*</span></label>
                        <input type="email" class="form-control" id="emailEstab" name="emailEstab" placeholder="Informe email do estabelecimento.">
                        </div>
                        <div class="col-lg-6">
                            <label for="cnpjEstab">CNPJ <span class="span-required">*</span></label>
                            <input type="name" class="form-control" id="cnpjEstab" name="cnpjEstab" placeholder="Informe cnpj do estabelecimento." onkeypress="return somenteNumeros(event)" maxlength="14">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="loginEstab">Login <span class="span-required">*</span></label>
                            <input type="name" class="form-control" id="loginEstab" name="loginEstab" placeholder="Informe um usuário para o estabelecimento.">
                        </div>
                        <div class="col-lg-6">
                            <label for="senhaEstab">Senha <span class="span-required">*</span></label>
                            <input type="password" class="form-control" id="senhaEstab" name="senhaEstab" placeholder="Informe uma senha para o estabelecimento.">
                        </div>
                        <div class="col-lg-6"></div>
                        <div class="col-lg-6">
                            <label for="senhaEstab">Confirmar Senha <span class="span-required">*</span></label>
                            <input type="password" class="form-control" id="confirmSenha" name="confirmSenha" placeholder="Informe novamente uma senha para o estabelecimento.">
                        </div>
                    </div>
                    <br><label for="">Tipo Conta <span class="span-required">*</span></label>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                  <input type="radio" name="tipoContaEstab" id="contaBasica" value="basica" checked>
                                </span>
                                <label for="contaBasica" class="form-control input-decision">Conta Básica</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                  <input type="radio" name="tipoContaEstab" id="contaFull" value="full">
                                </span>
                                <label for="contaFull" class="form-control input-decision">Conta Full</label>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <div class="form-group">
                        <table>
                            <tr>
                                <td>
                                    <label for="telefone_f">Nome Contato Principal <span class="span-required">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <input type="text" class="form-control" name="contatoTelefone_f" id="contatoTelefone_f">
                                    </div>
                                </td>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td>
                                    <label for="telefone_c1">Nome Contato Celular 1</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <input type="text" class="form-control" name="contatoTelefone_c1" id="contatoTelefone_c1">
                                    </div>
                                </td>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td>
                                    <label for="telefone_c2">Nome Contato Celular 2</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <input type="text" class="form-control" name="contatoTelefone_c2" id="contatoTelefone_c2">
                                    </div>
                                </td>
                            </tr>
                            <tr><td>&nbsp;</td></tr>
                            <tr>
                                <td>
                                    <label for="telefone_f">Telefone Contato Principal <span class="span-required">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-phone"></i>
                                        </div>
                                        <input type="text" class="form-control phone" name="telefone_f" id="telefone_f">
                                    </div>
                                </td>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td>
                                    <label for="telefone_c1">Telefone Contato Celular 1 </label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-phone"></i>
                                        </div>
                                        <input type="text" class="form-control phone" name="telefone_c1" id="telefone_c1">
                                    </div>
                                </td>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td>
                                    <label for="telefone_c2">Telefone Contato Celular 2 </label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-phone"></i>
                                        </div>
                                        <input type="text" class="form-control phone" name="telefone_c2" id="telefone_c2">
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <br><br>
                        <label for="cepEstab">Situação Empresa</label>
                        <div class="row">
                            <div class="col-lg-3">
                                <button type="button" class="btn btn-success" onclick="buscarInformacoesEmpresa()">Verificar</button>
                            </div>
                            <div class="col-lg-2" id="infReceita">
                                <label id="situacaoEstab"></label><br>
                                <label id="statusEstab"></label><br>
                                <label id="aberturaEstab"></label><br>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>

                <hr>

                <div class="box-header with-border">
                    <h3 class="box-title">Informações de Endereço</h3>
                </div>

                <div class="box-body">

                    <label for="cepEstab">CEP <span class="span-required">*</span></label>
                    <div class="row">
                        <div class="col-lg-3">
                            <input type="name" class="form-control cep" name="cepEstab" id="cepEstab" placeholder="Informe cep do endereço do estabelecimento." onkeypress="return somenteNumeros(event)">
                        </div>
                        <div class="col-lg-3">
                            <button type="button" class="btn btn-info" onclick="buscarCep('click')">Buscar</button>
                        </div>
                    </div>
                    <br>
                    <div id="infEndereco" style="display: none">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="enderecoEstab">Endereço</label>
                                <input type="name" class="form-control" id="enderecoEstab" name="enderecoEstab" placeholder="Informe endereço do estabelecimento.">
                            </div>
                            <div class="col-lg-2">
                                <label for="numeroEstab">Número <span class="span-required">*</span></label>
                                <input type="name" class="form-control" id="numeroEstab" name="numeroEstab" placeholder="Informe número do estabelecimento." onkeypress="return somenteNumeros(event)">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="complementoEstab">Complemento</label>
                                <input type="name" class="form-control" id="complementoEstab" name="complementoEstab" placeholder="Informe complemento do endereço.">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="estadoEstab">Estado</label>
                                <select class="form-control" id="estadoEstab" name="estadoEstab" onchange="buscarCidade()">
                                    <option value="">Selecione</option>
                                    <?php $__currentLoopData = $estados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $est): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($est->state_cod); ?>"><?php echo e($est->name_visible); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="cidadeEstab">Cidade</label>
                                <select class="form-control" id="cidadeEstab" name="cidadeEstab">
                                    <option value="">Selecione</option>
                                </select>
                            </div>
                            <input type="hidden" id="dddCidade" name="dddCidade" value="" />
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-3">
                            <label for="bairroEstab">Bairro</label>
                            <input type="name" class="form-control" id="bairroEstab" name="bairroEstab" placeholder="Informe bairro do estabelecimento.">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <input type="submit" class="btn btn-primary" value="Gravar" />
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript" >
        $( document ).ready(function() {
            $('.phone').mask('(00) 00000-0000');
            $('.cep').mask('00000-000');
        });

        function buscarCep(type = '') {
            let cep = document.getElementById('cepEstab').value.replace('-','');

            if (cep.length === 8){
                $.ajax({
                    url: "https://viacep.com.br/ws/"+ cep +"/json/",
                    type: 'GET',
                    crossDomain: true,
                    dataType: 'jsonp',
                    success: function(data) {
                        if (typeof(data.logradouro) != "undefined"){
                            document.getElementById("infEndereco").style.display = "block";
                            document.getElementById("enderecoEstab").value = data.logradouro;
                            document.getElementById("enderecoEstab").disabled = true;
                            document.getElementById("bairroEstab").value = data.bairro;
                            document.getElementById("bairroEstab").disabled = true;
                            document.getElementById("estadoEstab").value = data.uf;
                            document.getElementById("estadoEstab").disabled = true;
                            var cidade = data.localidade;
                            cidade = cidade.replace(/ /g, '-').toLowerCase();
                            buscarCidade(cidade);
                            document.getElementById("cidadeEstab").disabled = true;
                            if (type !== ''){
                                document.getElementById('numeroEstab').value = '';
                                document.getElementById('complementoEstab').value = '';
                            }


                        }else {
                            document.getElementById("infEndereco").style.display = "none";
                            document.getElementById('numeroEstab').value = '';
                            document.getElementById('complementoEstab').value = '';
                            swal("Erro", "Cep não localizado!", "error");

                        }
                    },
                    error: function() {
                        document.getElementById("infEndereco").style.display = "none";
                        document.getElementById('numeroEstab').value = '';
                        document.getElementById('complementoEstab').value = '';
                        swal("Erro", "Desconhecido, favor recarrega a página e tente novamente!", "error");
                    },
                });
            }else if (cep.length === 0){
                document.getElementById("infEndereco").style.display = "none";
                document.getElementById('numeroEstab').value = '';
                document.getElementById('complementoEstab').value = '';
                swal("Erro", "Favor preencha o cep!", "error");
            }else {
                document.getElementById("infEndereco").style.display = "none";
                document.getElementById('numeroEstab').value = '';
                document.getElementById('complementoEstab').value = '';
                swal("Erro", "Cep incompleto, favor verifique e tente novamente!", "error");
            }

        }

        function buscarCidade(index = ''){
            let estado = document.getElementById('estadoEstab').value;

            if (estado.length > 0){
                $.ajax({
                    url: "http://localhost/ProjetosLaravel/nightlife/public/citys/"+estado,
                    type: 'GET',
                    crossDomain: true,
                    success: function(data) {
                        data = JSON.parse(data);

                        if (typeof(data[0].id) != "undefined") {
                            var selectCidades = document.getElementById("cidadeEstab");

                            for(var k in data) {
                                var option = document.createElement("option");
                                option.id = data[k].name;
                                option.value = data[k].id;
                                option.text = data[k].name_visible;
                                selectCidades.add(option);

                                if (index !== '' && data[k].name === index ){
                                    console.log(data[k].ddd_city)
                                    document.getElementById("dddCidade").value = data[k].ddd_city;
                                    selectCidades.value = data[k].id;
                                }
                            }
                        }
                    },
                    error: function() {
                        swal("Erro", "Desconhecido, favor recarrega a página e tente novamente!", "error");
                    },
                });
            }else if (estado.length === 0){
                swal("Erro", "Selecione o estado e tente novamente!", "error");
            }
        }

        function buscarInformacoesEmpresa() {
            let cnpjEstab = document.getElementById('cnpjEstab').value.trim();

            if (cnpjEstab.length === 14){
                $.ajax({
                    url: "http://www.receitaws.com.br/v1/cnpj/"+ cnpjEstab,
                    type: 'GET',
                    crossDomain: true,
                    dataType: 'jsonp',
                    success: function(data) {
                        if (typeof(data.situacao) != "undefined") {
                            document.getElementById("situacaoEstab").innerHTML = 'Situação Empresa: ' + data.situacao;
                            document.getElementById("statusEstab").innerHTML  = 'Status Empresa: ' + data.status;
                            document.getElementById("aberturaEstab").innerHTML = 'Data Abertura: ' + data.abertura;
                            document.getElementById("infReceita").style.backgroundColor = '#C2F9C7';
                            document.getElementById('cepEstab').value = data.cep.replace('.','');
                            document.getElementById('numeroEstab').value = data.numero;
                            document.getElementById('complementoEstab').value = data.complemento;
                            buscarCep();
                        }else {
                            document.getElementById("situacaoEstab").innerHTML = '';
                            document.getElementById("statusEstab").innerHTML  = 'Dados não encontrados ou inválidos';
                            document.getElementById("aberturaEstab").innerHTML = '';
                            document.getElementById("infReceita").style.backgroundColor = '#F35658';
                        }
                    },
                    error: function() {
                        document.getElementById("situacaoEstab").innerHTML = '';
                        document.getElementById("statusEstab").innerHTML  = '';
                        document.getElementById("aberturaEstab").innerHTML = '';
                        document.getElementById("infReceita").style.backgroundColor = 'white';
                        swal("Erro", "Desconhecido, favor recarrega a página e tente novamente!", "error");
                    },
                });
            }else if (cnpjEstab.length === 0){
                document.getElementById("situacaoEstab").innerHTML = '';
                document.getElementById("statusEstab").innerHTML  = '';
                document.getElementById("aberturaEstab").innerHTML = '';
                document.getElementById("infReceita").style.backgroundColor = 'white';
                swal("Erro", "Favor preencha o cnpj do Estabelecimento!", "error");
            }else {
                document.getElementById("situacaoEstab").innerHTML = '';
                document.getElementById("statusEstab").innerHTML  = '';
                document.getElementById("aberturaEstab").innerHTML = '';
                document.getElementById("infReceita").style.backgroundColor = 'white';
                swal("Erro", "Cnpj incompleto, favor verifique e tente novamente!", "error");
            }

        }

        function somenteNumeros(e) {
            var charCode = e.charCode ? e.charCode : e.keyCode;
            // charCode 8 = backspace
            // charCode 9 = tab
            if (charCode != 8 && charCode != 9) {
                // charCode 48 equivale a 0
                // charCode 57 equivale a 9
                if (charCode < 48 || charCode > 57) {
                    return false;
                }
            }
        }

        function validarFormulario(f) {
            //confirmSenha
            if (f.razaoSocialEstab.value === ''){
                swal("Erro", "O campoo [Razão Social] é obrigatório, favor preencha!", "error");
                return false;
            }else if (f.inscrEstadualEstab.value === ''){
                swal("Erro", "O campoo [Inscrição Estadual] é obrigatório, favor preencha!", "error");
                return false;
            }else if (f.emailEstab.value === ''){
                swal("Erro", "O campoo [E-mail] é obrigatório, favor preencha!", "error");
                return false;
            }else if (!validarEmail(f.emailEstab.value)){
                swal("Erro", "O campoo [E-mail] é inválido, favor corrija e tente novamente!", "error");
                return false;
            }else if (f.cnpjEstab.value === ''){
                swal("Erro", "O campoo [CNPJ] é obrigatório, favor preencha!", "error");
                return false;
            }else if (f.loginEstab.value === ''){
                swal("Erro", "O campoo [Login] é obrigatório, favor preencha!", "error");
                return false;
            }else if (f.senhaEstab.value === ''){
                swal("Erro", "O campoo [Senha] é obrigatório, favor preencha!", "error");
                return false;
            }else if (f.confirmSenha.value !== f.senhaEstab.value){
                swal("Erro", "Confirme a senha e tente novamente!", "error");
                return false;
            }else if (f.senhaEstab.value !== '' && f.senhaEstab.value.length < 8){
                swal("Erro", "Senha mínima de 8 caracteres!", "error");
                return false;
            }else if (f.tipoContaEstab.value === ''){
                swal("Erro", "O campoo [Tipo Conta] é obrigatório, favor preencha!", "error");
                return false;
            }else if (f.contatoTelefone_f.value === ''){
                swal("Erro", "O campoo [Nome Contato Principal] é obrigatório, favor preencha!", "error");
                return false;
            }else if (f.telefone_f.value === '' && f.telefone_f.value.length > 7){
                swal("Erro", "O campoo [Telefone Contato Principal] é obrigatório, favor preencha!", "error");
                return false;
            }else if (f.cepEstab.value === ''){
                swal("Erro", "O campoo [CEP] é obrigatório, favor preencha!", "error");
                return false;
            }else if (f.enderecoEstab.value === ''){
                swal("Erro", "Cep inválido ou não localizado, insira e clique em [Buscar]!", "error");
                return false;
            }else if (f.numeroEstab.value === ''){
                swal("Erro", "O campo [Número] é obrigatório, favoor preencha!", "error");
                return false;
            }

            if (f.enderecoEstab.disabled){
                f.enderecoEstab.disabled = false;
                f.bairroEstab.disabled = false;
                f.estadoEstab.disabled = false;
                f.cidadeEstab.disabled = false;
            }

            return true;
        }

        function validarEmail(email) {
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        }
    </script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Projetos Desenvolvimento\ProjetosPhpStorm\ProjetosLaravel\nightlife\resources\views/paineladmin/admin/establishment/criar-estabelecimento.blade.php ENDPATH**/ ?>