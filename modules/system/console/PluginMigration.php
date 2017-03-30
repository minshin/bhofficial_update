<?php namespace System\Console;

use Illuminate\Console\Command;
use System\Classes\UpdateManager;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use System\Classes\PluginManager;
use October\Rain\Database\Updater;

class PluginMigration extends Command
{
    
    /**
     * The console command name.
     * @var string
     */
    protected $name = 'plugin:migration';
    
    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Migration a new plugin.';
    
    /**
     * Create a new command instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Execute the console command.
     * @return void
     */
    public function fire()
    {
        $pluginName = $this->argument('name');
        $scriptName = $this->argument('script');
        $op =  $this->argument('YorN');
        
        $this->output->writeln($pluginName);
        
        PluginManager::instance()->loadPlugins();
        
        $this->output->writeln($scriptName);
        
        if(PluginManager::instance()->hasPlugin($pluginName)){

            $this->output->writeln('ok');
            
            $pluginPath = PluginManager::instance()->getPluginPath($pluginName);
            
            $scriptPath = $pluginPath.'/updates/'.$scriptName;
            
            $update = new Updater();
            
           // $this->output->writeln($scriptPath);
            if($op == 'Y'){
            	$update->setUp($scriptPath);
            }else 
               $update->packDown($scriptPath);
            
            
            
        }else{
            
            $this->output->writeln('no');
            
        }      

    }
    
    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the plugin. Eg: AuthorName.PluginName'],
            ['script', InputArgument::REQUIRED,'Script name'],
            ['YorN', InputArgument::REQUIRED,'up down'],
        ];
    }
    
    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
    
}