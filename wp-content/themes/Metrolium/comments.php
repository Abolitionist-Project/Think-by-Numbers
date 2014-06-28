<?php
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) die ('Please do not load this page directly. Thanks!');

function comments_style($comment, $args, $depth)
	{
	$GLOBALS['comment'] = $comment;
	if($depth == $args['max_depth']) $class = 'max-depth';
	?>

	<li <?php comment_class($class) ?>>
		<header class="detail">
			<?php echo get_avatar($comment,$size='120') ?>
			<h4><?php comment_author_link() ?></h4>
			<p class="datetime"><?php comment_date() ?>, <?php comment_time() ?></p>
			<ul class="actions">
				<?php if(current_user_can('administrator')) : ?><li><a class="button square" title="Email author" href="mailto:<?php comment_author_email() ?>"><i class="icon-envelope-alt"></i></a></li><?php endif ?>
				<?php if(current_user_can('edit_comment', $comment->comment_ID)) : ?><li><a class="button square" title="Edit comment" href="<?php echo get_edit_comment_link() ?>"><i class="icon-pencil"></i></a></li><?php endif ?>
				<?php if($depth < $args['max_depth']) : ?><li><a class="button square" title="Reply" href="<?php echo esc_url(add_query_arg('replytocom',$comment->comment_ID)) ?>"><i class="icon-reply"></i></a></li><?php endif ?>
			</ul>
		</header>
		<div class="typography detail">
			<?php
			if ($comment->comment_approved == '0') echo '<p class="notice warning">'. __( 'This comment is awaiting approval', 'euged' ) .'</p>';
			else comment_text();
			?>
		</div>
	</li>

<?php } ?>

<?php if (have_comments()) : ?>

<div id="comments">

	<div class="hr icon"><i class="icon-comment"></i></div>

	<?php if(post_password_required()) : ?>

		<p class="notice error"><?php _e('This post is password protected. Enter the password to view comments', 'euged') ?></p>

	<?php else : ?>

		<h3><?php comments_number( __( 'No Comments', 'euged'), __( 'One Comment', 'euged'), __( '% Comments', 'euged') ) ?></h3>
		<ul class="commentlist">
			<?php wp_list_comments(array('type' => 'comment', 'callback' => 'comments_style')) ?>
		</ul>

		<?php if(get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
			<div id="comments-navigation">
				<div class="previous-comments"><?php echo get_previous_comments_link('Older comments') ?></div>
				<div class="next-comments"><?php echo get_next_comments_link('Newer comments') ?></div>
			</div>
		<?php endif ?>

	<?php endif ?>

</div>

<?php endif ?>

<?php if(comments_open()) : ?>

	<div id="respond">

		<?php if (!have_comments()) : ?>
			<div class="hr icon"><i class="icon-comment"></i></div>
		<?php endif ?>

		<?php comment_form(); ?>

	</div>

<?php elseif(is_singular('post')) : ?>

	<div id="comments">
		<div class="hr icon"><i class="icon-comment"></i></div>
		<p class="notice error"><?php _e('Comments are closed', 'euged') ?></p>
	</div>

<?php endif ?>
