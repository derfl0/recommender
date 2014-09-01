<?php
require 'bootstrap.php';

/**
 * RecomenderPlugin.class.php
 *
 * ...
 *
 * @author  Florian Bieringer <florian.bieringer@uni-passau.de>
 * @version 0.1a
 */

class RecommenderPlugin extends StudIPPlugin implements SystemPlugin {

    public function __construct() {
        parent::__construct();
        
        $navigation = new AutoNavigation(_('Kursvorschläge'));
        $navigation->setURL(PluginEngine::GetURL($this, array(), 'show'));
        Navigation::addItem('/start/my_courses/recomenderplugin', $navigation);
    }

    public function initialize () {

    
        PageLayout::addStylesheet($this->getPluginURL().'/assets/style.css');
        PageLayout::addScript($this->getPluginURL().'/assets/application.js');
    }

    public function perform($unconsumed_path) {
        $this->setupAutoload();
        $dispatcher = new Trails_Dispatcher(
            $this->getPluginPath(),
            rtrim(PluginEngine::getLink($this, array(), null), '/'),
            'show'
        );
        $dispatcher->plugin = $this;
        $dispatcher->dispatch($unconsumed_path);
    }

    private function setupAutoload() {
        if (class_exists("StudipAutoloader")) {
            StudipAutoloader::addAutoloadPath(__DIR__ . '/models');
        } else {
            spl_autoload_register(function ($class) {
                include_once __DIR__ . $class . '.php';
            });
        }
    }
}
