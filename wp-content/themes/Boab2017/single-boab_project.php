<?php get_header(); ?>

<div class="row">

        <div class="col-xs-12">

            <?php
            if(have_posts()) :
                while(have_posts()) : the_post();
                    ?>

                    <div class="row hidden-xs">
                        <div id="clip"><img class="clip" src="<?=get_template_directory_uri()?>/static/images/clip.svg"></div>
                    </div>

                    <div class="row">
                        <div class="hidden-xs col-sm-4">&nbsp;</div>
                        <div class="col-xs-12 col-sm-8 headline"><?php the_title('<h1>', '</h1>');?></div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-8 featured-image adaptable-image"><?php the_post_thumbnail('full'); ?></div>
                        <?php
                            $strClient = get_post_meta(get_the_ID(), 'boab_projects_contact_client', true);
                            if(!empty($strClient)) {
                                ?>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="row project-overview-info">
                                        <div class="col-xs-6 col-sm-12">
                                            <p class="webstyle3">Client</p>
                                            <p class="webstyle1"><?=$strClient?></p>
                                        </div>


                                <?php
                            }

                            // Get the custom taxonomy
                            $arrTaxonomies = get_the_terms(get_the_ID(), 'Service');
                            $strTaxonomies = '';

                            if($arrTaxonomies)
                            {
                                ?>
                                <div class="col-xs-6 col-sm-12">
                                    <p class="webstyle3 services">Services</p>
                                    <?php
                                    $strTaxonomies = '<ul class="services">';
                                    foreach($arrTaxonomies as $oTaxonomy)
                                    {
                                        $strTaxonomies .= '<li><p class="webstyle5">'.$oTaxonomy->name.'</p></li>';
                                    }
                                    $strTaxonomies .= '</ul>';
                            }

                            echo $strTaxonomies.'</div>';
                        ?>
                                </div>
                            </div>
                    </div>

                    <div class="row content project-content">
                        <div class="col-xs-12 col-sm-5">
                            <?php
                                $strBeforeImageSrc = get_post_meta(get_the_ID(), 'before-thumbnail-src', true);

                                $iImages = 0;
                                if($strBeforeImageSrc)
                                {
                                    $strBeforeImageTitle = get_post_meta(get_the_ID(), 'before-thumbnail-title', true);
                                    $strBeforeImageAlt = get_post_meta(get_the_ID(), 'before-thumbnail-alt', true);

                                    $iImages++;
                                }

                                $strAfterImageSrc = get_post_meta(get_the_ID(), 'after-thumbnail-src', true);

                                if($strAfterImageSrc)
                                {
                                    $strAfterImageTitle = get_post_meta(get_the_ID(), 'after-thumbnail-title', true);
                                    $strAfterImageAlt = get_post_meta(get_the_ID(), 'after-thumbnail-alt', true);

                                    $iImages++;
                                }

                                $strImages = '';
                                if($iImages == 1 && $strAfterImageSrc)
                                {
                                    $strImages = '
                                        <img src="'.$strAfterImageSrc.'" title="'.$strAfterImageTitle.'" alt="'.$strAfterImageAlt.'" />
                                    ';
                                }
                                elseif($iImages == 2)
                                {
                                    // We have both before and after image, display both
                                    $strImages = '
                                        <img src="'.$strBeforeImageSrc.'" title="'.$strBeforeImageTitle.'" alt="'.$strBeforeImageAlt.'" class="swap" />
                                        <img src="'.$strAfterImageSrc.'" title="'.$strAfterImageTitle.'" alt="'.$strAfterImageAlt.'" style="display:none;" />
                                    ';
                                }

                                echo $strImages;
                            ?>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div><?php the_content(); ?></div>
                        </div>
                        <div class="hidden-xs col-sm-1">&nbsp;</div>
                    </div>

                    <?php

                    // Now fetch all of the building blocks this site is made from :)
                    global $wpdb;

                    $arrResults = $wpdb->get_results("
                      SELECT
                        pm.meta_value 
                      FROM
                        {$wpdb->postmeta} pm
                      RIGHT JOIN
                        {$wpdb->posts} p 
                        ON
                              p.ID = pm.post_id
                          AND p.post_type = 'boab_project'
                      WHERE
                        pm.meta_key LIKE '_project_content_block%'
                        AND pm.post_id = {$post->ID}
                    ");

                    // Loop through the results, and create an array that contains the orderno as a key and the decoded JSON as value
                    if(count($arrResults) > 0)
                    {
                        $arrBlocks = [];
                        foreach($arrResults as $oResult)
                        {
                            $oDecodedData = json_decode($oResult->meta_value);

                            $arrBlocks[intval($oDecodedData->order)] = $oDecodedData;
                        }

                        ksort($arrBlocks);

                        // Loop through the blocks and build the content
                        $strBuildContent = '';
                        $iGalleryNo = 0;
                        foreach($arrBlocks as $oData)
                        {
                            // Assemble all images in an easy to control array
                            $arrImages = [];
                            if(!empty($oData->{'img-1-thumbnail-src'}))
                            {
                                $arrImages[] = boab2017_ImageInfoArray($oData->{'img-1-thumbnail-src'}, $oData->{'img-1-thumbnail-title'}, $oData->{'img-1-thumbnail-alt'});
                            }
                            if(!empty($oData->{'img-2-thumbnail-src'}))
                            {
                                $arrImages[] = boab2017_ImageInfoArray($oData->{'img-2-thumbnail-src'}, $oData->{'img-2-thumbnail-title'}, $oData->{'img-2-thumbnail-alt'});
                            }
                            if(!empty($oData->{'img-3-thumbnail-src'}))
                            {
                                $arrImages[] = boab2017_ImageInfoArray($oData->{'img-3-thumbnail-src'}, $oData->{'img-3-thumbnail-title'}, $oData->{'img-3-thumbnail-alt'});
                            }
                            if(!empty($oData->{'img-4-thumbnail-src'}))
                            {
                                $arrImages[] = boab2017_ImageInfoArray($oData->{'img-4-thumbnail-src'}, $oData->{'img-4-thumbnail-title'}, $oData->{'img-4-thumbnail-alt'});
                            }
                            if(!empty($oData->{'img-5-thumbnail-src'}))
                            {
                                $arrImages[] = boab2017_ImageInfoArray($oData->{'img-5-thumbnail-src'}, $oData->{'img-5-thumbnail-title'}, $oData->{'img-5-thumbnail-alt'});
                            }
                            if(!empty($oData->{'img-6-thumbnail-src'}))
                            {
                                $arrImages[] = boab2017_ImageInfoArray($oData->{'img-6-thumbnail-src'}, $oData->{'img-6-thumbnail-title'}, $oData->{'img-6-thumbnail-alt'});
                            }

                            switch($oData->type)
                            {
                                case 'gallery' :

                                    $iGalleryNo++;
                                    $strImages = '';
                                    if(count($arrImages) > 0)
                                    {
                                        $strImages = '<div class="gallery-slider">';
                                        $iImages = 0;
                                        foreach($arrImages as $arrImage)
                                        {
                                            $strImages .= '<a href="'.$arrImage['src'].'" data-toggle="lightbox" data-gallery="gallery-'.$iGalleryNo.'"><img src="'.$arrImage['src'].'" alt="'.$arrImage['alt'].'" title="'.$arrImage['title'].'" /></a>';
                                            /*
                                            if($iImages == 0)
                                            {
                                                $strImages .= '
                                                <div class="row">
                                                    <div class="col-xs-12 gallery-images gallery-img-row-1">
                                            ';
                                            }
                                            if($iImages == 2)
                                            {
                                                $strImages .= '
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-12 gallery-images gallery-img-row-2">
                                            ';
                                            }

                                            $strImages .= '<div><img src="'.$arrImage['src'].'" alt="'.$arrImage['alt'].'" title="'.$arrImage['title'].'" /></div>';

                                            $iImages++;
                                            <div class="your-class">

    <div>your content</div>
    <div>your content</div>
  </div>
                                            */
                                        }

                                        $strImages .= '</div>';
                                    }

                                    $strBuildContent .= '
                                    <div class="row gallery full-color content-block">
                                        <div class="col-xs-12 col-sm-2">
                                        
                                            <p class="webstyle4">'.$oData->headline.'</p>
                                            <p class="webstyle5 gallery-text">'.$oData->text.'</p>
                                            <p class="webstyle3">Photographer</p>
                                            <p class="webstyle5">'.$oData->photographer.'</p>
                                        </div>
                                        <div class="col-xs-12 col-sm-10">
                                            '.$strImages.'
                                        </div>
                                    </div>
                                    ';

                                    break;
                                case '3-img-content' :
                                    $strBuildContent .= '
                                    <div class="row content-block image-content hidden-xs">
                                        <div class="three-image-content-container">
                                            <div class="top-images-container">
                                                <div class="col-xs-8">
                                                    <div class="adaptable-image"><img src="'.$arrImages[0]['src'].'" alt="'.$arrImages[0]['alt'].'" title="'.$arrImages[0]['title'].'"  /></div>
                                                </div>
                                                <div class="col-xs-4">
                                                    <div class="adaptable-image "><img src="'.$arrImages[1]['src'].'" alt="'.$arrImages[1]['alt'].'" title="'.$arrImages[1]['title'].'"  /></div>
                                                </div>
                                            </div>
                                            <div class="bottom-content-container">
                                                <div class="col-xs-8">
                                                    <div><p class="webstyle4">'.$oData->text.'</p></div>
                                                </div>
                                                <div class="col-xs-4">
                                                    <div class="adaptable-image"><img src="'.$arrImages[2]['src'].'" alt="'.$arrImages[2]['alt'].'" title="'.$arrImages[2]['title'].'"  /></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row content-block image-content visible-xs xs-img-container">
                                        <div class="col-xs-12">
                                            <div class="adaptable-image"><img src="'.$arrImages[0]['src'].'" alt="'.$arrImages[0]['alt'].'" title="'.$arrImages[0]['title'].'"  /></div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="adaptable-image "><img src="'.$arrImages[1]['src'].'" alt="'.$arrImages[1]['alt'].'" title="'.$arrImages[1]['title'].'"  /></div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div><p class="webstyle4">'.$oData->text.'</p></div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="adaptable-image"><img src="'.$arrImages[2]['src'].'" alt="'.$arrImages[2]['alt'].'" title="'.$arrImages[2]['title'].'"  /></div>
                                        </div>
                                    </div>
                                    ';
                                    break;
                                case '4-img-content' :
                                    $strBuildContent .= '
                                    <div class="row image-content content-block hidden-xs">
                                        <div class="col-xs-12 image-1-container adaptable-image"><img src="'.$arrImages[0]['src'].'" alt="'.$arrImages[0]['alt'].'" title="'.$arrImages[0]['title'].'"  /></div>
                                        <div class="four-image-content-container">
                                            <div class="col-xs-8 content-cell">
                                                <div><p class="webstyle4">'.$oData->text.'</p></div>
                                                <div class="adaptable-image bottom-text-image"><img src="'.$arrImages[1]['src'].'" alt="'.$arrImages[1]['alt'].'" title="'.$arrImages[1]['title'].'"  /></div>
                                            </div>
                                            <div class="col-xs-4 images-cell">
                                                <div class="adaptable-image top-image"><img src="'.$arrImages[2]['src'].'" alt="'.$arrImages[2]['alt'].'" title="'.$arrImages[2]['title'].'"  /></div>
                                                
                                                <div class="adaptable-image bottom-image"><img src="'.$arrImages[3]['src'].'" alt="'.$arrImages[3]['alt'].'" title="'.$arrImages[3]['title'].'"  /></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row content-block image-content visible-xs xs-img-container">
                                        <div class="col-xs-12">
                                            <div class="adaptable-image"><img src="'.$arrImages[0]['src'].'" alt="'.$arrImages[0]['alt'].'" title="'.$arrImages[0]['title'].'"  /></div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div><p class="webstyle4">'.$oData->text.'</p></div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="adaptable-image "><img src="'.$arrImages[1]['src'].'" alt="'.$arrImages[1]['alt'].'" title="'.$arrImages[1]['title'].'"  /></div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="adaptable-image"><img src="'.$arrImages[2]['src'].'" alt="'.$arrImages[2]['alt'].'" title="'.$arrImages[2]['title'].'"  /></div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="adaptable-image"><img src="'.$arrImages[3]['src'].'" alt="'.$arrImages[3]['alt'].'" title="'.$arrImages[3]['title'].'"  /></div>
                                        </div>
                                    </div>
                                    ';
                                    break;
                                case 'divider-image' :
                                    $strBuildContent .= '
                                    <div class="row content-block image-content">
                                        <div class="col-xs-12 image-1-container adaptable-image"><img src="'.$arrImages[0]['src'].'" alt="'.$arrImages[0]['alt'].'" title="'.$arrImages[0]['title'].'"  /></div>
                                    </div>
                                    ';
                                    break;
                            }
                        }

                        echo $strBuildContent;
                    }

                endwhile;
            endif;

            // Get manually selected related posts
            $arrCustomRelatedPosts = $wpdb->get_results("
              SELECT
                p.*
              FROM
                {$wpdb->posts} p
              RIGHT JOIN
                {$wpdb->postmeta} pm
                ON
                    pm.post_id = {$post->ID}
                AND pm.meta_key LIKE 'related-post-id-%'
                AND pm.meta_value != ''
             WHERE
                p.ID = pm.meta_value
            AND p.post_status = 'publish'
             GROUP BY
                p.ID
             ORDER BY
                p.post_date DESC
             LIMIT 3
            ");

            $iAmountOfComputerSelectedRelatedPosts = intval(3 - count($arrCustomRelatedPosts));

            $arrAutoRelatedPosts = [];
            $arrPanicRelatedPosts = [];
            if($iAmountOfComputerSelectedRelatedPosts > 0)
            {
                $strExcludedIDs = '';

                // Make sure we're not finding any of the posts that's already chosen
                if(count($arrCustomRelatedPosts) > 0)
                {
                    foreach($arrCustomRelatedPosts as $oCustomRelatedPosts)
                        $strExcludedIDs .= intval($oCustomRelatedPosts->ID).',';
                }
                $strExcludedIDs = rtrim($strExcludedIDs, ',');

                $strExcludedPostsCondition = '';
                if(!empty($strExcludedIDs))
                    $strExcludedPostsCondition = 'AND p.ID NOT IN ('.$strExcludedIDs.')';


                if(count($arrTaxonomies) > 0 && $arrTaxonomies !== false)
                {
                    $strTaxonomySlugCSV = '';
                    foreach($arrTaxonomies as $oTaxonomy)
                    {
                        $strTaxonomySlugCSV .= '"'.esc_attr($oTaxonomy->slug).'",';
                    }
                    $strTaxonomySlugCSV = rtrim($strTaxonomySlugCSV, ',');

                    $arrAutoRelatedPosts = $wpdb->get_results("
                      SELECT
                        p.*
                      FROM
                        {$wpdb->posts} p
                      RIGHT JOIN
                        {$wpdb->terms} t 
                        ON
                            t.slug in(".$strTaxonomySlugCSV.")
                      RIGHT JOIN
                        {$wpdb->term_relationships} tr
                        ON
                            tr.object_id = p.ID
                        AND tr.term_taxonomy_id = t.term_id
                     WHERE
                     	p.ID > 0
                    AND p.ID != {$post->ID}
                    ".$strExcludedPostsCondition."
                    AND p.post_status = 'publish'
                     GROUP BY
                     	p.ID
                     ORDER BY
                     	p.post_date DESC
                     LIMIT {$iAmountOfComputerSelectedRelatedPosts}
                    ");
                }

                // If that didn't do the trick, then just fetch anything...
                $iAmountOfComputerSelectedRelatedPosts = intval(3 - count($arrCustomRelatedPosts) - count($arrAutoRelatedPosts));
                if($iAmountOfComputerSelectedRelatedPosts > 0)
                {

                    // now extend the excluded ID's even further
                    if(count($arrAutoRelatedPosts) > 0)
                    {
                        foreach($arrAutoRelatedPosts as $oAutoRelatedPosts)
                            $strExcludedIDs .= intval($oAutoRelatedPosts->ID).',';
                    }
                    $strExcludedIDs = rtrim($strExcludedIDs, ',');

                    $strExcludedPostsCondition = '';
                    if(!empty($strExcludedIDs))
                        $strExcludedPostsCondition = 'AND p.ID NOT IN ('.$strExcludedIDs.')';

                    $arrPanicRelatedPosts = $wpdb->get_results("
                      SELECT
                        p.*
                      FROM
                        {$wpdb->posts} p
                      WHERE
                     	p.ID > 0
                    AND p.ID != {$post->ID}
                    ".$strExcludedPostsCondition."
                    AND p.post_status = 'publish'
                     GROUP BY
                     	p.ID
                     ORDER BY
                     	p.post_date DESC
                     LIMIT {$iAmountOfComputerSelectedRelatedPosts}
                    ");
                }
            }

            $arrRelatedPosts = array_merge($arrCustomRelatedPosts, $arrAutoRelatedPosts, $arrPanicRelatedPosts);

            $strRelatedPosts = '';
            if(count($arrRelatedPosts) > 0)
            {
                $iLoopNo = 0;
                foreach($arrRelatedPosts as $oRelatedPost)
                {
                    $iLoopNo++;
                    // Get the custom taxonomy
                    $arrTaxonomies = get_the_terms(get_the_ID(), 'Service');
                    $strTaxonomies = '';

                    if($arrTaxonomies)
                    {
                        foreach($arrTaxonomies as $oTaxonomy)
                        {
                            $strTaxonomies .= $oTaxonomy->name.', ';
                        }
                    }

                    $strHiddenXSClass = $iLoopNo > 1 ? ' hidden-xs' : '';

                    $strRelatedPosts .= '
                    <div class="col-xs-12 col-sm-4'.$strHiddenXSClass.'">
                        <a href="'.get_permalink($oRelatedPost->ID).'">
                            <img class="clip" src="'.get_template_directory_uri().'/static/images/clip_white.svg">
                            <h3>'.$oRelatedPost->post_title.'</h3>
                            <p class="webstyle5">'.(rtrim($strTaxonomies, ', ')).'</p>
                        </a>
                    </div>
                    ';
                }
            }
            ?>

            <div class="row related-posts full-color">
                <?=$strRelatedPosts?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>

<?php

/*
 * <article id="post-<?php the_ID();?>" <?php post_class(); ?>>

                        <?php

                        the_title('<h1 class="entry-title">', '</h1>');

                        if( has_post_thumbnail() ) :
                            ?>
                            <div class="pull-right"><?php the_post_thumbnail('thumbnail'); ?></div>
                            <?php
                        endif;
                        ?>
                        <small><?=boab2017_CustomTerm($post->ID, 'solution-to')?> <?php

                            if(current_user_can('manage_options')) :
                                echo ' | ';
                                edit_post_link();
                            endif;

                            ?></small>



                        <hr>

                        <div class="col-xs-6 text-left">
                            <?php previous_post_link() ?>
                        </div>
                        <div class="col-xs-6 text-right">
                            <?php next_post_link() ?>
                        </div>

                    </article>
 */
?>
