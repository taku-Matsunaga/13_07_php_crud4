<?php 

require_once (dirname(__FILE__) . '/vendor/autoload.php');

define("API_KEY","AIzaSyCBnN_EElLdqMs0MJ3ZLF4D79pX0seWlKA");

$client = new Google_Client();
$client->setApplicationName("xxxxxxxxxxx");
$client->setDeveloperKey(API_KEY);

$youtube = new Google_Service_YouTube($client);

$keyword = "jazz";
if( isset($_POST['keyword'])) {
    $keyword = $_POST['keyword'];
}

$params['q'] = $keyword;
$params['type'] = 'video';
$params['maxResults'] = 10;

$keyword = htmlspecialchars($keyword);
$videos = [];
try {
    $searchResponse = $youtube->search->listSearch('snippet', $params);
    array_map(function ($searchResult) use (&$videos) {
        $videos[] = $searchResult;
    },$searchResponse['items']);
} catch (Google_Service_Exception $e) {
    echo htmlspecialchars($e->getMessage());
    exit;
} catch (Google_Exception $e) {
    echo htmlspecialchars($e->getMessage());
    exit;
}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Youtube</title>
<link rel="stylesheet" href="http://no1s.biz/kenshu/bootstrap/bootstrap-3.3.4/css/bootstrap.css">
<link rel="stylesheet" href="http://no1s.biz/kenshu/bootstrap/bootstrap-3.3.4/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="http://no1s.biz/kenshu/bootstrap/bootstrap-3.3.4/js/bootstrap.min.js"></script>
<style>
html, body{
    background-color: #f1f1f1;
    height: 100%;
    margin: 0;
    padding: 0;
}
#container{
    height: 100%;
}
#header{
    padding: 20px;
    background-color: #fff;
}
#header form{
    width: 1200px;
    margin: 0 auto;
}
#main_box{
    margin: 0 auto;
    width: 1200px;
}
.movieBox {
    margin: 20px 0;
}
a.movieLink {
    display:block;
    overflow: auto;
    padding: 10px;
    border: 1px solid #ccc;
    background-color: #fff;
    color: #696969;
}

a.movieLink:hover {
    border: 1px solid #4169E1;
    color: #4169E1;
}

.movieBox .thums {
    float: left;
    margin-right: 10px;
    width: 120px;
}
.movieBox .description {
    float:left;
    width: 1000px;
    word-break: break-all;
}
</style>
</head>
<body>
<div id="container">
    <div id="header">
        <form method="post">
            <input type="text" id="keyword" name="keyword" value="<?=$keyword?>" />
            <input type="submit" value="検索" />
        </form>
        <div>
            <a href="read.php">保存動画一覧</a>
        </div>
    </div>
    <div id="main_box" class="clearfix">
    <?php 

    echo '<form action="create.php" method="POST">';

    foreach($videos as $video) :
        echo '<div class="movieBox">';
        echo '<a class="movieLink" href="https://www.youtube.com/watch?v=' . $video['id']['videoId'] . '">';
        echo '<div class="thums">';
        echo '<img src="' . $video['snippet']['thumbnails']['default']['url']. '" />';
        echo '</div>';
        echo '<div class="description">';
        echo '<div>' . $video['snippet']['title'] . '</div>';
        echo '<div>' . $video['snippet']['description'] . '</div>';
        echo '</div>';
        echo '</a>';

        echo '<div>';
        echo '</div>';
        echo '    <input type="radio" name="video" value="https://www.youtube.com/watch?v=' . $video['id']['videoId'] . '">';
        echo '<input type="hidden" name="thumb" value=' . $video["snippet"]["thumbnails"]["default"]["url"] .'>';
        echo '<input type="hidden" name="title" value=' . $video['snippet']['title'] . '>';
        echo '</div>';
    endforeach;

        echo '<button>Submit</button>';
        echo '</form>';
    ?>
    </div>
    <div>
    </div>
</div>
</body>
</html>