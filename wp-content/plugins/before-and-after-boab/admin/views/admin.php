<h2>Before Boab Logo</h2>
<p class="hide-if-no-js">
    <a title="Set Footer Image" href="javascript:void(0);" class="set-before-boab-logo change-logo" data-type="before">Set before logo</a>
</p>

<div class="hidden before-boab-logo-container img-container">
    <img src="<?=get_post_meta( $post->ID, 'before-thumbnail-src', true );?>" alt="<?=get_post_meta( $post->ID, 'before-thumbnail-title', true );?>" title="<?=get_post_meta( $post->ID, 'before-thumbnail-alt', true );?>" />
</div><!-- #featured-footer-image-container -->

<p class="hide-if-no-js hidden">
    <a title="Remove Footer Image" href="javascript:;" class="remove-before-boab-logo remove-logo" data-type="before">Remove featured image</a>
</p><!-- .hide-if-no-js -->

<p id="before-boab-inputs-container" class="hidden">
    <input type="text" id="before-thumbnail-src" name="before-thumbnail-src" value="<?=get_post_meta( $post->ID, 'before-thumbnail-src', true );?>" />
    <input type="text" id="before-thumbnail-title" name="before-thumbnail-title" value="<?=get_post_meta( $post->ID, 'before-thumbnail-title', true );?>" />
    <input type="text" id="before-thumbnail-alt" name="before-thumbnail-alt" value="<?=get_post_meta( $post->ID, 'before-thumbnail-alt', true );?>" />
</p><!-- #featured-footer-image-meta -->

<h2>After Boab Logo</h2>
<p class="hide-if-no-js">
    <a title="Set Footer Image" href="javascript:void(0);" class="set-after-boab-logo change-logo" data-type="after">Set After logo</a>
</p>

<div class="hidden after-boab-logo-container img-container">
    <img src="<?=get_post_meta( $post->ID, 'after-thumbnail-src', true );?>" alt="<?=get_post_meta( $post->ID, 'after-thumbnail-title', true );?>" title="<?=get_post_meta( $post->ID, 'after-thumbnail-alt', true );?>" />
</div><!-- #featured-footer-image-container -->

<p class="hide-if-no-js hidden">
    <a title="Remove Footer Image" href="javascript:;" class="remove-after-boab-logo remove-logo" data-type="after">Remove featured image</a>
</p><!-- .hide-if-no-js -->

<p id="after-boab-inputs-container" class="hidden">
    <input type="text" id="after-thumbnail-src" name="after-thumbnail-src" value="<?=get_post_meta( $post->ID, 'after-thumbnail-src', true );?>" />
    <input type="text" id="after-thumbnail-title" name="after-thumbnail-title" value="<?=get_post_meta( $post->ID, 'after-thumbnail-title', true );?>" />
    <input type="text" id="after-thumbnail-alt" name="after-thumbnail-alt" value="<?=get_post_meta( $post->ID, 'after-thumbnail-alt', true );?>" />
</p><!-- #featured-footer-image-meta -->

<!--h2>After Boab Logo</h2>
<p class="hide-if-no-js">
    <a title="Set Footer Image" href="javascript:;" id="set-footer-thumbnail">Set after logo</a>
</p>

<div id="featured-footer-image-container" class="hidden">
    <img src="" alt="" title="" />
</div>

<p class="hide-if-no-js hidden">
    <a title="Remove Footer Image" href="javascript:;" id="remove-footer-thumbnail">Remove featured image</a>
</p>

<p id="featured-image">
    <input type="text" id="thumbnail-src" name="thumbnail-src" value="<?=get_post_meta( $post->ID, 'thumbnail-src', true );?>" />
    <input type="text" id="thumbnail-title" name="thumbnail-title" value="<?=get_post_meta( $post->ID, 'thumbnail-title', true );?>" />
    <input type="text" id="thumbnail-alt" name="thumbnail-alt" value="<?=get_post_meta( $post->ID, 'thumbnail-alt', true );?>" />
</p><!-- #featured-footer-image-meta -->