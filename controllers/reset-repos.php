<?php
class ResetRepos {
    public function init(){
        $reset = ReposModel::reset();

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL,"https://api.github.com/search/repositories?q=language:php&sort=stars&order=desc&per_page=100");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        $response = curl_exec($curl);
        curl_close ($curl);

        $repos = json_decode($response);

        foreach($repos->items as $r){
            ReposModel::insert_repo([
                $r->id,
                $r->name,
                $r->html_url,
                date('Y-m-d H:i:s', strtotime($r->created_at)),
                date('Y-m-d H:i:s', strtotime($r->pushed_at)),
                $r->description,
                $r->stargazers_count
            ]);
        }

        App::assign('message', 'Repos Reset');
    }
}
?>
