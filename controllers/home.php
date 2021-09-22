<?php
class Home {
    public function init(){
        $repos = ReposModel::getRepos();
        App::assign('repos', $repos);
    }
}
?>
