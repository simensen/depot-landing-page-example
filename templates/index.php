<?php

$basicProfileInfo = $server->entity()->findProfileInfo(
    'https://tent.io/types/info/basic/v0.1.0'
)->content();

$essayPostCriteria = new Depot\Core\Model\Post\PostCriteria;

$essayPostCriteria->limit = 20;
$essayPostCriteria->postTypes = array(
    'https://tent.io/types/post/essay/v0.1.0',
);

$essayPostListResponse = $client->posts()->getPosts($server, $essayPostCriteria);

$statusPostCriteria = new Depot\Core\Model\Post\PostCriteria;

$statusPostCriteria->limit = 5;
$statusPostCriteria->postTypes = array(
    'https://tent.io/types/post/status/v0.1.0',
);

$statusPostListResponse = $client->posts()->getPosts($server, $statusPostCriteria);

?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $basicProfileInfo['name']; ?> &mdash; <?php echo $entityUri; ?></title>
</head>
<body>

<?php if (!empty($basicProfileInfo['avatar_url'])) { ?>
<img style='max-width: 100px; float: right;' alt='Avatar' src='<?php echo $basicProfileInfo['avatar_url'] ?>'>
<?php } ?>

<h1><?php echo $basicProfileInfo['name']?></h1>

<p><?php echo $basicProfileInfo['bio']?></p>

<?php if (isset($basicProfileInfo['website_url'])) { ?>
<p><a href='<?php echo $basicProfileInfo['website_url'] ?>'><?php echo $basicProfileInfo['website_url'] ?></a></p>
<?php } ?>

<?php if ($statusPostListResponse->posts()) { ?>
<h2>Status Updates</h2>
<ul>
<?php foreach ($statusPostListResponse->posts() as $post) { $content = $post->content(); ?>
    <li>
        <?php if (isset($content['text'])) { ?><p><?php echo implode('<br>', explode("\n", $content['text'])); ?></p><?php } ?>
    </li>
<?php } ?>
</ul>
<?php } ?>

<?php if ($essayPostListResponse->posts()) { ?>
<h2>Essays</h2>
<ul>
<?php foreach ($essayPostListResponse->posts() as $post) { $content = $post->content(); ?>
    <li>
        <?php if (!empty($content['title'])) { ?><h3><?php echo $content['title']; ?></h3><?php } ?>
        <?php if (!empty($content['excerpt'])) { ?><div class="excerpt"><em>Excerpt: <?php echo $content['excerpt']; ?></em></div><?php } ?>
        <?php if (isset($content['body'])) { ?><div class="body"><?php echo $content['body']; ?></div><?php } ?>
        <div>Published <?php echo date('r', $post->publishedAt()); ?></div>
    </li>
<?php } ?>
</ul>
<?php } ?>

</body>
</html>
