
<?php
class IndexController
{
    public function index()
    {
        $view = new View();
        $posts = Post::all();
        $view->render('index', [
            "posts" => $posts
        ]);
    }
    public function newPost()
    {
        $data = $this->validate($_POST);
        if ($data === false){
            header('Location:'.App::config('url'));
        }
        else{
            $connection = Db::connect();
            $sql = 'insert into post (content) values (:content)';
            $statement = $connection->prepare($sql);
            $statement->bindValue('content',$data['content']);
            $statement->execute();
            header('Location:'.App::config('url'));
        }
    }
    private function validate($data)
    {
        $required = ['content'];
        foreach ($required as $key){
            if(!isset($data[$key])){
                return false;
            }
            $data[$key] = trim((string)$data[$key]);
            if (empty($data[$key])){
                return false;
            }
            return $data;
        }
    }
}