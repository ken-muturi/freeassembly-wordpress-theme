<?php
/**
 * The template for displaying Comments.
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>

<div id="comments" class="comments-area">
	<?php comment_form(); ?>
	
	<ol class="commentlist">
		<?php foreach ($comments as $comment) : ?>
		<li <?php echo $oddcomment; ?>id="comment-<?php comment_ID() ?>">
		<div class="quote"><?php comment_text() ?></div>
		<?php if ($comment->comment_approved == '0') : ?>
		<em>Your comment is awaiting moderation.</em>
		<?php endif; ?>
		</li>
		<cite><?php comment_author_link() ?> on <a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date('F jS, Y') ?> at <?php comment_time() ?> <?php edit_comment_link('edit','&nbsp;&nbsp;',''); ?></a></cite>
		<?php
		/* Changes every other comment to a different class */
		$oddcomment = ( empty( $oddcomment ) ) ? 'class="alt" ' : '';
		?>
		<?php endforeach; /* end for each comment */ ?>
	</ol>
</div><!-- #comments .comments-area -->