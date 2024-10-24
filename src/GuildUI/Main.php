<?php

namespace GuildUI;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class Main extends PluginBase implements Listener {

    private array $guilds = [];
    private GuildUI $guildUI;

    public function onEnable(): void {
        $this->guildUI = new GuildUI($this);
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("Plugin GuildUI Diaktifkan");
    }

    public function onJoin(PlayerJoinEvent $event): void {
        // Logika untuk pemain baru yang bergabung (opsional)
    }

    public function getGuilds(): array {
        return $this->guilds;
    }

    public function addGuild(Guild $guild): void {
        $this->guilds[$guild->getName()] = $guild;
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if ($command->getName() === "guild") {
            if (!$sender instanceof Player) {
                $sender->sendMessage("Perintah ini hanya bisa digunakan dalam permainan.");
                return true;
            }

            switch ($args[0] ?? '') {
                case "create":
                    $this->guildUI->createGuildUI($sender);
                    break;
                // Tangani perintah lain...
                default:
                    $sender->sendMessage("Penggunaan: /guild [create|list|achievements|feedback|tournament]");
                    break;
            }
            return true;
        }
        return false;
    }
}
