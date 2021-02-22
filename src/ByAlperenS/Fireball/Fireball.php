<?php

namespace ByAlperenS\Fireball;

use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\plugin\PluginBase;
use ByAlperenS\Fireball\Event\FireballListener;

class Fireball extends PluginBase{

    public function onEnable(){
        Item::addCreativeItem(ItemFactory::get(ItemIds::FIREBALL));
        $this->getServer()->getPluginManager()->registerEvents(new FireballListener($this), $this);
    }
}
