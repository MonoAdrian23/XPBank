<?php

declare(strict_types=1);

namespace MonoAdrian23\XPBank;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener {

    /** @var \SQLite3 */
    public $db;

    public function onEnable()
    {
       $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getCommandMap()->register("expbank", new BankCommand($this));


       $this->db = new \SQLite3($this->getDataFolder() . "database.db");
       $this->db->query("CREATE TABLE IF NOT EXISTS xp (uuid VARCHAR(50), username VARCHAR(50), xp INTEGER DEFAULT 0, PRIMARY KEY (uuid))");
    }

    public function onJoin(PlayerJoinEvent $event): void
    {
        $player = $event->getPlayer();
        $uuid = $player->getUniqueId()->toString();
        $username = $player->getName();
        $this->db->query("INSERT OR IGNORE INTO xp (uuid, username) VALUES ('$uuid', '$username')");
    }

}
