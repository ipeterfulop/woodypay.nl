<?php


namespace App\ViewComposers;


use Illuminate\View\View;

class AdminMenuViewComposer
{
    public function compose(View $view)
    {
        if (\Auth::check()) {
            $menuitems = \Datalytix\Menu\Factories\MenuFactory::buildForCurrentUser();
            $result = [];
            foreach ($menuitems as $item) {
                $result[] = $this->transformMenuitem($item);
            }
        } else {
            $result = [];
        }

        $view->with('menuitems', $result);
    }

    protected function transformMenuitem($menuitem)
    {
        $result = [
            'link' => $menuitem->link,
            'label' => __($menuitem->label),
            'heroiconConfigPath' => $menuitem->iconclass,
            'active' => $menuitem->isActive(),
            'menuitems' => []
        ];
        foreach ($menuitem->menuitems as $item) {
            $result['menuitems'][] = $this->transformMenuitem($item);
            if ($item->isActive()) {
                $result['active'] = true;
            }
        }

        return (object)$result;
    }

}