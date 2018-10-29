<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package yugen
 */

get_header();

?>
    <main role="main">

      <section class="jumbotron text-center">
        <div class="container">
          <h1 class="jumbotron-heading">Album example</h1>
          <p class="lead text-muted">Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don't simply skip over it entirely.</p>
          <p>
            <a href="#" class="btn btn-primary my-2">Main call to action</a>
            <a href="#" class="btn btn-secondary my-2">Secondary action</a>
          </p>
        </div>
      </section>

      <div class="album py-5 bg-light">
        <div class="container">

          <div class="row">

          <?php
            if ( have_posts() ) :

            /* Start the Loop */
            while ( have_posts() ) : the_post();

            /*
             * Include the Post-Format-specific template for the content.
             * If you want to override this in a child theme, then include a file
             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
             */
             ?>
              <div class="col-md-4">
              <div class="card mb-4 shadow-sm">
                <img class="card-img-top" src="<?php the_post_thumbnail_url('item');?>" alt="Card image cap">
                <div class="card-body">
                  <a href="<?php the_permalink()?>" target="_blank"><?php the_title();?></a>
                  <p class="card-text"><?php the_excerpt(); ?></p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                     <a href="<?php the_permalink(); ?>"> <button type="button" class="btn btn-sm btn-outline-secondary">View</button></a>
                      <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                    </div>
                    <small class="text-muted">9 mins</small>
                  </div>
                </div>
              </div>
            </div>

        <?php endwhile; endif; ?>
          </div>
        </div>
      </div>

    </main>

<?php

get_footer();
