<?php $__env->startSection('title', 'Histórico de Movimentações'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Histórico de Movimentações</h1>
    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="">Histórico</a></li>
    </ol>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="box">
        <div class="box-header">
            <form action="#" method="POST" class="form form-inline">
                <?php echo csrf_field(); ?>

                <input type="text" name="id" class="form-control" placeholder="ID">
                <input type="date" name="date" class="form-control" >
                <select name="type" class="form-control">
                    <option value="">--- SELECIONE O TIPO ---</option>



                </select>

                <button type="submit" class="btn btn-primary">Pesquisar</button>
            </form>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>ID Usuário</th>
                    <th>ID Estabelecimento</th>
                    <th>Razão Social</th>
                    <th>Nome Fantasia</th>
                    <th>Inscrição Estadual</th>
                    <th>Tipo Licença</th>
                    <th>E-mail</th>
                    <th>Login</th>
                    <th>CNPJ</th>
                    <th>Contato</th>
                    <th>Celular</th>
                    <th>CEP</th>
                </tr>
                </thead>
                <tbody>
                <?php if(isset($userEstab) && isset($estab)): ?>
                    <tr>
                        <td><?php echo e($estab->user_id); ?>                                       </td>
                        <td><?php echo e($estab->id); ?>                                            </td>
                        <td><?php echo e($estab->corporate_name); ?>                                </td>
                        <td><?php echo e($userEstab->name); ?>                                      </td>
                        <td><?php echo e($estab->state_registration); ?>                            </td>
                        <td><?php echo e(($estab->type_license === 'b') ? 'Básica' : 'Full'); ?>    </td>
                        <td><?php echo e($userEstab->email); ?>                                     </td>
                        <td><?php echo e($userEstab->login); ?>                                     </td>
                        <td><?php echo e($userEstab->cpf_cnpj); ?>                                  </td>
                        <td><?php echo e($userEstab->contact_main); ?>                              </td>
                        <td><?php echo e('('.$userEstab->ddd_main.')'.$userEstab->phone_main); ?>   </td>
                        <td><?php echo e($estab->zip_code); ?>                                      </td>
                    </tr>
                <?php elseif(isset($estabelecimentos)): ?>
                    <?php $__currentLoopData = $estabelecimentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                                var_dump($estab);
                        die();
                                ?>
                        <tr>
                            <td><?php echo e($estab->user_id); ?>                                       </td>
                            <td><?php echo e($estab->id); ?>                                            </td>
                            <td><?php echo e($estab->corporate_name); ?>                                </td>
                            <td><?php echo e($estab->name); ?>                                      </td>
                            <td><?php echo e($estab->state_registration); ?>                            </td>
                            <td><?php echo e(($estab->type_license === 'b') ? 'Básica' : 'Full'); ?>    </td>
                            <td><?php echo e($estab->email); ?>                                     </td>
                            <td><?php echo e($estab->login); ?>                                     </td>
                            <td><?php echo e($estab->cpf_cnpj); ?>                                  </td>
                            <td><?php echo e($estab->contact_main); ?>                              </td>
                            <td><?php echo e('('.$estab->ddd_main.')'.$estab->phone_main); ?>   </td>
                            <td><?php echo e($estab->zip_code); ?>                                      </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
















                </tbody>
            </table>






        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Projetos Desenvolvimento\ProjetosPhpStorm\ProjetosLaravel\nightlife\resources\views/paineladmin/admin/establishment/lista-estabelecimento.blade.php ENDPATH**/ ?>