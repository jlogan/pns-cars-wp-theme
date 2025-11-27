<?php
if( have_rows('services_list', 'option') ): ?>
<section class="section-padding" id="services">
    <div class="container">
        <h2 class="section-title fade-in-up"><?php echo esc_html( get_field( 'services_heading', 'option' ) ?: 'Benefits for Drivers' ); ?></h2>
        <div class="services-grid">
            <?php while( have_rows('services_list', 'option') ): the_row(); ?>
                <div class="service-card fade-in-up">
                    <h3><?php the_sub_field('title'); ?></h3>
                    <p><?php the_sub_field('description'); ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>
<?php endif; ?>

