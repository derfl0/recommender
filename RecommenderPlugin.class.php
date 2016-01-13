<?php

require 'bootstrap.php';

/**
 * RecomenderPlugin.class.php
 *
 * @author  Florian Bieringer <florian.bieringer@uni-passau.de>
 */
class RecommenderPlugin extends StudIPPlugin implements SystemPlugin
{

    public function __construct()
    {
        parent::__construct();
        if (!$GLOBALS['perm']->have_perm('admin')) {
            $navigation = new AutoNavigation(_('Kursvorschläge'));
            $navigation->setURL(PluginEngine::GetURL($this, array(), 'show'));
            Navigation::addItem('/browse/recomenderplugin', $navigation);
            if (stripos($_SERVER['REQUEST_URI'], "dispatch.php/my_courses") !== false) {
                $semester = Semester::findCurrent();
                if ($semester->vorles_beginn + 604800 > time()) {
                    PageLayout::addBodyElements("<table style='display:none' data-semester='" . htmlReady($semester->name) . "'><tr class='rec'><td colspan='7'><a href='" . PluginEngine::GetURL($this, array(), 'show') . "'>" . _('Veranstaltungen suchen') . "</a></td></tr></table>");
                    PageLayout::addScript($this->getPluginURL() . '/assets/recommender.js');
                }
            }
        }
    }

    public function perform($unconsumed_path)
    {
        $dispatcher = new Trails_Dispatcher(
            $this->getPluginPath(), rtrim(PluginEngine::getLink($this, array(), null), '/'), 'show'
        );
        $dispatcher->plugin = $this;
        $dispatcher->dispatch($unconsumed_path);
    }

}
