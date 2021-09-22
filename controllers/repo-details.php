<?php
class RepoDetails {
    public function init(){
        global $page;
        $repo = ReposModel::getRepo((int)$page);
        App::assign('repo', $repo[0]);
    }
}
?>
