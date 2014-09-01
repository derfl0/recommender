<?php

class ShowController extends StudipController {

    public function __construct($dispatcher) {
        parent::__construct($dispatcher);
        $this->plugin = $dispatcher->plugin;
    }

    public function before_filter(&$action, &$args) {

        $this->set_layout($GLOBALS['template_factory']->open('layouts/base_without_infobox'));
//      PageLayout::setTitle('');
    }

    public function index_action() {
        $recommended = DBManager::get()->prepare("SELECT seminare.* FROM
                            (SELECT u2.user_id, COUNT(*) as points
                            FROM seminar_user u1 
                            JOIN seminar_user u2 USING (seminar_id) 
                            WHERE u1.user_id = :userid 
                            AND u2.user_id != :userid  
                            GROUP BY u2.user_id 
                            ORDER BY COUNT(*) DESC)
                            as recommender
                            JOIN seminar_user USING (user_id)
                            JOIN seminare USING (seminar_id)
                            WHERE seminar_id NOT IN (SELECT seminar_id FROM seminar_user WHERE user_id = :userid )
                            AND start_time >= :start
                            GROUP BY seminar_id
                            ORDER BY SUM(points) DESC
                            LIMIT 30");
        
        // Prepare params
        $semester = current(Semester::findBySQL('vorles_ende > ? ORDER BY beginn', array(time())));
        $this->semester = $semester;
        $recommended->bindParam(':start', $semester->beginn);
        $recommended->bindParam(':userid', $GLOBALS['user']->id);
        
        // Find it
        $recommended->execute();
        
        while ($next = $recommended->fetch(PDO::FETCH_ASSOC)) {
            $this->courses[] = Course::import($next);
        }
        
    }

    // customized #url_for for plugins
    function url_for($to) {
        $args = func_get_args();

        # find params
        $params = array();
        if (is_array(end($args))) {
            $params = array_pop($args);
        }

        # urlencode all but the first argument
        $args = array_map('urlencode', $args);
        $args[0] = $to;

        return PluginEngine::getURL($this->dispatcher->plugin, $params, join('/', $args));
    }

}
