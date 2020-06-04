<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Admin\CategoryStatistics;
use App\Models\Admin\EstablishmentStatistics;
use App\Models\Admin\RhythmStatistics;

class ResetCountersStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ResetCountersStatistics:resetCounters';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resetar contadores semanais, mensais e anuais.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dayWeek = intval(date( 'N'));

        if ($dayWeek === 1):
            $categorys = CategoryStatistics::get();

            foreach ($categorys as $category):
                if ($category['year'] < date('Y')):
                    //INCLUIR TABELA MENSAL LOG
                    $category->total_views_week = 0;
                    $category->total_views_month = 0;
                    $category->total_views_year = 0;
                    $category->month = date('m');
                    $category->year = date('Y');
                    if (!$category->save())
                        echo "Ocorreu algum erro ao atualizar a categoria {$category->category->id} - {$category->category->name} [SEMANA|MES|ANO]\n\n";
                    else
                        echo "Categoria {$category->category->id} - {$category->category->name} atualizada com sucesso [SEMANA|MES|ANO]!\n\n";

                elseif ($category['month'] < date('m')):
                    $category->total_views_week = 0;
                    $category->total_views_month = 0;
                    $category->month = date('m');
                    if (!$category->save())
                        echo "Ocorreu algum erro ao atualizar a categoria {$category->category->id} - {$category->category->name} [SEMANA|MES]\n\n";
                    else
                        echo "Categoria {$category->category->id} - {$category->category->name} atualizada com sucesso [SEMANA|MES]!\n\n";
                else: 
                    $category->total_views_week = 0;
                    if (!$category->save())
                        echo "Ocorreu algum erro ao atualizar a categoria {$category->category->id} - {$category->category->name} [SEMANA]\n\n";
                    else
                        echo "Categoria {$category->category->id} - {$category->category->name} atualizada com sucesso [SEMANA]!\n\n";        
                endif;

            endforeach;

            $rhythms = RhythmStatistics::get();

            foreach ($rhythms as $rhythm):
                if ($rhythm['year'] < date('Y')):
                    //INCLUIR TABELA MENSAL LOG
                    $rhythm->total_views_week = 0;
                    $rhythm->total_views_month = 0;
                    $rhythm->total_views_year = 0;
                    $rhythm->month = date('m');
                    $rhythm->year = date('Y');
                    if (!$rhythm->save())
                        echo "Ocorreu algum erro ao atualizar o ritmo musical {$rhythm->rhythm->id} - {$rhythm->rhythm->name} [SEMANA|MES|ANO]\n\n";
                    else
                        echo "Ritmo Musical {$rhythm->rhythm->id} - {$rhythm->rhythm->name} atualizada com sucesso [SEMANA|MES|ANO]!\n\n";

                elseif ($rhythm['month'] < date('m')):
                    $rhythm->total_views_week = 0;
                    $rhythm->total_views_month = 0;
                    $rhythm->month = date('m');
                    if (!$rhythm->save())
                        echo "Ocorreu algum erro ao atualizar o ritmo musical {$rhythm->rhythm->id} - {$rhythm->rhythm->name} [SEMANA|MES]\n\n";
                    else
                        echo "Ritmo Musical {$rhythm->rhythm->id} - {$rhythm->rhythm->name} atualizada com sucesso [SEMANA|MES]!\n\n";
                else: 
                    $rhythm->total_views_week = 0;
                    if (!$rhythm->save())
                        echo "Ocorreu algum erro ao atualizar o ritmo musical {$rhythm->rhythm->id} - {$rhythm->rhythm->name} [SEMANA]\n\n";
                    else
                        echo "Ritmo Musical {$rhythm->rhythm->id} - {$rhythm->rhythm->name} atualizada com sucesso [SEMANA]!\n\n";        
                endif;

            endforeach;

            $establishments = EstablishmentStatistics::whereHas('establishment', function ($q) { $q->whereStatus(1); })->get();

            foreach ($establishments as $establishment):
                if ($establishment['year'] < date('Y')):
                    //INCLUIR TABELA MENSAL LOG
                    $establishment->total_views_week = 0;
                    $establishment->total_views_month = 0;
                    $establishment->total_views_year = 0;
                    $establishment->month = date('m');
                    $establishment->year = date('Y');
                    if (!$establishment->save())
                        echo "Ocorreu algum erro ao atualizar o estabelecimento {$establishment->establishment->id} - {$establishment->establishment->corporate_name} [SEMANA|MES|ANO]\n\n";
                    else
                        echo "Estabelecimento {$establishment->establishment->id} - {$establishment->establishment->corporate_name} atualizada com sucesso [SEMANA|MES|ANO]!\n\n";

                elseif ($establishment['month'] < date('m')):
                    $establishment->total_views_week = 0;
                    $establishment->total_views_month = 0;
                    $establishment->month = date('m');
                    if (!$establishment->save())
                        echo "Ocorreu algum erro ao atualizar o estabelecimento {$establishment->establishment->id} - {$establishment->establishment->corporate_name} [SEMANA|MES]\n\n";
                    else
                        echo "Estabelecimento {$establishment->establishment->id} - {$establishment->establishment->corporate_name} atualizada com sucesso [SEMANA|MES]!\n\n";
                else: 
                    $establishment->total_views_week = 0;
                    if (!$establishment->save())
                        echo "Ocorreu algum erro ao atualizar a estabelecimento {$establishment->establishment->id} - {$establishment->establishment->corporate_name} [SEMANA]\n\n";
                    else
                        echo "Estabelecimento {$establishment->establishment->id} - {$establishment->establishment->corporate_name} atualizada com sucesso [SEMANA]!\n\n";        
                endif;

            endforeach;

        else:
            //COLOCAR DEBBUG =
            $categorys = CategoryStatistics::where('month', '<', date('m'))->orWhere('year', '<', date('Y'))->get();

            if (count($categorys) > 0):
                foreach ($categorys as $category):
                    if ($category['year'] < date('Y')):
                        //INCLUIR TABELA MENSAL LOG
                        $category->total_views_month = 0;
                        $category->total_views_year = 0;
                        $category->month = date('m');
                        $category->year = date('Y');
                        if (!$category->save())
                            echo "Ocorreu algum erro ao atualizar a categoria {$category->category->id} - {$category->category->name} [MES|ANO]\n\n";
                        else
                            echo "Categoria {$category->category->id} - {$category->category->name} atualizada com sucesso [MES|ANO]!\n\n";

                    elseif ($category['month'] < date('m')):
                        $category->total_views_month = 0;
                        $category->month = date('m');
                        if (!$category->save())
                            echo "Ocorreu algum erro ao atualizar a categoria {$category->category->id} - {$category->category->name} [MES]\n\n";
                        else
                            echo "Categoria {$category->category->id} - {$category->category->name} atualizada com sucesso [MES]!\n\n";
                    endif;

                endforeach;

            endif;

            $rhythms = RhythmStatistics::where('month', '<', date('m'))->orWhere('year', '<', date('Y'))->get();

            if (count($rhythms) > 0):
                foreach ($rhythms as $rhythm):
                    if ($rhythm['year'] < date('Y')):
                        //INCLUIR TABELA MENSAL LOG
                        $rhythm->total_views_month = 0;
                        $rhythm->total_views_year = 0;
                        $rhythm->month = date('m');
                        $rhythm->year = date('Y');
                        if (!$rhythm->save())
                            echo "Ocorreu algum erro ao atualizar a ritmo musical {$rhythm->rhythm->id} - {$rhythm->rhythm->name} [MES|ANO]\n\n";
                        else
                            echo "Ritmo Musical {$rhythm->rhythm->id} - {$rhythm->rhythm->name} atualizada com sucesso [MES|ANO]!\n\n";

                    elseif ($rhythm['month'] < date('m')):
                        $rhythm->total_views_month = 0;
                        $rhythm->month = date('m');
                        if (!$rhythm->save())
                            echo "Ocorreu algum erro ao atualizar a ritmo musical {$rhythm->rhythm->id} - {$rhythm->rhythm->name} [MES]\n\n";
                        else
                            echo "Ritmo Musical {$rhythm->rhythm->id} - {$rhythm->rhythm->name} atualizada com sucesso [MES]!\n\n";
                    endif;

                endforeach;

            endif;

            $establishments = EstablishmentStatistics::where('month', '<', date('m'))->orWhere('year', '<', date('Y'))
                                ->whereHas('establishment', function ($q) { $q->whereStatus(1); })->get();

            if (count($establishments) > 0):
                foreach ($establishments as $establishment):
                    if ($establishment['year'] < date('Y')):
                        //INCLUIR TABELA MENSAL LOG
                        $establishment->total_views_month = 0;
                        $establishment->total_views_year = 0;
                        $establishment->month = date('m');
                        $establishment->year = date('Y');
                        if (!$establishment->save())
                            echo "Ocorreu algum erro ao atualizar o estabelecimento {$establishment->establishment->id} - {$establishment->establishment->corporate_name} [MES|ANO]\n\n";
                        else
                            echo "Estabelecimento {$establishment->establishment->id} - {$establishment->establishment->corporate_name} atualizada com sucesso [MES|ANO]!\n\n";

                    elseif ($establishment['month'] < date('m')):
                        $establishment->total_views_month = 0;
                        $establishment->month = date('m');
                        if (!$establishment->save())
                            echo "Ocorreu algum erro ao atualizar o estabelecimento {$establishment->establishment->id} - {$establishment->establishment->corporate_name} [MES]\n\n";
                        else
                            echo "Estabelecimento {$establishment->establishment->id} - {$establishment->establishment->corporate_name} atualizada com sucesso [MES]!\n\n";
                    endif;

                endforeach;

            endif;

        endif;

    }
}
