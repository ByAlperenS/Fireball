<?php

/*
 * Author: ByAlperenS
 * Contect:
 *   - Messenger: Alperen Sancak
 *   - Facebook: Alperen Sancak
 *   - Discord: ByAlperenS#5361
 *
 * Turkey - 2020
 *
 */

namespace Fireball;

use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\plugin\PluginBase;
use Fireball\Event\FireballListener;

class Fireball extends PluginBase{

    public function onEnable()
    {
        $this->getLogger()->info("Plugin Enable - ByAlperenS");
        $this->getLogger()->info("https://github.com/ByAlperenS");
        Item::addCreativeItem(ItemFactory::get(ItemIds::FIREBALL));
        $this->getServer()->getPluginManager()->registerEvents(new FireballListener($this), $this);
    }
}
