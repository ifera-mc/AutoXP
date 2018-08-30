<?php

/**
 *   ___        _       __   ________
 *  / _ \      | |      \ \ / /| ___ \
 * / /_\ \_   _| |_ ___  \ V / | |_/ /
 * |  _  | | | | __/ _ \ /   \ |  __/
 * | | | | |_| | || (_) / /^\ \| |
 * \_| |_/\__,_|\__\___/\/   \/\_|
 *
 * Discord: JackMD#3717
 * Twitter: JackMTaylor_
 *
 * This software is distributed under "GNU General Public License v3.0".
 * This license allows you to use it and/or modify it but you are not at
 * all allowed to sell this plugin at any cost. If found doing so the
 * necessary action required would be taken.
 *
 * AutoXP is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License v3.0 for more details.
 *
 * You should have received a copy of the GNU General Public License v3.0
 * along with this program. If not, see
 * <https://opensource.org/licenses/GPL-3.0>.
 * ------------------------------------------------------------------------
 */

namespace JackMD\AutoXP;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener{
	
	public function onEnable(): void{
		$this->getServer()->getPluginManager()->registerEvents(($this), $this);
		$this->getLogger()->info("Plugin Enabled.");
	}

    /**
     * @param BlockBreakEvent $event
     * @priority HIGHEST
     */
	public function onBreak(BlockBreakEvent $event){
	    if($event->isCancelled()){
	        return;
        }
		$event->getPlayer()->addXp($event->getXpDropAmount());
		$event->setXpDropAmount(0);
	}
	
	public function onPlayerKill(PlayerDeathEvent $event){
		$player = $event->getPlayer();
		$cause = $player->getLastDamageCause();
		if($cause instanceof EntityDamageByEntityEvent){
			$damager = $cause->getDamager();
			if($damager instanceof Player){
				$damager->addXp($player->getXpDropAmount());
				$player->setCurrentTotalXp(0);
			}
		}
	}
}