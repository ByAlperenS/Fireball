<?php

namespace ByAlperenS\Fireball\Event;

use ByAlperenS\Fireball\Fireball;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\level\particle\HugeExplodeParticle;
use pocketmine\level\sound\GhastShootSound;
use pocketmine\math\Vector3;

class FireballListener implements Listener{

    /** @var array */
    private $status = [];
    /** @var Fireball */
    private $plugin;

    public function __construct(Fireball $plugin){
        $this->plugin = $plugin;
    }

    public function join(PlayerJoinEvent $e){
        $p = $e->getPlayer();

        $this->status[$p->getName()] = false;
    }

    public function quit(PlayerQuitEvent $e){
        $p = $e->getPlayer();

        unset($this->status[$p->getName()]);
    }

    public function interact(PlayerInteractEvent $e){
        $p = $e->getPlayer();

        if ($e->getAction() == PlayerInteractEvent::RIGHT_CLICK_BLOCK) {
            if ($p->getInventory()->getItemInHand()->getId() == Item::FIREBALL) {
                $this->status[$p->getName()] = true;
                $p->getInventory()->removeItem(ItemFactory::get(Item::FIREBALL));
            }
        }
    }

    public function move(PlayerMoveEvent $e){
        $p = $e->getPlayer();

        $from = $e->getFrom();
        $to = $e->getTo();
        if ($this->status[$p->getName()]) {
            $distance = 10;
            $x = ($to->x - $from->x) * ($distance / 2);
            $z = ($to->z - $from->z) * ($distance / 2);
            $p->setMotion(new Vector3($x, 0.8, $z));
            $p->getLevel()->addParticle(new HugeExplodeParticle(new Vector3($p->getX(), $p->getY(), $p->getZ())));
            $p->getLevel()->addParticle(new HugeExplodeParticle(new Vector3($p->getX() +1, $p->getY(), $p->getZ())));
            $p->getLevel()->addParticle(new HugeExplodeParticle(new Vector3($p->getX() -1, $p->getY(), $p->getZ())));
            $p->getLevel()->addParticle(new HugeExplodeParticle(new Vector3($p->getX(), $p->getY(), $p->getZ() +1)));
            $p->getLevel()->addParticle(new HugeExplodeParticle(new Vector3($p->getX(), $p->getY(), $p->getZ() -1)));

            $p->getLevel()->addSound(new GhastShootSound(new Vector3($p->getX(), $p->getY(), $p->getZ())));
            $this->status[$p->getName()] = false;
        }
    }
}
