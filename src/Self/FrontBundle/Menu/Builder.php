<?php
namespace Self\FrontBundle\Menu;


use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Home');


        $menu->addChild('Post');

        // create another menu item
        $menu->addChild('About Me');
        // you can also add sub level's to your menu's as follows
        $menu['About Me']->addChild('Edit profile');

        // ... add more children

        return $menu;
    }
}
