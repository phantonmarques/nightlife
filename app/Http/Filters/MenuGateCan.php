<?php

    namespace App\Http\Filters;

    use JeroenNoten\LaravelAdminLte\Menu\Builder;
    use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;

    class MenuGateCan implements FilterInterface
    {
        public function transform($item, Builder $builder)
        {
            if (isset($item['permission']) && is_array($item['permission'])):
                $permission = false;

                foreach ($item['permission'] as $permission):
                    if (auth()->user()->can($permission)):
                        $permission = true;
                    endif;

                endforeach;

                if (!$permission):
                    return false;
                endif;


            else:
                if (isset($item['permission']) && !auth()->user()->can($item['permission'])):
                    return false;
                endif;

            endif;

            return $item;
        }
    }