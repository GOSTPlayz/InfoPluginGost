<?php
namespace PluginGost;
use pocketmine\Server;
use pocketmine\Player;

use pocketmine\plugin\PluginBase;

use pocketmine\item\Item;
use pocketmine\item\ItemFactory;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use GUI\libs\muqsit\invmenu\InvMenu;
use GUI\libs\muqsit\invmenu\InvMenuHandler;

use pocketmine\event\Listener;

class Main extends PluginBase implements Listener{

	public function onEnable(){
		$this->getLogger()->info("Its Enabled ;>");
	}

	public function onDisable(){
		$this->getLogger()->info("Its Disabled :<");
	}

	public function onCommand(CommandSender $sender, Command $cmd, String $label, Array $args) : bool{

		switch ($cmd->getName()) {
			case "info":
				if($sender instanceof Player){
					$this->form($sender);
				} else{
					$sender->sendMessage("This command is to be used In-Game");
				}
				break;
		}
		return true;
	}

	public function form($player){
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function(Player $player, int $data = null){
			$result = $data;
			if($result === null){
				return true;
			}
			switch($result){
				case 0:
					$player->sendMessage("§a§oLink to YT:https://www.youtube.com/channel/UCfIOv_n12TsSOwXWwa00fQA?view_as=subscriber");
				break;
				case 1:
					$player->sendMessage("§a§oAdd me on Disord @Gost#9999");
				break;
				case 2:
					$this->openFood($player);
				break;
			}
		});
		$form->setTitle("§l§bOwner Info");
		$form->setContent("§aOwner Social Media Links");
		$form->addButton("§l§fYou§4Tube");
		$form->addButton("§l§9Discord");
		$form->addButton("§l§k§b!!§r§l§6Food§b§k!!§r");
		$form->sendToPlayer($player);
		return $form;
	}
	public function openFood($player){
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function(Player $player, array $data = null){
			if($data === null){
				return true;
			}
			$player->sendMessage("§b".$data[0]." Amount of NOM NOM Added To your Inventory :3");
			$item = ItemFactory::get(364, 0, $data[0]);
			if($player->getInventory()->canAddItem($item)){
				$player->getInventory()->addItem($item);
			}
		});
		$form->setTitle("§l§6NOM NOM§r");
		$form->addSlider("§bAmount Of NOM NOM.", 1, 128);
		$form->sendToPlayer($player);
		return $form;
	}
}